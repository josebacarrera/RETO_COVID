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
                        if (result.horasDisponibles.length == 0) {
                            horasOcupadas = Array();
                        } else {
                            horasOcupadas = result.horasDisponibles;
                        }
                        
                        var horasDisponibles;

                        var horaIni = $scope.usuario.objCentro.horario_temprano.split('-')[0]
                        var horaFin = $scope.usuario.objCentro.horario_temprano.split('-')[1]

                        
                        for (var i = 0; i < 60; i+15) {     
                            console.log(i%15);                            
                        }

                        console.log(horaIni);


                        
                        console.log(horasDisponibles);

                    }).catch(error => console.error('Error status:', error));

                }

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