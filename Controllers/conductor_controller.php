<?php

require_once './Models/conductorModel.php';

class conductor_controller
{
    private $conductor;


    public function __construct()
    {
        $this->conductor = new conductor();
    }
    public function conductor_listar()
    {
        return $this->conductor->conductor_get();
    }

    public function conductor_read($id_conductor)
    {
        return $this->conductor->codificar_Json("Conductor: ", $this->conductor->conductor_read($id_conductor));
    }

    public function conductor_create($datos)
    {
        return $this->conductor->conductor_create($datos);
    }

    public function conductor_update($id_conductor, $datos)
    {
        return $this->conductor->conductor_update($id_conductor, $datos);
    }

    public function conductor_delete($id_conductor)
    {
        return $this->conductor->conductor_delete($id_conductor);
    }
}