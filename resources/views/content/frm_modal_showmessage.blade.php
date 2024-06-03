
@component('components.modal_large')

	@slot('trigger')
		myModal_show_message
        	@endslot

	@slot('title')
		<h5><label id="title_titular_modal">Información importante</label></h5>
	@endslot


	@slot('body')



 	<div class="row">
		<div class="col-md-12" id="modal-show-alerts-content">


		</div>
	</div>


	@endslot

	@slot('footer')
	<label id="NoVolverAMmostrar"></label>
{{-- 
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      --}}
	 @endslot

@endcomponent
<!-- /modal -->










