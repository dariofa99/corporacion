
@component('components.modal_large')

	@slot('trigger')
		myModal_client_streaming_cases
        	@endslot

	@slot('title')
		<h5><label id="title_titular_modal">Video llamada</label></h5>
	@endslot


	@slot('body')




	<div class="row">

		<div class="col-md-4 offset-md-4 text-md-center" >
		<a id="newtab-stream-cases-client" href="" class="btn btn-info" target="_blank">Abrir en nueva pestaña</a>
		
		</div>

		<div class="col-md-4 text-md-right" >
			{{-- <button type="button" id="copy-stream-cases-client"  data-frame="" class="btn btn-info">Copiar link</button> --}}
		</div>


	</div>
	<br>
	<div class="row">
		<div class="col-md-12" id="content-text-stream-cases-client" >
			<input type="text" class="form-control form-control-sm text-center" readonly id="text-stream-cases-client" value="">
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="embed-responsive embed-responsive-4by3" style=" height: 500px; ">
				<iframe id="iframe-stream-cases-client" class="embed-responsive-item" src="" frameborder="0" style="border:0" allow="camera; microphone" ></iframe> 
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










