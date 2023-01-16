<form id="myformchangepassword">
    <div class="row">
    <div class="col-md-3">
      <div class="form-group">    
         <input type="password" class="form-control form-control-sm" {{$canedit ? '':'disabled'}} value="" required  @if(auth()->user()->can('editar_contraseñas')) name="oldpassword"  placeholder="Contraseña administrador" @else name="oldpassword"  placeholder="Contraseña actual" @endif id="oldpassword">
      </div>
  </div>
     <div class="col-md-3">
      <div class="form-group">    
         <input type="password" class="form-control form-control-sm" {{$canedit ? '':'disabled'}} value="" required name="password" id="password" placeholder="Nueva contraseña">
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">    
         <input type="password" class="form-control form-control-sm" {{$canedit ? '':'disabled'}} value="" required name="confirpassword" id="confirpassword" placeholder="Repetir contraseña">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">    
        @if($canedit)
        <button type="submit"   class="btn btn-primary btn-sm" >
           Actualizar contraseña</button>
        @endif

      </div>
    </div>
  </div>
  </form>