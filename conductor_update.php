<?php
include "connection.php";

$json = json_decode(file_get_contents("php://input"), true);

try {
    $update = $database->prepare("UPDATE conductor SET cedula = :cedula, nombres = :nombres, apellidos = :apellidos, fecha_contratacion = :fecha_contratacion, fecha_terminacion = :fecha_terminacion, bono_extras = :bono_extras, email = :email, id_vehiculo = :id_vehiculo WHERE id_conductor = :id_conductor");

    $id_conductor = $json["id_conductor"];
    $cedula = $json["cedula"];
    $nombres = $json["nombres"];
    $apellidos = $json["apellidos"];
    $fecha_contratacion = $json["fecha_contratacion"];
    $fecha_terminacion = $json["fecha_terminacion"];
    $bono_extras = $json["bono_extras"];
    $email = $json["email"];
    $id_vehiculo = $json["id_vehiculo"];

    $update->bindParam(":cedula", $cedula);
    $update->bindParam(":nombres", $nombres);
    $update->bindParam(":apellidos", $apellidos);
    $update->bindParam(":fecha_contratacion", $fecha_contratacion);
    $update->bindParam(":fecha_terminacion", $fecha_terminacion);
    $update->bindParam(":bono_extras", $bono_extras);
    $update->bindParam(":email", $email);
    $update->bindParam(":id_vehiculo", $id_vehiculo);
    $update->bindParam(":id_conductor", $id_conductor);

    $update->execute();

    $update = $database->prepare("SELECT * from carro WHERE id_carro = :id_vehiculo");
    $update->bindParam(":id_vehiculo", $id_vehiculo);
    $update->execute();
    $resultado = $update->fetchAll(PDO::FETCH_ASSOC);

    $json['Carro asignado'] = $resultado;

    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        'mensaje' => "Registro actualizado correctamente",
        'Conductor actualizado' => $json
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
