<?php
$idCategoria = filter_input(INPUT_POST, "idCategoria");

mysql_connect("localhost", "root", "frodo2013") or die ("Connection Error: " . mysql_error());
mysql_select_db("pruebaestudio") or die ("Connection Error: " . mysql_error());

$sql = "Select * from articulos where idCategorias = $idCategoria;";
$result = mysql_query($sql) or die("Couldn't execute query: " . mysql_error());
$i = 0;
while($fila = mysql_fetch_array($result, MYSQL_ASSOC)){
    $datos[$i] = array(
        'idArticulo'=>$fila["idArticulo"], 
        'nombreArticulo'=>$fila["nombreArticulo"], 
        'descripcionArticulo'=>$fila["descripcionArticulo"], 
        'precioArticulo'=>$fila["precioArticulo"], 
        'idCategorias'=>$idCategoria);
    $i++;
}
header('Content-type: application/json');

echo json_encode($datos);
