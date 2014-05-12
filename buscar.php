<?php

require 'clases/Ayudante.php';
$ayudante = new Ayudante();
$tpl = $ayudante->Template('layouts/layoutBase.html');

$conBBDD = new mysqli("localhost","root","123456","tblfestivales");
if ($conBBDD->connect_errno) {
    if ($tpl->exists("AVISO"))
        $tpl->AVISO = 'no se a podido conectar a la BBDD intetalo mas tarde';
}
$rcsFestivales=$conBBDD->query("select festivales.id, festivales.nombre,festivales.fecha from festivales group by fecha;");
if ($rcsFestivales->num_rows == 0) {
    if ($tpl->exists("AVISO"))
        $tpl->AVISO = 'esta mal echa la conexcion a la base de datos';
};
if (empty($_POST)) {
    $tpl->addFile('CONTENIDO', 'paginas/buscar.html');
    while ($oFestival = $rcsFestivales->fetch_object()) {
        $tpl->FESTIVALES_ID = $oFestival->id;
        $tpl->FESTIVALES_NOMBRE = $oFestival->nombre;
        $tpl->FESTIVALES_FECHA = $oFestival->fecha;
        $tpl->block('FESTIVALES_BLOCK');
        $tpl->block('FESTIVALES2_BLOCK');
    }
    
}else{
    
}





$tpl->show();