@foreach (session('session_case')->logs()
->where('type_status_id','<>',15)->where('type_log_id',22)->get() as $log) 
         @if($log->files()->where('type_status_id','!=','15')->first())
          <div class="col-lg-3 col-6 num_doc">
            <!-- small card -->
            <div class="small-box  {{ getBgColorDocument($log->files()->first()->original_name) }}">
              <div class="inner bg-white">
                <h6 title="Nombre del archivo">@if(count($log->files)>0)
                {{$log->files()->first()->original_name}}@endif
                </h6>
                <p>Tamaño: @if(count($log->files)>0)
                 {{ number_format(($log->files()->first()->size / 1048576),2) }} MB
                 @endif
                </p>
                <p>Subido: {{getDateForNotification($log->created_at)}}
                <br>               
                </p>
              </div>
              <div class="icon">
                <i class="{{ getBgIconDocument($log->files()->first()->original_name) }}"></i>
              </div>
              <div class="row footer-small-box">
                <div class="col-md-8" align="center">                
                <a target="_blank" href="/oficina/descargar/documento/{{$log->files()->first()->id}}" class="small-box-footer" >
                Descargar  <i class="fas fa-cloud-download-alt"></i>
                </a>
                </div>
               <div class="col-md-4">                
                <a href="#" data-id="{{$log->id}}" class="btn_edit_log small-box-footer float-right" title="Editar...">
                <i class="fas fa-edit"></i>
                </a>
                <a href="#" data-id="{{$log->id}}" class="btn_delete_log small-box-footer float-right" title="Eliminar...">
                <i class="fas fa-trash"></i>
                </a>
              </div>
              </div>
            
            </div>
          </div>       
          <!-- ./col -->
          @endif
@endforeach
@if(Session::has('mail_error'))
            
            <script>
                toastr.error('{{ Session::get("mail_error") }}','Error',
                    {"positionClass": "toast-top-right","timeOut":"10000"});
            </script> 
@endif