var miApp = angular.module('miApp',[]);

miApp.controller('mainController', async ($scope) => {

    $scope.login = () => {
        console.log(event.target);
    }

    $scope.$digest();

})


function login() {
    return new Promise ((resolve,reject)=>{

        fetch('controller/cLogin.php', {
            method: 'POST', 
            headers:{'Content-Type': 'application/json'}
        }).then(res => res.json()).then(result => {

          console.log(result);
          resolve(result);

        }).catch(error => console.error('Error status:', error));

    })
}