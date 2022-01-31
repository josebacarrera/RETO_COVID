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
                    let url= "../img/"+session.paciente.foto_perfil;

                    $("#pacienteNombre").val(session.paciente.nombre);
                    $("#pacienteApellido").val(session.paciente.apellido);
                    $("#pacienteTIS").val(session.paciente.tis);
                    $("#pacienteEmail").val(session.paciente.email);
                    $("#pacienteTelefono").val(session.paciente.telefono);
                    $("#pacienteDireccion").val(session.paciente.direccion);
                    $("#pacientePoblacion").val(session.paciente.objLocalidad.nombre);
                    $('#fotoPerfil').attr("src", url);

                    break;

            case 'COVID':
                    ($scope.show==contenType)?$scope.show='default':$scope.show = contenType;
                    break;

            case 'pedirCita':
                ($scope.show==contenType)?$scope.show='default':$scope.show = contenType;                

                var horasOcupadas = Array();

                $scope.getHoraByFechaCentro = () => {

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
                            let m1 = timeZone.split('-')[0].split(':')[0]
                            let h2 = timeZone.split('-')[1].split(':')[0]
                            let m2 = timeZone.split('-')[1].split(':')[0]

                            var quarterHours = ["00", "15", "30", "45"];
                            var time = [];
                            for(var i = h1; i < h2; i++){
                                for(var j = 0; j < 4; j++){
                                    time.push(i + ":" + quarterHours[j]);
                                }
                            }
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