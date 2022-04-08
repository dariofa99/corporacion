
    {{--  <div class="card-header">
         
     </div> --}}
     <div class="card-body">  
         <div class="row">
         <div class="col-md-7">
             <small>Fecha de creación: {{getDateHourForNotification($panic_alert->created_at)}}.</small>    
         </div>  
         <div class="col-md-5">
             <small class="float-right">Estado: {{$panic_alert->type_status->name}} 
                {{-- $panic_alert->status_description !='' ? '- Descripción: '.$panic_alert->status_description :'' --}}</small>    
         </div>  
         </div>                      
         <div class="row" >
             <div class="col-md-7 col-xs-12" >
                 <label>{{$panic_alert->user->name}}</label>
             </div>
             <div class="col-md-5 col-xs-12">
               
               
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

