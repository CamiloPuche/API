<?php

include "connection.php";

try {
    $statement = $database->prepare("SELECT * FROM carro");

    $statement->execute();
    $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);

    $database = null;

    header('Content-type:application/json;charset=utf-8');
    echo json_encode($resultado);

} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}