@component('components.modal_medium')

	@slot('trigger')
		myModal_change_status
	@endslot

	@slot('title')
		<h6><label id="lbl_modal_title_diary">Cambiando estado</label></h6>
	@endslot


	@slot('body')


 	<div class="row">
		<div class="col-md-10 offset-md-1" id="content_form_cl">
		       
         <form method="POST" id="myformChangeStatus">
            <input type="hidden" name="id">
     {{ csrf_field() }}
       
         <div class="form-group">
            <label>Estado</label>
            <select class="form-control form-control-sm" name="type_status_id" id="type_status_id">
               
                @foreach($types_status as $id => $type_status)
                <option value="{{$id}}">{{$type_status}}</option>
                @endforeach
            </select>
         </div>

         <div class="form-group">
            <label>Estado</label>
            <textarea class="form-control form-control-sm" name="status_description" id="status_description" rows="4"></textarea>
         </div>


        <button type="submit" class="btn btn-primary btn-sm btn-block">Actualizar</button>

                            
                </form>
         
		</div>
	</div>


	@endslot

  	@slot('footer')  
       <div id="footer_modal-diary"> </div>
	@endslot
  
@endcomponent
<!-- /modal -->

