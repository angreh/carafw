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
if (empty($_POST)) {
// pega esse arquivo e joga dentor de contenido
    $tpl->addFile('CONTENIDO', 'paginas/admin/adcionarGrupos.html');
} else {
    $result = $conBBDD->query("insert into tblfestivales.grupos (nombre) values" .
            " ('" . $_POST["adicionarNombreGrupo"] . "')");
    if ($result === FALSE) {
        exit('deu merda');
    }
    $conBBDD->close();
    header("location: adcionarGrupos.php");
}

$tpl->show();
?>