@component('components.modal_medium')

	@slot('trigger')
		myModal_create_user
	@endslot

	@slot('title')
		<h6><label id="lbl_modal_title">Nuevo usuario</label></h6>
	@endslot


	@slot('body')


 	<div class="row">
      <div class="col-md-10 offset-md-1" id="content_chk_sel_prof" style="display:none">
                 <div class="form-group">
                
                  <div class="form-group">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" checked required type="radio" name="radio_change_revisor" id="select_user" value="select_user">
                      <label class="form-check-label" for="select_user">Profesionales registrados</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input"  required type="radio" name="radio_change_revisor" id="create_user" value="create_user">
                      <label class="form-check-label" for="create_user">Registrar profesional</label>
                    </div>
                </div>
                  </div>
        </div>

		<div class="col-md-10 offset-md-1">
		       
         <form action="{{route('users.store')}}" method="POST" id="myformCreateUser">
             <input type="hidden" name="id" id="id_user">
             <input type="hidden" name="type_user_id" id="type_user_id">
     {{ csrf_field() }}

            <div class="col-md-12" id="cont_select_new_professional" style="display:none">
                 <div class="form-group">
                  <label>Nombre de usuario:</label>
                   <select disabled name="id" required  id="id_usuario" class="form-control form-control-sm">
                      <option value="">Seleccione...</option>
                      @foreach ($users_prof as $user)
                          <option value="{{$user->id}}">{{$user->name}}</option>
                      @endforeach
                    </select>
                 </div>
            </div>
        
       <div id="cont_form_new_professional" style="display:block">
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
                    <input type="text" required class="form-control form-control-sm onlynumber" data-toggle="tooltip" title="Solo números" name="identification_number" id="identification_number">
                </div>

                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" required class="form-control form-control-sm" id="name" name="name" value="">                               
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" required class="form-control form-control-sm" id="email" name="email" value="">                               
                </div>
                <div class="form-group">
                    <label for="direction">Dirección</label>
                    <input type="text" required class="form-control form-control-sm default-email" id="address" name="address" value="">                               
                </div> 
                <div class="form-group">
                    <label for="telephone">Teléfono</label>
                    <input type="number" required class="form-control form-control-sm" id="phone_number" name="phone_number" value="">                               
                </div>

                <div class="form-group contentDefendant">
                    <label for="typedefendant" id="lbl_type_user_defendant">Tipo contraparte</label>
                    <input type="text"  class="form-control form-control-sm default-email" id="typedefendant" name="type_defendant" maxlength="20" value="">                               
                </div> 
                
                <div class="form-group">
                    <label for="telephone">Rol de sistema <small id="lbl_rol_status"> </small></label>
                    <select name="role_id" id="vo_role_id" class="form-control form-control-sm">
                    @foreach($roles_access_vo as $key => $role)
                     <option value="{{$role->id}}">{{$role->name}} </option>
                    @endforeach
                    </select>

                    <select style="display:none" disabled name="role_id" id="prof_role_id" class="form-control form-control-sm">
                               @foreach($roles_prof as $key => $role)
                                   <option value="{{$role->id}}">{{$role->name}} </option>
                               @endforeach
                    </select>  

                </div>
               {{--  <input type="hidden" readonly required class="form-control form-control-sm" id="password" name="password" value="">                               
               --}}                              
         </div>                  
                          <button type="submit" class="btn btn-primary btn-block" >Agregar</button>

                             <button type="button" style="display:none" class="btn btn-default btn-block">Agregar</button>


                </form>
         
		</div>
	</div>


	@endslot

  	@slot('footer')  
       
    @endslot
  
@endcomponent
<!-- /modal -->

