@component('components.modal_medium')

	@slot('trigger')
		myModal_asignar_rol
	@endslot

	@slot('title')
		<h6><label id="lbl_modal_title">Asignando rol</label></h6>
	@endslot


	@slot('body')


 	<div class="row">
		<div class="col-md-6 offset-md-3">
		       
            <form id="myformAsigRol" method="POST">
			<input type="hidden" value="{{$user->id}}" name="id" id="user_id">
            <select class="form-control" name="role_id" id="rol_asig_id">
				@foreach ($roles as $key => $rol)
					<option value="{{$key}}">{{$rol}}</option>
				@endforeach
			</select>    
			<br>   
            <button type="submit" class="btn btn-primary btn-block">Asignar</button>

            </form>
         
		</div>
	</div>


	@endslot

  	@slot('footer')  
              
	@endslot
  
@endcomponent
<!-- /modal -->

