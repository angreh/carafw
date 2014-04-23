<?php

// Importa las clases que se utilizarán
require 'clases/Ayudante.php';
$ayudante = new Ayudante();


// Define cuáles son los códigos HTML que se utilizarán
// essa linha cria a classe template e impota um layout 
$tpl = $ayudante->Template('../layouts/layoutBase.html');
// pega esse arquivo e joga dentor de contenido
$tpl->addFile('CONTENIDO', '../paginas/usuario.html');

$conBBDD = new mysqli("localhost", "usuario", "123456", "municipios");
if ($conBBDD->connect_errno) {
    echo "&gt;disconect database;&lt";
}
$rcsDatos = $conBBDD->query("select id, comunidad from comunidades order by comunidad;");
if ($rcsDatos->num_rows == 0) {
    exit;
}


while ($oComunidad = $rcsDatos->fetch_object()) {
    echo "<option value=" . $oComunidad->id . ">" . utf8_encode($oComunidad->comunidad) . "</option>";
}

$lstProvincia = $conBBDD->query("SELECT provincias.id,provincias.provincia FROM provincias
                        inner join comunidades on provincias.comunidad_id=comunidades.id where provincias.comunidad_id=1 order by provincia");
while ($oProvinci = $lstProvincia->fetch_object()) {
    echo "<option value=" . $oProvinci->id . ">" . utf8_encode($oProvinci->provincia) . "</option>";
}

$consLocali = $conBBDD->query("select municipios.id,municipios.municipio from municipios
                        inner join provincias on municipios.provincia_id=provincias.id where provincia_id=4 order by municipios.municipio");
while ($oLocalidad = $consLocali->fetch_object()) {
    echo "<option value=" . $oLocalidad->id . ">" . utf8_encode($oLocalidad->municipio) . "</option>";
}

// Código PHP
//$usuario = $ayudante->Usuarios()->lista();
//$tpl->USUARIO = $usuario[0];
// Muestra el contenido final
$tpl->show();
?>
