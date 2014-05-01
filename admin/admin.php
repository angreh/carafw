<?php
require '../clases/Ayudante.php';
$ayudante = new Ayudante();

// Define cuáles son los códigos HTML que se utilizarán
// essa linha cria a classe template e impota um layout 
$tpl = $ayudante->Template('layouts/admin/layoutAdmin.html');
// pega esse arquivo e joga dentor de contenido
$tpl->addFile('CONTENIDO', 'paginas/admin/admin.html');

session_name("session");
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location: login.php");
}
$conBBDD = new mysqli("localhost", "root", "123456", "tblfestivales");
if ($conBBDD->connect_errno) {
    if ($tpl->exists("AVISO"))
        $tpl->AVISO = 'no se a podido conectar a la BBDD intetalo mas tarde';
}

$tpl->show();
?>
