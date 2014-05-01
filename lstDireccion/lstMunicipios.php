<?php
if (!preg_match("/^[0-9]{1,10}$/", $_POST["idLocalidad"])) {
    exit;
}
$conBBDD = new mysqli("localhost", "root", "123456", "tblfestivales");
if ($conBBDD->connect_errno) {
    echo "&gt;disconect database;&lt";
}
$rcsDatos = $conBBDD->query("select municipios.idmunicipio, municipios.municipio from tblfestivales.municipios where idprovincia=" . $_POST["idLocalidad"] . " order by municipios.municipio");
if ($rcsDatos->num_rows == 0) {
    exit;
}
    while($oComunida=$rcsDatos->fetch_object()){
        echo "<option value=".$oComunida->idmunicipio.">".$oComunida->municipio."</option>";
    }
$conBBDD->close();
?>