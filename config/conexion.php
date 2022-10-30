<?php

$servidor="mysql:dbname=empleadosdb;host=127.0.0.1";
$usuario="root";
$password="";
/*array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8") -> para poder agregar caracteres especiales */
try {
   $pdo= new PDO($servidor,$usuario,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
   //echo "La conexión a sido exitosa";
} catch (PDOException $e) {
    // pide que devuelva el error que tiene al momento de conectarse
    echo "La conexión a fallado".$e->getMessage();
}

?>