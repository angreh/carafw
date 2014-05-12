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
$lstGrupos = $conBBDD->query("SELECT grupos.id , grupos.nombre from grupos group by nombre;");
if (empty($_POST)) {
    $tpl->addFile('CONTENIDO', 'paginas/admin/adicionarGrupoFestival.html');
    while ($rcsGrupos = $lstGrupos->fetch_object()) {
        $tpl->GRUPO_ID = $rcsGrupos->id;
        $tpl->GRUPOS = $rcsGrupos->nombre;
        $tpl->block('GRUPO_BLOCK');
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
