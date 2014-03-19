<?php

require 'clases/Ayudante.php';
$ayudante = new Ayudante();

$usuario = $ayudante->Usuarios()->lista();

$tpl = $ayudante->Template('layouts/base.html');
$tpl->addFile('CONTENIDO', 'paginas/index.html');
$tpl->USUARIO = $usuario[0];
$tpl->show();