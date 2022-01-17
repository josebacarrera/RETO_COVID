$(document).ready(init);

function init() {/* 
    //Comprueba que se ha iniciado sesión
    await getSession().then(async function(session){

   });*/
    loadContent();
}

function loadContent() {
    $("#datosPersonales").click(function () {
        $(".infoOpcion").css('display', 'none')
        $("#infoDatosPersonales").css('display', 'block')
    });
}
var paginaSanitarios = angular.module('paginaSanitarios', []);


paginaSanitarios.controller('datosPersonales', function ($scope) {
    $scope.nombre = "prueba";
    $('#nombreTrabajador').val($scope.nombre);
});
