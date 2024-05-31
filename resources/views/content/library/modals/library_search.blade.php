@component('components.modal_medium')

	@slot('trigger')
		myModal_library_search
	@endslot

	@slot('title')
		<h6><label >Opciones de busqueda</label></h6>
	@endslot


	@slot('body')
            <div class="alert alert-info alert-dismissible" id="alert_diary" >
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h7><i class="icon fas fa-info"></i> Diligencie cualquiera de los campos a buscar.</h7>
            </div>
    <form  action="biblioteca" method="GET" enctype="multipart/form-data">
 	<div class="row">
	    <div class="col-md-10 offset-md-1" >

            
                <div class="form-group">
                    <label for="description">Nombre de archivo</label>
                    <input type="text"  id="namearchive" class="form-control input_data" name="name"  >            
                </div>
                <div class="form-group">
                    <label>Rama del derecho</label>
                    <select class="form-control"  id="branch_lawsearch" name="branch_law">
                        <option value="">Seleccione...</option>
                        @foreach($branch_law as $law)
                            <option value="{{ $law->id }}">{{ $law->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Categoría</label>
                    <select class="form-control"  id="categoryLibrarysearch" name="category">
                        <option value="">Seleccione...</option>
                        @foreach($category as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>        



                





         
		</div>
	</div>


	@endslot

  	@slot('footer')  
        <button type="submit" class="btn btn-primary float-right" ><i class="fas fa-search"></i> Buscar</button>
    
	@endslot
</form>
@endcomponent
<!-- /modal -->

