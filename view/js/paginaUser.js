document.addEventListener("DOMContentLoaded", function(){
    elementoAgenda=document.getElementById("#mostrarAgenda");
    elementoAgenda.addEventListener("click", showAgenda);
    elementoInforme=document.getElementById("#mostrarInforme");
    elementoInforme.addEventListener("click", showInforme);
    elementoDatos=document.getElementById("#mostrarDatos");
    elementoDatos.addEventListener("click", showDatos);
});

function showAgenda(){
    document.getElementById("#mostrarAgenda").style.display = '';
    document.getElementById("#mostrarInforme").style.display = 'none';
    document.getElementById("#mostrarDatos").style.display = 'none';
}
function showInforme(){
    document.getElementById("#mostrarAgenda").style.display = 'none';
    document.getElementById("#mostrarInforme").style.display = '';
    document.getElementById("#mostrarDatos").style.display = 'none';
}
function showDatos(){
    document.getElementById("mostrarAgenda").style.display = 'none';
    document.getElementById("mostrarInforme").style.display = 'none';
    document.getElementById("mostrarDatos").style.display = '';
    console.log("hawaii");
}
function showCovid(){
    document.getElementById("mostrarAgenda").style.display = 'none';
    document.getElementById("mostrarInforme").style.display = 'none';
    document.getElementById("mostrarDatos").style.display = 'none';
    document.getElementById("mostrarCovid").style.display = '';
}
