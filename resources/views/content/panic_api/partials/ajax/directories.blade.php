@foreach($directories as $key => $directory)
    

<div class="col-12 col-sm-12 col-xs-12 col-md-4">
    <div class="card bg-light size-text">
      <div class="card-header text-muted border-bottom-0">
        
      </div>
      <div class="card-body pt-0">
        <div class="row">
          <div class="col-12">
            <h2 class="lead"><b>{{$directory->dir_name}}</b></h2>            
            <ul class="ml-4 mb-0 fa-ul text-muted">
                <li class="small"><span class="fa-li">
                    <i class="fas fa-envelope"></i></span> 
                    Correo: {{$directory->email}}
                </li>
                <li class="small"><span class="fa-li">
                    <i class="fas fa-lg fa-phone" style="font-size: 15px;"></i></span> 
                    Teléfono: {{$directory->number_phone}}
                </li>
                <li class="small">
                    <span class="fa-li"><i class="fas fa-home"></i></span> 
                    Dirección: {{$directory->address}}
                </li>
                <li class="small">
                    <span class="fa-li"><i class="fas fa-phone-volume"></i></span> 
                    Usuario de confianza: {{$directory->is_trusted ? 'SI':'NO'}}
                </li>
                @if(count($directory->aditional_data)>0)      
                <li class="small">                   
                <ul style="list-style: none;padding:0px;display:none" id="ul_list_adtional_data-{{$directory->id}}">
                        @foreach($directory->aditional_data as $key_2 => $aditional_data)                                          
                        <li>
                        <span class="fa-li"><i class="fa fa-th-large"></i></span> 
                            {{$aditional_data->type_aditional_data[0]->name}}:
                            {{$aditional_data->value}}
                        </li>    
                        @endforeach
                    </ul>
                    <span style="cursor:pointer" class="btn_change_display_aditional_data" data-id="{{$directory->id}}" data-status="false">
                         Ver más... </span>  
                </li>
                @endif
              {{--<li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span>  Empresa: </li>--}}
            </ul>
          </div>
         {{--  <div class="col-5 text-center">
            <img src="{{$user->image}}" alt="" class="img-circle img-fluid img-user">
          </div> --}}
        </div>
      </div>
      <div class="card-footer">          
        <small>Pertenece a: <strong><a href="/admin/users/{{$directory->user_id}}/edit">{{$directory->user_name}}</a></strong> </small>
      </div>
    </div>
  </div>

  @endforeach