@component('components.modal_medium')

	@slot('trigger')
		myModal_create_bill
	@endslot

	@slot('title')
		<h6><label id="lbl_modal_title">Actualizando cobro</label></h6>
     <span style="margin-left:15px;margin-top: -3px;"></span>
	@endslot


	@slot('body')


 	<div class="row">
		<div class="col-md-12 " id="content_form_cl">
		       
        
  

        <div class="card card-primary card-outline card-outline-tabs">
              <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="nav-bill-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="link-general-bill-tab" data-toggle="pill" href="#general-bill-tab" role="tab" aria-controls="general-bill-tab" aria-selected="true">
                    General</a>
                  </li>
                  <li class="nav-item optionsnav">
                    <a class="nav-link" id="link-value-bill-tab" data-toggle="pill" href="#value-bill-tab" role="tab" aria-controls="value-bill-tab" aria-selected="false">
                    Valor</a>
                  </li>
                 
                 {{--   <li class="nav-item optionsnav">
                    <a class="nav-link" id="link-options-bill-tab" data-toggle="pill" href="#options-bill-tab" role="tab" aria-controls="options-bill-tab" aria-selected="false">
                    Opciones</a>
                  </li>  --}}
                  <li class="nav-item optionsnav">
                    <a class="nav-link" id="link-support-bill-tab" data-toggle="pill" href="#support-bill-tab" role="tab" aria-controls="support-bill-tab" aria-selected="false">
                    Soportes</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="tabs-bill-content">
                     
                  <div class="tab-pane fade show active" id="general-bill-tab" role="tabpanel" aria-labelledby="general-bill-tab">
                    <form action="#" method="POST" id="myformEditBill" enctype="multipart/form-data">
 
                            <input type="hidden" name="id" id="payment_id"> 
                            <input type="hidden" name="type_bill_id" id="type_bill_id">
                             {{ csrf_field() }}
                        <div class="form-group bill_r">
                                <label for="concept">Categoria</label>
                                <select name="type_category_id" required="" class="form-control form-control-sm" id="type_categorybill_id">
                                        <option value="">Seleccione..</option>
                                        @foreach ($types_categories_pays as $key => $type_categories_pays)
                                             <option value="{{$key}}">{{$type_categories_pays}}</option>
                                        @endforeach
                                </select>
                                                                 
                        </div>
              
                        <div class="form-group bill_r">
                                <label for="concept">Concepto</label>
                                <input type="text" required="" class="form-control form-control-sm input_payment_value" id="concept" name="concept">                               
                        </div>
              
                        <div class="form-group">
                                <label for="email">Descripción</label>
                                <textarea required="" class="form-control form-control-sm input_payment_value" name="description" id="description" rows="3"></textarea> 
                                              
                        </div>     

                        <div class="form-group bill">
                                <label for="shared_bill">¿Compartir con solicitante?</label>
                                <input type="checkbox" class="chk_payment_value" name="shared" id="shared_bill" data-size="xs" data-style="order-check" data-width="60" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">
                        </div>
      <button type="submit" class="btn btn-sm btn-primary btn-block" >
        Actualizar</button>          
</form>
                  </div>



                  <div class="tab-pane fade" id="value-bill-tab" role="tabpanel" aria-labelledby="value-bill-tab">
                     <form action="" method="POST" id="myformEditBillCredits">
 
                         <div class="form-group"> 
                                          <label for="value">Valor</label>
                                          <input type="number" required="" class="form-control form-control-sm set_val_pcv" id="value" name="value" value="">                               
                                      </div>
                                      <div class="form-group bill_r">
                                        <label for="type_payment_id">Tipo pago</label>
                                        <select name="type_payment_id" required="" class="form-control form-control-sm" id="type_payment_id">
                                          <option value="">Seleccione..</option>
                                           @foreach ($types_payment as $key => $type_payment)
                                             <option value="{{$key}}">{{$type_payment}}</option>
                                        @endforeach
                                        </select>                     
                                      </div>  
                                      <div class="row credit_options">
                                        <div class="col">
                                          <div class="form-group">
                                            <label for="num_payments">Número de cuotas</label>
                                            <input type="number" min="1" required="" class="form-control form-control-sm set_val_pcv" id="num_payments" name="num_payments" value="">                               
                                        </div>
                                        </div>
                                        <div class="col">
                                          <div class="form-group">
                                            <label for="type_periodpay_id">Periodo de cuota</label>
                                            <select name="type_periodpay_id" required="" class="form-control form-control-sm" id="type_periodpay_id">
                                              <option value="">Seleccione..</option>
                                              @foreach ($types_periodpay as $key => $type_periodpay)
                                                <option value="{{$key}}">{{$type_periodpay}}</option>
                                              @endforeach
                                            </select>                     
                                          </div> 
                                        </div>
                                      </div>

                                      <div class="row credit_options">
                                        <div class="col">
                                          <div class="form-group">
                                          <label for="limit_payment_date">Valor cuota</label>
                                          <input type="text" readonly name="pay_credit_value" id="pay_credit_value" required="" class="form-control form-control-sm" >
                                          </div>
                                        </div>
                                        <div class="col">
                                          <div class="form-group">
                                          <label for="limit_payment_date">Fecha pago primera cuota</label>
                                          <input type="date" min="{{date('Y-m-d')}}" name="limit_payment_date" id="limit_payment_date" required="" class="form-control form-control-sm" >
                                          </div> 
                                        </div>
                                      </div>

                                      <div class="row mp_options">
                                        <div class="col">
                                          <div class="form-group">
                                          <label for="limit_payment_date">Forma de pago</label>
                                               </div>
                                        </div>
                                        <div class="col">
                                          <div class="form-group">
                                             <select name="payment_method_id" required disabled class="form-control form-control-sm payment_method_id" id="payment_method_id">
                                              <option value="">Seleccione..</option>
                                              @foreach ($types_payment_method as $key => $type_payment_method)
                                                <option value="{{$key}}">{{$type_payment_method}}</option>
                                              @endforeach
                                            </select>   
                                       </div> 
                                        </div>
                                      </div>
 
                                 <div class="form-group des_mp" style="display:none">
                                          <label for="value">Descripción de pago</label>
                                          <textarea class="form-control form-control-sm" disabled required name="description_pmethod" id="description_pmethod" rows="4"></textarea>
                                  </div>       
   <div class="form-group des_url_pay" style="display:none">
                                          <label for="value">URL</label>
                                          <input class="form-control form-control-sm"
                                            type="url" name="description_pmethod" id="url_description_pmethod" value="https://biz.payulatam.com/"
                                            placeholder="https://biz.payulatam.com/"
                                            pattern="https://biz.payulatam.com/.*" size="30"
                                            required>
                                  </div>



        <button type="submit" class="btn btn-sm btn-primary btn-block" >
        Confirmar Cobro</button>


  </form>
                  </div>



                  <div class="tab-pane fade" id="support-bill-tab" role="tabpanel" aria-labelledby="support-bill-tab">
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
</div>
</div>
<div class="row" id="content_list_support_file">
<div class="col-md-12">
<ul id="payment_files" class="products-list product-list-in-card pl-2 pr-2">
              
                 
                </ul>

</div>
</div> 
<hr>
<div class="row" style="display:none;margin-bottom:4px;" id="content_form_support_file">
      <div  class="col-12">
                    <div id="actions">
                      <!-- The fileinput-button span is used to style the file input field as button -->
                      <span class="btn btn-primary btn-sm fileinput-button dz-clickable">
                          <i class="fa fa-upload"></i>
                          <span>Subir archivo</span>
                      </span>
                    
                       <button type="reset" class="btn btn-sm btn-default cancel">
                          <i class="fa fa-window-close-o"></i>
                          <span>Ver subidos</span>
                      </button>

                     
                    </div>

    </div>

<div class="col-md-12" id="cont_bill_files_upload">
    
                <div class="table table-striped files" id="previews_bill_files" style="margin-top:3px">

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


                  </div>
                  <div class="tab-pane fade" id="options-bill-tab" role="tabpanel" aria-labelledby="options-bill-tab">

       
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>

              




         
		</div>
	</div>


	@endslot

  	@slot('footer')  
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>       
	@endslot
  
@endcomponent
<!-- /modal -->

