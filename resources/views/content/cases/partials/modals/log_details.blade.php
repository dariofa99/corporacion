@component('components.modal_large')

	@slot('trigger')
		myModal_log_details
	@endslot

	@slot('title')
		<h6><label >Documento</label></h6>
	@endslot


	@slot('body')


 	<div class="row">
	    <div class="col-md-10 offset-md-1" id="content_form_details_log">
            <div class="row">
                <div class="col-md-6">
                    <label>Concepto: </label><p id="concept"></p>
                </div>

                <div class="col-md-6">
                    <label>Categoría: </label><p id="category"></p>
                </div>

            </div> 
            <div class="row">
                <div class="col-md-12">
                    <label>Descripción: </label>
                    <p align="justify" id="description">

                    </p>
                </div>
            </div>
          
          
             <div class="row">               

                <div class="col-md-6">
                    <label>Creado por: </label>
                    <p id="user_created" > 
                    </p>
                </div>

                 <div class="col-md-6">
                    <label>Fecha creación: </label>
                    <p id="created_at">
                    </p>
                </div>

            </div>

            <div class="row">   
                <div class="col-md-6">
                    <label>Fecha radicado: </label>
                    <p id="lbl_filing_date">
                    </p>
                </div>

            </div>

              
            <div class="row">
                <table class="table" id="list_files_log_details">
                <thead>
                    <th>
                    Nombre Archivo
                    </th>
                    <th>
                    Tamaño
                    </th>
                </thead>
                <tbody>
                
                </tbody>                
                </table>               
            </div>
           

         
		</div>
	</div>


	@endslot

  	@slot('footer')  
      <div id="footer_library_show"></div>
	@endslot
  
@endcomponent
<!-- /modal -->

