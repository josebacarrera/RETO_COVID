var paginaSanitarios = angular.module('paginaSanitarios', []);


paginaSanitarios.controller('datosPersonales', function ($scope) {
    $scope.nombre="prueba";
    $('#nombreTrabajador').val($scope.nombre);
});
