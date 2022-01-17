
$(document).ready(getSession);



var reto_covid = angular.module('reto_covid', []);
reto_covid.controller('cLogin', function ($scope) {

    $scope.usuario;
    $scope.password;

    $scope.login = function (solicitud) {

        var url = "controller/cLogin.php";
        var data = {
                        'solicitud': solicitud,
                        'usuario':$scope.usuario,
                        'password':$scope.password
                    };

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