<?php
// hola mundo en
$carros = explode("/", $_SERVER['REQUEST_URI']);

if (count(array_filter($carros)) == 2) {
    /*Si no estoy ingresando a ninguna tabla*/
    $json = array(
        "error" => "No se esta haciendo ninguna petición a la API"
    );
    echo json_encode($json, true);

    return;



} else {
    if (count(array_filter($rutaConductor)) == 3) {


        /*Haciendo petición a la tabla carro*/


        if (array_filter($rutaConductor)[3] == "registrar_persona") {


            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {

                /*=============================================
                Capturar datos
                =============================================*/
                $data = array(
                    "titulo" => $_POST["titulo"],
                    "descripcion" => $_POST["descripcion"],
                    "instructor" => $_POST["instructor"],
                    "imagen" => $_POST["imagen"],
                    "precio" => $_POST["precio"]
                );

                //  echo "<pre>"; print_r($datos); echo "<pre>";

                // $cursos=new ControladorCursos();
                $cursos->create($datos);
            }

            if (array_filter($rutaConductor)[3] == "carro") {


                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
                    /*=============================================
                    Capturar datos
                    =============================================*/
                    $data = array(
                        "titulo" => $_POST["titulo"],
                        "descripcion" => $_POST["descripcion"],
                        "instructor" => $_POST["instructor"],
                        "imagen" => $_POST["imagen"],
                        "precio" => $_POST["precio"]
                    );
                    //  echo "<pre>"; print_r($datos); echo "<pre>";

                    // $cursos=new ControladorCursos();
                    $cursos->create($datos);
                }
            }
        }
    }
}