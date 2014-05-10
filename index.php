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
$lstFestivales = $conBBDD->query("select id,nombre from festivales order by fecha limit 6");
while ($rcsFestivales = $lstFestivales->fetch_object()) {
        $tpl->FESTIVAL_ID = $rcsFestivales->id;
        $tpl->FESTIVAL_NOMBRE = $rcsFestivales->nombre;
        $tpl->block('FESTIVAL_BLOCK');  
}

$tpl->show();