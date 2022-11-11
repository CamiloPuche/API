<?php

require_once 'Models/connection.php';
require_once 'Models/carroModel.php';

class conductor
{
    private $database;
    public $carro_fk;

    public function __construct()
    {
        $this->database = connection::conectar();
        $this->carro_fk = new carro();
    }

    public function validar_datos($datos)
    {
        $cedula = $datos['cedula'];
        $bono_extras = $datos['bono_extras'];

        if (!is_numeric($cedula)) {
            return "Error en el campo ´cedula´ solo se permiten datos numericos";
        }
        if (!is_float($bono_extras)) {
            return "Error en el campo ´bono_extras´ solo se permiten datos numericos";
        }

        return "Datos correctos";
    }

    public function codificar_Json($dato, $valor)
    {
        header('Content-type:application/json;charset=utf-8');
        return json_encode(
            [
                $dato => $valor
            ]
        );
    }

    public function conductor_get_fk($id_conductor)
    {
        return $this->conductor_read($id_conductor);
    }

    public function conductor_get()
    {
        $statement = $this->database->prepare("SELECT * FROM conductor");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->database = null;
        for ($i = 0; $i < count($result); $i++) {
            $id_vehiculo = $result[$i]['id_vehiculo'];
            $result[$i]['Carro asignado: '] = $this->carro_fk->carro_read($id_vehiculo);
        }

        return $this->codificar_Json("Conductor: ", $result);
    }


    public function conductor_read($id_conductor)
    {
        $statement = $this->database->prepare("SELECT * from conductor WHERE id_conductor = :id_conductor");
        $statement->bindParam(":id_conductor", $id_conductor);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $id_vehiculo = $result[0]['id_vehiculo'];
        $result[0]['Carro asignado:'] = $this->carro_fk->carro_read($id_vehiculo);

        if ($result == false) {
            return null;
        }

        return $result;
    }


    public function conductor_create($datos)
    {
        $validacion = $this->validar_datos($datos);
        if (hash_equals($validacion, "Datos correctos")) {
            $carro_fk = $this->carro_fk->carro_read($datos['id_vehiculo']);
            if ($carro_fk != null) {
                $statement = $this->database->prepare("INSERT INTO conductor (cedula, nombres, apellidos, fecha, fecha_contratacion, fecha_terminacion, bono_extras, email, id_vehiculo) VALUES (:cedula, :nombres, :apellidos, :fecha, :fecha_contratacion, :fecha_terminacion, :bono_extras, :email, :id_vehiculo)");
                $statement->bindParam(':cedula', $datos['cedula']);
                $statement->bindParam(':nombres', $datos['nombres']);
                $statement->bindParam(':cant_pasajeros', $datos['apellidos']);
                $statement->bindParam(':fecha', $datos['fecha']);
                $statement->bindParam(':fecha_contratacion', $datos['fecha_contratacion']);
                $statement->bindParam(':fecha_terminacion', $datos['fecha_terminacion']);
                $statement->bindParam(':bono_extras', $datos['bono_extras']);
                $statement->bindParam(':email', $datos['email']);
                $statement->bindParam(':id_vehiculo', $datos['id_vehiculo']);
                $statement->execute();
                //$result = $statement->fetchAll(PDO::FETCH_ASSOC);
                $datos["Carro asignado: "] = $carro_fk;
                return $this->codificar_Json("Datos ingresados", $datos);
            }
            return $this->codificar_Json("Error", "El carro que se desea asignar no existe");
        }
        return $this->codificar_Json("Error", $validacion);
    }

    public function conductor_update($id_conductor, $datos)
    {
        $validacion = $this->validar_datos($datos);
        if (hash_equals($validacion, "Datos correctos")) {
            $statement = $this->database->prepare("UPDATE conductor SET cedula = :cedula, nombres = :nombres, apellidos = :apellidos, fecha = :fecha, fecha_contratacion = :fecha_contratacion, fecha_terminacion = :fecha_terminacion, bono_extras = :bono_extras, email = :email, id_vehiculo = :id_vehiculo WHERE id_conductor = :id_conductor");
            $statement->bindParam(':cedula', $datos['cedula']);
            $statement->bindParam(':nombres', $datos['nombres']);
            $statement->bindParam(':cant_pasajeros', $datos['apellidos']);
            $statement->bindParam(':fecha', $datos['fecha']);
            $statement->bindParam(':fecha_contratacion', $datos['fecha_contratacion']);
            $statement->bindParam(':fecha_terminacion', $datos['fecha_terminacion']);
            $statement->bindParam(':bono_extras', $datos['bono_extras']);
            $statement->bindParam(':email', $datos['email']);
            $statement->bindParam(':id_vehiculo', $datos['id_vehiculo']);
            $statement->bindParam(":id_conductor", $id_conductor);
            $statement->execute();

            $result = $this->conductor_get_fk($datos['id_conductor']);
            $carro_fk = $this->carro_fk->carro_read($result[0]['id_vehiculo']);
            $result[0]["Carro asignado: "] = $carro_fk[0];
            return $this->codificar_Json("Conductor actualizado correctamente", $result);
        }
        return $this->codificar_Json("Error", $validacion);
    }

    public function conductor_delete($id_conductor)
    {
        $result = $this->conductor_read($id_conductor);
        $carro_fk = $this->carro_fk->carro_read($result[0]['id_vehiculo']);
        $result[0]["Carro asignado: "] = $carro_fk[0];
        $statement = $this->database->prepare("DELETE FROM conductor WHERE id_conductor = :id_conductor");

        $statement->bindParam(':id_conductor', $id_conductor);
        $statement->execute();
        return $this->codificar_Json("Conductor eliminado correctamente", $result);
    }
}