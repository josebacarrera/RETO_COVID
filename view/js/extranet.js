var reto_covid_intranet = angular.module('reto_covid_intranet', []);
var savedFileBase64;
var filename;
var filesize;

reto_covid_intranet.controller('body', async function ($scope) {


    let session = await getSession(); // Variable session almacena los datos de session.
    if (session) // $scope.usuario recibe los datos de session.
        (session.sanitario) ? $scope.usuario = session.sanitario : $scope.usuario = session.paciente;

        var data = { 'solicitud': 'getLocalidades' }
        var url = "../../controller/cLocalidad.php";
        fetch(url, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'Content-Type': 'application/json' }

        }).then(res => res.json()).then(result => {
            $scope.localidades = result.localidades;
        }).catch(error => console.error('Error status:', error));

    $scope.show = 'default';

    $scope.loadContent = async (contenType) => {

        switch (contenType) {
            case 'AGENDA':
                ($scope.show == contenType) ? $scope.show = 'default' : $scope.show = contenType;
                break;

            case 'INFORME':
                ($scope.show == contenType) ? $scope.show = 'default' : $scope.show = contenType;
                break;

            case 'DATOS':

                ($scope.show == contenType) ? $scope.show = 'default' : $scope.show = contenType;

                $("#pacienteNombre").val(session.paciente.nombre);
                $("#pacienteApellido").val(session.paciente.apellido);
                $("#pacienteTIS").val(session.paciente.tis);
                $("#pacienteFecha_nac").val(session.paciente.fecha_nacimiento);
                $("#pacienteLocalidad").val(session.paciente.cod_centro);
                $("#pacienteEmail").val(session.paciente.email);
                $("#pacienteTelefono").val(session.paciente.telefono);
                $("#pacienteDireccion").val(session.paciente.direccion);
                $('#fotoPerfil').attr("src", "../img/" + session.paciente.foto_perfil);

                $scope.updatePaciente = function () {


                    var data = {
                        "solicitud": "updatePaciente",
                        "tis": $("#pacienteTIS").val(),
                        "nombre": $("#pacienteNombre").val(),
                        "apellido": $("#pacienteApellido").val(),
                        "telefono": $("#pacienteTelefono").val(),
                        "direccion": $("#pacienteDireccion").val(),
                        "localidad": $("#pacienteLocalidad").val(),
                        "fotoPerfil": $("#fotoPerfil").attr("src")
                    };
                    
                    var url="../../controller/cPaciente.php";
                    
                    fetch(url, {
                        method: 'POST',
                        body: JSON.stringify(data),
                        headers: { 'Content-Type': 'application/json' }
            
                    }).then(res => res.json()).then(result => {
                        console.log(result);
                        $('#fotoPerfil').attr("src", savedFileBase64);
                    }).catch(error => console.error('Error status:', error));

                }


                $scope.discardChanges = function () {
                    $("#pacienteNombre").val(session.paciente.nombre);
                    $("#pacienteApellido").val(session.paciente.apellido);
                    $("#pacienteTIS").val(session.paciente.tis);
                    $("#pacienteEmail").val(session.paciente.email);
                    $("#pacienteTelefono").val(session.paciente.telefono);
                    $("#pacienteDireccion").val(session.paciente.direccion);
                    $('#fotoPerfil').attr("src", "../img/" + session.paciente.foto_perfil);
                }
                break;

            case 'COVID':
                ($scope.show == contenType) ? $scope.show = 'default' : $scope.show = contenType;
                break;

            case 'preguntasFrecuentes':
                console.log(1);
                ($scope.show == contenType) ? $scope.show = 'default' : $scope.show = contenType;
                break;

            case 'pedirCita':
                ($scope.show == contenType) ? $scope.show = 'default' : $scope.show = contenType;

                var horasOcupadas = Array();
                $scope.horarios = Array();
                var fechaSeleccionada;

                $scope.getHoraByFechaCentro = () => {

                    fechaSeleccionada = event.target.value

                    var data = { 'solicitud': 'selectHoraByFechaCentro', 'fecha': fechaSeleccionada, 'centro': $scope.usuario.objCentro.cod }
                    var url = "../../controller/cCitas.php";
                    fetch(url, {
                        method: 'POST',
                        body: JSON.stringify(data),
                        headers: { 'Content-Type': 'application/json' }
                    }).then(res => res.json()).then(result => {
                        console.log(result);

                        var timeZone = $scope.usuario.objCentro.horario_temprano
                        $scope.horarios = getTime(timeZone);

                        function getTime(timeZone) {

                            let h1 = timeZone.split('-')[0].split(':')[0]
                            let m1 = timeZone.split('-')[0].split(':')[1]
                            let h2 = timeZone.split('-')[1].split(':')[0]
                            let m2 = timeZone.split('-')[1].split(':')[1]

                            var quarterHours = ["00", "15", "30", "45"];
                            var time = [];
                            for (var i = parseInt(h1); i <= parseInt(h2); i++) {
                                for (var j = 0; j < 4; j++) {
                                    time.push(i + ":" + quarterHours[j]);
                                }
                            }

                            if (m1 != '00') {
                                if (m1 == '15') {
                                    time.splice(time.indexOf(h1 + ':00'))
                                } else if (m1 == '30') {
                                    time.splice(time.indexOf(h1 + ':00'))
                                    time.splice(time.indexOf(h1 + ':15'))
                                } else {
                                    time.splice(time.indexOf(h1 + ':00'))
                                    time.splice(time.indexOf(h1 + ':15'))
                                    time.splice(time.indexOf(h1 + ':30'))
                                }
                            }

                            if (m2 != '45') {
                                if (m2 == '00') {
                                    time.splice(time.indexOf(h2 + ':15'))
                                    time.splice(time.indexOf(h2 + ':30'))
                                    time.splice(time.indexOf(h2 + ':45'))
                                } else if (m2 == '15') {
                                    time.splice(time.indexOf(h2 + ':30'))
                                    time.splice(time.indexOf(h2 + ':45'))
                                } else if (m2 == '30') {
                                    time.splice(time.indexOf(h2 + ':45'))
                                }
                            }


                            return time;
                        }

                        if (result.horasOcupadas.length > 0) {
                            result.horasOcupadas.forEach(h => {
                                $scope.horarios = $scope.horarios.filter(function (f) { return f !== h.slice(1, -3) })
                            });
                        }

                        console.log($scope.horarios);
                        console.log(timeZone);

                        $scope.$digest;

                    }).catch(error => console.error('Error status:', error));

                }

                $scope.pedirCita = () => {

                    var hora = event.target.innerHTML;
                    console.log(hora);

                    var data = { 'solicitud': 'selectByCod_Centro', 'cod_centro': $scope.usuario.objCentro.cod }
                    var url = "../../controller/cSanitario.php";
                    fetch(url, {
                        method: 'POST',
                        body: JSON.stringify(data),
                        headers: { 'Content-Type': 'application/json' }
                    }).then(res => res.json()).then(result => {
                        console.log(result);
                        var data = { 'solicitud': 'insertCita', 'fecha': fechaSeleccionada, 'hora': hora, 'tis': $scope.usuario.tis, 'sanitario': result.sanitario.cod, 'centro': $scope.usuario.objCentro.cod }
                        var url = "../../controller/cCitas.php";
                        fetch(url, {
                            method: 'POST',
                            body: JSON.stringify(data),
                            headers: { 'Content-Type': 'application/json' }
                        }).then(res2 => res2.json()).then(result2 => {
                            console.log(result2);
                        }).catch(error => console.error('Error status:', error));

                    }).catch(error => console.error('Error status:', error));




                }

                break;

            case 'verCitas':
                ($scope.show == contenType) ? $scope.show = 'default' : $scope.show = contenType;
                break;


            case 'verVacunas':
                ($scope.show == contenType) ? $scope.show = 'default' : $scope.show = contenType;
                break;

            default:
                console.log('ERROR, contenType not supported');
                break;
        }

    }

    $scope.$digest();

    console.log($scope.usuario);


    console.group('DEBUG');
    console.log($scope);
    console.groupEnd();

});

function changeFitx() {
    var file = event.currentTarget.files[0];
    console.log(event.currentTarget.files[0])
    var reader = new FileReader();

    filename = file.name;
    filesize = file.size;

    if (!new RegExp("(.*?).(jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF)$").test(filename)) {
        alert("Solo se aceptan imágenes JPG, PNG y GIF");
    } else {
        reader.onloadend = function () {

            savedFileBase64 = reader.result;     // Almacenar en variable global para uso posterior	  
            $('#fotoPerfil').attr("src", savedFileBase64);
        }
        if (file) {
            reader.readAsDataURL(file);
            $('#fotoPerfil').attr("src", savedFileBase64);
        } else {
            $('#fotoPerfil').attr("src", "");
        }
    }
}

$(window).on('load', function () {
    setTimeout(function () {
        $(".loader-page").css({ visibility: "hidden", opacity: "0" })
    }, 500);
});




function getSession() { //RECOGE LAS VARIABLES DE SESSION

    return new Promise((resolve, reject) => {
        $.ajax({
            url: "../../controller/cSession.php",
            method: "GET",
            dataType: 'json',
            success: function (response) {
                resolve(response['SESSION']);
            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
                reject();
            }
        })
    })
}