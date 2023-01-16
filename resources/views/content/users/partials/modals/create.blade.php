@component('components.modal_medium')

	@slot('trigger')
		myModal_create_user
	@endslot

	@slot('title')
		<h6><label id="lbl_modal_title">Nuevo usuario</label></h6>
	@endslot


	@slot('body')


 	<div class="row">
		<div class="col-md-10 offset-md-1">
		       
         <form action="{{route('users.store')}}" method="POST" id="myformCreateNewUser">
             
     {{ csrf_field() }}
            <div class="form-group">
                 @foreach ($types_identification as $key => $tipo_doc )
                     <div class="form-check form-check-inline">
                      <input class="form-check-input" required checked type="radio" name="type_identification_id" id="type_identification-{{$key}}" value="{{$key}}">
                      <label class="form-check-label" for="inlineRadio1">{{$tipo_doc}}</label>
                    </div>
                 @endforeach
                </div>

       <div class="form-group">

                <label for="num_identificacion">No de identificación</label>
                    <input type="text" required class="form-control onlynumber"  data-toggle="tooltip" title="Solo números" name="identification_number" id="identification_number">
                </div>

<div class="form-group">

                                <label for="name">Nombre</label>
                                <input type="text" required class="form-control form-control-sm" id="name" name="name" value="">                               
                            </div>

                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" required class="form-control form-control-sm" id="email" name="email" value="">                               
                            </div>

                         {{--    <div class="form-group">
                                <label for="direction">Dirección</label>
                                <input type="text" required class="form-control form-control-sm" id="direccion" name="direccion" value="">                               
                            </div> --}}

                            <div class="form-group">
                                <label for="telephone">Teléfono</label>
                                <input type="number" required class="form-control form-control-sm" id="phone_number" name="phone_number" value="">                               
                            </div>
                            
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input  required type="password" class="form-control form-control-sm" id="password" name="password" value="">                               
                            </div>
                          
                            <div class="form-group">
                            <label for="password">Rol  <small id="lbl_rol_status"> </small></label>
                            <select class="form-control" required name="role_id" id="rol_asig_id">
                                @foreach ($roles as $key => $rol)
                                    <option value="{{$key}}">{{$rol}}</option>
                                @endforeach
                            </select>    
                            </div> 
                           
                           

                             <button type="submit" class="btn btn-primary btn-sm btn-block">Crear usuario</button>


                </form>
         
		</div>
	</div>


	@endslot

  	@slot('footer')  
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>       
	@endslot
  
@endcomponent
<!-- /modal -->

