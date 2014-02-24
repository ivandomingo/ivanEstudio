<?php
session_start();

//Saca el JSON que recibe
$json = filter_input(INPUT_POST, "carrito");

//Crea una clase estandar donde la ''rellena'' con el JSON
$carrito = new stdClass();
$carrito = json_decode($json);

//Total del precio del pedido
$total = 0;

//Accedemos a los campos del carrito y sacamos la fecha y la lista de los articulos
$fechaCreacion = $carrito->fechaCreacion;
$listaArticulos = $carrito->listaArticulos;
if ($listaArticulos != null) {

    mysql_connect("localhost", "root", "frodo2013") or die("Couldn't connect to the DB" . mysql_error());
    mysql_select_db("pruebaestudio") or die("Couldn't connect to the DB" . mysql_error());

//Con esto sacamos cada precio y unidades de cada articulo y rellenamos la variable total.
    foreach ($listaArticulos as $articulo) {
        $precioArticulo = $articulo->precio;
        $unidadesArticulo = $articulo->unidades;
        $total = $total + ($unidadesArticulo * $precioArticulo);
    }

//Sacamos a través de la variable de session el ID del usuario ==NO FUNCIONA==
    $user = $_SESSION["username"];
    $sql4 = "SELECT idCliente FROM clientes WHERE login = '$user';";
    $result4 = mysql_query($sql4) or die("Couldn't execute query: " . mysql_error());
    $fila2 = mysql_fetch_array($result4, MYSQL_ASSOC);
    $login = $fila2["idCliente"];

//Insertara la cabecera del pedido

    $sql = "INSERT INTO pedidos VALUES (null,'$fechaCreacion',$total,1);";
    $result = mysql_query($sql) or die("Couldn't execute query: " . mysql_error());

//Seleccionamos el id del ultimo pedido hecho por el cliente
    $sql2 = "SELECT MAX(idPedido) AS maximo FROM pedidos WHERE usuario = 1";
    $result2 = mysql_query($sql2) or die("Couldn't execute query: " . mysql_error());
    $fila = mysql_fetch_array($result2, MYSQL_ASSOC);
    $idPedido = $fila["maximo"];

//Sacamos cada articulo de la lista y hacemos un insert por cada uno
    foreach ($listaArticulos as $articulo) {
        $idArticulo = $articulo->idArticulo;
        $precio = $articulo->precio;
        $unidadesArticulo = $articulo->unidades;

        $sql3 = "INSERT INTO detallepedidos VALUES(null,$idPedido,$idArticulo,$precio,$unidadesArticulo);";
        $result3 = mysql_query($sql3) or die("Couldn't execute query: " . mysql_error());
    }

//============== CURL, CONEXION CON OTRA APLICACION ============================//
//
//    $transaccionBancaria = array('userTienda' => "root", 'passwordTienda' => "frodo2013", 'codigoClienteOrigen' => "1", 'codigoClienteDestino' => '2', 'concepto' => "Compra en Densetech", 'total' => $total);
//
//    $url = "/proyecto1_banco_server/api/TransaccionBancaria";
//    $jsonTransaccion = json_encode($transaccionBancaria);
//
//    $curl = curl_init();
//    curl_setopt($curl, CURLOPT_URL, $url);
//    curl_setopt($curl, CURLOPT_POST, 1);
//    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonTransaccion);
//    curl_setopt($curl, CURLOPT_RESTURNTRANSFER, true);
//    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
//        'Content-type: application/json',
//        'Content-length: ' . strlen($jsonTransaccion))
//    );
//    curl_exec($curl) or die(curl_error($curl));
//    curl_close($curl);
} else {
    header('Location: ../portal.php');
}