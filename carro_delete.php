<?php

include "connection.php";

$json = json_decode(file_get_contents("php://input"), true);

try{
    $id_carro = $json['id_carro'];

    $statement = $database->prepare("SELECT * FROM carro WHERE id_carro = :id_carro");
    $statement->bindParam(':id_carro', $id_carro);
    $statement->execute();

    $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $database->prepare("DELETE FROM carro WHERE id_carro = :id_carro");
    $statement->bindParam(':id_carro', $id_carro);
    $statement->execute();

    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        'mensaje' => "Registro eliminado correctamente",
        'Carro eliminado' => $resultado
    ]);

} catch (PDOException $e){
    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        'error' => [
            'codigo' => $e->getCode(),
            'mensaje' => $e->getMessage()
        ]
    ]);
}