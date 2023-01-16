@component('components.modal_medium')

	@slot('trigger')
		myModal_show_diary
	@endslot

	@slot('title')
		<h6><label id="lbl_modal_title_diary_show">Nuevo evento</label></h6>
	@endslot


	@slot('body')


 	<div class="row">
		<div class="col-md-10 offset-md-1">
		            
        
         <div class="form-group">
                <label for="date">Fecha</label>
                <input type="date" id ="fecha_evento_diary_show" disabled class="form-control" >
                
        </div>


            <div class="row">
                <div class= "col-md-6">
                    <div class="form-group">
                        <label>Inicio:</label>

                        <div class="input-group date" id="timepicker1_show" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" disabled data-target="#timepicker1" id="input-date-picker1_show">
                        <div class="input-group-append" data-target="#timepicker1" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                        </div>
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                </div>
                <div class= "col-md-6">
                    <div class="form-group">
                        <label>Fin:</label>

                        <div class="input-group date" id="timepicker2_show" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" disabled data-target="#timepicker2" id="input-date-picker2_show">
                            <div class="input-group-append" data-target="#timepicker2" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                            </div>
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                </div>
            </div>



            <div class="form-group">
                <label for="concept">Título</label>
                <input type="text" disabled class="form-control form-control" id="title_diary_show">                               
            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea class="form-control form-control" disabled id="description_diary_show"  rows="3"></textarea> 
            </div>            
                           
                
            <div class="form-group">
                <label for="description">Url</label>
                <a href="#" target="_blank" id="arf_title_url"> </a>
            </div>            
         
		</div>
	</div>


	@endslot

  	@slot('footer')  
       <div id="footer_modal-diary-show"> </div>
	@endslot
  
@endcomponent
<!-- /modal -->

