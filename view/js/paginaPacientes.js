$(document).ready(init);
function init() {
    loadPaginaPacientes();
}
function loadPaginaPacientes() {
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
    $("#covid").click(function () {
        $(".infoOpcion").css('display', 'none');
        $("#infoCovid").css('display', 'block');
    });
    
}

