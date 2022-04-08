@component('components.modal_medium')

	@slot('trigger')
	myModalDetalsAudit
	@endslot

	@slot('title')
		<h6><label id="lbl_modal_title_diary_show">Descripción de cambios</label></h6>
	@endslot


	@slot('body')


 	<div class="row">
		<div class="col-md-10 offset-md-1">
		   <textarea readonly disabled rows="15" id="myJsonParse" class="form-control"></textarea> 		   
        </div>

    </div>
         

	


	@endslot

  	@slot('footer')  
       <div id="footer_modal-diary-show"> </div>
	@endslot
  
@endcomponent
<!-- /modal -->

