var objeto=1;


$("#btnDescargar").on('click', function(event) {
    event.preventDefault();
    if(filtros())
    {
       $("#frmInventario").submit(); 
    }
    else
    {
        alert("Ingrese el filro cliente");
    }
    
})

// validacion de los campos

function filtros(){

  if(($("#id_cliente").val() != 0 && $("#id_cliente").val() != null))
  {
    return true;
  }
  return false;
}



 $(window).on("beforeunload", function() {
  if(objeto==1){
          $.ajax({
          type: "POST", 
          url: '../ingreso/salir',
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
