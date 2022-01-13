$(document ).ready(load)
var reto_covid = angular.module('reto_covid', []);
reto_covid.controller('navbarController', ($scope) => {
    $scope.prueba=function name(params) {
        console.log($scope + "holaa")
    } 

});
function load(){
    $("#navbar").load("view/shared/navbar.html");
    $("#footer").load("view/shared/footer.html");
};
