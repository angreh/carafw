<?php

// Importa las clases que se utilizarán
require '../clases/Ayudante.php';
$ayudante = new Ayudante();


// Define cuáles son los códigos HTML que se utilizarán
// essa linha cria a classe template e impota um layout 
$tpl = $ayudante->Template('layouts/admin/layoutLogin.html');
// pega esse arquivo e joga dentor de contenido
$tpl->addFile('CONTENIDO', 'paginas/admin/login.html');


// Código PHP
//$usuario = $ayudante->Usuarios()->lista();
//$tpl->USUARIO = $usuario[0];


// Muestra el contenido final
$tpl->show();

?>
