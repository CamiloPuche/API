<?php

require_once "Models/connection.php";

try {
    $statement = $database = connection::conectar()->prepare("SELECT * FROM carro");

    $statement->execute();
    $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);

    $database = null;

    header('Content-type:application/json;charset=utf-8');
    echo json_encode($resultado);

} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}