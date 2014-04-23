<?php
$conBBDD=new mysqli("localhost","root","123456","tblfestivales");
if ($conBBDD->connect_errno) {
    echo "&gt;disconect database;&lt";
}
$conBBDD->query("insert into usuarios (nombre,apellidos,tipoVia,direccion,portal,piso,puerta,comunidad,provincia,localidad,correo,login,password) values".
        " ('".$_POST["nombre"]."','".$_POST["apellidos"]."','".$_POST["lstTipoVia"]."','".$_POST["direccion"]."',".$_POST["portal"].",".$_POST["piso"].",'".$_POST["puerta"]."',".$_POST["lstComunidad"].",".$_POST["lstProvincia"].",".$_POST["lstLocalidad"].",'".$_POST["correo"]."','".$_POST["login"]."','".$_POST["pass"]."')");
header("location:../index.php");
$conBBDD->close();
?>
