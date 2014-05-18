window.onload = function() {

    $("#datepicker").datepicker({
        inline: true,
        onSelect: function(dateStr) {
            $("#divListaFestivales").load('/listaFestivais.php?fechaFesti='+dateStr);
        },
        beforeShowDay: highlightDays
    });

    $(".rslides").responsiveSlides();
    document.getElementById("idMenuHome").onclick = function() {
        document.location = "/index.php";
    };
    document.getElementById("idMenuBuscar").onclick = function() {
        document.location = '/buscar.php';
    };
    document.getElementById("idMenuGaleria").onclick = function() {
        document.location = '/galeria.php';
    };
    document.getElementById("idMenuUsuario").onclick = function() {
        document.location = '/loguearUsuario.php';
    };

    document.querySelector("input[name='nombre']").onkeypress = function(e) {
        return ((!e.charCode) || /[a-záéíóúüñ]/i.test(funcionOnKeyPress(e)));
    };
    document.querySelector("input[name='apellidos']").onkeypress = function(e) {
        return ((!e.charCode) || /[a-záéíóúüñ]/i.test(funcionOnKeyPress(e)));
    };
    document.querySelector("input[name='correo']").onkeypress = function(e) {
        return ((!e.charCode) || /(\w+([+-._]\w+)*@\w+\.\w+)*/i.test(funcionOnKeyPress(e)));
    };
    document.querySelector("input[name='login']").onkeypress = function(e) {
        return ((!e.charCode) || /[a-z0-9]/i.test(funcionOnKeyPress(e)));
    };
    document.querySelector("input[name='pass']").onkeypress = function(e) {
        return ((!e.charCode) || /[a-z0-9]/i.test(funcionOnKeyPress(e)));
    };

    document.querySelector(".divUsuarioContenedor>form").onsubmit = function() {
        if (!/^[a-záéíóúüñ]+( [a-záéíóúüñ]+)*$/i.test(document.querySelector("input[name='nombre']").value) || document.querySelector("input[name='nombre']").value == "") {
            document.querySelector("input[name='nombre']").select();
//            document.querySelector(".divUsuarioContenedor>.divMensajeError").innerHTML = "No se puede dejar el campo nombre vacio";
            return false;
        }
        if (!/^[a-záéíóúüñ]+( [\-a-záéíóúüñ]+)*$/i.test(document.querySelector("input[name='apellidos']").value) || document.querySelector("input[name='apellidos']".value) == "") {
//            document.querySelector(".divUsuarioContenedor>.divMensajeError").innerHTML = "No se puede dejar el campo apellidos vacio";
            document.querySelector("input[name='apellidos']").select();
            return false;
        }
        if (!/^(\w+([+-._]\w+)*@\w+\.\w+)*$/i.test(document.querySelector("input[name='correo']").value) || document.querySelector("input[name='correo']".value) == "") {
//            document.querySelector(".divContenedor>.divMensajeError").innerHTML = "No se puede dejar el campo correo vacio";
            document.querySelector("input[name='correo']").select();
            return false;
        }
        if (!/^[a-z][0-9a-z]{3,9}$/i.test(document.querySelector("input[name='login']").value) || document.querySelector("input[name='login']".value) == "") {
//            document.querySelector(".divContenedor>.divMensajeError").innerHTML = "No se puede dejar el campo login vacio";
            document.querySelector("input[name='login']").select();
            return false;
        }
    };
    if (!/^[a-z][0-9a-z]{3,9}$/i.test(document.querySelector("input[name='pass']").value) || document.querySelector("input[name='pass']".value) == "") {
//        document.querySelector(".divContenedor>.divMensajeError").innerHTML = "No se puede dejar el campo password vacio";
        document.querySelector("input[name='pass']").select();
        return false;
    }

};
funcionOnKeyPress = function(e) {
    var strChar;
    if (window.event) {
        strChar = String.fromCharCode(window.event.KeyCode);
    } else {
        if (e.KeyCode) {
            return true;
        } else {
            strChar = String.fromCharCode(e.charCode);
        }
    }
    return strChar;
};

function highlightDays(date) {
    for (var i = 0; i < datess.length; i++) {
        //alert('(' + date + ') - (' + datess[i] + ') ' + (datess[i].toString() === date.toString()) + ' , ' + typeof (date) + ' , ' + typeof (datess[i]));
        if (datess[i].toString() === date.toString()) {
            return [true, 'highlight-date'];
        }
    }
    return [true, ''];
}
