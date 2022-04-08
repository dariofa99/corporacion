@component('components.modal_medium')

	@slot('trigger')
		myModal_create_log
	@endslot

	@slot('title')
		<h6><label id="lbl_modal_title">Creando documento</label></h6>
	@endslot


	@slot('body')


 	<div class="row">
		<div class="col-md-10 offset-md-1" id="content_form_cl">
		       
         <form action="/log" method="POST" id="myformCreateLog" enctype="multipart/form-data">
             <input type="hidden" name="id" id="log_id"> 
             <input type="hidden" name="type_log_id" id="type_log_id">
     {{ csrf_field() }}
       
        
                            {{-- <div class="form-group">
                                    <label for="date">Fecha</label>
                                    <input type="date" disabled name="fecha_c" id ="fecha_c" required class="form-control" value="{{date('Y-m-d')}}">
                            </div>

                            <div class="form-group">
                            <label for="concept">Concepto</label>
                                <input type="text" required class="form-control form-control" id="concept" name="concept">                               
                            </div> --}}

                            <div class="form-group">
                                <label for="email">Descripción</label>
                                <textarea class="form-control form-control" name="description" id="description"  rows="3"></textarea> 
                            </div>

                         
                            <div class="form-group">
                            <div class="custom-file">
                                    <input type="file" name="log_file" class="custom-file-input" id="logFile" >
                                    <label class="custom-file-label" for="customFile">Subir Archivo</label>
                            </div>
                            </div>
                            
                                                  
                           

                             <button type="submit" class="btn btn-primary btn-block">Agregar</button>

                            
                </form>
         
		</div>
	</div>


	@endslot

  	@slot('footer')  
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>       
	@endslot
  
@endcomponent
<!-- /modal -->

