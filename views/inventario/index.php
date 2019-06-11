<br>
<!--
<div class="row justify-content-center">
	<div class="col-4">
		<h6>{MENSAJE}</h6>	
	</div>		
</div> -->

  <div class="row">
    <div class="col-12">
        <div class="page-header  p-1 mb-2  shadow-sm">
            <h1 class="text-center">{TITULO}</h1>
        </div>
    </div>
  </div>
  <br>
  <br>
  <div class="row justify-content-center">
    <div class="col-md-12 ">
      <form class="form-inline"  name="frmInventario" id="frmInventario"  method="POST"  action="../inventario/reporte">
            <h6><label class="mb-2 mr-sm-2 lb-md" >Cliente </label></h6>
            <div class='nput-group mb-2 mr-sm-2'>
              <select class="form-control " name="id_cliente" id="id_cliente" required>
                           {CLIENTE}
              </select>
            </div> 
            <div class="btn-group mb-2 ml-3">
              <button type="submit" class="btn btn-success " id="btnDescargar"><span class="fa fa-download"></span> Descargar</button>
            </div>          
        
      </form>
    </div>    
  </div>  





