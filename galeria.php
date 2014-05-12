<?php

require 'clases/Ayudante.php';
$ayudante = new Ayudante();


$tpl = $ayudante->Template('layouts/layoutBase.html');

$tpl->addFile('CONTENIDO', 'paginas/galeria.html');
$conBBDD = new mysqli("localhost", "root", "123456", "tblfestivales");
if ($conBBDD->connect_errno) {
    if ($tpl->exists("AVISO"))
        $tpl->AVISO = 'no se a podido conectar a la BBDD intetalo mas tarde';
}
$lstFestival = $conBBDD->query("select id,nombre from festivales order by nombre");
while ($rcsDatos = $lstFestival->fetch_object()) {
    $dir = "imagenes/GaleriaFotos/" . $rcsDatos->id . "/";
    $tpl->FESTIVAL_NOMBRE=$rcsDatos->nombre;
    // Open a directory, and read its contents
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if(strlen($file) > 2){
                    $tpl->FESTIVAL_FOTO=$rcsDatos->id . "/".$file;
                    $tpl->block("ARQUIVOS_BLOCK");
                }
            }
            closedir($dh);
        }
    }
    $tpl->block("FESTIVAL_BLOCK");
    
}


$tpl->show();