<?php

session_start();

if ($_POST["username"] == null || $_POST["password"] == null) {
    header('Location: ../login.php');
} else {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $username = stripslashes($username);
    $password = stripslashes($password);

    $username = mysql_real_escape_string($username);
    $password = mysql_real_escape_string($password);
    
    mysql_connect("localhost","root","frodo2013") or die ("Couldn't connect to DB".  mysql_error());
    mysql_select_db("pruebaestudio") or die ("Couldn't connect to DB".mysql_error());
    
    $sql = "SELECT * FROM clientes WHERE login = '$username' AND password = '$password';";
    echo $sql;
    $result = mysql_query($sql) or die("Couldn't execute query".  mysql_error());
    
    $fila = mysql_fetch_array($result, MYSQL_ASSOC);
    
    if($password == $fila["password"]){
        $_SESSION["username"] = $username;
        header("Location: ../portal.php");
    }else{
        header("Location: ../login.php");
    }
}
