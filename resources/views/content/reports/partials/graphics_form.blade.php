<form action="/reportes/excel/generate" method="POST" id="myFormGenerateRG">
    @csrf
    <div class="row">
        <div class="col-md-5">
        <label for="select_table">Tabla Principal</label>
        <select class="form-control form-control-sm generate_graf" id="select_table_graphic" name="select_table_graphic">
          <option value="" selected="selected">Seleccione...</option>
          <option value="cases">Casos</option>                  
        </select>
        <div class="form-check form-check-inline">
            <input class="form-check-input generate_graf" type="radio" checked name="type_graphic" id="inlineRadio1" value="pie">
            <label class="form-check-label" for="inlineRadio1">Torta</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input generate_graf" type="radio" name="type_graphic" id="inlineRadio2" value="linea">
            <label class="form-check-label" for="inlineRadio2">Linea</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input generate_graf" type="radio" name="type_graphic" id="inlineRadio3" value="column">
            <label class="form-check-label" for="inlineRadio3">Columnas</label>
          </div>
        </div>
        <div class="col-md-1"><br>
        <label for="">Hab. Rango</label>
        <input type="checkbox" id="check_hab_rango_graphics" class="generate_graf">
        </div>
        <div class="col-md-5"> 
        <div class="row">
          <div class="col-md-6">
                    <label for="fecha_ini">Fecha Inicial</label>
            <input class="form-control form-control-sm generate_graf" id="fecha_ini" disabled="" name="fecha_ini" type="date" value="2021-01-07">
          </div>
          <div class="col-md-6">
            <label for="fecha_fin">Fecha Final</label>
            
            <input class="form-control form-control-sm generate_graf" id="fecha_fin" disabled="" name="fecha_fin" type="date" value="2021-01-14">
          </div>
        </div>  
        </div>


        </div>
        <div class="row">  
        <div class="col-md-5">  
            <label for="">Filtro</label><br>
            <select class="form-control form-control-sm generate_graf" id="select_filter_graphic" name="select_filter_graphic">
                <option value="type_status">Estado</option>
                <option value="type_case">Tipo de proceso</option>
                <option value="type_branch_law">Tipo de Caso</option>
                @foreach($ref_users as $key => $ref_user)
                <option value="{{$key}}">{{$ref_user}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">  
        <label for="">Cruzar</label><br>
        <input type="checkbox" id="check_hab_cruce" class="generate_graf">
        </div> 
        <div class="col-md-5">  
        <label for="select_filter_table">Opciones de cruce</label>                    
        <select disabled class="form-control form-control-sm generate_graf" id="select_filter_cruce" name="select_filter_cruce">
         
        </select>
        
        </div>

        </div> 
</form> 
<hr>
<div class="row">
  <div class="col-md-12">
    <div id="chartdiv" style="width: 100%;height:700px">

    </div>
  </div>
</div>