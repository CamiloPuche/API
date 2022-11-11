<?php
require_once "Models/connection.php";
    $json = json_decode(file_get_contents("php://input"), true);

try{
    $statement = $database->prepare("INSERT INTO carro (placa, marca, cant_pasajeros) VALUES (:placa, :marca, :cant_pasajeros)");

    $placa = $json['placa'];
    $marca = $json['marca'];
    $cant_pasajeros = $json['cant_pasajeros'];

    $statement->bindParam(':placa', $placa);
    $statement->bindParam(':marca', $marca);
    $statement->bindParam(':cant_pasajeros', $cant_pasajeros);

    $statement->execute();

    $json['id_carro'] = $database->lastInsertId();
    header('Content-type:application/json;charset=utf-8');
    echo json_encode($json);

} catch (PDOException $e) {
    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        'error' => [
            'codigo' => $e->getCode(),
            'mensaje' => $e->getMessage()
        ]
    ]);
}