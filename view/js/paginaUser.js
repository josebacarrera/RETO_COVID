$(".btnAgenda").click(showAgenda);

function showAgenda(){
    $(".agenda").css('display', 'inline-block');
    $(".informe").css('display', 'none');
    $(".datos").css('display', 'none');
    $(".vacuna").css('display', 'none');
    $(".faq").css('display', 'none');
}

$(".btnInforme").click(showInforme);

function showInforme() {
    $(".agenda").css('display', 'none');
    $(".informe").css('display', 'inline-block');
    $(".datos").css('display', 'none');
    $(".vacuna").css('display', 'none');
    $(".faq").css('display', 'none');
}

$(".btnDatos").click(showDatos);

function showDatos() {
    $(".agenda").css('display', 'none');
    $(".informe").css('display', 'none');
    $(".datos").css('display', 'inline-block');
    $(".vacuna").css('display', 'none');
    $(".faq").css('display', 'none');
}

$(".btnVacuna").click(showCovid);

function showCovid() {
    $(".agenda").css('display', 'none');
    $(".informe").css('display', 'none');
    $(".datos").css('display', 'none');
    $(".vacuna").css('display', 'inline-block');
    $(".faq").css('display', 'none');
}

$(".btnVMas").click(showFaq);

function showFaq() {
    $(".agenda").css('display', 'none');
    $(".informe").css('display', 'none');
    $(".datos").css('display', 'none');
    $(".vacuna").css('display', 'none');
    $(".faq").css('display', 'inline-block');
}