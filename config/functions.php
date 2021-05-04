<?php
// model.php
 
 require_once 'config.php'; 

function openConex(){
	$conex=new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
	mysqli_set_charset($conex,'utf8');
	
    return $conex;
}    
 
function getSocios(){	
	$mysqli = openConex();
	
	$result = $mysqli->query('SELECT * FROM socios ORDER BY id desc');	

	return $result;	
}
function getRoles(){
	$mysqli = openConex();

	$result = $mysqli->query('SELECT * FROM roles ORDER BY id desc');

	return $result;
}
function getCategorias(){
	$mysqli = openConex();

	$result = $mysqli->query('SELECT * FROM categorias');

	return $result;
}
function getTemas(){
	$mysqli = openConex();

	$result = $mysqli->query('SELECT id, color FROM temas ORDER BY id desc');

	return $result;
}
function getSetings(){
	$mysqli = openConex();

	$result = $mysqli->query('SELECT * FROM settings');

	return $result;
}
function getColor(){
	$mysqli = openConex();

	$result = $mysqli->query('SELECT nombre FROM color_tema');

	return $result;
}
function getFuente(){
	$mysqli = openConex();

	$result = $mysqli->query('SELECT fuente FROM fuentes');

	return $result;
}
function getVariedades(){
	$mysqli = openConex();

	$result = $mysqli->query('SELECT nombre FROM variedades');

	return $result;
}
function getProductos(){
	$mysqli = openConex();

	$result = $mysqli->query('SELECT * FROM productos');

	return $result;
}

function getSociosById($id){
	$mysqli = openConex();
 
	$result = $mysqli->query('SELECT * FROM socios WHERE id ='.$id);
	$row = mysqli_fetch_assoc($result);
	
    return $row;
}

function getRolesById($id){
	$mysqli = openConex();

	$result = $mysqli->query('SELECT * FROM roles WHERE id =' . $id);
	$row = mysqli_fetch_assoc($result);

	return $row;
}

function getCategoriasById($id){
	$mysqli = openConex();

	$result = $mysqli->query('SELECT * FROM categorias WHERE id =' . $id);
	$row = mysqli_fetch_assoc($result);

	return $row;
}

function getSetingsById($id){
	$mysqli = openConex();

	$result = $mysqli->query('SELECT * FROM settings WHERE id =' . $id);
	$row = mysqli_fetch_assoc($result);

	return $row;
}

function getColorById($id){
	$mysqli = openConex();

	$result = $mysqli->query('SELECT * FROM color_tema WHERE id =' . $id);
	$color_tema = mysqli_fetch_assoc($result);

	return $color_tema;
}

function getFuenteById($id){
	$mysqli = openConex();

	$result = $mysqli->query('SELECT * FROM fuentes WHERE id =' . $id);
	$fuente_tema = mysqli_fetch_assoc($result);

	return $fuente_tema;
}

function getProductosById($id){
	$mysqli = openConex();

	$result = $mysqli->query('SELECT * FROM productos WHERE id =' . $id);
	$row = mysqli_fetch_assoc($result);

	return $row;
}

?>

