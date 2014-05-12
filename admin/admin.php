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
    $tpl->addFile('CONTENIDO', 'paginas/admin/admin.html');
    $lstNovedades=$conBBDD->query("select idnovedades,novedades from novedades");
    $rcsNoveda=$lstNovedades->fetch_object();
    $tpl->NOVEDADES_NOMBRE=$rcsNoveda->novedades;
} else {
    $modificar = $conBBDD->query("UPDATE `tblfestivales`.`novedades` SET `novedades`='" . $_POST["modificarNovedades"] . "' ");
        if ($modificar === FALSE) {
            exit('no a sido posible inserta los datos');
        }
    
     header("location: admin.php");
}

$tpl->show();
?>
