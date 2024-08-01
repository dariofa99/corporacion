@component('components.modal_medium')

	@slot('trigger')
		myModal_create_library
	@endslot

	@slot('title')
		<h6><label id="lbl_modal_title_diary">Nuevo documento</label></h6>
	@endslot


	@slot('body')


 	<div class="row">
		<div class="col-md-10 offset-md-1" id="content_form_cl">
		       
         <form method="POST" id="myformCreateLibrary" enctype="multipart/form-data">
            
     {{ csrf_field() }}
       
        <input id="library_id" name="id" type="hidden" value="0">


            <div class="form-group">
                <label>Archivo</label>
                <div class="custom-file">
                      <input type="file" required class="custom-file-input" id="customFileLibrary" name="name_file">
                      <label class="custom-file-label" for="customFileLibrary" id="name_file_library">Seleccione archivo...</label>
                    </div>                            
             </div>



            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea class="form-control form-control" required name="description" id="descriptionLibrary"  rows="2"></textarea>            
            </div>

            

                <div class="form-group">
                    <label>Tipo de Caso</label>
                    <select class="form-control" required id="branch_lawLibrary" name="branch_law">
                        <option value="">Seleccione...</option>
                        @foreach($branch_law as $law)
                            <option value="{{ $law->id }}">{{ $law->name }}</option>
                        @endforeach

                    </select>
                </div>

                <div class="form-group">
                    <label>Categoría</label>
                    <select class="form-control" required id="categoryLibrary" name="category">
                        <option value="">Seleccione...</option>
                        @foreach($category as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group">
                <label for="date">Mantener hasta:</label>
                <input type="date" name="fecha_max" id ="fecha_max_library" class="form-control" title="Elegir fecha en solo en caso que se requira.">
                
                </div>
                
    





       
                                                  
                           

                             <button type="submit" id="btn-file-library" class="btn btn-primary btn-block">Crear</button>

                            
                </form>
         
		</div>
	</div>


	@endslot

  	@slot('footer')  
       <div id="footer_modal-library"> </div>
	@endslot
  
@endcomponent
<!-- /modal -->

