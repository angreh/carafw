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
    $tpl->addFile('CONTENIDO', 'paginas/admin/modificarGrupo.html');
    $lstGrupos = $conBBDD->query("select id,nombre,descripcion from grupos where id=" .$_GET["modificarId"]." ");
    while ($rcsGrupos = $lstGrupos->fetch_object()) {
        $tpl->GRUPO_NOMBRE = $rcsGrupos -> nombre;
        $tpl->GRUPO_DESCRIPCION = $rcsGrupos -> descripcion;
    }
} else {
    if ($_POST['modificarGrupo'] == 'grupo') {
        $modificar = $conBBDD->query("UPDATE `tblfestivales`.`grupos` SET `descripcion`='" . $_POST["modificarDescriGrupo"] . "', `nombre`='" . $_POST["modificarNombreGrupo"] . "' where id=".$_GET["modificarId"]." ");
        if ($modificar === FALSE) {
            exit('no a sido posible inserta los datos');
        }
    }
     header("location: adcionarGrupos.php");
}


$tpl->show();