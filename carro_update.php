<?php
include "connection.php";

$json = json_decode(file_get_contents("php://input"), true);

try {
    $id_carro = $json['id_carro'];
    $placa = $json['placa'];
    $marca = $json['marca'];
    $cant_pasajeros = $json['cant_pasajeros'];

    $statement = $database->prepare("UPDATE carro SET placa = :placa, marca = :marca, cant_pasajeros = :cant_pasajeros WHERE id_carro = :id_carro");

    $statement->bindParam(':placa', $placa);
    $statement->bindParam(':marca', $marca);
    $statement->bindParam(':cant_pasajeros', $cant_pasajeros);
    $statement->bindParam(':id_carro', $id_carro);

    $statement->execute();

    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        'mensaje' => "Registro actualizado correctamente",
        'Carro actualizado' => $json
    ]);
} catch (PDOException $e) {
    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        'error' => [
            'codigo' => $e->getCode(),
            'mensaje' => $e->getMessage()
        ]
    ]);
}