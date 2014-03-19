<?php

require '../clases/Ayudante.php';
$ayudante = new Ayudante();

$usuario = $ayudante->Usuarios()->add();

echo $usuario;
