<?php

// Importa las clases que se utilizarán
require '../clases/Ayudante.php';
$ayudante = new Ayudante();


// Define cuáles son los códigos HTML que se utilizarán
// essa linha cria a classe template e impota um layout 
$tpl = $ayudante->Template('layouts/admin/layoutLogin.html');
// pega esse arquivo e joga dentor de contenido
$tpl->addFile('CONTENIDO', 'paginas/admin/login.html');

if (isset($_GET["desconectado"]) && $_GET["desconectado"] == 1) {
    session_name("session");
    session_start();
    session_unset();
    session_destroy();
    header("location: login.php");
};
if (!empty($_POST)) {



    $conBBDD = new mysqli("localhost", "root", "123456", "tblfestivales");
    if ($conBBDD->connect_errno) {
        if ($tpl->exists("AVISO"))
            $tpl->AVISO = 'no se a podido conectar a la BBDD intetalo mas tarde';
    };
    $rcsDato = $conBBDD->query("SELECT login from tblfestivales.admnistrador where login='" . $_POST["login"] . "' and password='" . md5($_POST["pass"]) . "'");

    if ($rcsDato->num_rows == 1) {
        session_name("session");
        session_start();
        $_SESSION["usuario"] = $_POST["login"];
        header("location: admin.php");
    };
    $conBBDD->close();
}
$tpl->ACTION = $_SERVER["PHP_SELF"];

$tpl->show();
?>
