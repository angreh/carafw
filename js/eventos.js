$().ready(function() {
    $("select[name='lstComunidad']").change(function() {
        $("select[name='lstProvincia']").load("/lstDireccion/lstProvincia.php", {idComunidad: $("select[name='lstComunidad']").val()}, function() {
            $("select[name='lstMunicipios']").load("/lstDireccion/lstMunicipios.php", {idLocalidad: $("select[name='lstProvincia']").val()});
        });
    });
    $("select[name='lstProvincia']").change(function() {
        $("select[name='lstMunicipios']").load("/lstDireccion/lstMunicipios.php", {idLocalidad: $("select[name='lstProvincia']").val()});
    });
//    $("#buscarNombre").click(function() {
//        $("#divTabla").load("consultaBuscar.php", {nombreFesti: $("#lstFestivalesNombre").val()});
//    });
//    $("#buscarFecha").click(function() {
//        $("#divTabla").load("consultaBuscar.php", {fechaFesti: $("#lstFestivalesFecha").val()});
//    });
//    $("#lstFestivalesNombre").change(function() {
//        $("#divTabla").html("");
//    });
//    $("#lstFestivalesFecha").change(function() {
//        $("#divTabla").html("");
//
//    });
});