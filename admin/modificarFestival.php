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
    // retorna la tabla festival
    $tpl->addFile('CONTENIDO', 'paginas/admin/modificarFestival.html');
    $lstGrupos = $conBBDD->query("SELECT festivales.nombre ,festivales.fecha ,comunidades.id as comunidadeID ,provincias.id as provinciaID ,municipios.idmunicipio ,festivales.descripcion FROM tblfestivales.festivales " .
            "inner join tblfestivales.municipios on festivales.idmunicipio = municipios.idmunicipio inner join tblfestivales.provincias on municipios.idprovincia = provincias.id " .
            "inner join tblfestivales.comunidades on provincias.comunidad_id = comunidades.id where festivales.id='" . $_GET["idmodificar"] . "' ");
    $rcsGrupos = $lstGrupos->fetch_object();
    $tpl->FESTIVAL_NOMBRE = $rcsGrupos->nombre;
    $tpl->FESTIVAL_FECHA = $rcsGrupos->fecha;
    $tpl->FESTIVAL_DESCRIPCION = $rcsGrupos->descripcion;


    // retorna las localizaciones
    $rcsDatos = $conBBDD->query("select id, comunidad from tblfestivales.comunidades order by comunidad;");
    if ($rcsDatos->num_rows == 0) {
        if ($tpl->exists("AVISO"))
            $tpl->AVISO = 'esta mal echa la conexcion a la base de datos';
    }

    while ($oComunidad = $rcsDatos->fetch_object()) {
        $tpl->COMUNIDADE_ID = $oComunidad->id;
        $tpl->COMUNIDADE = $oComunidad->comunidad;
        if ($oComunidad->id == $rcsGrupos->comunidadeID) {
            $tpl->COMUNIDADE_SELECT = ' selected="selected"';
        } else {
            $tpl->COMUNIDADE_SELECT = '';
        }
        $tpl->block('COMUNIDADE_BLOCK');
    }
    $lstProvincia = $conBBDD->query("SELECT provincias.id,provincias.provincia FROM tblfestivales.provincias " .
            "inner join comunidades on provincias.comunidad_id=comunidades.id where provincias.comunidad_id=" . $rcsGrupos->comunidadeID . " order by provincia");
    if ($lstProvincia->num_rows == 0) {
        if ($tpl->exists("AVISO"))
            $tpl->AVISO = 'esta mal echa la conexcion a la base de datos';
    }


    while ($oProvinci = $lstProvincia->fetch_object()) {
        $tpl->PROVINCIA_ID = $oProvinci->id;
        $tpl->PROVINCIA = $oProvinci->provincia;
        if ($oProvinci->id == $rcsGrupos->provinciaID) {
            $tpl->PROVINCIA_SELECT = ' selected="selected"';
        } else {
            $tpl->PROVINCIA_SELECT = '';
        }
        $tpl->block('PROVINCIA_BLOCK');
    }

    $lstMunicipios = $conBBDD->query("select municipios.idmunicipio,municipios.municipio from tblfestivales.municipios " .
            "inner join provincias on municipios.idprovincia=provincias.id where idprovincia=" . $rcsGrupos->provinciaID . " order by municipios.municipio");
    if ($lstMunicipios->num_rows == 0) {
        if ($tpl->exists("AVISO"))
            $tpl->AVISO = 'esta mal echa la conexcion a la base de datos';
    }
    while ($oMunicipios = $lstMunicipios->fetch_object()) {
        $tpl->MUNICIPIOS_ID = $oMunicipios->idmunicipio;
        $tpl->MUNICIPIOS = $oMunicipios->municipio;
        if ($oMunicipios->idmunicipio == $rcsGrupos->idmunicipio) {
            $tpl->MUNICIPIO_SELECT = ' selected="selected"';
        } else {
            $tpl->MUNICIPIO_SELECT = '';
        }
        $tpl->block('MUNICIPIOS_BLOCK');
    }
} else {
    if ($_POST['modificarFestival'] == 'festival') {
        $modificar = $conBBDD->query("UPDATE `tblfestivales`.`festivales` SET `nombre`='" . $_POST["modificarNombreFestival"] . "', `fecha`='" . $_POST["modificarFechaFestival"] . "', `idmunicipio`='" . $_POST["lstMunicipios"] . "', `descripcion`='" . $_POST["modificarDescriFestival"] . "' where id=" . $_GET["idmodificar"] . " ");
        if ($modificar === FALSE) {
            exit('no a sido posible inserta los datos');
        }
    }
    header("location: adcionarFestival.php");
}


$tpl->show();