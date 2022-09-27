<?php

include "connection.php";

try {
    $statement = $database->prepare("SELECT * from conductor");
    $statement->execute();

    $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $database->prepare("SELECT * from carro WHERE id_carro = :id_vehiculo");
    for ($i = 0; $i < count($resultado); $i++) {
        $id_vehiculo = $resultado[$i]['id_vehiculo'];
        $statement->bindParam(":id_vehiculo", $id_vehiculo);
        $statement->execute();

        $resultado2 = $statement->fetchAll(PDO::FETCH_ASSOC);
        $resultado[$i]['Carro asignado'] = $resultado2;
    }

    header('Content-type:application/json;charset=utf-8');
    echo json_encode($resultado);

} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}