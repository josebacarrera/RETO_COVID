reto_covid.controller('login', function ($scope) {

    $scope.usuario;
    $scope.password;

    $scope.login = function (solicitud) {
        

        if (solicitud == 'loginTis') {
            alert("Has iniciado sesión correctamente");
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
            alert("Has cerrado sesión correctamente");
            var data = {
                'solicitud': solicitud
            };
        }

        var url = "controller/cLogin.php";
        fetch(url, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'Content-Type': 'application/json' }

        }).then(res => res.json()).then(result => {

            if (result.error) {
                console.log(result.errorInf);
            } else {
                if ( result.logged ) {
                    window.location.reload();
                } else if (result.logout) {
                    window.location.reload();
                }
            }

        }).catch(error => console.error('Error status:', error));

        return false;
    }

});

function validateTis(p) {
    if(isNaN(p.value.slice(-1))){p.value = p.value.slice(0, -1);}
    if (p.value.length > 8) {p.value = p.value.slice(0, -1);}
}

function validateDni(p) {
    console.log(1);
    if (p.value.length > 8) {
        if(!isNaN(p.value.slice(-1))){p.value = p.value.slice(0, -1);}
    } else {
        if(isNaN(p.value.slice(-1))){p.value = p.value.slice(0, -1);}}
    if (p.value.length > 9) {p.value = p.value.slice(0, -1);}    
}
