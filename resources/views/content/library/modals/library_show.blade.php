@component('components.modal_medium')

	@slot('trigger')
		myModal_library_show
	@endslot

	@slot('title')
		<h6><label >Documento</label></h6>
	@endslot


	@slot('body')


 	<div class="row">
	    <div class="col-md-10 offset-md-1" id="content_form_cl">
            <div class="row">
                <div class="col-md-12">
                    <label>Nombre del archivo: </label><p id="library_name_show"></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Descripción: </label>
                    <p id="modal_description_show">

                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Rama del derecho: </label><p id="library_law_show"></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Categoría: </label><p id="library_cat_show"></p>
                </div>
            </div>

              
            <div class="row">
                <div class="col-md-6">
                    <label>Tamaño: </label>
                    <p id="library_size_show">1024 MB 
                    </p>
                </div>
                <div class="col-md-6">
                    <label>Fecha creación: </label>
                    <p id="library_date_show">
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Creado por: </label>
                    <span id="library_owner_show" > 
                    </span>
                </div>
            </div>

         
		</div>
	</div>


	@endslot

  	@slot('footer')  
      <div id="footer_library_show"></div>
	@endslot
  
@endcomponent
<!-- /modal -->

