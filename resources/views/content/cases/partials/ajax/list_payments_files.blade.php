 @foreach ($payment->files()->where('type_status_id','!=','15')->get() as $file )
        <li class="item" id="item-{{$file->pivot->id}}">
                    
                    <div class="product-inf">
                      <a target="_blank" href="/payments/download/support/{{$file->pivot->file_id}}" class="product-title">
                      {{$file->original_name}}
                        @permission('eliminar_spago')
                        <span class="badge badge-warning float-right btn_delete_file" data-pivot="{{$file->pivot->id}}">
                        X</span></a>
                        @endpermission
                       <span class="product-description">
                        Tamaño: {{$file->size}} - Categoria: {{$file->category[0]->name}}
                      </span> 
                    </div>
                  </li>
 @endforeach 