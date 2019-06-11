$(document).ready(function() {
 	$("#usuario, #clave").on('copy cut paste', function(event) {
 	    event.preventDefault();
      	$("#respuesta").html('<div class="alert alert-danger">Las funciones copiar (Ctrl+C), cortar (Ctrl+X) y pegar (Ctrl+v) no están permitidas en este campo.');
    });
    
    $("#cargaUrl").val(window.location.origin); 
});
 