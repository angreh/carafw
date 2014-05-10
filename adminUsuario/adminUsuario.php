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
$nombreUsuario = $conBBDD->query("select id,nombre from usuarios");
$rcsDato = $nombreUsuario->fetch_object();
$tpl->NOMBRE_USUARIO = $rcsDato->nombre;

if (!empty($_GET) && isset($_GET['borrarGrupo'])) {

    //query de apagar o registro
    $borrar = $conBBDD->query("delete from tblfestivales.usuarios_grupos where usuarios_grupos.idgrupo=" . $_GET['borrarGrupo']);
    if ($borrar === FALSE) {
        exit('no a sido borrado ');
    }
    header("location: adminUsuario.php");
    //linha para redirecionar
};
if (!empty($_GET) && isset($_GET['borrarEstilo'])) {

    //query de apagar o registro
    $borrar = $conBBDD->query("delete from tblfestivales.estilos_usuarios where estilos_usuarios.idEstilos=" . $_GET['borrarEstilo']);
    if ($borrar === FALSE) {
        exit('no a sido borrado ');
    }
    header("location: adminUsuario.php");
    //linha para redirecionar
};
if (!empty($_GET) && isset($_GET['borrarFestival'])) {

    //query de apagar o registro
    $borrar = $conBBDD->query("delete from tblfestivales.usuarios_festivales where usuarios_festivales.idFestivales=" . $_GET['borrarFestival']);
    if ($borrar === FALSE) {
        exit('no a sido borrado ');
    }
    header("location: adminUsuario.php");
    //linha para redirecionar
};
if (!empty($_GET) && isset($_GET['borrarLocaliza'])) {

    //query de apagar o registro
    $borrar = $conBBDD->query("delete from tblfestivales.localizacion_usuario where localizacion_usuario.idFestivales=" . $_GET['borrarLocaliza']);
    if ($borrar === FALSE) {
        exit('no a sido borrado ');
    }
    header("location: adminUsuario.php");
    //linha para redirecionar
};


if (empty($_POST)) {
    $tpl->addFile('CONTENIDO', 'paginas/adminUsuarios/adminUsuario.html');
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
    $lstFestivalAnidados = $conBBDD->query("select festivales.id,festivales.nombre from tblfestivales.festivales inner join tblfestivales.usuarios_festivales on usuarios_festivales.idFestivales=festivales.id where idUsuarios=" . $_SESSION["usuarioID"]);
    while ($oFestivalAnidados = $lstFestivalAnidados->fetch_object()) {
        $tpl->FESTIVALES_ID = $oFestivalAnidados->id;
        $tpl->FESTIVALES_NOMBRE = $oFestivalAnidados->nombre;
        $tpl->block('FESTIVALES_BLOCK');
    }
    $lstGruposAnidados = $conBBDD->query("select grupos.id,grupos.nombre from tblfestivales.grupos inner join tblfestivales.usuarios_grupos on usuarios_grupos.idgrupo=grupos.id where idusuario=" . $_SESSION["usuarioID"]);
    while ($oGruposAnidados = $lstGruposAnidados->fetch_object()) {
        $tpl->GRUPOS_ID = $oGruposAnidados->id;
        $tpl->GRUPOS_NOMBRE = $oGruposAnidados->nombre;
        $tpl->block('GRUPOS_BLOCK');
    }
    $lstEstilosAnidados = $conBBDD->query("select estilos.id,estilos.nombre from tblfestivales.estilos inner join tblfestivales.estilos_usuarios on estilos_usuarios.idEstilos=estilos.id where idUsuarios=" . $_SESSION["usuarioID"]);
    while ($oEstilosAnidados = $lstEstilosAnidados->fetch_object()) {
        $tpl->ESTILO_ID = $oEstilosAnidados->id;
        $tpl->ESTILO_NOMBRE = $oEstilosAnidados->nombre;
        $tpl->block('ESTILO_BLOCK');
    }
    $lstLocalizaAnidados = $conBBDD->query("select estilos.id,estilos.nombre from tblfestivales.estilos inner join tblfestivales.estilos_usuarios on estilos_usuarios.idEstilos=estilos.id where idUsuarios=" . $_SESSION["usuarioID"]);
    while ($oLocalizaAnidados = $lstLocalizaAnidados->fetch_object()) {
        $tpl->LOCALIZA_ID = $oLocalizaAnidados->id;
        $tpl->LOCALIZA_NOMBRE = $oLocalizaAnidados->nombre;
        $tpl->block('LOCALIZA_BLOCK');
    }
    $tpl->show();
} else {
    if ($_POST['adicionarTipo'] == 'localizacion') {

        $result = $conBBDD->query("insert into tblfestivales.localizacion_usuario (localizacion_usuario.idUsuarios,localizacion_usuario.idcomunidad,localizacion_usuario.idprovincia,localizacion_usuario.idmunicipio) values" .
                " (" . $_SESSION["usuarioID"] . "," . $_POST["lstComunidad"] . "," . $_POST["lstProvincia"] . "," . $_POST["lstMunicipios"] . " ) ");
        if ($result === FALSE) {
            exit('no a sido posible inserta los datos');
        }
    } elseif ($_POST['adicionarTipo'] == 'grupos') {
        $result = $conBBDD->query("insert into tblfestivales.usuarios_grupos (idusuario,idgrupo) values" .
                " (" . $_SESSION["usuarioID"] . "," . $_POST["lstGrupos"] . " ) ");

        if ($result === FALSE) {
            exit('no a sido posible inserta los datos');
        }
    } elseif ($_POST['adicionarTipo'] == 'estilos') {

        $result = $conBBDD->query("insert into tblfestivales.estilos_usuarios (idEstilos,idUsuarios) values" .
                " (" . $_POST["lstEstilos"] . "," . $_SESSION["usuarioID"] . " ) ");
        if ($result === FALSE) {
            exit('no a sido posible inserta los datos');
        }
    } elseif ($_POST['adicionarTipo'] == 'festivales') {
        $result = $conBBDD->query("insert into tblfestivales.usuarios_festivales (idUsuarios,idFestivales) values" .
                " (" . $_SESSION["usuarioID"] . "," . $_POST["lstFestivales"] . " ) ");

        if ($result === FALSE) {
            exit('no a sido posible inserta los datos');
        }
    }
    $conBBDD->close();
    header("location:adminUsuario.php");
}
?>