
@component('components.modal_medium')

	@slot('trigger')
		myModal_create_new_prof
	@endslot

	@slot('title')
		<h5><label id="title_titular_modal">Asignando profesional</label></h5>
	@endslot


	@slot('body')



 	<div class="row">
		<div class="col-md-12">
		<div class="box-body" id="content_form_rev">
     <div class="col-md-12" id="cont">
                 <div class="form-group">
                
                  <div class="form-group">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" checked required type="radio" name="radio_change_revisor" id="select_user" value="select_user">
                      <label class="form-check-label" for="select_user">Profesionales registrados</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input"  required type="radio" name="radio_change_revisor" id="create_user" value="create_user">
                      <label class="form-check-label" for="create_user">Nuevo profesional</label>
                    </div>
                </div>
                  </div>
               </div>
    <form id="myFormCreateNewProfessional">
    <input type="hidden" name="id" id="id_us">
    <input type="text" name="type_user_id" id="type_user_id">
     

 
<div id="cont_select_new_professional">
<div class="col-md-12" id="cont_select_new_professional">
                 <div class="form-group">
                  <label>Nombre de perfil:</label>
                   <select name="id" required  id="id_usuario" class="form-control form-control-sm">
                      <option value="">Seleccione...</option>
                      @foreach ($users_prof as $user)
                          <option value="{{$user->id}}">{{$user->name}}</option>
                      @endforeach
                    </select>
                 </div>
</div>

</div>





          <div id="cont_form_new_professional" style="display:none">
                <div class="form-group">
                  <select name="type_identification_id" id="type_identification" class="form-control form-control-sm form-select" required>
                      @foreach ($types_identification as $key => $tipo_doc)
                          <option value="{{ $key }}" @if($tipo_doc == "CC") selected @endif>{{ $tipo_doc }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="form-group">
                    <label for="num_identificacion">No de identificación</label>
                    <input type="text" required class="form-control" name="identification_number" id="identification_number">
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
                                <input type="text" required class="form-control form-control-sm" id="address" name="address" value="">                               
                            </div> 

                            <div class="form-group">
                                <label for="telephone">Teléfono</label>
                                <input type="number" required class="form-control form-control-sm" id="phone_number" name="phone_number" value="">                               
                            </div>

                             <div class="form-group">
                                <label for="role">Rol</label>
                               <select name="role_id" id="us_role_id" class="form-control form-control-sm">
                               @foreach($roles_access_vo as $key => $role)
                                   <option value="{{$role->id}}">{{$role->display_name}} </option>
                               @endforeach
                               </select>                              
                            </div>
                    </div>           



                <div class="col-md-12">
                 <div class="form-group">

                    <input type="submit" class="btn btn-success btn-block" value="Agregar">

                    <input type="button" style="display:none" class="btn btn-success btn-block" value="Agregar">
                  </div>
               </div>
    </form>

			</div>
		</div>
	</div>


	@endslot

	@slot('footer')

	{{--  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
     --}}
	 @endslot

@endcomponent
<!-- /modal -->










