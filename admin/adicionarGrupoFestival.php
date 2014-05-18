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

if (!empty($_GET) && isset($_GET['apagarId'])) {

    //query de apagar o registro
    $borrar = $conBBDD->query("delete from grupos_festivales where idFestivales =" . $_GET['apagarId']);
    if ($borrar === FALSE) {
        exit('no a sido borrado ');
    }
    header("location: adicionarGrupoFestival.php");
    //linha para redirecionar
};


if (empty($_POST)) {
    $tpl->addFile('CONTENIDO', 'paginas/admin/adicionarGrupoFestival.html');
    $lstGrupos = $conBBDD->query("SELECT grupos.id , grupos.nombre from grupos group by nombre;");
    while ($rcsGrupos = $lstGrupos->fetch_object()) {
        $tpl->GRUPO_ID = $rcsGrupos->id;
        $tpl->GRUPOS = $rcsGrupos->nombre;
        $tpl->block('GRUPO_BLOCK');
    }
    
    $lstGruposFestivales = $conBBDD->query("SELECT grupos_festivales.idFestivales , grupos.nombre from grupos inner join grupos_festivales on grupos.id = grupos_festivales.idGrupos where grupos_festivales.idFestivales=".$_GET["idFestivalGrupo"]." group by grupos.nombre;");
    while ($rcsGruposFestivales = $lstGruposFestivales->fetch_object()) {
        $tpl->ID_GFESTIVAL= $rcsGruposFestivales->idFestivales;
        $tpl->GRUPOS_NOMBRE = $rcsGruposFestivales->nombre;
        $tpl->block('GRUPOS_BLOCK');
    }
} else {
    $result = $conBBDD->query("insert into tblfestivales.grupos_festivales (idGrupos,idFestivales) values" .
            " ('" . $_POST["lstGrupos"] . "','" . $_GET["idFestivalGrupo"] . "')");
    if ($result === FALSE) {
        exit('deu merda');
    }
    $conBBDD->close();
    header("location: adicionarGrupoFestival.php");
}

$tpl->show();
