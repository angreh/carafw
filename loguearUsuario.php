<?php

require 'clases/Ayudante.php';
$ayudante = new Ayudante();


$tpl = $ayudante->Template('layouts/layoutBase.html');

$tpl->addFile('CONTENIDO', 'paginas/loguearUsuario.html');
if (isset($_GET["desconectadoo"]) && $_GET["desconectadoo"] == 1) {
    session_name("sessionn");
    session_start();
    session_unset();
    session_destroy();
    header("location: loguearUsuario.php");
};
if (!empty($_POST)) {



    $conBBDD = new mysqli("localhost", "root", "123456", "tblfestivales");
    if ($conBBDD->connect_errno) {
        if ($tpl->exists("AVISO"))
            $tpl->AVISO = 'no se a podido conectar a la BBDD intetalo mas tarde';
    };
    $rcsDato = $conBBDD->query("SELECT login,id from tblfestivales.usuarios where login='" . $_POST["loginn"] . "' and password='" . md5($_POST["passs"]) . "'");

    if ($rcsDato->num_rows == 1) {
        $usuario = $rcsDato->fetch_object();
        session_name("sessionn");
        session_start();
        $_SESSION["usuarioo"] = $_POST["loginn"];
        $_SESSION["usuarioID"] = $usuario->id;
        header("location: adminUsuario/adminUsuario.php");
    };
    $conBBDD->close();
}
$tpl->ACTION = $_SERVER["PHP_SELF"];

$tpl->show();
?>
