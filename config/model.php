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
	
	$result = $mysqli->query('SELECT id, nombre, apellidos, dni, birth, pais, rol, genero, consumo, saldo FROM socios ORDER BY id desc');	

	return $result;	
}
function getRoles()
{
	$mysqli = openConex();

	$result = $mysqli->query('SELECT id, rol, descripcion FROM roles ORDER BY id desc');

	return $result;
}
function getCategorias()
{
	$mysqli = openConex();

	$result = $mysqli->query('SELECT id, categoria, descripcion FROM categorias ORDER BY id desc');

	return $result;
}
function getTemas()
{
	$mysqli = openConex();

	$result = $mysqli->query('SELECT id, color FROM temas ORDER BY id desc');

	return $result;
}
function getSetings()
{
	$mysqli = openConex();

	$result = $mysqli->query('SELECT color, fuente FROM settings ORDER BY id desc');

	return $result;
}

function getSociosById($id)
{
	$mysqli = openConex();
 
	$result = $mysqli->query('SELECT date, id, nombre, apellidos, dni, birth, pais, rol, genero, consumo, saldo FROM socios WHERE id ='.$id);
	$row = mysqli_fetch_assoc($result);
	
    return $row;
}

function getRolesById($id)
{
	$mysqli = openConex();

	$result = $mysqli->query('SELECT date, id, rol, descripcion FROM roles WHERE id =' . $id);
	$row = mysqli_fetch_assoc($result);

	return $row;
}

function getCategoriasById($id)
{
	$mysqli = openConex();

	$result = $mysqli->query('SELECT date, id, nombre, descripcion FROM categorias WHERE id =' . $id);
	$row = mysqli_fetch_assoc($result);

	return $row;
}

function getSetingsById()
{
	$mysqli = openConex();

	$result = $mysqli->query('SELECT date, id, color, fuente FROM settings WHERE id =1');
	$row = mysqli_fetch_assoc($result);

	return $row;
}

?>

