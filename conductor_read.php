<?php
include "connection.php";

try {
    $id_conductor = $_GET["id_conductor"];

    $statement=$database->prepare("SELECT * from conductor WHERE id_conductor = :id_conductor");
    $statement->bindParam(":id_conductor", $id_conductor);
    $statement->execute();

    $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);

    $id_vehiculo = $resultado[0]['id_vehiculo'];
    $statement=$database->prepare("SELECT * from carro WHERE id_carro = :id_vehiculo");
    $statement->bindParam(":id_vehiculo", $id_vehiculo);
    $statement->execute();

    $resultado2 = $statement->fetchAll(PDO::FETCH_ASSOC);
    $resultado [0]['Carro asignado'] = $resultado2;

    $database = null;

    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        $resultado[0]
    ]);

} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}