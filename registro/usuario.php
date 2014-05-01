<?php

// Importa las clases que se utilizarán
require '../clases/Ayudante.php';
$ayudante = new Ayudante();


// Define cuáles son los códigos HTML que se utilizarán
// essa linha cria a classe template e impota um layout 
$tpl = $ayudante->Template('layouts/layoutBase.html');
// pega esse arquivo e joga dentor de contenido
$tpl->addFile('CONTENIDO', 'paginas/usuario.html');

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
    $tpl->PROVINCIA_ID=$oProvinci->id;
    $tpl->PROVINCIA=$oProvinci->provincia;
    $tpl->block('PROVINCIA_BLOCK');
}

$lstMunicipios = $conBBDD->query("select municipios.id,municipios.municipios from tblfestivales.municipios
                        inner join provincias on municipios.id_provincia=provincias.id where id_provincia=4 order by municipios.municipios");
if ($lstMunicipios->num_rows == 0) {
    if ($tpl->exists("AVISO"))
        $tpl->AVISO = 'esta mal echa la conexcion a la base de datos';
}
while ($oMunicipios = $lstMunicipios->fetch_object()) {
    $tpl->MUNICIPIOS_ID=$oMunicipios->id;
    $tpl->MUNICIPIOS=$oMunicipios->municipios;
    $tpl->block('MUNICIPIOS_BLOCK');

  //  echo "<option value=" . $oLocalidad->id . ">" . utf8_encode($oLocalidad->municipios) . "</option>";
}
 echo "<img src=imagenes/lupa.png alt='confirmacion' />" ;
// Código PHP
//$usuario = $ayudante->Usuarios()->lista();
//$tpl->USUARIO = $usuario[0];
// Muestra el contenido final
$tpl->show();
?>
