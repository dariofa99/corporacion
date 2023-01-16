@forelse($case->getSupportLogs() as $category => $logs) 
    <div class="card">
      <div class="card-header">
        <a class="card-link" data-toggle="collapse" href="#collapse{{sanear_string($category)}}">
          {{$category}}
        </a>
      </div>     
      <div id="collapse{{sanear_string($category)}}" class="collapse" data-parent="#accordion_support_logs">
        <div class="card-body">     
          <div class="row">
            @foreach ($logs as $log )   
            @if(count($log->files()->where('type_status_id','!=','15')->get())>0)     
                        <div class="col-lg-3 col-6" id="{{$log->id}}">
                                <!-- small card -->
                                <div  class="small-box {{ getBgColorDocument($log->files[0]->original_name) }}">
                                  <div class="inner bg-white archive" data-id="{{ $log->files[0]->id }}" >
                                    <h6 title="Nombre del archivo">{{ $log->concept }}</h6>
                                    <h6 title="Nombre del archivo">{{ $log->files[0]->original_name }}</h6>
                                    <div class="row tmno">
                                      <div class="col-7">
                                        <p>Tamaño: {{ number_format(($log->files[0]->size / 1048576),2) }} MB</p>      
                                      </div>
                                    </div>
                                    <p>Subido: {{getDateForNotification($log->files[0]->created_at)}} </p>
                                  </div> 
                                  <div class="icon archive" data-id="{{ $log->files[0]->id }}">
                                    <i class="{{ getBgIconDocument($log->files[0]->original_name) }}"></i>
                                  </div>
                                    <a target="_blank" href="/oficina/descargar/documento/{{ $log->files[0]->id }}" class="small-box-footer">Descargar  <i class="fas fa-cloud-download-alt"></i>
                                    </a>
                                </div>
                        </div>
                  @else
                  Sin archivo       
                @endif        
            @endforeach
          </div> 
        </div>
      </div>
    </div> 
@empty

@endforelse