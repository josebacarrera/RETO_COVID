var reto_covid = angular.module('reto_covid', []);

reto_covid.controller('main', async function ($scope) {

    let session = await getSession();
    session.sanitario1?$scope.usuario=session.sanitario:$scope.usuario=session.paciente;
    console.log($scope.usuario);
    loadContent(session, $scope)

});


function loadContent(session, $scope) {
    if (session) { // TIENE SESSION
        $('#formLogin').css('display', 'none')
        if (session.sanitario) { // SANITARIO
            $('#loggedSanitario').removeClass('d-none')
            $('#intranetCorporativa').removeClass('d-none')
            // $scope.nombre_sanitario=$scope.usuario.nombre
            
        } else if(session.paciente) { // PACIENTE
            $('#loggedUser').removeClass('d-none')
            $('#carpetaSalud').removeClass('d-none')
        }
    } else { // NO TIENE SESSION
        $('#formLogin').css('display', 'block')
        $('#loggedSanitario').addClass('d-none')
        $('#loggedUser').addClass('d-none')
        $('#intranetCorporativa').addClass('d-none')
        $('#carpetaSalud').addClass('d-none')
    }
}

reto_covid.controller('login', function ($scope) {

    $scope.usuario;
    $scope.password;

    $scope.login = function (solicitud) {

        if (solicitud == 'loginTis') {
            console.log( $scope.fecha_nac.getUTCFullYear()+"-"+($scope.fecha_nac.getUTCMonth()+1)+"-"+($scope.fecha_nac.getUTCDate()+1))
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
        console.log(data)

        var url = "controller/cLogin.php";
        fetch(url, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'Content-Type': 'application/json' }

        }).then(res => res.json()).then(result => {

            console.log(result)

        }).catch(error => console.error('Error status:', error));

        return false;
    }

});



// function loadContent(session, $scope) {
//     console.log($scope);
//     $scope.dni='123'
// }
