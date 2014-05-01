<?php
if (!preg_match("/^[0-9]{1,10}$/", $_POST["idComunidad"])) {
    exit;
}
$conBBDD = new mysqli("localhost", "root", "123456", "tblfestivales");
if ($conBBDD->connect_errno) {
    echo "&gt;disconect database;&lt";
}
$query = "SELECT provincias.id,provincias.provincia FROM tblfestivales.provincias where comunidad_id=".$_POST["idComunidad"]."";
$rcsDatos = $conBBDD->query($query);
if ($rcsDatos->num_rows == 0) {
    exit($query);
}
    while($oComu=$rcsDatos->fetch_object()){
        echo "<option value=".$oComu->id.">".$oComu->provincia."</option>";
    }
$conBBDD->close();
?>