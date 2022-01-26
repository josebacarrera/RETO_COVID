$(document).ready(init);

function init() {
    loadPaginaSanitario();
}

function loadPaginaSanitario() {
    $(".infoOpcion").css('display', 'none');
    $("#infoInformes").css('display', 'block');
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
    $("#configuracionVacuna").click(function () {
        $(".infoOpcion").css('display', 'none');
        $("#infoVacunas").css('display', 'block');

    }); 
}

var savedFileBase64;
var filename;
var filesize;

//CONTROLADOR DE LOS DATOS PERSONALES
reto_covid.controller('datosPersonales', async function ($scope) {
    let session = await getSession();

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

        }).catch(error => console.error('Error status:', error));

    };

});


//CONTROLADOR PARA DAR DE BAJA A UN PACIENTE
reto_covid.controller('bajaPaciente', async function ($scope) {
    $scope.tisPacientes = await getTisPacientes();

    $scope.change = async function () {
        console.log($scope.tisPaciente);
        var data = { 'solicitud': 'getPacienteByTis', 'tis':$scope.tisPaciente }
        var url = "controller/cPaciente.php";
        fetch(url, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'Content-Type': 'application/json' }

        }).then(res => res.json()).then(result => {
            console.log(result.lisTis);
        }).catch(error => console.error('Error status:', error));        
    };

});


//CONTROLADOR PARA EL ALTA DE LOS PACIENTES
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

    $scope.alta = async function() {
        if ($scope.nombre && $scope.apellido && $scope.fecha_nac && $scope.email && $scope.direccion && $scope.localidad) 
        {
            $scope.mensajeAlta="Paciente introducido correctamente"
            await insertPaciente($scope.nombre, $scope.apellido,$scope.fecha_nac,$scope.email,$scope.direccion, $scope.localidad);
        }else if (!$scope.email && $scope.nombre && $scope.apellido && $scope.fecha_nac && $scope.direccion && $scope.localidad){
            $scope.mensajeAlta="Introduce un email valido"
        }else{
            $scope.mensajeAlta="Introduce valores valido"
        }
    }

    // CUERPO
    $scope.$digest();
})

reto_covid.controller('editarVacunas', async function ($scope) {
    $scope.vacunas = await getVacunas();
    console.log($scope.vacunas[0]);

    $scope.updateVacuna = (codigo) => {
        console.log(codigo)
    }
    // CUERPO
    $scope.$digest();

})



//CARGA LAS LOCALIDADES
function getLocalidades() {
    return new Promise((resolve, reject) => {
        var data = { 'solicitud': 'getLocalidades' }
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

//CARGA TIS PACIENTES
function getTisPacientes() {
    return new Promise((resolve, reject) => {
        var data = { 'solicitud': 'selectAllTis' }
        var url = "controller/cPaciente.php";
        fetch(url, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'Content-Type': 'application/json' }

        }).then(res => res.json()).then(result => {
            resolve(result.lisTis);
        }).catch(error => console.error('Error status:', error));
    })
}


//INSERTAR PACIENTE
function insertPaciente(nombre, apellido,fecha_nac,email,direccion, localidad) {
    return new Promise((resolve) => {
        var data = { 'solicitud': 'insertPaciente', 'nombre': nombre, 'apellido': apellido, 'fecha_nac': fecha_nac, 'localidad': localidad, 'email': email, 'direccion': direccion };
        var url = "controller/cPaciente.php";
        fetch(url, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'Content-Type': 'application/json' }
        }).then(res => res.json()).then(result => {
            console.log(result);
            resolve(result);
        }).catch(error => console.error('Error status:', error));
    })
}

//CARGA LAS VACUNAS
function getVacunas() {
    return new Promise((resolve, reject) => {
        var data = { 'solicitud': 'setListVacunas' }
        var url = "controller/cVacuna.php";
        fetch(url, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'Content-Type': 'application/json' }

        }).then(res => res.json()).then(result => {
            resolve(result.vacunas);
        }).catch(error => console.error('Error status:', error));
    })
}

//ACTIVA LOS CAMPOS PARA PODER EDITARLOS
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
