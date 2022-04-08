@component('components.modal_medium')

	@slot('trigger')
		myModal_create_diary
	@endslot

	@slot('title')
		<h6><label id="lbl_modal_title_diary">Nuevo evento</label></h6>
	@endslot


	@slot('body')


 	<div class="row">
		<div class="col-md-10 offset-md-1" id="content_form_cl">
		       
         <form method="POST" id="myformCreateDiary" enctype="multipart/form-data">
            
     {{ csrf_field() }}
       
        <input id="diary_id" name="diary_id" type="hidden" value="0">
         <div class="form-group">
                <label for="date">Fecha</label>
                <input type="date" name="fecha" id ="fecha_evento_diary" required class="form-control" >
                
        </div>


            <div class="row">
                <div class= "col-md-6">
                    <div class="form-group">
                        <label>Inicio:</label>

                        <div class="input-group date" id="timepicker1" data-target-input="nearest">
                        <input type="text"  required name="inicio" class="form-control datetimepicker-input" data-target="#timepicker1" id="input-date-picker1">
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

                        <div class="input-group date" id="timepicker2" data-target-input="nearest">
                            <input type="text"  required name="fin" class="form-control datetimepicker-input" data-target="#timepicker2" id="input-date-picker2">
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
                    <input type="text" name="title" required class="form-control form-control" id="title_diary" >                               
                 </div>

                            <div class="form-group">
                                <label for="description">Descripción</label>
                                <textarea class="form-control form-control" required name="description" id="description_diary"  rows="2"></textarea> 
                                
                               </div>
                               <div class="form-group">

                                <label for="concept">Url</label>
                                    <input type="url" name="url" required class="form-control form-control" id="title_url">                               
                                 </div>            
                <div class="form-group ">   
                    <label for="cp2">Color</label>      
                            <div id="cp2" class="input-group" title="Using input value">
                                <input type="text" required name = "color" id="input-color-diary" class="form-control input-lg" style="display:none;" value="#11a643"/>
                                <span class="input-group-append">
                                    <span class="input-group-text colorpicker-input-addon" ><i id="color-diary" style="width: 200px;"></i></span>
                                </span>
                            </div>
                </div>     


                  
                <div class="form-group">
                    <label>Añadir invitados</label>
                    <select class="select2" name = "invitados[]" id="select2_users_diary" multiple="multiple" data-placeholder="Seleccione invitados..." style="width: 100%;">
                        @foreach ($users as $user )     
                            <option value="{{$user->id}}" >{{$user->name}}</option>
                        @endforeach
       
                  </select>
                </div>


       
                                                  
                           

                             <button type="submit" id="btn-event-diary" class="btn btn-primary btn-block">Crear</button>

                            
                </form>
         
		</div>
	</div>


	@endslot

  	@slot('footer')  
       <div id="footer_modal-diary"> </div>
	@endslot
  
@endcomponent
<!-- /modal -->

