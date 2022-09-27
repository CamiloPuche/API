<?php
include "connection.php";

$json = json_decode(file_get_contents("php://input"), true);
try {
    $statement = $database->prepare("INSERT INTO conductor (cedula, nombres, apellidos, fecha_contratacion, fecha_terminacion, bono_extras, email, id_vehiculo) VALUES (:cedula, :nombres, :apellidos, :fecha_contratacion, :fecha_terminacion, :bono_extras, :email, :id_vehiculo)");

    $cedula = $json["cedula"];
    $nombres = $json["nombres"];
    $apellidos = $json["apellidos"];
    $fecha_contratacion = $json["fecha_contratacion"];
    $fecha_terminacion = $json["fecha_terminacion"];
    $bono_extras = $json["bono_extras"];
    $email = $json["email"];
    $id_vehiculo = $json["id_vehiculo"];

    $statement->bindParam(":cedula", $cedula);
    $statement->bindParam(":nombres", $nombres);
    $statement->bindParam(":apellidos", $apellidos);
    $statement->bindParam(":fecha_contratacion", $fecha_contratacion);
    $statement->bindParam(":fecha_terminacion", $fecha_terminacion);
    $statement->bindParam(":bono_extras", $bono_extras);
    $statement->bindParam(":email", $email);
    $statement->bindParam(":id_vehiculo", $id_vehiculo);

    $statement->execute();

    $statement = $database->prepare("SELECT * from carro WHERE id_carro = :id_vehiculo");
    $statement->bindParam(":id_vehiculo", $id_vehiculo);
    $statement->execute();

    $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);

    $json['Carro asignado'] = $resultado;
    header('Content-type:application/json;charset=utf-8');
    echo json_encode([$json]);
} catch (PDOException $e) {
    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        'error' => [
            'codigo' => $e->getCode(),
            'mensaje' => $e->getMessage()
        ]
    ]);
}
