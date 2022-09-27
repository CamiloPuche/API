<?php
include "connection.php";

$json = json_decode(file_get_contents("php://input"), true);
try {
    $id_conductor = $json['id_conductor'];

    $statement = $database->prepare("SELECT * from conductor WHERE id_conductor = :id_conductor");
    $statement -> bindParam(":id_conductor", $id_conductor);
    $statement -> execute();
    $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);

    $id_vehiculo = $resultado[0]['id_vehiculo'];
    $statement = $database->prepare("SELECT * from carro WHERE id_carro = :id_vehiculo");
    $statement -> bindParam(":id_vehiculo", $id_vehiculo);
    $statement -> execute();
    $resultado2 = $statement->fetchAll(PDO::FETCH_ASSOC);

    $resultado[0]['Carro asignado'] = $resultado2[0];

    $statement = $database->prepare("DELETE FROM conductor WHERE id_conductor = :id_conductor");
    $statement->bindParam(":id_conductor", $id_conductor);
    $statement->execute();

    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        'mensaje' => "Registro eliminado correctamente",
        'Conductor eliminado' =>$resultado
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