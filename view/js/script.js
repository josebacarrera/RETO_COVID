$(document).ready(init);
var reto_covid = angular.module('reto_covid', []);

async function init() {
    await getSession().then(async function (session) {
        // loadUser(session);
    });

}

// function loadUser(session) {
//     console.log(session);
//     console.log(session.nombre_sanitario)
//     $('#formLogin').css('text-align', 'center')
//     $('#formLogin').css('padding', '30px')
//     if (session.nombre_sanitario) {
//         $('#formLogin').html('<p> <u> Nombre y apellido:</u> ' + session.nombre_sanitario + ' ' + session.nombre_sanitario + '</p>' +
//             '<p> <u> DNI:</u> ' + session.dni_sanitario + '</p>' +
//             '<p><u>Cargo: </u>' + session.cargo_sanitario + '</p>')
//         $('#formLogin').append('<button id="logout" class="btn btn-primary" type="button">Log Out</button>')
//         $('#logout').attr('ng-click','cLogin(`logout`)');
//     }
// }

reto_covid.controller('login', function ($scope) {

    $scope.usuario;
    $scope.password;
    $scope.tis;
    $scope.fecha_nac;

    $scope.login = function (solicitud) {

        if (solicitud == 'loginTis') {
            var data = {
                'solicitud': solicitud,
                'tis': $scope.usuario,
                'fecha_nac': $scope.password
            };
        } else if (solicitud == 'loginDni') {
            var data = {
                'solicitud': solicitud,
                'dni': $scope.usuario,
                'password': $scope.password
            };
        }

        var url = "controller/cLogin.php";

        fetch(url, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'Content-Type': 'application/json' }

        }).then(res => res.json()).then(result => {

            console.log(result);

        }).catch(error => console.error('Error status:', error));

        return false;
    }
});
