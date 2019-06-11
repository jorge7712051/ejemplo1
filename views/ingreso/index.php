<br>
<div class="row justify-content-center">
	<div class="col-xs-12 col-md-5">
    <p class="h2 text-center">Login</p><br>
		<form action="../ingreso/index" method="POST">
        <input type="hidden"  name="cargaUrl" id="cargaUrl" />
  			<div class="form-group">
    			<input type="text" class="form-control" id="usuario" name="usuario" placeholder="USUARIO" autocomplete="off" style="text-transform:uppercase;" required>
    		</div>
  			<div class="form-group">
    			<input type="password" class="form-control" id="clave" name="password" placeholder="PASSWORD" required>
 			</div>
       	<button type="submit" class="btn btn-success btn-block">INGRESAR</button>
		</form>
		<div id="respuesta">{MENSAJE}</div>	
	</div>		
</div>

	