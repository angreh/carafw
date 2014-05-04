$().ready(function() {
    $("select[name='lstComunidad']").change(function() {
        $("select[name='lstProvincia']").load("/lstDireccion/lstProvincia.php", {idComunidad: $("select[name='lstComunidad']").val()}, function() {
            $("select[name='lstMunicipios']").load("/lstDireccion/lstMunicipios.php", {idLocalidad: $("select[name='lstProvincia']").val()});
        });
    });
    $("select[name='lstProvincia']").change(function() {
        $("select[name='lstMunicipios']").load("/lstDireccion/lstMunicipios.php", {idLocalidad: $("select[name='lstProvincia']").val()});
    });
});