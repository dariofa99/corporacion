
    {{--  <div class="card-header">
         
     </div> --}}
  
     <div class="card-body">  
         <div class="row">
         <div class="col-md-7">
             <small>Fecha de creación: {{getDateHourForNotification($panic_alert->created_at)}}.</small>    
         </div>  
         <div class="col-md-5">
             <small class="float-right">Estado: {{$panic_alert->type_status}} 
                {{-- $panic_alert->status_description !='' ? '- Descripción: '.$panic_alert->status_description :'' --}}</small>    
         </div>  
         </div>                      
         <div class="row" >
             <div class="col-md-7 col-xs-12" >
                 <label>{{$panic_alert->name}} <small><a target="_blank" href="/admin/users/{{$panic_alert->user_id}}/edit">Ver perfil</a></small></label>
             </div>
             <div class="col-md-5 col-xs-12">
               
                 <button data-id="{{$panic_alert->id}}" class="btn btn-xs btn-success float-right ml-1 mb-2 btn_change_status">Cambiar estado</button>
                @if(count($panic_alert->cases)<=0)
                    <a href="/casos/create?wus={{$panic_alert->identification_number}}&puid={{$panic_alert->id}}" class="btn btn-xs btn-primary float-right mb-2" >Asignar caso</a>
                @else
                    <a href="/casos/{{$panic_alert->cases()->first()->pivot->case_id}}/edit" class="btn btn-xs btn-primary float-right mb-2" >Asignado - Ir</a>             
                @endif

                <a target="_blank" href="/panic/directories?user_id={{$panic_alert->user_id}}" class="btn btn-xs btn-warning float-right mr-1 mb-2 btn_view_directory">Ver personas de confianza</a>
              

                </div>
         </div>
         <div class="row">
             <div class="col-12" style="border-top: 1px solid gray">
             <small>{{$panic_alert->city}} - {{$panic_alert->address}} -
                 <a href="{{$panic_alert->location}}" target="_blank">
                     {{$panic_alert->location}}</a>
             </small>
             </div>
         </div>
     </div>

