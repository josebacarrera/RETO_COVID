// document.addEventListener("DOMContentLoaded", function(){
//     elementoAgenda=document.getElementById("#mostrarAgenda");
//     elementoAgenda.addEventListener("click", showAgenda);
//     elementoInforme=document.getElementById("#mostrarInforme");
//     elementoInforme.addEventListener("click", showInforme);
//     elementoDatos=document.getElementById("#mostrarDatos");
//     elementoDatos.addEventListener("click", showDatos);
//     elementoDatos=document.getElementById("#mostrarCovid");
//     elementoDatos.addEventListener("click", showCovid);
// });

// function showAgenda(){
//     document.getElementById("#mostrarAgenda").style.display = '';
//     document.getElementById("#mostrarInforme").style.display = 'none';
//     document.getElementById("#mostrarDatos").style.display = 'none';
//     document.getElementById("#mostrarCovid").style.display = 'none';
// }
// function showInforme(){
//     document.getElementById("#mostrarAgenda").style.display = 'none';
//     document.getElementById("#mostrarInforme").style.display = '';
//     document.getElementById("#mostrarDatos").style.display = 'none';
//     document.getElementById("#mostrarCovid").style.display = 'none';
// }
// function showDatos(){
//     document.getElementById("mostrarAgenda").style.display = 'none';
//     document.getElementById("mostrarInforme").style.display = 'none';
//     document.getElementById("mostrarDatos").style.display = '';
//     document.getElementById("mostrarCovid").style.display = 'none';
// }
// function showCovid(){
//     document.getElementById("mostrarAgenda").style.display = 'none';
//     document.getElementById("mostrarInforme").style.display = 'none';
//     document.getElementById("mostrarDatos").style.display = 'none';
//     document.getElementById("mostrarCovid").style.display = '';
// }


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