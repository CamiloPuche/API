<?php

require_once "Controllers/conductor_controller.php";

$datos = json_decode(file_get_contents("php://input"), true);

$id_conductor = $datos["id_conductor"];
$conductor = new conductor_controller();
echo ($conductor->conductor_delete($id_conductor));

// echo ($carro->carro_create($datos));


/* $datos = json_decode(file_get_contents("php://input"), true);
$id_carro = $datos["id_carro"];
$carro = new carro_controller();
echo ($carro->carro_update($id_carro,$datos)); */

/* require_once "Controllers/carro_controller.php";

$datos = json_decode(file_get_contents("php://input"), true);

$carro = new carro_controller();
$data = $datos;
echo ($carro->carro_create($data)); */
