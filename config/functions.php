<?php
// model.php
 
 require_once 'config.php'; 

function openConex(){
	$conex=new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
	mysqli_set_charset($conex,'utf8');
    return $conex;
}    

// FUNCIONES PARA LA TABLA SOCIOS
 
function getSocios(){	
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM socios ORDER BY id desc');	
	return $result;	
}
function getSociosById($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM socios WHERE id =' . $id);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

// FUNCIONES PARA LA TABLA ROLES

function getRoles(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT id, nombre, descripcion FROM roles ORDER BY id desc');
	return $result;
}
function getRolesById($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT id, nombre, descripcion FROM roles WHERE id =' . $id);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

// FUNCIONES PARA LA TABLA CATEGORIAS

function getCategorias(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM categorias');
	return $result;
}
function getCategoriasById($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM categorias WHERE id =' . $id);
	$row = mysqli_fetch_assoc($result);
	return $row;
}
function showCategoria($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM productos WHERE id=' . $id );
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
	$result = $mysqli->query('SELECT id, nombre FROM variedades');
	return $result;
}
function getVariedadesById($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT id, nombre FROM variedades WHERE id =' . $id);
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
?>