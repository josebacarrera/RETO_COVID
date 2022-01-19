$(document).ready(init);

function init() {/* 
    //Comprueba que se ha iniciado sesión
    await getSession().then(async function(session){

   });*/
    loadContent();
}

function loadContent() {
    $("#datosPersonales").click(function () {
        $(".infoOpcion").css('display', 'none');
        $("#infoDatosPersonales").css('display', 'block');

    });
    $("#agendaSanitaria").click(function () {
        $(".infoOpcion").css('display', 'none');
        $("#infoAgenda").css('display', 'block');

    });
    $("#informes").click(function () {
        $(".infoOpcion").css('display', 'none');
        $("#infoInformes").css('display', 'block');

    });
}
var paginaSanitarios = angular.module('paginaSanitarios', []);


paginaSanitarios.controller('datosPersonales', function ($scope) {
    $scope.nombre = "prueba";
    $('#nombreTrabajador').val($scope.nombre);
    $scope.editableInput = false;

    $scope.btnGuardar = function () {

    };

});

//Activar los campos para editarlos
paginaSanitarios.directive("inputDisabled", function () {
    return function (scope, element, attrs) {
        scope.$watch(attrs.inputDisabled, function (val) {
            if (val) {
                element.removeAttr("disabled");
                $("#btnGuardar").css('display','block')
            }
            else {
                element.attr("disabled", "disabled");
                $("#btnGuardar").css('display','none')
            }
        });
    }
});