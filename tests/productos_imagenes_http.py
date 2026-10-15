"""Verify real multipart uploads using a short-lived local PHP test server."""

import http.cookiejar
import json
import pathlib
import re
import socket
import subprocess
import time
import urllib.parse
import urllib.request
import urllib.error


RAIZ = pathlib.Path(__file__).resolve().parents[1]
with socket.socket() as reserva:
    reserva.bind(("127.0.0.1", 0))
    puerto = reserva.getsockname()[1]
BASE = f"http://127.0.0.1:{puerto}"
cookies = http.cookiejar.CookieJar()
cliente = urllib.request.build_opener(urllib.request.HTTPCookieProcessor(cookies))


def pedir(ruta, datos=None):
    cuerpo = urllib.parse.urlencode(datos).encode() if datos is not None else None
    with cliente.open(BASE + ruta, cuerpo, timeout=30) as respuesta:
        return respuesta.read().decode()


def subir(ruta, campos):
    limite = "ccsm-productos-regresion"
    partes = []
    for nombre, valor in campos.items():
        partes.append(
            f'--{limite}\r\nContent-Disposition: form-data; name="{nombre}"\r\n\r\n{valor}\r\n'.encode()
        )
    imagen = (RAIZ / "public/uploads/productos/default.png").read_bytes()
    partes.append(
        f'--{limite}\r\nContent-Disposition: form-data; name="imagen_producto"; filename="prueba.png"\r\nContent-Type: image/png\r\n\r\n'.encode()
        + imagen + b"\r\n"
    )
    partes.append(f"--{limite}--\r\n".encode())
    peticion = urllib.request.Request(
        BASE + ruta, b"".join(partes),
        {"Content-Type": f"multipart/form-data; boundary={limite}"},
    )
    with cliente.open(peticion, timeout=30) as respuesta:
        return respuesta.read().decode()


def estado_demo():
    sid = next(cookie.value for cookie in cookies if cookie.name == "PHPSESSID")
    codigo = r"""
    session_save_path('sessions_temp');
    session_id($argv[1]);
    session_start();
    require 'config/config.php';
    require 'config/database.php';
    if (!Demo::activa()) throw new RuntimeException('Falta demo de prueba.');
    echo json_encode([
        'archivos' => array_map('basename', glob(Demo::carpetaImagenes('productos') . '*')),
        'productos' => Database::getConnection()->query('SELECT id_producto, producto, imagen_producto FROM productos ORDER BY id_producto')->fetchAll()
    ]);
    """
    return json.loads(subprocess.check_output(["php", "-r", codigo, sid], cwd=RAIZ, text=True))


servidor = subprocess.Popen(
    ["php", "-S", f"127.0.0.1:{puerto}", str(RAIZ / "tests/http_router.php")],
    cwd=RAIZ, stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL,
)
demo = False
try:
    for intento in range(50):
        if servidor.poll() is not None:
            raise RuntimeError("El servidor PHP de prueba no pudo arrancar.")
        try:
            html = pedir("/login")
            break
        except urllib.error.URLError:
            time.sleep(0.1)
    else:
        raise RuntimeError("El servidor PHP de prueba no responde.")
    # Internal demo setup avoids creating persistent visitor metadata for upload tests.
    sid = next(cookie.value for cookie in cookies if cookie.name == "PHPSESSID")
    codigo = r"""
    session_save_path('sessions_temp');
    session_id($argv[1]);
    session_start();
    require 'config/config.php';
    require 'config/database.php';
    Demo::iniciar();
    """
    subprocess.check_call(["php", "-r", codigo, sid], cwd=RAIZ)
    demo = True
    antes = estado_demo()
    comunes = {"categoria_id": "1", "impuesto_id": "4", "pvp": "1", "dispensario": "10", "visible": "1"}
    for ruta, campos, mensaje in [
        ("/productos/guardar", {"producto": "   "}, "Introduce el nombre"),
        ("/productos/actualizar", {"producto": " ", "id_producto": "1"}, "Introduce el nombre"),
        ("/productos/actualizar", {"producto": "Prueba", "id_producto": "0"}, "El artículo no existe"),
        ("/productos/actualizar", {"producto": "Prueba", "id_producto": "999999"}, "El artículo no existe"),
    ]:
        assert mensaje in subir(ruta, comunes | campos)
        assert estado_demo() == antes, "Se creó un archivo o se modificó el catálogo con datos inválidos."
    subir("/productos/guardar", comunes | {"producto": "0"})
    despues = estado_demo()
    assert len(despues["archivos"]) == len(antes["archivos"]) + 1
    assert despues["productos"][-1]["producto"] == "0"
    nombre = despues["productos"][-1]["imagen_producto"]
    assert nombre in despues["archivos"], "Una subida válida no se asocia al producto."
    subir("/productos/actualizar", comunes | {"producto": "Producto actualizado", "id_producto": "1"})
    final = estado_demo()
    assert final["productos"][0]["producto"] == "Producto actualizado"
    assert final["productos"][0]["imagen_producto"] in final["archivos"]
    print("OK: multipart real, nombres vacíos, IDs inválidos, cero archivos huérfanos y subidas válidas.")
finally:
    try:
        if demo:
            html = pedir("/logout")
            csrf = re.search(r'name="csrf" value="([^"]+)"', html).group(1)
            pedir("/demo/salir", {"csrf": csrf, "accion": "omitir"})
            sid = next(cookie.value for cookie in cookies if cookie.name == "PHPSESSID")
            subprocess.check_call([
                "php", "-r",
                "session_save_path('sessions_temp'); session_id($argv[1]); session_start(); session_destroy();",
                sid,
            ], cwd=RAIZ)
    finally:
        servidor.terminate()
        servidor.wait(timeout=10)
