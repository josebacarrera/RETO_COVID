//MOSTRAR DIV MOTIVO CUANDO CLICKAS EN 'OTRO...'
function mostrar() {

    var valor = document.getElementById("MotivoS").value;

    if (valor == "Otro") {
        document.getElementById("motivo").style.display = 'block';
        document.getElementById("MasMotivo2").required = true;
    } else {
        document.getElementById("motivo").style.display = 'none';
    }
}

function enviarFormulario(){
    console.lo
}
//RELLENAR FORMULARIO
function formRelleno() {
        event.preventDefault()
        var nombre = $('#Nombre').val();
        var correo = $('#Correo').val();
        var motivoC = $('#MotivoS').val();
        var masMotivo = $('#MasMotivo2').val();
        var mensaje = $('#Mensaje').val();
        var datos = {'Nombre': nombre, 'Correo': correo, 'MotivoS': motivoC, 'MasMotivo': masMotivo, 'Mensaje': mensaje };
        var datos = JSON.stringify(datos);


        $.ajax({
            url: "controller/cContacto.php",
            method: "POST",
            data: {
                'datos': datos,
            },
            success: function (result) {
                result?window.alert("FORMULARIO ENVIADO"):window.alert("ERROR!! VUELVE A INTENTARLO");
            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }
        }) 

        limpiarFormulario();

}

function limpiarFormulario() {
    $('#formulario')[0].reset();
}