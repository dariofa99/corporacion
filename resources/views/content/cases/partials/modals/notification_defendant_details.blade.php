@component('components.modal_medium')

	@slot('trigger')
		myModal_notification_defendant_details
	@endslot

	@slot('title')
		<h6><label >Documento</label></h6>
	@endslot


	@slot('body')


 	<div class="row">
	    <div class="col-md-10 offset-md-1" id="content_notification_defendant_details">
            <div class="row">
                <div class="col-md-12 col_details_n">
                    <label>Asunto: </label><p id="concept">Esto es una prueba de texto</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col_details_n">
                    <label>Cuerpo del correo: </label>
                    <p id="description" align="justify">

                    </p>
                </div>
            </div>
          
           

             <div class="row">
                <div class="col-md-12 col_details_n">
                    <label>Nombre del archivo: </label><br>
                    <a target="_blank" id="log_file_name"></a>
                </div>
            </div>

              
            <div class="row">
                <div class="col-md-6 col_details_n">
                    <label>Tamaño: </label>
                    <p id="log_size">1024 MB 
                    </p>
                </div>
                <div class="col-md-6 col_details_n">
                    <label>Fecha creación: </label>
                    <p id="created_at">
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col_details_n">
                    <label>Estado: </label>
                    <p id="notification_status" > 
                    </p>
                </div>
            </div>

              <div class="row table-responsive p-0" id="cont_access_data">
                <div class="col-md-12">
                   <table style="width:100%">
                   <thead>
                   <th align="center" colspan="2">Datos generales de la conexión del sitio de revisión</th>
                   </thead>
                   <tbody>
                   <tr class="col_details_n">
                   <td>Navegador: <br>
                   <span id="lbl_accadd_browser"> </span>
                   </td>

                    <td>Dirección IP: <br>
                   <span id="lbl_ipaddress"> </span>
                   </td>

                   </tr>

                   <tr class="col_details_n">
                   <td>Sistema Operativo: <br>
                   <span id="lbl_os"> </span>
                   </td>

                    <td>Fecha: <br>
                   <span id="lbl_time"> </span>
                   </td>

                   </tr>

                <tr class="col_details_n">
                   <td>Ciudad: <br>
                   <span id="lbl_city"> </span>
                   </td>

                    <td>Pais: <br>
                   <span id="lbl_country"> </span>
                   </td>

                   </tr>

                   </tbody>
                   </table>
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

