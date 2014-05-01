<?php
if (!preg_match("/^[0-9]{1,10}$/", $_POST["idComunidad"])) {
    exit;
}
$conBBDD = new mysqli("localhost", "root", "123456", "tblfestivales");
if ($conBBDD->connect_errno) {
    echo "&gt;disconect database;&lt";
}
$rcsDatos = $conBBDD->query("SELECT comunidades.id,comunidades.comunidad FROM tblfestivales.comunidades where comunidades.id=" .$_POST["idComunidad"]. " order by comunidades.comunidad");
if ($rcsDatos->num_rows == 0) {
    exit;
}
    while($oProvin=$rcsDatos->fetch_object()){
        echo "<option value=".$oProvin->id.">".$oProvin->comunidad."</option>";
    }
   $conBBDD->close();
?>