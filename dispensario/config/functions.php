<?php

function openConex(){
	$conex=new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
	mysqli_set_charset($conex,'utf8');
    return $conex;
}

function getSetingsById($id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM settings WHERE id =' . $id);
	$row = mysqli_fetch_assoc($result);
	return $row;
    $conex ->close();
}

function getCategorias(){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM categorias ORDER BY id_categoria ASC');
	return $result;
    $conex ->close();
}

function getProductsByCategory($categoria_id){
	$mysqli = openConex();
	$result = $mysqli->query('SELECT * FROM productos WHERE categoria_id =' . $categoria_id);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

?>