<br>
  <div class="row">
    <div class="col-12">
        <div class="page-header">
            <h1 class="text-center">{TITULO}</h1>
        </div>
    </div>
  </div>
  <br>
  <br>
  <div class="row justify-content-center">
    <div class="col-md-6 col-xs-12">
      <form id="cambio-contrasena" method="POST" class="needs-validation" novalidate>
        <div class="form-group">
          <label for="passwactual">Contraseña Actual</label>
          <input type="password" class="form-control" id="passwactual" name="passwactual" >
          <div class="invalid-feedback" id="errorpasswactual"></div> 
        </div>
        <div class="form-group">
          <label for="nuevopass">Nueva Contraseña</label>
          <input type="password" class="form-control" id="nuevopass" name="nuevopass" >
          <div class="invalid-feedback" id="errornuevopass"></div>          
        </div>
        <div class="form-group">
          <label for="repetirpass">Repetir Contraseña</label>
          <input type="password" class="form-control" id="repetirpass" name="repetirpass" >
          <div class="invalid-feedback" id="errorrepetirpass"></div>
        </div>
        <button type="submit" class="btn btn-success">Cambiar</button>
      </form>
      <div id="respuesta"></div>
    
</div>  