$(document).ready(init);

function init() {
    loadPaginaSanitario();
}

function loadPaginaSanitario() {
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

var savedFileBase64;
var filename;
var filesize;

reto_covid.controller('datosPersonales', async function ($scope) {
    let session = await getSession();
    console.log(session)

    $scope.nombre = session.sanitario.nombre;
    $scope.apellido = session.sanitario.apellido;
    $scope.dni = session.sanitario.dni;
    $scope.cargo = session.sanitario.cargo;

    $('#nombreTrabajador').val($scope.nombre);
    $('#apellidoTrabajador').val($scope.apellido);
    $('#dniTrabajador').val($scope.dni);
    $('#cargoTrabajador').val($scope.cargo);

    $scope.editableInput = false;

    $scope.updateSanitario = function () {

        
        var data = {
            'solicitud': 'updateSanitario',
            'dni': $('#dniTrabajador').val(),
            'nombre': $('#nombreTrabajador').val(),
            'apellido': $('#apellidoTrabajador').val(),
        }

        var url = "controller/cSanitario.php";
        fetch(url, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'Content-Type': 'application/json' }

        }).then(res => res.json()).then(result => {
            console.log(result);

        }).catch(error => console.error('Error status:', error));

    };

});


//Activar los campos para editarlos
reto_covid.directive("inputDisabled", function () {
    return function (scope, element, attrs) {
        scope.$watch(attrs.inputDisabled, function (val) {
            if (val) {
                element.removeAttr("disabled");
                $("#btnGuardar").css('display', 'block')
                $('.input-file-input').prop("disabled", false); 

            }
            else {
                element.attr("disabled", "disabled");
                $("#btnGuardar").css('display', 'none')
                $('.input-file-input').prop("disabled", true); 
            }
        });
    }
});

reto_covid.controller('altaPaciente', async function ($scope) {

    // VARIABLES

    $scope.nombre;
    $scope.apellido;
    $scope.fecha_nac;
    $scope.email;
    $scope.direccion;
    $scope.localidad;

    // FUNCIONES

    $scope.localidades = await getLocalidades();
    $scope.alta = () => {
       console.log(1);
    }

    // CUERPO

    $scope.$digest();

})

function getLocalidades() {
    return new Promise((resolve, reject) => {
        var data = {'solicitud': 'getLocalidades'}
        var url = "controller/cLocalidad.php";
        fetch(url, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'Content-Type': 'application/json' }
    
        }).then(res => res.json()).then(result => {
            resolve(result.localidades);
    
        }).catch(error => console.error('Error status:', error));
    })
}