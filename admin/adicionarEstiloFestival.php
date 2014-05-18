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
    $tpl->addFile('CONTENIDO', 'paginas/admin/adicionarEstiloFestival.html');
    $lstGrupos = $conBBDD->query("select estilos.id , estilos.nombre from estilos group by nombre;");
    while ($rcsGrupos = $lstGrupos->fetch_object()) {
        $tpl->ESTILOS_ID = $rcsGrupos->id;
        $tpl->ESTILOS = $rcsGrupos->nombre;
        $tpl->block('ESTILOS_BLOCK');
    }
    $lstEstilosFestival = $conBBDD->query("SELECT estilo_festival.idestilo, estilos.nombre FROM tblfestivales.estilos inner join tblfestivales.estilo_festival on estilos.id = estilo_festival.idestilo where estilo_festival.idfestival=" . $_GET["idFestivalEstilo"] . " group by estilos.nombre;");
    while ($rcsEstilos = $lstEstilosFestival->fetch_object()) {
        $tpl->FESTILO_ID = $rcsEstilos->idestilo;
        $tpl->FESTILO_NOMBRE = $rcsEstilos->nombre;
        $tpl->block("FESTILO_BLOCK");
    }
} else {
    $result = $conBBDD->query("INSERT INTO `tblfestivales`.`estilo_festival` (`idfestival`, `idestilo`) VALUES  ('" . $_GET["idFestivalEstilo"] . "','" . $_POST["lstEstilos"] . "')");
    if ($result === FALSE) {
        exit('deu merda');
    }
    $conBBDD->close();
    header("location: adicionarEstiloFestival.php");
}
$tpl->show();
