@component('components.modal_large')

	@slot('trigger')
		myModal_user_data
	@endslot

	@slot('title')
		<h6><label id="lbl_modal_title">Datos del usuario</label></h6>
	@endslot


	@slot('body')


 	<div class="row">
		<div class="col-md-9">
		      <select class="form-control" name="data_user" id="data_user">
              @foreach ($types_data_user as  $key => $type_data_user )
                  <option value="{{$key}}"> {{ $type_data_user}} </option>
              @endforeach
              </select> 
         
         
		</div>

        	<div class="col-md-3">
		      <button class="btn btn-primary btn-block" id="btn_add_user_data">Agregar</button>
         
         
		</div>
	</div>
<hr>



    <div class="row content_user_data" id="content_user_data">
 
    
   
    </div>


	@endslot

  	@slot('footer')  
             
	@endslot
  
@endcomponent
<!-- /modal -->

