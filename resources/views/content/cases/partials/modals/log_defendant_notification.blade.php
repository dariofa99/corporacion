@component('components.modal_medium')

	@slot('trigger')
		myModal_log_defendant_notification
	@endslot

	@slot('title')
		<h6><label id="lbl_modal_title_diary">Nueva notificación</label></h6>
	@endslot


	@slot('body')


 	<div class="row">
		<div class="col-md-10 offset-md-1" id="content_form_dnotification">
		       
         <form method="POST" id="myformCreateDNotification" enctype="multipart/form-data">
            
     {{ csrf_field() }}
       
            <input type="hidden" name="id" id="log_df_id"> 
            <input type="hidden" name="type_log_id" value="105" id="type_log_df_id">
            <input type="hidden" id="has_file">
            <input type="hidden" name="type_category_id" value="8" id="type_category_df_id">
     

         <div class="form-group log_r">
            <label for="concept">Asunto</label>
            <input type="text" required class="form-control form-control-sm" id="concept_df" name="concept">                               
        </div>
        <div class="form-group">
                                <label for="email">Cuerpo del correo</label>
          <textarea required class="form-control form-control-sm" name="description" id="description_df"  rows="3"></textarea> 
        </div>
        <div class="form-group log_r">
                            <div class="custom-file">
                                    <input type="file" required accept=".pdf" name="log_file" class="custom-file-input" id="logFile_df" >
                                    <label class="custom-file-label" for="customFile">Subir Archivo</label>
                            </div>
                            <small style="color:red" id="lbl_validate_file"></small>
        </div>
        <div class="form-group" style="margin-bottom:1px">
              <label>Destinatarios</label>
              
                    <select required class="select2" name="destinatarios[]" id="destinatarios_df" multiple="multiple" data-placeholder="Seleccione destinatarios..." style="width: 100%;">
                        {{-- @foreach ($case->users()->where('type_user_id',21)->get() as $user )     
                            <option value="{{$user->id}}" >{{$user->name}}</option>
                        @endforeach --}}
               </select>
        </div>
        <div class="form-check">
        <label class="form-check-label">
            <input type="checkbox" id="users_all_send_not" class="form-check-input" name="users_all_send" value="1">Enviar a todos
        </label>
        </div>
<hr>
        <button type="submit"  class="btn btn-primary btn-sm btn-block">Enviar</button>
        
                </form>
         
		</div>
	</div>


	@endslot

  	@slot('footer')  
       <div id="footer_modal-diary"> </div>
	@endslot
  
@endcomponent
<!-- /modal -->

