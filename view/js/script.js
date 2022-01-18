
$(document).ready(getSession);



var reto_covid = angular.module('reto_covid', []);
reto_covid.controller('cLogin', function ($scope) {

    $scope.usuario;
    $scope.password;

    $scope.login = function (solicitud) {

        if (solicitud == 'loginTis') {
            var data = {
                'solicitud': solicitud,
                'tis':$scope.usuario,
                'fecha_nac':$scope.password
            };
        } else if (solicitud == 'loginDni') {
            var data = {
                'solicitud': solicitud,
                'dni':$scope.usuario,
                'password':$scope.password
            };
        }

        var url = "controller/cLogin.php";

        fetch(url, {
              method: 'POST',
              body: JSON.stringify(data),
              headers:{'Content-Type': 'application/json'}  
              
        }).then(res => res.json()).then(result => {
    
            console.log(result);
    
        }).catch(error => console.error('Error status:', error));
        
        return false;    
    };
});