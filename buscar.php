<?php

require 'clases/Ayudante.php';
$ayudante = new Ayudante();
$tpl = $ayudante->Template('layouts/layoutBase.html');








$tpl->addFile('CONTENIDO', 'paginas/buscar.html');


















$tpl->show();