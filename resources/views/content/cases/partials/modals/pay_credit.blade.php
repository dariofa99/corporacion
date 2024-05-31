@component('components.modal_medium')

	@slot('trigger')
		myModal_pay_credit
	@endslot

	@slot('title')
		<h6><label id="lbl_modal_title">Nuevo cobro</label></h6>
     <span style="margin-left:15px;margin-top: -3px;"></span>
	@endslot


	@slot('body')


 	<div class="row">
		<div class="col-md-12 " id="content_form_cl">
		       
        
  

        <form action="" method="POST" id="myformPayCredits">
 
          <input type="hidden" readonly name="id" id="payment_credit_id">            
                                      
                           

                                      <div class="row credit_options">
                                        <div class="col">
                                          <div class="form-group">
                                          <label for="limit_payment_date">Valor cuota</label>
                                          <input type="text" readonly name="value" id="payment_credit_value" required class="form-control form-control-sm" disabled>
                                          </div>
                                        </div>
                                        <div class="col">
                                          <div class="form-group">
                                          <label for="limit_payment_date">Fecha pago</label>
                                          <input type="date" name="payment_date" readonly id="limit_payment_date" required value="{{date('Y-m-d')}}" class="form-control form-control-sm" >
                                          </div> 
                                        </div>
                                      </div>

                                      <div class="row mp_options_pay">
                                        <div class="col">
                                          <div class="form-group">
                                          <label for="payment_method_id">Forma de pago</label>
                                               </div>
                                        </div>
                                        <div class="col">
                                          <div class="form-group">
                                             <select name="payment_method_id" required class="form-control form-control-sm payment_method_id" id="payment_method_id_p">
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
                                          <textarea class="form-control form-control-sm" 
                                          disabled required name="description_pmethod" id="description_pmethod" rows="4"></textarea>
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
        Cambiar forma de pago</button>


  </form>


         
		</div>
	</div>


	@endslot

  	@slot('footer')  
       	@endslot
  
@endcomponent
<!-- /modal -->

