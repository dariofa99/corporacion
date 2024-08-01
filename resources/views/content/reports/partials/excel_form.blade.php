<form id="MyFormDownloadExcel" action="/reportes/excel/generate" method="POST" target="downloadFrame">
    @csrf
 <div class="row">
  <div class="col-md-12">

    <div class="row">
      <div class="col-md-5">
      <label for="select_table">Tabla Principal</label>
      <select class="form-control form-control-sm  " id="select_table" name="select_table">
        {{-- <option value="" selected="selected">Seleccione...</option> --}}
        <option value="cases">Casos</option>                  
      </select>

      </div>
      <div class="col-md-1"><br>
      <label for="">Hab. Rango</label>
      <input type="checkbox" id="check_hab_rango" class="">
      </div>
      <div class="col-md-5"> 
      <div class="row">
        <div class="col-md-6">
                  <label for="fecha_ini">Fecha Inicial</label>
          <input class="form-control form-control-sm " id="fecha_ini" disabled="" name="fecha_ini" type="date" value="2021-01-07">
        </div>
        <div class="col-md-6">
          <label for="fecha_fin">Fecha Final</label>
          
          <input class="form-control form-control-sm " id="fecha_fin" disabled="" name="fecha_fin" type="date" value="2021-01-14">
        </div>
      </div>  
      </div>


      </div>
      <div class="row">  
  
      <div class="col-md-5">  
      <label for="select_filter_table">Filtro</label>                    
      <select class="form-control form-control-sm generate_graf" id="select_filter_table" name="select_filter_table">
       <option value="all">Todo</option>
       <option value="type_status">Estado</option>
       <option value="type_case">Tipo de proceso</option>
       <option value="type_branch_law">Tipo de Caso</option>
        @foreach($ref_users as $key => $ref_user)
         <option value="{{$key}}">{{$ref_user}}</option>
       @endforeach
      </select>                
      </div>
      <div class="col-md-5">  
        <label for="select_options_filter_table">Opciones de Filtro</label>                    
        <select class="form-control form-control-sm " id="select_options_filter_table" name="select_options_filter_table">
         
        </select>                
        </div>
        <div class="col-md-2">
          <input type="submit" value="Generar reporte" class="btn btn-success">                    
        </div>
      </div> 
 


</div>
 </div>

  <!-- THE CALENDAR -->
  <div class="row">
    <div class="col-md-12 ml-3 mt-4" id="exceldiv" style="width: 100%;height:500px;display:block">
      <div class="row">

        <div class="col-md-3">
          <input  id="headerinput-cn" name="header[]" type="hidden" value="numero_caso">
           
          <div class="form-check form-check-inlin"> 
            <input class="form-check-input hih" checked name="values[]" type="checkbox" id="inlineCheckbox-cn" value="numero_caso">
           
            <label class="form-check-label" for="inlineCheckbox-cn">No Caso</label>
          </div>
        </div>  

        <div class="col-md-3">
          <input  id="headerinput-sc" name="header[]" type="hidden" value="estado">                      
            
          <div class="form-check form-check-inlin">
            <input class="form-check-input hih" checked name="values[]" type="checkbox" id="inlineCheckbox-sc" value="estado">

            <label class="form-check-label" for="inlineCheckbox-sc">Estado</label>
          </div>
        </div> 

        <div class="col-md-3">
          <input name="header[]" id="headerinput-cp" type="hidden" value="tipo_proceso">
           
          <div class="form-check form-check-inlin">
             <input class="form-check-input hih" checked name="values[]" type="checkbox" id="inlineCheckbox-cp" value="tipo_proceso">
            <label class="form-check-label" for="inlineCheckbox-cp">Tipo de proceso</label>
          </div>
        </div> 

        <div class="col-md-3">
          <input  name="header[]" id="headerinput-cbl" type="hidden" value="rama_derecho">
           
          <div class="form-check form-check-inlin">
             <input class="form-check-input hih" checked name="values[]" type="checkbox" id="inlineCheckbox-cbl" value="rama_derecho">
            <label class="form-check-label" for="inlineCheckbox-cbl">Tipo de Caso</label>
          </div>
        </div> 


      @foreach($types_data as $key => $type_data)

        <div class="col-md-3">
          <input name="header[]" type="hidden" id="headerinput-{{$key}}" value="{{$type_data}}">
          <div class="form-check form-check-inlin">                   
            <input class="form-check-input hih" checked name="values[]" type="checkbox" id="inlineCheckbox-{{$key}}" value="{{$key}}">
            <label class="form-check-label" for="inlineCheckbox-{{$key}}">{{$type_data}}</label>
          </div>
        </div>                           
      
      @endforeach

    </div>

    <div class="row">

      @foreach($types_data_user as $key => $type_data_user)
        @if(!is_array($type_data_user))

        <div class="col-md-3">
          <input name="user_header[]" type="hidden" id="userheaderinput-{{sanear_string($type_data_user)}}" value="{{$type_data_user}}">
          <div class="form-check form-check-inlin">                   
            <input class="form-check-input hih" checked name="user_values[]" type="checkbox" id="userinlineCheckbox-{{sanear_string($type_data_user)}}" value="{{sanear_string($type_data_user)}}">
            <label class="form-check-label" for="userinlineCheckbox-{{sanear_string($type_data_user)}}">{{$type_data_user}}</label>
          </div>
        </div>  
        @else  
        @foreach($type_data_user as $key => $type_data_user)
        <div class="col-md-3">
          <input name="user_header[]" type="hidden" id="userheaderinput-{{$key}}" value="{{$type_data_user}}">
          <div class="form-check form-check-inlin">                   
            <input class="form-check-input hih" checked name="user_values[]" type="checkbox" id="userinlineCheckbox-{{$key}}" value="{{$key}}">
            <label class="form-check-label" for="userinlineCheckbox-{{$key}}">{{$type_data_user}}</label>
          </div>
        </div> 
        @endforeach
      @endif
      @endforeach

    </div>



    </div> 
   

  </div>
</form>
<iframe id="downloadFrame" name="downloadFrame" style="display: none;"></iframe>