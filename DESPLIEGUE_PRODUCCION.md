# Despliegue de CCSM a producción

GreenPower CCSM es una aplicación descargable para instalar en un hosting
compatible: subir el paquete, ejecutar el asistente y empezar a gestionar
la instalación propia. La demo permite conocerla antes de instalarla; su
registro de visitas tiene como finalidad el análisis de uso y la mejora
de la aplicación, no forma parte de los datos de negocio.

Esta guía complementa al instalador web (`public/install.php`). Sigue los pasos en orden.

## 1. Qué subir al servidor

Todo el contenido de este proyecto, tal cual, **incluyendo**:
- `schema_produccion.sql` (en la raíz) — el instalador lo necesita para crear las tablas.
- La carpeta `logs/` (vacía, con su `.htaccess`).

Para una instalación **nueva**, no subas `config/config.php` del entorno local
ni los candados de instalación: el asistente genera una configuración de
producción. Si ya existe `config.php` o `installed.lock`, se bloquea sin
conectarse a la base ni modificarla. Conserva ambos archivos al actualizar
una instalación existente.

**No hace falta subir** `bbdd.sql` ni `bbdd_auto.sql` (son el volcado de desarrollo, con datos de prueba) ni los `migracion_*.sql` sueltos — el instalador no los usa. Si los subes por comodidad, el `.htaccess` de la raíz ya bloquea su descarga, pero lo más limpio es no subirlos.

## 2. Configura el document root

Para `ccsm.dbold.es`, configura el document root del subdominio para que apunte
directamente a la carpeta de CCSM y sube allí el contenido completo del proyecto.
El instalador quedará en `https://ccsm.dbold.es/install.php`; no hace falta crear
una subcarpeta `/ccsm` dentro del subdominio. En Apache, conserva los `.htaccess`
incluidos: el de la raíz enruta la aplicación y los recursos de `/public`,
bloquea carpetas privadas y permite abrir el instalador. Debe estar activo
`mod_rewrite` y el hosting debe permitir reglas `.htaccess`. El paquete incluye
`index.php` e `install.php` en la raíz como accesos directos y declara `index.php`
como página de inicio; para que funcionen las rutas internas y los recursos, sí
se necesita `.htaccess`.

## 3. Permisos de escritura

El usuario del servidor web (`www-data`, `apache`, etc.) necesita permisos de escritura en:
- `/config` (el instalador reescribe `config.php` y crea `installed.lock`)
- `/logs` (para los errores en producción)
- `/sessions_temp` (se crea sola si no existe, pero necesita poder crearse)
- `/public/uploads` y sus subcarpetas (`socios/`, `productos/`) — para las fotos

```bash
chmod -R 755 config logs public/uploads
# o, si tu hosting lo requiere:
chown -R www-data:www-data config logs sessions_temp public/uploads
```

## 4. Crea un usuario de base de datos

Crea en tu proveedor de hosting (o `mysql`/`mariadb` en tu VPS) un usuario con permisos sobre una base de datos vacía (el instalador puede crear la base de datos si el usuario tiene permiso `CREATE`, pero si tu hosting no lo permite, créala tú antes desde el panel y déjala vacía).

## 5. Ejecuta el instalador

Visita `https://ccsm.dbold.es/install.php` y sigue el asistente: comprobará
los requisitos del servidor y pedirá la base de datos y la cuenta administradora.
Revisa los campos y confirma que es una instalación nueva antes de enviarlos.

1. **Base de datos**: host, puerto, nombre, usuario y contraseña.
2. **Aplicación**: la URL pública o ruta (detectada automáticamente, revísala).
   La configuración generada utiliza siempre producción y deshabilita la demo.
3. **Administrador Maestro**: nombre, email, usuario y contraseña — es la única cuenta que se crea. Desde ella das de alta al resto del personal.

Al enviarlo, el instalador:
- Crea la base de datos si no existe.
- Importa `schema_produccion.sql` (estructura completa + catálogos de sistema: países, géneros, IVA, roles base — **sin** socios, ventas, productos ni usuarios de prueba).
- Crea tu usuario Administrador Maestro con acceso total.
- Crea `config/config.php` con tus datos reales sin reemplazar una configuración existente.
- Deja un candado (`config/installed.lock`) para que el instalador no se pueda volver a ejecutar.

## 6. Después de instalar — obligatorio

1. **Borra `public/install.php`** del servidor.
2. Comprueba que `https://ccsm.dbold.es` carga por HTTPS.
3. Entra en `https://ccsm.dbold.es/login` con el Administrador Maestro y empieza a dar de alta categorías, productos, cuotas, proveedores, variedades, personal y roles desde la propia aplicación — todo eso arranca vacío a propósito.

## ¿Necesitas reinstalar desde cero?

Usa una copia independiente sin configuración ni candados y una base nueva
vacía, después de hacer las copias de seguridad pertinentes. El instalador no
ofrece reinstalación forzada, no elimina tablas y rechaza cualquier base que
ya las contenga. La creación de tablas en MariaDB no se revierte
automáticamente: si una instalación falla a mitad, revisa esa base antes
de volver a intentarlo.

Para comprobar el instalador sin modificar la configuración ni los datos
actuales, ejecuta `php tests/instalador.php`. Usa un directorio y una base
temporal exclusivos y los elimina al finalizar.

Las regresiones de subida de productos se comprueban con
`python3 tests/productos_imagenes_http.py`: arranca un servidor PHP local
temporal, envía imágenes mediante formularios multipart y verifica que los
nombres vacíos o IDs inexistentes no crean archivos ni cambian el catálogo.
También comprueba subidas válidas y elimina su entorno demo al terminar.

## Actualizar categorías con iconos

En una instalación existente con MariaDB, ejecuta una vez
[`migracion_iconos_categorias.sql`](./migracion_iconos_categorias.sql) en la base de
datos antes de desplegar el código actualizado. Añade el campo `icono` sin
modificar las imágenes ni los demás datos existentes. Las instalaciones nuevas
ya incluyen el campo en el esquema.

En el alta o la edición de una categoría se puede seleccionar un icono de
Bootstrap Icons (MIT, servido localmente) o «Sin icono». El icono aparece en el
listado de categorías y en los filtros del dispensario; el nombre sigue visible.

El selector agrupa los símbolos de flores, resinas, aceites, vaporizadores,
papel de liar y filtros en «Dispensario» y conserva los iconos anteriores en
«Generales». Son representaciones aproximadas de Bootstrap Icons, no imágenes
específicas de los productos.

## Acceso demo aislado

Para mostrar el botón «Entrar en demo», añade `define('DEMO_ENABLED', true);` a
`config/config.php`. Para deshabilitar nuevas entradas, cambia el valor a `false`.
Si la constante no existe, el botón y las nuevas entradas demo quedan deshabilitados.

Cada sesión demo crea una base MariaDB independiente con el prefijo
`ccsm_demo_`, a partir de `schema_produccion.sql` y `demo_datos.sql`.
No copia registros reales: usa socios, personal, categorías, productos y
proveedores ficticios. El usuario demo tiene permisos de administrador dentro de
ese entorno. Las operaciones se conservan entre peticiones de la misma sesión,
pero no modifican los datos de negocio reales. Las fotos se guardan en un directorio temporal
privado y se sirven solo a su sesión demo.

El usuario de conexión a MariaDB necesita permisos para crear, utilizar y
eliminar las bases demo. No habilites el botón si el hosting no lo permite.
También se necesita escritura en el directorio temporal de PHP. La demo falla
explícitamente si no puede preparar su entorno; nunca utiliza la base real
como alternativa.

Limita los permisos adicionales al prefijo de bases demo; no es necesario
conceder acceso administrativo global a MariaDB.

El acceso exige nombre, email y confirmación de lectura del aviso. Antes de
habilitarlo en una instalación existente, aplica `migracion_registro_demo.sql`
en la base real. Las instalaciones nuevas ya incluyen la tabla `demo_usos`.
El registro de visitas es una excepción explícita al aislamiento: conserva en
la base real nombre, email normalizado, inicio, caducidad, fin, estado y
sugerencias opcionales. El email no se verifica; se utiliza para contabilizar
repeticiones, no como identificación autenticada. No se guardan operaciones
de negocio reales ni se copian datos personales reales a las demos.

Al pulsar Salir se solicitan sugerencias opcionales: «Enviar y salir» o «Salir
sin enviar». Al completar la salida se elimina la base demo y sus fotos.
La sesión caduca dos horas después de entrar: la siguiente petición descarta
el entorno y ofrece dejar sugerencias. Cerrar el navegador no puede mostrar
ese formulario; la limpieza registra la caducidad de las demos abandonadas.
Si caduca mientras se envía el formulario de salida, se conserva su autorización
y se procesa la respuesta sin perder las sugerencias.
El registro permanente no tiene borrado automático. Antes de publicar, define
una política de conservación y facilita tu información de privacidad/contacto
para gestionar solicitudes sobre estos datos.
Las demos abandonadas se eliminan cuando entra otra demo. Para limpiarlas aunque
no haya visitantes, programa con el mismo usuario del servidor web:

```bash
php /ruta/ccsm/bin/limpiar_demo.php
```

Puede ejecutarse cada diez minutos. No elimina sesiones que todavía estén
procesando una petición. Las cookies del navegador delimitan la sesión:
las pestañas del mismo navegador comparten una demo; otro navegador o ventana
privada tiene su propio entorno.

Comprobaciones locales (la segunda necesita que la aplicación esté sirviéndose):

```bash
php tests/demo.php
python3 tests/demo_http.py http://ccsm.dbold.local
php tests/registro_demo.php
php tests/demo_caducidad.php
php tests/demo_caducidad.php invalido
```

Las pruebas eliminan sus entornos demo y verifican que no se alteran los
registros de negocio ni las fotos reales. Las pruebas de seguimiento crean
visitas ficticias con emails únicos y eliminan exclusivamente sus registros.

## Informes

La sección `/informes` está disponible en la navegación para administradores
(perfil 1), incluida la demo. Incluye historial de ventas y compras y ventas
agrupadas por producto y por socio. Permite filtrar por fechas (día final
incluido), producto y socio o proveedor. Los totales corresponden a todo el
filtro, no solo a la página visible; se muestran 50 resultados por página.

Cada operación es una línea de venta o compra, no un ticket agrupado. Los
informes utilizan los importes registrados y las relaciones actuales del
catálogo. Separan unidades y gramos; las cantidades sin medida se indican
aparte. El sistema existente elimina las ventas anuladas, por lo que no se
puede consultar un historial de anulaciones con los datos actuales.

Ejecuta `php tests/informes.php` para comprobar los cuatro informes, filtros,
límites de fechas, paginación y acceso. Usa un entorno demo temporal que se
elimina al finalizar y no modifica los datos reales.

Los administradores fuera del modo demo disponen además de `/informes/demo`,
enlazado desde Informes: total de usos, emails distintos, visitantes que
repiten, número de visita, fechas y sugerencias, con 50 visitas por página.
Este informe permanente no está disponible para los usuarios demo, ni mediante
su URL directa, para evitar exponer nombres, emails y sugerencias reales.

## Análisis de la demo y contacto

Antes de actualizar una instalación existente, aplica
`migracion_analitica_contacto.sql` después de `migracion_registro_demo.sql`.
Los esquemas de instalaciones nuevas ya incluyen estas tablas y columnas.

La analítica funciona únicamente en demos con un registro de visitante. Guarda
sección y acción de una lista cerrada, fecha y resultado (`ok`, `error` o
`desconocido` cuando el módulo no confirma su resultado). También registra
subidas intentadas sin nombres de archivo ni contenido. No incluye parámetros
de URL, valores de formularios, datos de negocio, textos de errores, IP,
agentes de navegador, pulsaciones ni grabaciones. Las valoraciones de facilidad
(1-5) e intención de instalar son opcionales; «Salir sin enviar» las omite.
Los registros técnicos propios de Apache o del proveedor de hosting son
independientes de esta analítica; revisa su configuración y política de privacidad.

La actividad es una estimación: cada 30 segundos, solo con pestaña visible e
interacción reciente, se envía una señal sin contenido ni eventos del teclado.
El servidor limita cada intervalo a 35 segundos y exige el token de esa sesión.
No cuenta una pestaña olvidada como dos horas de uso activo. El informe muestra
totales, errores, última actividad, valoraciones y recorrido por visita.
No se usan servicios externos ni se envía telemetría desde instalaciones
descargadas a otro servidor. Un fallo de analítica se registra en el servidor;
un fallo de señal de actividad se avisa sin impedir las operaciones de prueba.
Ejecuta `php tests/analitica_contacto.php` y
`python3 tests/demo_http.py http://ccsm.dbold.local` para comprobar privacidad,
resultados, valoración, límites de actividad y validación del contacto.
`node tests/demo_actividad.js` comprueba que no se envían señales desde una
pestaña oculta o inactiva ni contenido de las interacciones.

`/contacto` ofrece un formulario breve de conversación: tema, mensaje, email
y nombre opcional. Los mensajes enviados **sí se conservan** en la base real,
también si se envían desde la demo, con un aviso separado y confirmación de
lectura. No son datos de prueba y no se borran al salir. No se envía correo
automático: `/contacto/bandeja` permite a administradores reales leerlos,
marcarlos como leídos y abrir su propio cliente de correo para responder.
Los usuarios demo no pueden ver la bandeja ni marcar mensajes como leídos.
El formulario incluye CSRF, campo antispam y un límite de un envío por minuto
por sesión; no sustituye a un límite de peticiones del servidor para una web
abierta. Conservación y gestión de solicitudes de privacidad son responsabilidad
de cada instalación.
