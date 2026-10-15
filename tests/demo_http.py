"""Run against a local installation: python tests/demo_http.py http://ccsm.dbold.local."""

import http.cookiejar
import atexit
import pathlib
import re
import subprocess
import sys
import uuid
import json
import urllib.parse
import urllib.request
import urllib.error


BASE = sys.argv[1].rstrip("/")
RAIZ = pathlib.Path(__file__).resolve().parents[1]


def huella_real():
    codigo = r"""
    require 'config/config.php';
    require 'config/database.php';
    $datos = [];
    foreach (Database::getConnection()->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN) as $tabla) {
        if (in_array($tabla, ['demo_usos', 'demo_eventos', 'contacto_mensajes'], true)) continue;
        $datos[$tabla] = Database::getConnection()->query("SELECT * FROM `$tabla`")->fetchAll();
    }
    foreach (['socios', 'productos'] as $tipo) {
        foreach (glob("public/uploads/$tipo/*") as $archivo) {
            if (is_file($archivo)) $datos[$archivo] = hash_file('sha256', $archivo);
        }
    }
    echo hash('sha256', serialize($datos));
    """
    return subprocess.check_output(["php", "-r", codigo], cwd=RAIZ, text=True)


def navegador():
    return urllib.request.build_opener(
        urllib.request.HTTPCookieProcessor(http.cookiejar.CookieJar())
    )


def pedir(cliente, ruta, datos=None):
    body = urllib.parse.urlencode(datos).encode() if datos is not None else None
    with cliente.open(BASE + ruta, body, timeout=60) as respuesta:
        return respuesta.read().decode("utf-8")

EMAIL_PRUEBA = "test-" + uuid.uuid4().hex + "@example.invalid"


def entrar(cliente):
    html = pedir(cliente, "/login")
    csrf = re.search(r'name="csrf" value="([^"]+)"', html).group(1)
    return pedir(cliente, "/demo/entrar", {
        "demo_nombre": "Visitante de prueba HTTP",
        "demo_email": EMAIL_PRUEBA, "demo_aviso": "1", "csrf": csrf,
    })


def error_http(cliente, ruta, estado, datos=None):
    try:
        pedir(cliente, ruta, datos)
    except urllib.error.HTTPError as error:
        assert error.code == estado, (ruta, error.code)
        return error.read().decode("utf-8")
    raise AssertionError("Se aceptó una solicitud no autorizada: " + ruta)


def salir(cliente, texto=""):
    html = pedir(cliente, "/logout")
    token = re.search(r'name="csrf" value="([^"]+)"', html)
    if token:
        resultado = pedir(cliente, "/demo/salir", {
            "csrf": token.group(1), "accion": "enviar" if texto else "omitir",
            "sugerencias": texto, "registro_id": "0",
        })
        error_http(cliente, "/demo/salir", 403, {
            "csrf": token.group(1), "accion": "enviar", "sugerencias": "Duplicada"
        })
        return resultado
    return html


def comprobar_registro_y_limpiar():
    codigo = r"""
    require 'config/config.php';
    require 'config/database.php';
    $db = Database::getConnection();
    $stmt = $db->prepare('SELECT * FROM demo_usos WHERE email = :email ORDER BY id');
    $stmt->execute(['email' => $argv[1]]);
    $filas = $stmt->fetchAll();
    foreach ($filas as &$fila) {
        $eventos = $db->prepare('SELECT seccion, accion, resultado FROM demo_eventos WHERE uso_id = :id ORDER BY id');
        $eventos->execute(['id' => $fila['id']]);
        $fila['eventos'] = $eventos->fetchAll();
    }
    unset($fila);
    $delete = $db->prepare('DELETE FROM demo_usos WHERE email = :email');
    $delete->execute(['email' => $argv[1]]);
    $delete = $db->prepare('DELETE FROM contacto_mensajes WHERE email = :email');
    $delete->execute(['email' => $argv[1]]);
    echo json_encode($filas);
    """
    return json.loads(subprocess.check_output(["php", "-r", codigo, EMAIL_PRUEBA], cwd=RAIZ, text=True))

atexit.register(comprobar_registro_y_limpiar)


def subir_foto(cliente):
    limite = "ccsm-demo-test-boundary"
    campos = {
        "id_socio": "1", "nombre": "Alex", "apellidos": "Ejemplo",
        "card_id": "DEMO-001", "birth": "1990-01-01", "cuota_id": "1",
        "genero_id": "1", "pais_id": "1", "saldo": "100",
        "consumo": "0", "activo": "1",
    }
    partes = []
    for nombre, valor in campos.items():
        partes.append(
            f'--{limite}\r\nContent-Disposition: form-data; name="{nombre}"\r\n\r\n{valor}\r\n'.encode()
        )
    imagen = pathlib.Path(__file__).resolve().parents[1] / "public/uploads/productos/default.png"
    partes.append(
        f'--{limite}\r\nContent-Disposition: form-data; name="imagen_perfil"; filename="demo.png"\r\nContent-Type: image/png\r\n\r\n'.encode()
        + imagen.read_bytes() + b"\r\n"
    )
    partes.append(f"--{limite}--\r\n".encode())
    peticion = urllib.request.Request(
        BASE + "/socios/actualizar", b"".join(partes),
        {"Content-Type": f"multipart/form-data; boundary={limite}"},
    )
    with cliente.open(peticion, timeout=60) as respuesta:
        return respuesta.read().decode("utf-8")


antes = huella_real()
uno, dos = navegador(), navegador()
try:
    assert "Entrar en demo" in pedir(uno, "/login")
    contacto = pedir(uno, "/contacto")
    csrf_contacto = re.search(r'name="csrf" value="([^"]+)"', contacto).group(1)
    contacto_datos = {
        "csrf": csrf_contacto, "nombre": "", "email": EMAIL_PRUEBA,
        "tema": "idea", "mensaje": "Idea HTTP <segura>", "aviso": "1", "web": "",
    }
    error_http(uno, "/contacto", 400, contacto_datos | {"email": "invalido"})
    error_http(uno, "/contacto", 403, contacto_datos | {"csrf": "falso"})
    error_http(uno, "/contacto", 400, contacto_datos | {"web": "spam"})
    confirmado = pedir(uno, "/contacto", contacto_datos)
    assert "Tu mensaje ya está aquí" in confirmado
    contacto = pedir(uno, "/contacto")
    nuevo_csrf = re.search(r'name="csrf" value="([^"]+)"', contacto).group(1)
    error_http(uno, "/contacto", 429, contacto_datos | {"csrf": nuevo_csrf})
    error_http(uno, "/demo/entrar", 400, {})
    assert "Modo demo" in entrar(uno)
    error_http(uno, "/contacto/bandeja", 403)
    error_http(uno, "/contacto/leido", 403, {"id": "1", "csrf": "falso"})
    actividad_html = pedir(uno, "/socios")
    csrf_actividad = re.search(r'data-csrf="([^"]+)"', actividad_html).group(1)
    assert json.loads(pedir(uno, "/demo/actividad", {"csrf": csrf_actividad}))["success"]
    error_http(uno, "/demo/actividad", 403, {"csrf": "falso"})
    error_http(uno, "/informes?desde=" + urllib.parse.quote("2026-01-\0" + "01"), 400)
    error_http(uno, "/informes/demo", 403)
    assert "Uso de la demo y sugerencias" not in pedir(uno, "/informes")
    error_http(uno, "/demo/salir", 403, {"csrf": "falso", "accion": "omitir"})
    error_http(uno, "/demo/salir", 403, {"csrf": "", "accion": "omitir"})
    salida = pedir(uno, "/logout")
    csrf_salida = re.search(r'name="csrf" value="([^"]+)"', salida).group(1)
    error_http(uno, "/demo/salir", 400, {
        "csrf": csrf_salida, "accion": "enviar", "sugerencias": "x" * 4001
    })
    assert "Modo demo" in pedir(uno, "/socios")
    for ruta in ["/socios", "/productos", "/categorias", "/usuarios", "/perfiles",
                 "/proveedores", "/variedades", "/cuotas", "/configuracion",
                 "/compras", "/dispensario", "/informes"]:
        pagina = pedir(uno, ruta)
        assert "Modo demo" in pagina, ruta
        assert "Fatal error" not in pagina and "Warning:" not in pagina, ruta
    pedir(uno, "/categorias/guardar", {
        "categoria": "Categoría solo demo HTTP", "activo": "1",
        "servicio_id": "2", "icono": "bi-leaf",
    })
    assert "Categoría solo demo HTTP" in pedir(uno, "/categorias")
    assert "Modo demo" in entrar(dos)
    assert "Categoría solo demo HTTP" not in pedir(dos, "/categorias")
    foto = subir_foto(uno)
    assert 'id="previewPerfil" src="/demo/imagen?' in foto
    socio = json.loads(pedir(uno, "/dispensario/socio?id=1"))["socio"]
    with uno.open(BASE + socio["imagen_perfil_url"], timeout=60) as imagen:
        assert imagen.headers["Content-Type"] == "image/png"
        assert len(imagen.read()) > 0
    resultado = json.loads(pedir(uno, "/dispensario/cobrar", {
        "id_socio": "1", "id_producto": "1", "cantidad": "2", "total": "3",
    }))
    assert resultado["success"], resultado
    fallo = json.loads(pedir(uno, "/dispensario/cobrar", {
        "id_socio": "1", "id_producto": "1", "cantidad": "10000", "total": "1",
    }))
    assert not fallo["success"]
    socio = json.loads(pedir(uno, "/dispensario/socio?id=1"))["socio"]
    assert float(socio["saldo"]) == 97
    socio_dos = json.loads(pedir(dos, "/dispensario/socio?id=1"))["socio"]
    assert float(socio_dos["saldo"]) == 100
    assert not socio_dos["imagen_perfil"]
finally:
    salir(uno, "Sugerencia de prueba <segura>")
    salir(dos)

assert "Modo demo" in entrar(uno)
try:
    assert "Categoría solo demo HTTP" not in pedir(uno, "/categorias")
    assert not json.loads(pedir(uno, "/dispensario/socio?id=1"))["socio"]["imagen_perfil"]
finally:
    salir(uno)
registros = comprobar_registro_y_limpiar()
assert len(registros) == 3
assert all(r["fin"] and r["estado"] == "finalizada" for r in registros)
assert registros[0]["sugerencias"] == "Sugerencia de prueba <segura>"
assert registros[1]["sugerencias"] is None
assert all(r["sugerencias_fecha"] for r in registros)
assert any(e == {"seccion": "dispensario", "accion": "cobrar", "resultado": "ok"} for e in registros[0]["eventos"])
assert any(e == {"seccion": "dispensario", "accion": "cobrar", "resultado": "error"} for e in registros[0]["eventos"])
assert any(e["accion"] == "subir_imagen" for e in registros[0]["eventos"])
assert "Categoría solo demo HTTP" not in json.dumps([r["eventos"] for r in registros])
assert EMAIL_PRUEBA not in json.dumps([r["eventos"] for r in registros])
assert huella_real() == antes, "Se modificaron datos o imágenes reales."
print("OK: HTTP, aislamiento, fotos, ventas, reinicio, registro de tres visitas y sugerencias opcionales.")
