    var reto_covid_intranet = angular.module('reto_covid_intranet', []);

reto_covid_intranet.controller('body', async function ($scope) {

    
    let session = await getSession(); // Variable session almacena los datos de session.
    if (session) // $scope.usuario recibe los datos de session.
        (session.sanitario) ? $scope.usuario = session.sanitario : $scope.usuario = session.paciente;

    // MULTIPURPOSE VARIABLES
    
    $(".btnVMas").click(showFaq);

    function showFaq() {
        
        $(".faq_area").css('display', 'inline-block');
        $(".covidCard").css('display', 'none');

    }

    $(".btnAgenda").click(hideFaq);

    function hideFaq(){
        $(".faq_area").css('display', 'none');
        $(".covidCard").css('display', '');
    }

    $scope.show = 'default';

    $scope.loadContent = async (contenType) => {

        switch (contenType) {
            case 'AGENDA':
                ($scope.show==contenType)?$scope.show='default':$scope.show = contenType;
                break;

            case 'INFORME':
                ($scope.show==contenType)?$scope.show='default':$scope.show = contenType;
                break;

            case 'DATOS':
                    ($scope.show==contenType)?$scope.show='default':$scope.show = contenType;
                    console.log(session);

                    $("#pacienteNombre").val(session.paciente.nombre);
                    $("#pacienteApellido").val(session.paciente.apellido);
                    $("#pacienteTIS").val(session.paciente.tis);
                    $("#pacienteEmail").val(session.paciente.email);
                    $("#pacienteTelefono").val(session.paciente.telefono);
                    $("#pacienteDireccion").val(session.paciente.direccion);
                    $("#pacientePoblacion").val(session.paciente.objLocalidad.nombre);
                    $('#fotoPerfil').attr("src", "../img/"+session.paciente.foto_perfil);

                $scope.updatePaciente = function() {
                
                    $("#pacienteNombre").val();
                    $("#pacienteApellido").val();
                    $("#pacienteTIS").val();
                    $("#pacienteEmail").val();
                    $("#pacienteTelefono").val();
                    $("#pacienteDireccion").val();
                    $("#pacientePoblacion").val();
                    $('#fotoPerfil').attr("src");
                }
                
                
                $scope.discardChanges= function() {
                    $("#pacienteNombre").val(session.paciente.nombre);
                    $("#pacienteApellido").val(session.paciente.apellido);
                    $("#pacienteTIS").val(session.paciente.tis);
                    $("#pacienteEmail").val(session.paciente.email);
                    $("#pacienteTelefono").val(session.paciente.telefono);
                    $("#pacienteDireccion").val(session.paciente.direccion);
                    $("#pacientePoblacion").val(session.paciente.objLocalidad.nombre);
                    $('#fotoPerfil').attr("src", "../img/"+session.paciente.foto_perfil);
                }
                    break;

            case 'COVID':
                    ($scope.show==contenType)?$scope.show='default':$scope.show = contenType;
                    break;

            case 'pedirCita':
                ($scope.show==contenType)?$scope.show='default':$scope.show = contenType;                

                var horasOcupadas = Array();

                $scope.getHoraByFechaCentro = () => {

                    console.log(1);

                    var data = { 'solicitud': 'selectHoraByFechaCentro', 'fecha': event.target.value, 'centro': $scope.usuario.objCentro.cod}
                    var url = "../../controller/cCitas.php";
                    fetch(url, {
                        method: 'POST',
                        body: JSON.stringify(data),
                        headers: { 'Content-Type': 'application/json' }
                    }).then(res => res.json()).then(result => {
                        console.log(result);

                        var timeZone = $scope.usuario.objCentro.horario_temprano
                        var horarios = getTime(timeZone);

                        function getTime(timeZone) {

                            let h1 = timeZone.split('-')[0].split(':')[0]
                            let m1 = timeZone.split('-')[0].split(':')[1]
                            let h2 = timeZone.split('-')[1].split(':')[0]
                            let m2 = timeZone.split('-')[1].split(':')[1]

                            var quarterHours = ["00", "15", "30", "45"];
                            var time = [];
                            for(var i =parseInt(h1); i <= parseInt(h2); i++){
                                for(var j = 0; j < 4; j++){
                                    time.push(i + ":" + quarterHours[j]);
                                }
                            }

                            if (m1 != '00') {
                                if (m1=='15') {
                                    time.remove(time.indexOf(h1 + ':00'))
                                } else if (m1=='30') {
                                    time.remove(time.indexOf(h1 + ':00'))
                                    time.remove(time.indexOf(h1 + ':15'))
                                } else {
                                    time.remove(time.indexOf(h1 + ':00'))
                                    time.remove(time.indexOf(h1 + ':15'))
                                    time.remove(time.indexOf(h1 + ':30'))
                                }
                            }

                            // if (m2 != '00') {
                            //     if (m2=='15') {
                            //         time.remove(time.indexOf(h2 + ':00'))
                            //     } else if (m2=='30') {
                            //         time.remove(time.indexOf(h2 + ':00'))
                            //         time.remove(time.indexOf(h2 + ':15'))
                            //     } else {
                            //         time.remove(time.indexOf(h2 + ':00'))
                            //         time.remove(time.indexOf(h2 + ':15'))
                            //         time.remove(time.indexOf(h2 + ':30'))
                            //     }
                            // }

                            return time;
                        }

                        console.log(horarios);
                        console.log(timeZone);

                    }).catch(error => console.error('Error status:', error));

                }

                break;

            case 'verCitas':
                ($scope.show==contenType)?$scope.show='default':$scope.show = contenType;
                break;


            case 'verVacunas':
                ($scope.show==contenType)?$scope.show='default':$scope.show = contenType;
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