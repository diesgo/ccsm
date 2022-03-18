
<?php
// define('DBUSER','root');
// define('DBPWD','');
// define('DBHOST','localhost');
// define('DBNAME','greenpower');

// $conex=new mysqli(DBHOST, DBUSER, DBPWD, DBNAME); 
 
// mysqli_set_charset($conex,'utf8');


// if (mysqli_connect_error()) {
//     die('Error de Conexión (' . mysqli_connect_error() . ') '
//             . mysqli_connect_error());
// }

// echo 'Éxito... ' . $conex->host_info. "\n";

// FUNCIONES PARA LA TABLA SOCIOS

function openConex(){
	$conex=new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
	mysqli_set_charset($conex,'utf8');
    return $conex;
}

function getSocios(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM socios
	JOIN paises ON id_pais = pais_id
	JOIN genero ON id_genero = genero_id
	JOIN roles ON id_rol = rol_id
	ORDER BY id_socio desc');
	return $result;
}

function getSociosById($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM socios
	JOIN paises ON id_pais = pais_id
	JOIN genero ON id_genero = genero_id
	JOIN roles ON id_rol = rol_id
	WHERE id_socio =' . $id);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

function showSocio($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM socios WHERE id_socio=' . $id);
	return $result;
}

function getNumSocios(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT count(*)FROM socios');
	return $result;
}

// FUNCIONES PARA LA TABLA ROLES

function getRoles(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM roles ORDER BY id_rol desc');
	return $result;
}

function getRolesById($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM roles WHERE id_rol =' . $id);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

// FUNCIONES PARA LA TABLA CATEGORIAS

function getCategorias(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM categorias ORDER BY id_categoria DESC');
	return $result;
}

function getCategoriasById($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM categorias WHERE id_categoria =' . $id);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

function showCategoria($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM productos WHERE id=' . $id);
	return $result;
}

function dispatchCategoria($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM productos WHERE id=' . $id);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

// FUNCIONES PARA LA TABLA TEMAS

function getTemas(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT id, color FROM temas ORDER BY id desc');
	return $result;
}

// FUNCIONES PARA LA TALBA SETTINGS

function getSetings(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM settings');
	return $result;
	$conex ->close();
}

function getSetingsById($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM settings WHERE id =' . $id);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

// FUNCIONES PARA LA TABLA COLOR

function getColor(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT nombre FROM color_tema');
	return $result;
}

function getColorById($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM color_tema WHERE id =' . $id);
	$color_tema = mysqli_fetch_assoc($result);
	return $color_tema;
}

// FUNCIONES PARA LA TABLA FUENTES

function getFuente(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT fuente FROM fuentes');
	return $result;
}

function getFuenteById($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM fuentes WHERE id =' . $id);
	$fuente_tema = mysqli_fetch_assoc($result);
	return $fuente_tema;
}

// FUNCIONES PARA LA TABLA VARIEDADES

function getVariedades(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM variedades');
	return $result;
}

function getVariedadesById($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM variedades WHERE id_variedad =' . $id);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

// FUNCIONES PARA LA TABLA SERVICIOS

function getServicios(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM servicios');
	return $result;
}

function getServiciosById($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM servicios WHERE id_servicio =' . $id);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

// FUNCIONES PARA LA TABLA PROVEEDORES

function getProveedores(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM proveedores');
	return $result;
	$conex ->close();
}

function getProveedoresById($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM proveedores WHERE id_proveedor =' . $id);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

// FUNCIONES PARA LA TABLA USERS

function getUsers(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM users');
	return $result;
}

function getUsersById($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM users WHERE id_user =' . $id);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

// FUNCIONES PARA LA TABLA PRODUCTOS

function getProductos(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM productos
	INNER JOIN categorias ON id_categoria = categoria_id
	INNER JOIN variedades ON id_variedad = variedad_id
	INNER JOIN servicio ON id_servicio = servicio_id');
	return $result;
	echo $result;
}

function getNumProducts(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT id_producto FROM productos');
	return $result;
	echo $result;
}

function getProductosById($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM productos
	WHERE id_producto = ' . $id);
	$row = mysqli_fetch_assoc($result);
	return $row;
	$conex ->close();
}

function getProductsById($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM productos
	INNER JOIN categorias ON id_categoria = categoria_id
	INNER JOIN variedades ON id_variedad = variedad_id
	INNER JOIN servicios ON id_servicio = servicio_id
	WHERE id_producto = ' . $id);
	$row = mysqli_fetch_assoc($result);
	return $row;
	$conex ->close();
}

function getProductsByCategory($categoria_id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM productos WHERE categoria_id =' . $categoria_id);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

// FUNCIONES PARA LA TABLA ICONOS

function getIconos(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM iconos');
	return $result;
}

// FUNCIONES PARA LA TABLA PAISES

function getPaises(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM paises');
	return $result;
}

function showPais($pais_id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT pais FROM paises WHERE id_pais=' . $pais_id);
	return $result;
}

function getPaisesById($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM productos WHERE categoria =' . $id);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

function getPaisesSocios(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT count(pais_id), pais, bandera FROM socios JOIN paises ON id_pais = pais_id');
	return $result;
}

function getRecargasByProduct($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM recargas WHERE producto_id =' . $id);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

?>