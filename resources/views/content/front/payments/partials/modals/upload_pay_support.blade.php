@component('components.modal_medium')

	@slot('trigger')
		myModal_upload_pay_support
	@endslot

	@slot('title')
		<h6><label id="lbl_modal_title">Creando documento</label></h6>
	@endslot


	@slot('body')

<div class="row supload_supf">
<div class="col-md-4">
<label for="type_support_file">Agregar archivo</label>
                                           
</div>
<div class="col-md-8">
 <select name="type_category_id" required="" class="form-control form-control-sm" id="type_category_payment_id">
                                              <option value="">Seleccione una categoria..</option>
                                              @foreach ($types_support_file as $key => $type_support_file)
                                                <option value="{{$key}}">{{$type_support_file}}</option>
                                              @endforeach
                                            </select> 
<input type="hidden" name="payment_credit_id" id="payment_credit_id">
</div>
</div>

<hr>
<div class="row" style="display:none;margin-bottom:4px;" id="content_form_support_file">
      <div  class="col-12">
                    <div id="actions">
                      <!-- The fileinput-button span is used to style the file input field as button -->
                      <span class="btn btn-primary btn-sm fileinput-button dz-clickable">
                          <i class="fa fa-upload"></i>
                          <span>Archivo</span>
                      </span>
                    
                       <button type="reset" class="btn btn-sm btn-default cancel">
                          <i class="fa fa-window-close-o"></i>
                          <span> Cerrar</span>
                      </button>
                    </div>

    </div>

<div class="col-md-12">
    
                <div class="table table-striped files" id="previews" style="margin-top:3px">

                  <div id="template_2" class="file-row" style="display:block" >
                  
                  <div class="row">
                  <div class="col-md-3">
                  <span class="preview"><img data-dz-thumbnail /></span>
                            
                  </div>
                  <div class="col-md-6">
                  <div class="dz-filename"><span data-dz-name class=""></span></div>
                
                  <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                              <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                    </div>
                    <p class="size" data-dz-size></p>
                  </div>
                  <div class="col-md-3">
                    <button  class="btn btn-warning cancel">
                          <i class="fa fa-minus-circle"></i>                          
                      </button>
                  </div>
          
                  </div>
                  </div>
                  </div>
</div> 

</div>


	@endslot

  	@slot('footer')  
             
	@endslot
  
@endcomponent
<!-- /modal -->

