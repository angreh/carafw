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
$rcsDatos = $conBBDD->query("select id, comunidad from tblfestivales.comunidades order by comunidad;");
if ($rcsDatos->num_rows == 0) {
    if ($tpl->exists("AVISO"))
        $tpl->AVISO = 'esta mal echa la conexcion a la base de datos';
}
$lstProvincia = $conBBDD->query("SELECT provincias.id,provincias.provincia FROM tblfestivales.provincias
                        inner join comunidades on provincias.comunidad_id=comunidades.id where provincias.comunidad_id=1 order by provincia");
if ($lstProvincia->num_rows == 0) {
    if ($tpl->exists("AVISO"))
        $tpl->AVISO = 'esta mal echa la conexcion a la base de datos';
}

$lstMunicipios = $conBBDD->query("select municipios.idmunicipio,municipios.municipio from tblfestivales.municipios
                        inner join provincias on municipios.idprovincia=provincias.id where idprovincia=4 order by municipios.municipio");
if ($lstMunicipios->num_rows == 0) {
    if ($tpl->exists("AVISO"))
        $tpl->AVISO = 'esta mal echa la conexcion a la base de datos';
}
if (!empty($_GET) && isset($_GET['apagarId'])) {
    //query de apagar o registro
    //linha para redirecionar
}
// Define cuáles son los códigos HTML que se utilizarán
// essa linha cria a classe template e impota um layout 
if (empty($_POST)) {
// pega esse arquivo e joga dentor de contenido
    $tpl->addFile('CONTENIDO', 'paginas/admin/adcionarFestival.html');
    while ($oComunidad = $rcsDatos->fetch_object()) {
        $tpl->COMUNIDADE_ID = $oComunidad->id;
        $tpl->COMUNIDADE = $oComunidad->comunidad;
        $tpl->block('COMUNIDADE_BLOCK');
    }

    while ($oProvinci = $lstProvincia->fetch_object()) {
        $tpl->PROVINCIA_ID = $oProvinci->id;
        $tpl->PROVINCIA = $oProvinci->provincia;
        $tpl->block('PROVINCIA_BLOCK');
    }

    while ($oMunicipios = $lstMunicipios->fetch_object()) {
        $tpl->MUNICIPIOS_ID = $oMunicipios->idmunicipio;
        $tpl->MUNICIPIOS = $oMunicipios->municipio;
        $tpl->block('MUNICIPIOS_BLOCK');
    }
} else {

    $result = $conBBDD->query("insert into tblfestivales.festivales (nombre,fecha,comunidad,provincia,municipio,descripcion) values" .
            " ('" . $_POST["nombre"] . "','" . $_POST["fecha"] . "','" . $_POST["lstComunidad"] . "','" . $_POST["lstProvincia"] . "','" . $_POST["lstMunicipios"] . "','" . $_POST["descrip"] . "')");
    if ($result === FALSE) {
        exit('no a sido posible inserta los datos');
    }
    $conBBDD->close();
    header("location: adcionarFestival.php");
}
$tpl->show();
?>
