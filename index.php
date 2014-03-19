<?php

require 'clases/Ayudante.php';
$ayudante = new Ayudante();

$usuario = $ayudante->Usuarios()->add();

$tpl = $ayudante->Template('layouts/base.html');
$tpl->addFile('CONTENIDO', 'paginas/index.html');
$tpl->USUARIO = $usuario;
$tpl->show();