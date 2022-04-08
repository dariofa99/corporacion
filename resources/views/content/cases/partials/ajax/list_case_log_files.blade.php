 @foreach ($caseL->files()->where('type_status_id','!=','15')->get() as $file )
        <li class="item" id="item-{{$file->pivot->id}}">
                    
                    <div class="product-inf">
                      <a target="_blank" href="/oficina/descargar/documento/{{$file->pivot->file_id}}" class="product-title">{{$file->original_name}}
                        
                        <span class="badge badge-warning float-right btn_delete_file" data-pivot="{{$file->pivot->id}}">
                        X</span></a>
                     
                       <span class="product-description">
                        Tamaño: {{$file->size}} 
                      </span> 
                    </div>
                  </li>
 @endforeach 