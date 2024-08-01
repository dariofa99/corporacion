@component('components.modal_large')
    @slot('trigger')
        myModal_create_streaming_cases
    @endslot

    @slot('title')
        <h5><label id="title_titular_modal">Video llamada</label></h5>
    @endslot


    @slot('body')
        <div class="row">
            <div class="col-md-8">
		<a id="newtab-stream-cases" href="" class="btn btn-info" target="_blank">Ir a video llamada como persona moderadora</a>

            </div>

            <div class="col-md-4 text-md-right">
		 <button type="button" id="ask-stream-cases" data-id="{{ $case->id }}" class="btn btn-info">Invitar
                    solicitante</button>
            </div>


        </div>
        <br>
        <div class="row">
		<label>Link para solicitante</label>
        	<div class="col-md-12 input-group input-group-sm" id="content-text-stream-cases">
                	<input type="text" class="form-control form-control-sm text-center" readonly id="text-stream-cases" value="">
			<span class="input-group-btn">
				<button type="button"  id="copy-stream-cases" class="btn btn-info btn-flat btn-sm">Copiar link</button>
			</span>
        	</div>
        </div>
	<br>
        <div class="row">
                <label>Link para personas moderadoras</label>
                <div class="col-md-12 input-group input-group-sm" id="content-text-stream-cases-moderator">
                        <input type="text" class="form-control form-control-sm text-center" readonly id="text-stream-cases-moderator" value="">
                        <span class="input-group-btn">
                                <button type="button" id="copy-stream-cases-moderator" class="btn btn-info btn-flat btn-sm">Copiar link</button>
                        </span>
                </div>
        </div>






    @endslot

    @slot('footer')
        {{--  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
     --}}
           @endslot
@endcomponent
<!-- /modal -->
