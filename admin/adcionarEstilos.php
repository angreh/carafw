<?php

session_name("session");
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location: login.php");
}
require '../clases/Ayudante.php';
$ayudante = new Ayudante();

$tpl = $ayudante->Template('layouts/admin/layoutAdmin.html');
$conBBDD = new mysqli("localhost", "root", "123456", "tblfestivales");
if ($conBBDD->connect_errno) {
    if ($tpl->exists("AVISO"))
        $tpl->AVISO = 'no se a podido conectar a la BBDD intetalo mas tarde';
}
if (empty($_POST)) {

    $tpl->addFile('CONTENIDO', 'paginas/admin/adcionarEstilos.html');
} else {
    $result = $conBBDD->query("insert into tblfestivales.estilos (nombre) values" .
            " ('" . $_POST["adicionarNombreEstilo"] . "')");
    if ($result === FALSE) {
        exit('deu merda');
    }
    $conBBDD->close();
    header("location: adcionarEstilos.php");
}

$tpl->show();
?>