<?php

require 'clases/Ayudante.php';
$ayudante = new Ayudante();


$tpl = $ayudante->Template('layouts/layoutBase.html');

$tpl->addFile('CONTENIDO', 'paginas/index.html');
$conBBDD = new mysqli("localhost", "root", "123456", "tblfestivales");
if ($conBBDD->connect_errno) {
    if ($tpl->exists("AVISO"))
        $tpl->AVISO = 'no se a podido conectar a la BBDD intetalo mas tarde';
}
$lstFestivales = $conBBDD->query("select id,nombre,fecha from festivales order by fecha limit 6");

while ($rcsFestivales = $lstFestivales->fetch_object()) {
    $tpl->FESTIVAL_ID = $rcsFestivales->id;
    $tpl->FESTIVAL_NOMBRE = $rcsFestivales->nombre;
    $tpl->block('FESTIVAL_BLOCK');
}
$lstFestival = $conBBDD->query("select id,nombre,fecha from festivales order by fecha");
$fechas = '';
while ($rcsFestivales = $lstFestival->fetch_object()) {
    $fecha = explode('-',$rcsFestivales->fecha);
    $fechas .= 'new Date('.$fecha[0].','.$fecha[1].'-1,'.$fecha[2].'),';

}
$tpl->FESTIVAL_FECHAA = $fechas;
$lstNovedades = $conBBDD->query("select idnovedades,novedades from novedades limit 1");
$rcsNoveda = $lstNovedades->fetch_object();
$tpl->NOVEDADES_NOMBRE = $rcsNoveda->novedades;



$tpl->show();