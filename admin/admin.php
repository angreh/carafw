<?php

require '../clases/Ayudante.php';
$ayudante = new Ayudante();

// Define cuáles son los códigos HTML que se utilizarán
// essa linha cria a classe template e impota um layout 
$tpl = $ayudante->Template('layouts/admin/layoutAdmin.html');
// pega esse arquivo e joga dentor de contenido
$tpl->addFile('CONTENIDO', 'paginas/admin/admin.html');

$tpl->show();
?>