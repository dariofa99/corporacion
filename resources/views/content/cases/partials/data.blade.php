<div id="content_data" class="content_data">

  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
          <label for="case_number">Fecha reporte evento</label>
          <input type="date" data-type_id="140" class="form-control form-control-sm input_change_case_data set_old_value" 
          @if($case->getCaseData(140)) value="{{($case->getCaseData(140)->value)}}" @endif>    
      </div>
    </div>


    <div class="col-md-3">
      <div class="form-group">
          <label for="case_number">Nombre completo de la persona afectada</label>
          <input type="text" data-type_id="124" class="form-control form-control-sm input_case_data set_old_value"
          @if($case->getCaseData(124)) value="{{($case->getCaseData(124)->value)}}" @endif placeholder="Ej: Segundo Rosero">
      
      </div>
  </div>

  

    <div class="col-md-3">
      <div class="form-group">
          <label for="case_number">Cédula persona afectada</label>
          <input type="text" data-type_id="125" class="form-control form-control-sm input_case_data set_old_value" 
          @if($case->getCaseData(125)) value="{{($case->getCaseData(125)->value)}}" @endif placeholder="Ej: 568548965">
      
      </div>
  </div>

 
  <div class="col-md-3">
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <small>Los cambios se guardarán al salir de la caja de texto!</small>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
    </div>
</div> 

  <div class="col-md-3">
    <div class="form-group">
        <label for="case_number">Número de celular de la persona afectada</label>
        <input type="text" data-type_id="126" class="form-control form-control-sm input_case_data set_old_value" 
        @if($case->getCaseData(126)) value="{{($case->getCaseData(126)->value)}}" @endif placeholder="Ej: 3105489650">    
    </div>
  </div>

 

  <div class="col-md-3">
    <div class="form-group">
        <label for="case_number">Correo electrónico de la persona afectada</label>
        <input type="text" data-type_id="127" class="form-control form-control-sm input_case_data set_old_value" 
        @if($case->getCaseData(127)) value="{{($case->getCaseData(127)->value)}}" @endif placeholder="Ej: correo@mail.com">    
    </div>
  </div>
  
  <div class="col-md-3">
    <div class="form-group">
        <label for="case_number">Corregimiento/vereda/barrio</label>
        <input type="text" data-type_id="128" class="form-control form-control-sm input_case_data set_old_value" 
        @if($case->getCaseData(128)) value="{{($case->getCaseData(128)->value)}}" @endif placeholder="Ej: Corazón de Jesús">    
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
        <label for="case_number">Lugar de los hechos</label>
        <input type="text" data-type_id="129" class="form-control form-control-sm input_case_data set_old_value" 
        @if($case->getCaseData(129)) value="{{($case->getCaseData(129)->value)}}" @endif placeholder="Ej: San Fernando">    
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
        <label for="case_number">Fecha de los hechos</label>
        <input type="date" data-type_id="130" class="form-control form-control-sm input_change_case_data set_old_value" 
        @if($case->getCaseData(130)) value="{{($case->getCaseData(130)->value)}}" @endif>    
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
        <label for="case_number">Número de personas afectadas</label>
        <input type="text" data-type_id="131" class="form-control form-control-sm input_case_data set_old_value" 
        @if($case->getCaseData(131)) value="{{($case->getCaseData(131)->value)}}" @endif placeholder="Ej: 5">    
    </div>
  </div>

  <div class="col-md-3">
        
      
        <div class="form-group">
        <label for="case_number">Departamento</label>
        <input type="text" data-type_id="12" class="form-control form-control-sm input_case_data set_old_value" name="depto" id="depto" 
      @if($case->getCaseData(12)) value="{{($case->getCaseData(12)->value)}}" @endif placeholder="Ej: Nariño">
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="case_number">Municipio</label>
        <input type="text" data-type_id="13" class="form-control form-control-sm input_case_data set_old_value" name="municipio" id="municipio" 
        @if($case->getCaseData(13)) value="{{($case->getCaseData(13)->value)}}" @endif placeholder="Ej: San Juan de Pasto">
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="case_number">Juzgado</label>
        <input type="text" data-type_id="17" class="form-control form-control-sm input_case_data set_old_value" name="juzgado" id="juzgado" 
        @if($case->getCaseData(17)) value="{{($case->getCaseData(17)->value)}}" @endif placeholder="Ej: Administrativo">
      </div>
    </div>

  <div class="col-md-3">
    <div class="form-group">
        <label for="case_number">Se constituyó un delito</label>
        <select data-type_id="117" class="form-control form-control-sm input_change_case_data">
          <option value="">Seleccione</option>
            <option @if($case->getCaseData(117) and $case->getCaseData(117)->value == 'SI') selected @endif value="SI">SI</option>
            <option @if($case->getCaseData(117) and $case->getCaseData(117)->value == 'NO') selected @endif value="NO">NO</option>
        </select>
    
    </div>
</div>



    </div>
<!-------->
  

      <div class="row">

        <div class="col-md-6">  
          <div class="form-group">
              <label for="case_number">Personas/organizaciones afectadas</label>
              <textarea class="form-control form-control-sm input_case_data set_old_value" data-type_id="132"  rows="6">@if($case->getCaseData(132)){{($case->getCaseData(132)->value)}}@endif</textarea>
          </div>
      </div> 

      <div class="col-md-6">  
        <div class="form-group">
            <label for="case_number">Presuntos agresores</label>
            <textarea class="form-control form-control-sm input_case_data set_old_value" data-type_id="133"  rows="6">@if($case->getCaseData(133)){{($case->getCaseData(133)->value)}}@endif</textarea>
        </div>
      </div> 

      <div class="col-md-6">  
        <div class="form-group">
            <label for="case_number">El medio por el que se realizó la agresión</label>
            <textarea class="form-control form-control-sm input_case_data set_old_value" data-type_id="134"  rows="6">@if($case->getCaseData(134)){{($case->getCaseData(134)->value)}}@endif</textarea>
        </div>
      </div> 

      <div class="col-md-6">  
        <div class="form-group">
            <label for="case_number">Evidencias</label>
            <textarea class="form-control form-control-sm input_case_data set_old_value" data-type_id="135"  rows="6">@if($case->getCaseData(135)){{($case->getCaseData(135)->value)}}@endif</textarea>
        </div>
      </div>

    <div class="col-md-6">  
        <div class="form-group">
            <label for="case_number">Daños causados</label>
            <textarea class="form-control form-control-sm input_case_data set_old_value" data-type_id="118"  rows="6">@if($case->getCaseData(118)){{($case->getCaseData(118)->value)}}@endif</textarea>
        </div>
    </div>  
    <div class="col-md-6">  
      <div class="form-group">
          <label for="case_number">Tipo de riesgo</label>
          <textarea class="form-control form-control-sm input_case_data set_old_value" data-type_id="119"   rows="6">@if($case->getCaseData(119)){{($case->getCaseData(119)->value)}}@endif</textarea>
      </div>
    </div>
    <div class="col-md-6">  
      <div class="form-group">
          <label for="case_number">Características del riesgo</label>
          <textarea class="form-control form-control-sm input_case_data set_old_value" data-type_id="120"  rows="6">@if($case->getCaseData(120)){{($case->getCaseData(120)->value)}}@endif</textarea>
      </div>
  </div>  
  <div class="col-md-6">  
    <div class="form-group">
        <label for="case_number">Ocurrencia</label>
        <textarea class="form-control form-control-sm input_case_data set_old_value" data-type_id="121"   rows="6">@if($case->getCaseData(121)){{($case->getCaseData(121)->value)}}@endif</textarea>
    </div>
  </div>

  <div class="col-md-6">  
    <div class="form-group">
        <label for="case_number">Análisis del contexto del caso</label>
        <textarea class="form-control form-control-sm input_case_data set_old_value" data-type_id="122"  rows="6">@if($case->getCaseData(122)){{($case->getCaseData(122)->value)}}@endif</textarea>
    </div>
</div>  
<div class="col-md-6">  
  <div class="form-group">
      <label for="case_number">Qué ruta debe seguir</label>
      <textarea class="form-control form-control-sm input_case_data set_old_value" data-type_id="123"   rows="6">@if($case->getCaseData(123)){{($case->getCaseData(123)->value)}}@endif</textarea>
  </div>
</div>

    <div class="col-md-12">
      <div class="form-group">
        <label for="case_number">Hechos</label>
          <textarea class="form-control form-control-sm input_case_data set_old_value" data-type_id="14"  rows="10">@if($case->getCaseData(14)){{($case->getCaseData(14)->value)}}@endif</textarea>
        </div>
    </div>      

    <div class="col-md-12">
    
   
                      <div class="form-group">
                      <label for="case_number">Novedades/Observaciones</label>
                      <textarea class="form-control form-control-sm input_case_data set_old_value" data-type_id="24" rows="5">@if($case->getCaseData(24)){{($case->getCaseData(24)->value)}}@endif</textarea>
                    </div>
    </div>


    </div>

<div class="row">
    <div class="col-md-8">
      <h4>Información contraparte</h4>     
    </div>
<div class="col-md-2">
      <button class="btn btn-warning btn-block btn-sm" data-type_user_id="21" data-view="create"
              id="btnDNotification"><i class="fa fa-envelope" aria-hidden="true"></i> Notificaciones judiciales
        </button>
    </div>

    <div class="col-md-2"> 

        <button class="btn btn-primary btn-block btn-sm btnAddUserCase" data-type_user_id="21" data-view="create"
              id="btnAddUserCase"><i class="fa fa-user"> </i> Agregar contraparte 
        </button>

    </div>
</div>       

    <div class="row">
    <div class="col-md-12 table-responsive p-0">
    
        
        <table class="table table-hover content_ajax_list_users table-striped" id="table_list_defendant">
              <thead>
                  <th>
                  No. Identificación
                  </th>
                  <th>
                  Nombre
                  </th>
                  <th>Email</th>
                  <th>Teléfono</th>                  
                  <th>Tipo</th>
                  <th>Notificaciones</th>
                  <th>Acciones</th>
                  </thead>
                  <tbody>
                 @include('content.cases.partials.ajax.defendant')           
                  </tbody>
                  
              </table>
    </div>
    </div>


    <div class="row">
      <div class="col-md-8">
        <h4>Personas que intervienen en el caso</h4>     
      </div>
 {{--  <div class="col-md-2">
        <button class="btn btn-warning btn-block btn-sm" data-type_user_id="21" data-view="create"
                id="btnDNotification"><i class="fa fa-envelope" aria-hidden="true"></i> Notificaciones judiciales
          </button>
      </div> --}}
  
      <div class="col-md-2"> 
  
          <button class="btn btn-primary btn-block btn-sm btnAddUserCase" data-type_user_id="25" data-view="create"
                id="btnAddUserCase"><i class="fa fa-user"> </i> Agregar persona 
          </button>
  
      </div>
  </div>  


    <div class="row">
      <div class="col-md-12 table-responsive p-0">
      
          
          <table class="table table-hover content_ajax_list_users table-striped" id="table_list_interventor">
                <thead>
                    <th>
                    No. Identificación
                    </th>
                    <th>
                    Nombre
                    </th>
                    <th>Email</th>
                    <th>Teléfono</th>                  
                    <th>Tipo</th>
                    
                    <th>Acciones</th>
                    </thead>
                    <tbody>
                   @include('content.cases.partials.ajax.interventor')           
                    </tbody>
                    
                </table>
      </div>
      </div>


      <div class="row">
      <div class="col-md-8">
        <h4>Autoridades competentes que conocen el caso</h4>     
      </div>
  
      <div class="col-md-2"> 
  
          <button class="btn btn-primary btn-block btn-sm btnAddCaseNovelty" data-type_user_id="25" data-view="create"
                id="btnAddCaseNovelty"><i class="fa fa-lightbulb"> </i> Agregar novedad 
          </button>
  
      </div>
  </div>  


    <div class="row">
      <div class="col-md-12 table-responsive p-0">
      
          
          <table class="table table-hover content_ajax_list_novelty table-striped" id="table_list_novelty">
                <thead>
                    <th>
                    No.
                    </th>
                    <th>
                    Novedad
                    </th>
                    <th>Estado</th>
                    
                    <th>Acciones</th>
                    </thead>
                    <tbody>
                   @include('content.cases.partials.ajax.novelty')           
                    </tbody>
                    
                </table>
      </div>
      </div>

      <div class="row">
      <div class="col-md-8">
        <h4>Cuenta con</h4>     
      </div>
  
      <div class="col-md-2"> 
  
          <button class="btn btn-primary btn-block btn-sm btnAddCaseNoveltyHas" data-type_user_id="25" data-view="create"
                id="btnAddCaseNoveltyHas"><i class="fa fa-lightbulb"> </i> Agregar novedad 
          </button>
  
      </div>
  </div>  


    <div class="row">
      <div class="col-md-12 table-responsive p-0">
      
          
          <table class="table table-hover content_ajax_list_novelty_has table-striped" id="table_list_novelty_has">
                <thead>
                    <th>
                    No.
                    </th>
                    <th>
                    Novedad
                    </th>
                    <th>Estado</th>
                    
                    <th>Acciones</th>
                    </thead>
                    <tbody>
                   @include('content.cases.partials.ajax.novelty_has')           
                    </tbody>
                    
                </table>
      </div>
      </div>


    </div>


    </div>

    </div>