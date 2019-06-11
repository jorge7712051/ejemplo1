var objeto=1;

$(document).ready(function (){

    $("#cambio-contrasena").on("submit", function(e){
     e.preventDefault();
           $("input").removeClass("is-invalid"); 
      if(validaCambio() == true){
          var formData = new FormData();
          formData.append('nuevopass', $("#nuevopass").val());
          formData.append('passwactual', $("#passwactual").val());
          formData.append('repetirpass', $("#repetirpass").val());
          $.ajax({
          type: "POST", 
          url: 'cambio-contrasena',
          contentType:false,
          processData: false,
          dataType: "json",
          data: formData, 
          success: function(data) { 
             $(".errores").html('');
            if(data.error=='ok'){
              $("#respuesta").html('<div class="alert alert-success">Cambio de contraseña correcto, su sesión se cerrará para que vuelva a ingresar con su nueva clave.</div>');
              setTimeout(reDirigir, 4000);
            }else{
              $.each(data, function(i, item) {
                $("#"+i).addClass("form-control is-invalid");
                $("#error"+i).text(item);                     
              })
            }           
             
          },
          error: function(data, status, e) {
              $("#respuesta").html("Ocurrió un error, actualice la página y vuelva a intentarlo, en caso de persistir el problema comuníquese con el administrador del sistema.");
              $(".modal-alerta").modal("show");
            }
          });
     } 
    });  

    $("#passwactual, #nuevopass, #repetirpass").on('copy cut paste', function(event) {
      event.preventDefault();

      $("#respuesta").html("Las funciones copiar (Ctrl+C), cortar (Ctrl+X) y pegar (Ctrl+v) no están permitidas en este campo.");
      
    });
});

function validaCambio(){

  var Contrasena = $("#passwactual").val();
  var Nueva = $("#nuevopass").val();
  var Verifica = $("#repetirpass").val();
  var Pasa = false;

  if(Contrasena == Nueva){
    $("#respuesta").html('<div class="alert alert-danger">Debe ingresar una contraseña diferente a la actual.</div>');
   }
 else{
    Pasa = true;
  }
  return Pasa;
}

function reDirigir(){
   window.location = 'salir';   
    
}


$(window).on("beforeunload", function() {
  if(objeto==1){
          $.ajax({
          type: "POST", 
          url: 'salir',
          contentType:false,
          processData: false,                    
          success: function(data) {                
             
          }
    });
          
  }
}) 

function elemento(e){
  if (e.srcElement)
    tag = e.srcElement.tagName;
  else if (e.target)
      tag = e.target.tagName;
  if(tag=='A' )
  {
    objeto=0;
  }
 
  
}

function onKeyDownHandler(event) { 
  var codigo = event.which || event.keyCode; 
  if(codigo === 116){ 
    alert(objeto);
   objeto=0; 
 } 
}