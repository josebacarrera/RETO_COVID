$(document).ready(init);
var reto_covid = angular.module('reto_covid', []);

async function init() {
    await getSession().then(async function (session) {
        loadUser(session);
    });

}
function loadUser(session) {

    if(session){
        if (session.sanitario) {
            $('#formLogin').css('display','none')
            $('#loggedSanitario').removeClass('d-none')
        }
    }else{
        $('#formLogin').css('display','block')
    }

}
reto_covid.controller('login', function ($scope) {

    $scope.usuario;
    $scope.password;

    $scope.login = function (solicitud) {
        console.log(solicitud)
        if (solicitud == 'loginTis') {
            var data = {
                'solicitud': solicitud,
                'tis': $scope.tis,
                'fecha_nac': $scope.fecha_nac
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
            console.log(result);
        }).catch(error => console.error('Error status:', error));

        return false;
    }

    $scope.logout = function () {

        var url = "controller/cLogin.php";

        var data = {'solicitud':'logout'}
        fetch(url, {
            method: 'GET',
            data:JSON.stringify(data),
            headers: { 'Content-Type': 'application/json' }
        }).then(res => res.json()).then(result => {

            console.log(result)
        })
    }

});
