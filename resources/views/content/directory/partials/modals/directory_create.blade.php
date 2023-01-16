@component('components.modal_medium')

	@slot('trigger')
		{{$modalId}}
	@endslot

	@slot('title')
		<h6><label id="lbl_modal_title_diary">{{$labelTitle}}</label></h6>
	@endslot


	@slot('body')         
  
  <form method="POST" id="{{$formId}}">
    {{ csrf_field() }}       
    <input type="hidden" name="id" >
              
    <div class="row">
      <div class="col-md-10 offset-md-1 content_form_directory">    
        <div class="row">
          <div class= "col-md-12 mb-2">
            <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text" id="btnGroupAddon"><i class="fa fa-address-card"></i></div>
                </div>
                <input type="text" required name="name" class="form-control form-control-sm" placeholder="Nombre" aria-label="Input group example" aria-describedby="btnGroupAddon">
              </div>                 
        </div>
        </div>
        <div class="row">
          <div class= "col-md-12  mb-2">
            <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text" id="btnGroupAddon"> <i class="fa fas fa-home"></i>        </div>
                </div>
                <input type="text" name="address" class="form-control form-control-sm" placeholder="Dirección" aria-label="Input group example" aria-describedby="btnGroupAddon">
              </div>                       
          </div>
        </div>
        <div class="row">
          <div class= "col-md-12  mb-2">
            <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text" id="btnGroupAddon2"> <i class="fas fa-city"></i>        </div>
                </div>
                <input type="text" name="town" class="form-control form-control-sm" placeholder="Municipio" aria-label="Input group example" aria-describedby="btnGroupAddon">
              </div>                       
          </div>
        </div>
        <div class="row">
          <div class= "col-md-12  mb-2">
            <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text" id="btnGroupAddon"><i class="fas fa-phone"></i></div>
                </div>
                <input type="number" name="number_phone" class="form-control form-control-sm" placeholder="Teléfono" aria-label="Input group example" aria-describedby="btnGroupAddon">
              </div>                     
          </div>
        </div>

        <div class="row">
          <div class= "col-md-12  mb-2">
            <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text" id="btnGroupAddon"> <i class="fas fa-envelope"></i>        </div>
                </div>
                <input type="email"  name="email" class="form-control form-control-sm" placeholder="Correo electrónico" aria-label="Input group example" aria-describedby="btnGroupAddon">
              </div>                     
        </div>
        </div>
        <div class="content_old_addata_input pl-2" style="width: 100%"></div>

        <div class="content_new_input pl-2" style="width: 100%"></div>
       

          <div class="row">
            <div class="col-md-4 mb-1">
            <button type="button" data-form="{{$formId}}" class="btn btn-success btn-sm btn-block btn_new_field_directory">Agregar campo</button>
            </div>   
         
          <div class="col-md-4 mb-1">
            <button type="submit"  class="btn {{$buttonClass}}  btn-sm  btn-block">{{$labelButton}}</button> 
         </div>          
        </div>

      </div>

    </div>
  </form> 


	@endslot

  	
  @slot('footer')  
     
  @endslot
 
@endcomponent
<!-- /modal -->

