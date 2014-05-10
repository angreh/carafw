<?php

require 'clases/Ayudante.php';
$ayudante = new Ayudante();


$tpl = $ayudante->Template('layouts/layoutBase.html');

$tpl->addFile('CONTENIDO', 'paginas/informacionFestival.html');
$conBBDD = new mysqli("localhost", "root", "123456", "tblfestivales");
if ($conBBDD->connect_errno) {
    if ($tpl->exists("AVISO"))
        $tpl->AVISO = 'no se a podido conectar a la BBDD intetalo mas tarde';
}
$rcsIDFestival=$conBBDD->query("select * from festivales where id=".$_GET["idfestival"]);
$infoFestival=$rcsIDFestival->fetch_object();
$tpl->FESTIVAL_ID=$_GET['idfestival'];
$tpl->FESTIVAL_NOMBRE=$infoFestival->nombre;
$tpl->FESTIVAL_FECHA=$infoFestival->fecha;
$tpl->FESTIVAL_DESCRI=$infoFestival->descripcion;

$tpl->show();