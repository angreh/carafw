<?php

// Importa las clases que se utilizarán
require 'clases/Ayudante.php';
$ayudante = new Ayudante();


// Define cuáles son los códigos HTML que se utilizarán
$tpl = $ayudante->Template('layouts/base.html');
$tpl->addFile('CONTENIDO', 'paginas/index.html');


// Código PHP
$usuario = $ayudante->Usuarios()->lista();
$tpl->USUARIO = $usuario[0];


// Muestra el contenido final
$tpl->show();