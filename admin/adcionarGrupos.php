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
$lstGrupos = $conBBDD->query("select id,nombre from Grupos");

if (!empty($_GET) && isset($_GET['apagarId'])) {

    //query de apagar o registro
    $borrar = $conBBDD->query("delete from grupos where id=" . $_GET['apagarId']);
    if ($borrar === FALSE) {
        exit('no a sido borrado ');
    }
    header("location: adcionarGrupos.php");
    //linha para redirecionar
};
if (!empty($_GET) && isset($_GET['modificarId'])) {
    header("location: modificarGrupo.php");
    //linha para redirecionar
};
if (empty($_POST)) {
// pega esse arquivo e joga dentor de contenido
    $tpl->addFile('CONTENIDO', 'paginas/admin/adcionarGrupos.html');
    while ($rcsGrupos = $lstGrupos->fetch_object()) {
        $tpl->GRUPO_ID = $rcsGrupos->id;
        $tpl->GRUPO_NOMBRE = $rcsGrupos->nombre;
        $tpl->block('GRUPO_BLOCK');
    }
} else {
    $result = $conBBDD->query("insert into tblfestivales.grupos (nombre,descripcion) values" .
            " ('" . $_POST["adicionarNombreGrupo"] . "','" . $_POST["adicionarDescriGrupo"] . "')");
    if ($result === FALSE) {
        exit('deu merda');
    }
    $conBBDD->close();
    header("location: adcionarGrupos.php");
}

$tpl->show();
?>