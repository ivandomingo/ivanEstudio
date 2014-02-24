<?php

mysql_connect("localhost", "root", "frodo2013") or die("Connection Error: " . mysql_error());
mysql_select_db("pruebaestudio") or die("Error connecting to DB: " . mysql_error());

$sql = "Select * from categorias;";
$result = mysql_query($sql) or die("Couldn't execute query: " . mysql_error());

$i = 0;
while ($fila = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $datos[$i] = array(
        'idCategoria' => $fila["idCategoria"],
        'nombreCategoria' => $fila["nombreCategoria"]);
    $i++;
}
header('Content-type: application/json');
echo json_encode($datos);