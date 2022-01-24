// var reto_covid = angular.module('reto_covid', []);

reto_covid.controller('main', async function ($scope) {

    let session = await getSession();
    if (session)
        (session.sanitario) ? $scope.usuario = session.sanitario : $scope.usuario = session.paciente;

    console.log($scope.usuario);

    $scope.$digest();

})