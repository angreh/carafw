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
$lstUsuarios = $conBBDD->query("select id,login from usuarios");

if (!empty($_GET) && isset($_GET['apagarId'])) {

    //query de apagar o registro
    $borrar = $conBBDD->query("delete from usuarios where id=" . $_GET['apagarId']);
    if ($borrar === FALSE) {
        exit('no a sido borrado ');
    }
    header("location: modificarUsuarios.php");
    //linha para redirecionar
};

// pega esse arquivo e joga dentor de contenido
$tpl->addFile('CONTENIDO', 'paginas/admin/modificarUsuarios.html');
while ($rcsUsuarios = $lstUsuarios->fetch_object()) {
    $tpl->USUARIO_ID = $rcsUsuarios->id;
    $tpl->USUARIO_NOMBRE = $rcsUsuarios->login;
    $tpl->block('USUARIO_BLOCK');
}
$tpl->show();
?>