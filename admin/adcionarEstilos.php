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


if (!empty($_GET) && isset($_GET['apagarId'])) {

    //query de apagar o registro
    $borrar = $conBBDD->query("delete from estilos where id=" . $_GET['apagarId']);
    if ($borrar === FALSE) {
        exit('no a sido borrado ');
    }
    header("location: adcionarEstilos.php");
    //linha para redirecionar
};
if (empty($_POST)) {

    $tpl->addFile('CONTENIDO', 'paginas/admin/adcionarEstilos.html');
    $lstEstilos = $conBBDD->query("select id,nombre from estilos");
    while ($rcsEstilos = $lstEstilos->fetch_object()) {
        $tpl->ESTILO_ID = $rcsEstilos->id;
        $tpl->ESTILO_NOMBRE = $rcsEstilos->nombre;
        $tpl->block('ESTILO_BLOCK');
    }
} else {
    $result = $conBBDD->query("insert into tblfestivales.estilos (nombre) values" .
            " ('" . $_POST["adicionarNombreEstilo"] . "')");
    if ($result === FALSE) {
        exit('no a sido posible añadir un nuevo estilo.');
    }
    $conBBDD->close();
    header("location: adcionarEstilos.php");
}

$tpl->show();
?>