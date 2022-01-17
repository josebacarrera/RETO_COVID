document.addEventListener("DOMContentLoaded", function(){
    document.formulario.addEventListener('submit', validarFormulario);

    function validarFormulario(evObject){
        evObject.preventDefault();
        var nombre = document.getElementById("name")
        var comentario = document.getElementById("comentario")
        if (nombre.value == null || nombre.value == 0)
        {
            alert("El campo del nombre no puede estar vacio"); 
        }else if(comentario.value == null || comentario.value == 0){
            alert("El campo del comentario no puede estar vacio")
        }else{
            document.formulario.submit();
        }

    }
})