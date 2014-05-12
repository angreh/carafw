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
$lstGrupos = $conBBDD->query("select estilos.id , estilos.nombre from estilos group by nombre;");
if (empty($_POST)) {
    $tpl->addFile('CONTENIDO', 'paginas/admin/adicionarEstiloGrupo.html');
    while ($rcsGrupos = $lstGrupos->fetch_object()) {
        $tpl->ESTILOS_ID = $rcsGrupos->id;
        $tpl->ESTILOS = $rcsGrupos->nombre;
        $tpl->block('ESTILOS_BLOCK');
    }
} else {
    $result = $conBBDD->query("INSERT INTO `tblfestivales`.`estilos_grupos` (`idEstilos`, `idGrupos`) VALUES  ('" . $_POST["lstEstilos"] . "','" . $_GET["grupoId"] . "')");
    if ($result === FALSE) {
        exit('deu merda');
    }
    $conBBDD->close();
    header("location: adicionarEstiloGrupo.php");
}
$tpl->show();
