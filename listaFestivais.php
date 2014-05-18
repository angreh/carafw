<?php

require 'clases/Ayudante.php';
$ayudante = new Ayudante();


$tpl = $ayudante->Template('paginas/listaFestivais.html');

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
    $tpl->block('LISTAFESTIVALES_BLOCK');
}
$tpl->show();

?>
