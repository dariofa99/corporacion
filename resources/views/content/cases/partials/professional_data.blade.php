<div id="content_assignment_data">

 
<div class="row">
    <div class="col-md-10">
      <h4>Profesionales asignados</h4>     
    </div>
    <div class="col-md-2">
     @if(count($case->users()->where(['user_id'=>auth()->user()->id,'type_user_id'=>8])->get())>0 AND  auth()->user()->can('asig_invitado_casos')) 
       <button class="btn btn-primary btn-block btn-sm btnAddUserCase" data-type_user_id="36" data-view="create"
              id="btnAddProfessional"><i class="fa fa-user"> </i> Agregar invitado 
        </button>
    @elseif(auth()->user()->can('asig_profesional_casos'))
       <button class="btn btn-primary btn-block btn-sm btnAddUserCase" data-type_user_id="8" data-view="create"
              id="btnAddProfessional"><i class="fa fa-user"> </i> Agregar profesional 
        </button>
    @endif
    </div>
</div>    

    <div class="row">
    <div class="col-md-12 table-responsive p-0">
    
        
        <table class="table table-hover content_ajax_list_users table-striped" id="table_list_professional">
              <thead>
                  <th>
                  No. Identificación
                  </th>
                  <th>
                  Nombre
                  </th>
                  <th>Email</th>
                  <th>Teléfono</th>
                  <th>Dirección</th>
                  <th>Acciones</th>
                  </thead>
                  <tbody>
                      @include('content.cases.partials.ajax.professional_data')       
                  </tbody>
                  
              </table>
    </div>
    </div>

    </div>