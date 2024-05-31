
@component('components.modal_medium')

	@slot('trigger')
		myModal_create_show_logs
        	@endslot

	@slot('title')
		<h5><label id="title_titular_modal">Documentos</label></h5>
	@endslot


	@slot('body')



 	<div class="row">
		<div class="col-md-12">

        <ul class="nav nav-tabs item-tab-rec-logs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link item-link-send-logs active" id="custom-tabs-send-logs-tab" data-toggle="pill" href="#custom-tabs-send-logs" role="tab" aria-controls="custom-tabs-send-logs" aria-selected="true">
                    Enviados</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-rec-logs-tab" data-toggle="pill" href="#custom-tabs-rec-logs" role="tab" aria-controls="custom-tabs-rec-log" aria-selected="false">
                    Recibidos</a>
                  </li>              
                </ul>

		<div class="tab-content item-tab-rec-logs" id="custom-tabs-one-tabContent">       
            <div class="tab-pane fade show active" id="custom-tabs-send-logs" role="tabpanel" aria-labelledby="custom-tabs-send-logs-tab">
            <div class="" id="content_logs_send">

			</div>		
            </div>

            <div class="tab-pane fade show" id="custom-tabs-rec-logs" role="tabpanel" aria-labelledby="custom-tabs-rec-logs-tab">
             <div class="" id="content_logs_rec">
				
			</div>
            </div>

		</div>

			<div class="content_logs_notification" id="content_logs_notification">

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










