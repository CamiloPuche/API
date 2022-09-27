<?php

try {
    $database = new PDO('mysql:host=localhost;dbname=api', 'root', 'camilo2001');
} catch (\Throwable $th) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}
