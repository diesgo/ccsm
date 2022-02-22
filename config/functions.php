<?php
define('DBUSER','root');
define('DBPWD','');
define('DBHOST','localhost');
define('DBNAME','greenpower');

$conex=new mysqli(DBHOST, DBUSER, DBPWD, DBNAME); 
 
mysqli_set_charset($conex,'utf8');


if (mysqli_connect_error()) {
    die('Error de Conexión (' . mysqli_connect_error() . ') '
            . mysqli_connect_error());
}

echo 'Éxito... ' . $conex->host_info. "\n";

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

function getSociosById($id_socio){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM socios
	JOIN paises ON id_pais = pais_id
	JOIN genero ON id_genero = genero_id
	JOIN roles ON id_rol = rol_id
	WHERE id_socio =' . $id_socio);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

function showSocio($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM socios WHERE id_socio=' . $id_socio);
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
	$result = $mysqli->query('SELECT id_rol, rol, descripcion FROM roles ORDER BY id_rol desc');
	return $result;
}

function getRolesById($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT id_rol, rol, descripcion FROM roles WHERE id_rol =' . $id);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

// FUNCIONES PARA LA TABLA CATEGORIAS

function getCategorias(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM categorias INNER JOIN iconos ON id_icono = icono_id');
	return $result;
}

function getCategoriasById($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM categorias INNER JOIN iconos ON id_icono = icono_id WHERE id_categoria =' . $id);
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

// FUNCIONES PARA LA TABLA PRODUCTOS

function getProductos(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM productos');
	return $result;
}

function getProductosById($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM productos WHERE id =' . $id);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

function getProductsByCategory($categoria){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM productos WHERE categoria =' . $categoria);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

// FUNCIONES PARA LA TABLA ICONOS

function getIcono(){
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
?>
