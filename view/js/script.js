reto_covid.controller('login', function ($scope) {

    $scope.usuario;
    $scope.password;

    $scope.login = function (solicitud) {

        if (solicitud == 'loginTis') {
            var data = {
                'solicitud': solicitud,
                'tis': $scope.tis,
                'fecha_nac': ($scope.fecha_nac.getUTCFullYear()+"-"+($scope.fecha_nac.getUTCMonth()+1)+"-"+($scope.fecha_nac.getUTCDate()+1))
            };
        } else if (solicitud == 'loginDni') {
            var data = {
                'solicitud': solicitud,
                'dni': $scope.dni,
                'password': $scope.password
            };
        } else if (solicitud == 'logout') {
            var data = {
                'solicitud': solicitud
            };
        }

        var url = "controller/cLogin.php";
        fetch(url, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'Content-Type': 'application/json' }

        }).then(res => res.json()).then(async function result () {

            loadContent(await getSession());

        }).catch(error => console.error('Error status:', error));

        return false;
    }

});