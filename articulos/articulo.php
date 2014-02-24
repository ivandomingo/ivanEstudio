<?php

$idArticulo = $_POST["idArticulo"];//recibe por post el idArticulo

mysql_connect("localhost", "root", "frodo2013") or die("Connection Error: " . mysql_error());//intenta conectar con la bd
mysql_select_db("pruebaestudio") or die("Connection Error: " . mysql_error());//selecciona la base de datos

$sql = "Select * from articulos where idArticulo = $idArticulo";//selecciona el articulo con el idArticulo
$result = mysql_query($sql) or die("Couldn't execute query: " . mysql_error());//ejecuta el sql y lo guarda en result

$i = 0;
while ($fila = mysql_fetch_array($result, MYSQL_ASSOC)) {//mientras que exista un articulo en result se hace el while
    $datos[$i] = array(
        'idArticulo' => $fila["idArticulo"],//guarda en idArticulo el valor de fila->idArticulo
        'nombreArticulo' => $fila["nombreArticulo"],//guarda en nombreArticulo el valor de fila->nombreArticulo
        'descripcionArticulo' => $fila["descripcionArticulo"],//guarda en desc el valor de fila->descripcion
        'precioArticulo' => $fila["precioArticulo"],//guarda en precio el valor de fila->precio
        'idCategorias' => $fila["idCategorias"]);//guarda en idCategoria el valor de fila->idCategoria
    $i++;
}
header('Content-type: application/json');//indica que va a devolver texto json
echo json_encode($datos);//devuelve el json
