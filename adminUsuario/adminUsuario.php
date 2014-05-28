<?php

session_name("sessionn");
session_start();
if (!isset($_SESSION["usuarioo"])) {
    header("location: ../loguearUsuario.php");
}
require '../clases/Ayudante.php';
$ayudante = new Ayudante();

// Define cuáles son los códigos HTML que se utilizarán
// essa linha cria a classe template e impota um layout 
$tpl = $ayudante->Template('layouts/adminUsuarios/layoutUsuario.html');
// pega esse arquivo e joga dentor de contenido

$conBBDD = new mysqli("localhost", "root", "123456", "tblfestivales");
if ($conBBDD->connect_errno) {
    if ($tpl->exists("AVISO"))
        $tpl->AVISO = 'no se a podido conectar a la BBDD intetalo mas tarde';
};
$nombreUsuario = $conBBDD->query("select id,login from usuarios");
$rcsDato = $nombreUsuario->fetch_object();
$tpl->NOMBRE_USUARIO = $rcsDato->login;

if (!empty($_GET) && isset($_GET['borrarGrupo'])) {

    //query de apagar o registro
    $borrar = $conBBDD->query("delete from tblfestivales.notificacion_grupos where notificacion_grupos.idgrupo=" . $_GET['borrarGrupo']);
    if ($borrar === FALSE) {
        exit('no a sido borrado ');
    }
    header("location: adminUsuario.php");
    //linha para redirecionar
};
if (!empty($_GET) && isset($_GET['borrarEstilo'])) {

    //query de apagar o registro
    $borrar = $conBBDD->query("delete from tblfestivales.notificacion_estilos where notificacion_estilos.idEstilos=" . $_GET['borrarEstilo']);
    if ($borrar === FALSE) {
        exit('no a sido borrado ');
    }
    header("location: adminUsuario.php");
    //linha para redirecionar
};
if (!empty($_GET) && isset($_GET['borrarFestival'])) {

    //query de apagar o registro
    $borrar = $conBBDD->query("delete from tblfestivales.notificacion_festivales where notificacion_festivales.idFestivales=" . $_GET['borrarFestival']);
    if ($borrar === FALSE) {
        exit('no a sido borrado ');
    }
    header("location: adminUsuario.php");
    //linha para redirecionar
};
// borrar comunidad
if (!empty($_GET) && isset($_GET['borrarLocaliza'])) {

    //query de apagar o registro
    $borrar = $conBBDD->query("delete from tblfestivales.notificacion_comunidad where notificacion_comunidad.idcomunidad=" . $_GET['borrarLocaliza']);
    if ($borrar === FALSE) {
        exit('no a sido borrado ');
    }
    header("location: adminUsuario.php");
    //linha para redirecionar
};
// borrar provincia
if (!empty($_GET) && isset($_GET['borrarLocaliza1'])) {

    //query de apagar o registro
    $borrar = $conBBDD->query("delete from tblfestivales.notificacion_provincia where notificacion_provincia.idprovincia=" . $_GET['borrarLocaliza1']);
    if ($borrar === FALSE) {
        exit('no a sido borrado ');
    }
    header("location: adminUsuario.php");
    //linha para redirecionar
};
// borrar municipio
if (!empty($_GET) && isset($_GET['borrarLocaliza2'])) {

    //query de apagar o registro
    $borrar = $conBBDD->query("delete from tblfestivales.notificacion_municipio where notificacion_municipio.idMunicipio=" . $_GET['borrarLocaliza2']);
    if ($borrar === FALSE) {
        exit('no a sido borrado ');
    }
    header("location: adminUsuario.php");
    //linha para redirecionar
};


if (empty($_POST)) {
    $tpl->addFile('CONTENIDO', 'paginas/adminUsuarios/adminUsuario.html');

    // la lista de comundiades 
    $rcsDatos = $conBBDD->query("select id, comunidad from tblfestivales.comunidades order by comunidad;");
    if ($rcsDatos->num_rows == 0) {
        if ($tpl->exists("AVISO"))
            $tpl->AVISO = 'esta mal echa la conexcion a la base de datos';
    }

    while ($oComunidad = $rcsDatos->fetch_object()) {
        $tpl->COMUNIDADE_ID = $oComunidad->id;
        $tpl->COMUNIDADE = $oComunidad->comunidad;
        $tpl->block('COMUNIDADE_BLOCK');
    }
    $lstProvincia = $conBBDD->query("SELECT provincias.id,provincias.provincia FROM tblfestivales.provincias
                        inner join comunidades on provincias.comunidad_id=comunidades.id where provincias.comunidad_id=1 order by provincia");
    if ($lstProvincia->num_rows == 0) {
        if ($tpl->exists("AVISO"))
            $tpl->AVISO = 'esta mal echa la conexcion a la base de datos';
    }


    while ($oProvinci = $lstProvincia->fetch_object()) {
        $tpl->PROVINCIA_ID = $oProvinci->id;
        $tpl->PROVINCIA = $oProvinci->provincia;
        $tpl->block('PROVINCIA_BLOCK');
    }

    $lstMunicipios = $conBBDD->query("select municipios.idmunicipio,municipios.municipio from tblfestivales.municipios
                        inner join provincias on municipios.idprovincia=provincias.id where idprovincia=4 order by municipios.municipio");
    if ($lstMunicipios->num_rows == 0) {
        if ($tpl->exists("AVISO"))
            $tpl->AVISO = 'esta mal echa la conexcion a la base de datos';
    }
    while ($oMunicipios = $lstMunicipios->fetch_object()) {
        $tpl->MUNICIPIOS_ID = $oMunicipios->idmunicipio;
        $tpl->MUNICIPIOS = $oMunicipios->municipio;
        $tpl->block('MUNICIPIOS_BLOCK');
    }
    $lstFestivales = $conBBDD->query("SELECT id,nombre FROM tblfestivales.festivales order by nombre");
    while ($oFestival = $lstFestivales->fetch_object()) {
        $tpl->FESTIVAL_ID = $oFestival->id;
        $tpl->FESTIVAL_NOMBRE = $oFestival->nombre;
        $tpl->block('FESTIVAL_BLOCK');
    }
    $lstGrupos = $conBBDD->query("SELECT id,nombre FROM tblfestivales.grupos order by nombre");
    while ($oGrupos = $lstGrupos->fetch_object()) {
        $tpl->GRUPOS_ID = $oGrupos->id;
        $tpl->GRUPOS_NOMBRE = $oGrupos->nombre;
        $tpl->block('GRUPO_BLOCK');
    }
    $lstEstilos = $conBBDD->query("SELECT id,nombre FROM tblfestivales.estilos order by nombre");
    while ($oEstilos = $lstEstilos->fetch_object()) {
        $tpl->ESTILOS_ID = $oEstilos->id;
        $tpl->ESTILOS_NOMBRE = $oEstilos->nombre;
        $tpl->block('ESTILOS_BLOCK');
    }

    // donde empieza las cosas anidadas
    $lstFestivalAnidados = $conBBDD->query("select festivales.id,festivales.nombre from tblfestivales.festivales inner join tblfestivales.notificacion_festivales on notificacion_festivales.idFestivales=festivales.id where idUsuarios=" . $_SESSION["usuarioID"]);
    while ($oFestivalAnidados = $lstFestivalAnidados->fetch_object()) {
        $tpl->FESTIVALES_ID = $oFestivalAnidados->id;
        $tpl->FESTIVALES_NOMBRE = $oFestivalAnidados->nombre;
        $tpl->block('FESTIVALES_BLOCK');
    }
    $lstGruposAnidados = $conBBDD->query("select grupos.id,grupos.nombre from tblfestivales.grupos inner join tblfestivales.notificacion_grupos on notificacion_grupos.idgrupo=grupos.id where idusuario=" . $_SESSION["usuarioID"]);
    while ($oGruposAnidados = $lstGruposAnidados->fetch_object()) {
        $tpl->GRUPOS_ID = $oGruposAnidados->id;
        $tpl->GRUPOS_NOMBRE = $oGruposAnidados->nombre;
        $tpl->block('GRUPOS_BLOCK');
    }
    $lstEstilosAnidados = $conBBDD->query("select estilos.id,estilos.nombre from tblfestivales.estilos inner join tblfestivales.notificacion_estilos on notificacion_estilos.idEstilos=estilos.id where idUsuarios=" . $_SESSION["usuarioID"]);
    while ($oEstilosAnidados = $lstEstilosAnidados->fetch_object()) {
        $tpl->ESTILO_ID = $oEstilosAnidados->id;
        $tpl->ESTILO_NOMBRE = $oEstilosAnidados->nombre;
        $tpl->block('ESTILO_BLOCK');
    }
    // donde se enseña la lista
    $lstLocalizaAnidados = $conBBDD->query("select comunidades.id,comunidades.comunidad from tblfestivales.comunidades" .
            " inner join tblfestivales.notificacion_comunidad on comunidades.id = notificacion_comunidad.idcomunidad where notificacion_comunidad.idusuario=" . $_SESSION["usuarioID"] . " order by notificacion_comunidad.idUsuario;");
    while ($oLocalizaAnidados1 = $lstLocalizaAnidados->fetch_object()) {
        $tpl->LOCALIZA_ID = $oLocalizaAnidados1->id;
        $tpl->LOCALIZA_NOMBRE = $oLocalizaAnidados1->comunidad;
        $tpl->block('LOCALIZA_BLOCK');
    }
    $lstProvinciaAnidados = $conBBDD->query("select provincias.id,provincias.provincia from tblfestivales.provincias" .
            " inner join tblfestivales.notificacion_provincia on provincias.id = notificacion_provincia.idprovincia where notificacion_provincia.idusuario=" . $_SESSION["usuarioID"] . " order by notificacion_provincia.idUsuario;");
    while ($oLocalizaAnidados2 = $lstProvinciaAnidados->fetch_object()) {
        $tpl->LOCALIZA1_ID = $oLocalizaAnidados2->id;
        $tpl->LOCALIZA_NOMBRE = $oLocalizaAnidados2->provincia;
        $tpl->block('LOCALIZA1_BLOCK');
    }
    $lstMuniAnidados = $conBBDD->query("select municipios.idmunicipio ,municipios.municipio from tblfestivales.municipios" .
            " inner join tblfestivales.notificacion_municipio on municipios.idmunicipio = notificacion_municipio.idMunicipio where notificacion_municipio.idUsuarios=" . $_SESSION["usuarioID"] . " order by notificacion_municipio.idUsuarios;");
    while ($oLocalizaAnidados = $lstMuniAnidados->fetch_object()) {
        $tpl->LOCALIZA2_ID = $oLocalizaAnidados->idmunicipio;
        $tpl->LOCALIZA_NOMBRE = $oLocalizaAnidados->municipio;
        $tpl->block('LOCALIZA2_BLOCK');
    }
    $tpl->show();
} else {
    // insertar datos
    if ($_POST['adicionarTipo'] == 'comunidad') {

        $result = $conBBDD->query("insert into tblfestivales.notificacion_comunidad (notificacion_comunidad.idusuario,notificacion_comunidad.idcomunidad) values" .
                " (" . $_SESSION["usuarioID"] . "," . $_POST["lstComunidad"] . " ) ");
        if ($result === FALSE) {
            exit('no a sido posible inserta los datos');
        }
    } elseif ($_POST['adicionarTipo'] == 'provincia') {
        $result = $conBBDD->query("insert into tblfestivales.notificacion_provincia (notificacion_provincia.idusuario,notificacion_provincia.idprovincia) values" .
                " (" . $_SESSION["usuarioID"] . "," . $_POST["lstProvincia"] . " ) ");
        if ($result === FALSE) {
            exit('no a sido posible inserta los datos');
        }
    } elseif ($_POST['adicionarTipo'] == 'municipio') {
        $result = $conBBDD->query("insert into tblfestivales.notificacion_municipio (notificacion_municipio.idUsuarios,notificacion_municipio.idmunicipio) values" .
                " (" . $_SESSION["usuarioID"] . "," . $_POST["lstMunicipios"] . " ) ");
        if ($result === FALSE) {
            exit('no a sido posible inserta los datos');
        }
    } elseif ($_POST['adicionarTipo'] == 'grupos') {
        $result = $conBBDD->query("insert into tblfestivales.notificacion_grupos (idusuario,idgrupo) values" .
                " (" . $_SESSION["usuarioID"] . "," . $_POST["lstGrupos"] . " ) ");

        if ($result === FALSE) {
            exit('no a sido posible inserta los datos');
        }
    } elseif ($_POST['adicionarTipo'] == 'estilos') {

        $result = $conBBDD->query("insert into tblfestivales.notificacion_usuarios (idEstilos,idUsuarios) values" .
                " (" . $_POST["lstEstilos"] . "," . $_SESSION["usuarioID"] . " ) ");
        if ($result === FALSE) {
            exit('no a sido posible inserta los datos');
        }
    } elseif ($_POST['adicionarTipo'] == 'festivales') {
        $result = $conBBDD->query("insert into tblfestivales.notificacion_festivales (idUsuarios,idFestivales) values" .
                " (" . $_SESSION["usuarioID"] . "," . $_POST["lstFestivales"] . " ) ");

        if ($result === FALSE) {
            exit('no a sido posible inserta los datos');
        }
    }
    $conBBDD->close();
    header("location:adminUsuario.php");
}
?>