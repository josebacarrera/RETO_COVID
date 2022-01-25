var reto_covid_intranet = angular.module('reto_covid_intranet', []);

reto_covid_intranet.controller('body', async function ($scope) {

    
    let session = await getSession(); // Variable session almacena los datos de session.
    if (session) // $scope.usuario recibe los datos de session.
        (session.sanitario) ? $scope.usuario = session.sanitario : $scope.usuario = session.paciente;

    // MULTIPURPOSE CARIABLES
    $scope.show = 'default';

    $scope.loadContent = (contenType) => {
        console.log(contenType);

        switch (contenType) {
            case 'COVID':
                ($scope.show==contenType)?$scope.show='default':$scope.show = contenType;
                break;

            case 'PreguntasF':
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