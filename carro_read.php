<?php

include "connection.php";

try {
    $id_carro = $_GET["id_carro"];
    $statement = $database->prepare("SELECT * from carro WHERE id_carro = :id_carro");

    $statement->bindParam(":id_carro", $id_carro);

    $statement->execute();

    $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
    $database = null;

    header('Content-type:application/json;charset=utf-8');
    echo json_encode($resultado);

} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>