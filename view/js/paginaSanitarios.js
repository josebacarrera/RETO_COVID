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
    $scope.perfil = "view/img/"+session.sanitario.foto_pefil;
    $scope.codigo=session.sanitario.codigo
    
    $('#nombreTrabajador').val($scope.nombre);
    $('#apellidoTrabajador').val($scope.apellido);
    $('#dniTrabajador').val($scope.dni);
    $('#cargoTrabajador').val($scope.cargo);
    $('#fotoPerfil').attr("src",$scope.perfil);

    $scope.editableInput = false;

    $scope.updateSanitario = function () {
        var filename = $('#fotoTrabajador').val().replace(/^.*\\/, "");
        namefile= "img"+session.sanitario.cod;
        var data = {
            'solicitud': 'updateSanitario',
            'codigo': session.sanitario.cod,
            'dni': $('#dniTrabajador').val(),
            'nombre': $('#nombreTrabajador').val(),
            'apellido': $('#apellidoTrabajador').val(),
            'foto_perfil': filename,
            'nombreImg': namefile
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


//CONTROLADOR PARA DAR DE BAJA A UN PACIENTE
reto_covid.controller('bajaPaciente', async function ($scope) {
    $scope.tisPacientes = await getTisPacientes();

    $scope.change = function () {
        if ($scope.tisPaciente.length == 7) {
            var url = "controller/cPaciente.php";
            var data = { 'solicitud': 'getPacienteByTis', 'tis': $scope.tisPaciente };

            fetch(url, {
                method: 'POST', // or 'POST'
                body: JSON.stringify(data), // data can be `string` or {object}!
                headers: { 'Content-Type': 'application/json' }  // input data
            })
            .then(res => res.json()).then(result => {
                console.log(result.paciente);
                if (result.paciente) {
                    $('#selectedPacienteNombre').val(result.paciente.nombre);
                    $('#selectedPacienteApellido').val(result.paciente.apellido);
                    $('#selectedPacienteFecha').val(result.paciente.fecha_nacimiento);
                    $('#btnBaja').prop("disabled",false);

                } else {
                    $('#selectedPacienteNombre').val(" ");
                    $('#selectedPacienteApellido').val(" ");
                    $('#selectedPacienteFecha').val(" ");
                    $('#btnBaja').prop("disabled",true);

                }
            })
            .catch(error => console.error('Error status:', error));
        }
    };

    $scope.baja = function() {
        var url = "controller/cPaciente.php";
            var data = { 'solicitud': 'getPacienteByTis', 'tis': $scope.tisPaciente };

            fetch(url, {
                method: 'POST', // or 'POST'
                body: JSON.stringify(data), // data can be `string` or {object}!
                headers: { 'Content-Type': 'application/json' }  // input data
            })
            .then(res => res.json()).then(result => {
                console.log(result.paciente);
                if (result.paciente) {
                    $('#selectedPacienteNombre').val(result.paciente.nombre);
                    $('#selectedPacienteApellido').val(result.paciente.apellido);
                    $('#selectedPacienteFecha').val(result.paciente.fecha_nacimiento);
                    $('#btnBaja').prop("disabled",false);

                } else {
                    $('#selectedPacienteNombre').val(" ");
                    $('#selectedPacienteApellido').val(" ");
                    $('#selectedPacienteFecha').val(" ");
                    $('#btnBaja').prop("disabled",true);

                }
            })
            .catch(error => console.error('Error status:', error));
    }
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

    $scope.alta = function () {
        if ($scope.nombre && $scope.apellido && $scope.fecha_nac && $scope.email && $scope.direccion && $scope.localidad) {
            $scope.mensajeAlta = "Paciente introducido correctamente"
            var data = { 'solicitud': 'insertPaciente', 'nombre': $scope.nombre, 'apellido': $scope.apellido, 'fecha_nac': $scope.fecha_nac, 'localidad': $scope.localidad, 'email': $scope.email, 'direccion': $scope.direccion };
            var url = "controller/cPaciente.php";
            fetch(url, {
                method: 'POST',
                body: JSON.stringify(data),
                headers: { 'Content-Type': 'application/json' }
            }).then(res => res.json()).then(result => {
                console.log(result);
            }).catch(error => console.error('Error status:', error));
        } else if (!$scope.email && $scope.nombre && $scope.apellido && $scope.fecha_nac && $scope.direccion && $scope.localidad) {
            $scope.mensajeAlta = "Introduce un email valido"
        } else {
            $scope.mensajeAlta = "Introduce valores valido"
        }
    }

    // CUERPO
    $scope.$digest();
})

reto_covid.controller('editarVacunas', async function ($scope) {
    $scope.vacunas = await getVacunas();

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
