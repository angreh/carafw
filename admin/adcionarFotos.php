<?php

session_name("session");
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location: login.php");
}
require '../clases/Ayudante.php';
$ayudante = new Ayudante();

// Define cuáles son los códigos HTML que se utilizarán
// essa linha cria a classe template e impota um layout 
$tpl = $ayudante->Template('layouts/admin/layoutAdmin.html');
$conBBDD = new mysqli("localhost", "root", "123456", "tblfestivales");
if ($conBBDD->connect_errno) {
    if ($tpl->exists("AVISO"))
        $tpl->AVISO = 'no se a podido conectar a la BBDD intetalo mas tarde';
}
// pega esse arquivo e joga dentor de contenido
$tpl->addFile('CONTENIDO', 'paginas/admin/adcionarFoto.html');
$lstFestival = $conBBDD->query("select id,nombre from festivales order by nombre");
while ($rcsDatos = $lstFestival->fetch_object()) {
    $tpl->FESTIVAL_ID = $rcsDatos->id;
    $tpl->FESTIVAL_NOMBRE = $rcsDatos->nombre;
    $tpl->block("FESTIVAL_BLOCK");
}


$tpl->show();
?>