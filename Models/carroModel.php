<?php

require_once 'connection.php';

class carro
{
    private $database;

    public function __construct()
    {
        $this->database = connection::conectar();
    }

    public function validar_datos($datos)
    {
        $cant_pasajeros = $datos['cant_pasajeros'];
        if (!is_numeric($cant_pasajeros)) {
            return "Error en el campo ´cant_pasajeros´ solo se permiten datos numericos";
        }
        return "Datos correctos";
    }

    public function carro_create($datos)
    {
        $validacion = $this->validar_datos($datos);
        if (hash_equals($validacion, "Datos correctos")) {
            $statement = $this->database->prepare("INSERT INTO carro (placa, marca, cant_pasajeros) VALUES (:placa, :marca, :cant_pasajeros)");
            $statement->bindParam(':placa', $datos['placa']);
            $statement->bindParam(':marca', $datos['marca']);
            $statement->bindParam(':cant_pasajeros', $datos['cant_pasajeros']);
            $statement->execute();
            return $this->codificar_Json("Carro registrado exitosamente: ", $datos);
        }
        return $this->codificar_Json("Error: ", $validacion);
    }

    public function carro_get()
    {
        $statement = $this->database->prepare("SELECT * FROM carro");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->codificar_Json("Carros: ", $result);
    }

    public function carro_read($id_carro)
    {
        $statement = $this->database->prepare("SELECT * from carro WHERE id_carro = :id_carro");
        $statement->bindParam(":id_carro", $id_carro);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($result == false) {
            return null;
        }

        return $result;
    }

    public function carro_update($id_carro, $datos)
    {
        $validacion = $this->validar_datos($datos);
        if (hash_equals($validacion, "Datos correctos")) {
            $statement = $this->database->prepare("UPDATE carro SET placa = :placa, marca = :marca, cant_pasajeros = :cant_pasajeros WHERE id_carro = :id_carro");

            $statement->bindParam(':placa', $datos['placa']);
            $statement->bindParam(':marca', $datos['marca']);
            $statement->bindParam(':cant_pasajeros', $datos['cant_pasajeros']);
            $statement->bindParam(":id_carro", $id_carro);

            $statement->execute();
            return $this->codificar_Json("Carro actualizado exitosamente", $this->codificar_Json("Carro: ", $datos));
        }
        return $this->codificar_Json("Error", $validacion);
    }

    public function carro_delete($id_carro)
    {
        $result = $this->carro_read($id_carro);
        if ($result != null) {
            $statement = $this->database->prepare("DELETE FROM carro WHERE id_carro = :id_carro");
            $statement->bindParam(":id_carro", $id_carro);
            $statement->execute();
            return $this->codificar_Json("Carro eliminado exitosamente", $result);
        }

        return $this->codificar_Json("Error", "El carro a eliminar no existe");
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
}