<?php

require 'clases/Ayudante.php';
$ayudante = new Ayudante();
$tpl = $ayudante->Template('layouts/layoutBase.html');

$conBBDD = new mysqli("localhost", "root", "123456", "tblfestivales");
if ($conBBDD->connect_errno) {
    if ($tpl->exists("AVISO"))
        $tpl->AVISO = 'no se a podido conectar a la BBDD intetalo mas tarde';
}
$fechaFesti = explode('/', $_GET["fechaFesti"]);
$fechaFesti = $fechaFesti[2] . '-' . $fechaFesti[0] . '-' . $fechaFesti[1];
$rcsIDFestival = $conBBDD->query("select * from festivales where fecha='" . $fechaFesti . "' order by nombre");
while ($infoFestival = $rcsIDFestival->fetch_object()) {
    $tpl->FESTIVAL_ID = $infoFestival->id;
    $tpl->FESTIVAL_NOMBRE = $infoFestival->nombre;
    $tpl->block('LISTAFECHA_BLOCK');
}
$rcsNombreFestival = $conBBDD->query("select * from festivales where id='" . $_POST["lstFestivalesNombre"] . "' order by nombre");
while ($infoFestival = $rcsNombreFestival->fetch_object()) {
    $tpl->FESTIVAL_ID = $infoFestival->id;
    $tpl->FESTIVAL_NOMBRE = $infoFestival->nombre;
    $tpl->block('LISTANOMBRE_BLOCK');
}
$tpl->show();
?>
