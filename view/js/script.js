
var reto_covid = angular.module('reto_covid', []);
reto_covid.controller('loginController', function ($scope) {

    $scope.login = function () {
        var url = "controller/cLogin.php";
        var data = {
                        'solicitud':'LogDNI',
                        'usuario':$('#formLogin input')[0].value, 
                        'password':$('#formLogin input')[1].value
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


