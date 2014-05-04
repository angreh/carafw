<?php

require 'clases/Ayudante.php';
$ayudante = new Ayudante();



$tpl = $ayudante->Template('layouts/layoutBase.html');

$tpl->addFile('CONTENIDO', 'paginas/informacionFestival.html');



$tpl->show();