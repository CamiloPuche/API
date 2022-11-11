<?php

require_once 'Models/carroModel.php';

class carro_controller
{
    private $carro;

    public function __construct()
    {
        $this->carro = new carro();
    }

    public function carro_listar()
    {
        return $this->carro->carro_get();
    }

    public function carro_read($id_carro)
    {
        return $this->carro->codificar_Json("Carro: ", $this->carro->carro_read($id_carro));
    }

    public function carro_create($datos)
    {
        return $this->carro->carro_create($datos);
    }

    public function carro_update($id_carro, $datos)
    {
        return $this->carro->carro_update($id_carro, $datos);
    }

    public function carro_delete($id_carro)
    {
        return $this->carro->carro_delete(($id_carro));
    }

}