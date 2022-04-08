
  <div class="row content_log_data">
    <div class="col-md-2">
      <button class="btn btn-primary btn-sm btn-block btnAddLogCase" data-type_log_id="18"  id="btnAddLogCase">
      <i class="fa fa-newspaper"> </i> Agregar Actuación</button>
      <div class="progress" style="margin-top:2px;display:none" id="progress_bar"> 
        <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">25%</div>
      </div>
    </div>
    <div class="col-md-2">
      <button class="btn btn-warning btn-sm btn-block btnAddLogCase" data-type_log_id="23"  id="btnAddLogNotiCase">
        <i class="fa fa-info-circle"> </i> Enviar Notificación</button>
    </div>
    <div class="col-md-8">
    <form class="form-inline " id="myFormSearchLog"  action="/casos/search/logs">
                    <div class="col-md-5 offset-md-2">
                      <div class="form-group justify-content-end">
                        <select class="form-control form-control-sm" name="type">
                          <option value="view_all">Ver todo...</option>
                          <option value="created_at">Fecha de creación</option>
                          <option value="category">Categoría</option>
                          <option value="shared">Compartidos solicitante</option>
                          <option value="clientnotif">Notificaciónes solicitante</option> 
                          <option value="support">Documentos de apoyo</option>
                          <option value="notification">Con recordatorio</option>
                          <option value="event">Con recordatorio en agenda</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-5 ">
                      <div class="input-group ">
                        <input type="text" disabled id="types_text" class="form-control form-control-sm input_data" name="data" placeholder="Buscar..." aria-label="Buscar..." aria-describedby="basic-addon2">
                         <select style="display:none" class="form-control form-control-sm input_data" id="types_category" name="data">
                          <option value="view_all">Seleccione...</option>
                         @foreach ($types_categories_log as $key => $type_categories_log )
                              <option value="{{$key}}">{{$type_categories_log}}</option>
                         @endforeach
                        </select>
                        
                        
          
                        <div class="input-group-append">
                          <button type="submmit" class="input-group-text" id="basic-addon2"> <i class="fas fa-search"></i></button>                         
                        </div>
                      </div>                   
                    </div>
                  </form>
                  
    </div>
  </div>

  <div class="row content_log_data" id="content_log_data">
    <div class="col-md-12 table-responsive p-0">
        <table class="table content_list_logs table-striped" id="table_list_logs">
          <thead>
          <th>
          Fecha radicado
          </th>
          <th>
          Concepto
          </th>
         {{--  <th>
          Descripción
          </th> --}}
          <th>
          Archivo
          </th>
          <th>
          Compartido
          </th>
          <th>
          Detalles
          </th>
          </thead>

          <tbody>
            @include('content.cases.partials.ajax.case_log')
          </tbody>
          </table>
    </div>
  </div>
  @include('content.cases.partials.modals.log_create')
    
  