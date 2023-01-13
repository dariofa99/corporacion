@component('components.modal_medium')

	@slot('trigger')
		myModal_create_log
	@endslot

	@slot('title')
		<h6><label id="lbl_modal_title">Nueva Actuación</label></h6> <span style="margin-left:15px;margin-top: -3px;">{{date('Y-m-d')}}</span>
	@endslot


	@slot('body')

 
 	<div class="row">
		<div class="col-md-12 " id="content_form_cl">
		       
         <form action="/log" method="POST" id="myformCreateLog" enctype="multipart/form-data">
             <input type="hidden" name="id" id="log_id"> 
             <input type="hidden" name="type_log_id" id="type_log_id">
             <input type="hidden" id="has_file">
     {{ csrf_field() }}
  

        <div class="card card-primary card-outline card-outline-tabs">
              <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active btn_datos" id="custom-tabs-data-tab" data-toggle="pill" href="#custom-tabs-data" role="tab" aria-controls="custom-tabs-data" aria-selected="true">
                    Datos</a>
                  </li>
                  <li class="nav-item optionsnav">
                    <a class="nav-link" id="custom-tabs-files-tab" data-toggle="pill" href="#custom-tabs-files" role="tab" aria-controls="custom-tabs-files" aria-selected="false">
                    Archivos</a>
                  </li>

                   <li class="nav-item optionsnav">
                    <a class="nav-link" id="custom-tabs-options-tab" data-toggle="pill" href="#custom-tabs-options" role="tab" aria-controls="custom-tabs-options" aria-selected="false">
                    Opciones</a>
                  </li>
 
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-data" role="tabpanel" aria-labelledby="custom-tabs-data-tab">
                        
                        <div class="form-group log_r">
                                <label for="concept">Fecha radicado</label>
                                <input type="date" required class="form-control form-control-sm" id="filing_date" name="filing_date">                               
                                </div>

                        <div class="form-group log_r">
                                <label for="concept">Categoria</label>
                                       <select name="type_category_id" required class="form-control form-control-sm" id="type_category_id">
                                                <option value="">Seleccione..</option>
                        @foreach ($types_categories_log as $key => $value )
                                <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                        <option value="other">Otro</option>
                        </select>
                        <input type="hidden" placeholder="Nueva categoria" name="category_name" id="category_name" style="margin-top:2px" class="form-control form-control-sm" id="concept" name="concept">                               
                        </div>

                        <div class="form-group log_r">
                        <label for="concept">Concepto</label>
                        <input type="text" required class="form-control form-control-sm" id="concept" name="concept">                               
                        </div>

                            <div class="form-group">
                                <label for="email">Descripción</label>
                                <textarea required class="form-control form-control-sm" name="description" id="description"  rows="3"></textarea> 
                                
                               </div>

                         {{-- 
                              <div class="form-group log_r">
                            <div class="custom-file">
                                    <input type="file" name="log_file" class="custom-file-input" id="logFile" >
                                    <label class="custom-file-label" for="customFile">Subir Archivo</label>
                            </div>
                            </div> --}}                     
                  </div>



  
                  <div class="tab-pane fade" id="custom-tabs-files" role="tabpanel" aria-labelledby="custom-files-tab">



                   

        <div class="row" style="display:block;margin-bottom:4px;" id="content_form_support_file_log">
                                <div  class="col-12">
                                                <div id="actions_upload_logs">
                                                <!-- The fileinput-button span is used to style the file input field as button -->
                                                <span class="btn btn-primary btn-sm" id="fileinput-button_logs">
                                                        <i class="fa fa-upload"></i>
                                                        <span>Subir archivo</span>
                                                </span>
                                                
                                                <button type="reset" class="btn btn-sm btn-default cancel">
                                                        <i class="fa fa-window-close-o"></i>
                                                        <span>Quitar todos</span>
                                                </button>
                                                 <button type="reset" style="display:none" class="btn btn-sm btn-default start">
                                                        <i class="fa fa-window-close-o"></i>
                                                        <span> start</span>
                                                </button>
                                                </div>

                                </div>

        <div class="col-md-12" id="cont_files">    
                <div class="table table-striped files" id="previews_logs">

                  <div id="template_3" class="file-row" style="display:block" >
                  
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

   <div class="row" id="content_list_support_file_log">
                        <div class="col-md-12">
                                <ul id="log_files" class="products-list product-list-in-card pl-2 pr-2">
                                </ul>
                        </div>
                        </div>

                  </div>




                  <div class="tab-pane fade" id="custom-tabs-options" role="tabpanel" aria-labelledby="custom-tabs-options-tab">
                        <div class="form-group log_r">
                                <label for="email">¿Compartir con solicitante?</label>
                                <input type="checkbox" name="shared" id="shared_log" data-size="xs" data-style="order-check" data-width="60" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">
                        </div>
                        <div class="form-group log_r">
                                <label for="support_docs">¿Es documento de apoyo?</label>
                                <input type="checkbox" id="support_docs" name="support_docs" data-size="xs" data-style="order-check" data-width="60" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">
                        </div>
                        <div class="form-group log_r">
                                <label for="support_docs">¿Activar recordatorio?</label>
                                <input type="checkbox" id="recordatory" name="recordatory" data-size="xs" data-style="order-check" data-width="60" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">
                        </div>   
                        <div class="form-group log_r recordatoryclass" style="margin-left: 20px;">
                                <label for="date">Fecha recordatorio</label>
                                <input type="datetime-local" disabled name="notification_date" id ="notification_date" required class="form-control form-control-sm" value="">
                        </div>
                        <div class="form-group log_r recordatoryclass" style="margin-left: 20px;">
                                <label for="support_docs">¿Mostrar en agenda?</label>
                                <input type="checkbox" id="share_on_diary" name="share_on_diary" data-size="xs" data-style="order-check" data-width="60" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">
                        </div>       
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>

                <button type="submit" class="btn btn-primary btn-block add_log_button" >Agregar</button>

       </form>
         
		</div>
	</div>

 
	@endslot

  	@slot('footer')  
       <button type="button" class="btn btn-secondary btn_close_modal" data-modal="myModal_create_log" data-dismiss="modal">Cerrar</button>       
	@endslot
  
@endcomponent
<!-- /modal -->

