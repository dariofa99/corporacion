<form action="" id="myFormEditCase">


<div id="content_case_data">
<div class="row">
<div class="col-md-2 offset-md-10">
<button type="submit" class="btn btn-success btn-sm btn-block btns_update_case" style="display:none" id="btn_update_case">Actualizar</button>
<button type="button" class="btn btn-default btn-sm btn-block btns_update_case" style="display:none" id="btn_cancel_case">Cancelar</button>
<button type="button" class="btn btn-primary btn-sm btn-block" id="btn_edit_case">Editar</button>
</div>
</div>
<input type="hidden" id="case_id" name="id" value="{{$case->id}}">  
    
<div class="row">
     <div class="col-md-2">
                      <div class="form-group">
                      <label for="case_number">No Caso</label>
                      <input type="text" disabled class="form-control form-control-sm" name="case_number" id="case_number" value="{{$case->case_number}}" placeholder="00001">
                    </div>
                    </div>    
 
 <div class="col-md-2">
                      <div class="form-group">
                      <label for="case_number">Fecha de creación</label>
                      <input type="text" disabled class="form-control form-control-sm" name="created_at" id="created_at" value="{{$case->created_at}}" placeholder="00001">
                    </div>
                    </div>

            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Tipo de Caso: ">Tipo de Caso: </label>
                                    <select disabled class="form-control form-control-sm" name="type_branch_law_id" id="type_branch_law_id">
                      @foreach ($types_branch_law as $key => $type_branch_law)
                          <option value="{{$key}}" {{$key==$case->type_branch_law_id ? 'selected' : ''}}>{{$type_branch_law}}</option>
                      @endforeach
                      
                        
                      </select>
                                </div>
                            </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="Estado del caso">Estado Del Caso</label>
                                <select disabled class="form-control form-control-sm" name="type_status_id" id="type_status_id">
                      @foreach ($types_status as $key => $type_status)
                          <option value="{{$key}}" {{$key==$case->type_status_id ? 'selected' : ''}}>{{$type_status}}</option>
                      @endforeach
                      
                        
                      </select></div>
                        </div>
                    <div class="col-md-2"> 
                        <div class="form-group">
                            <label for="Tipo procedimiento: ">Tipo Procedimiento: </label>
                             
    
                             <select disabled class="form-control form-control-sm" name="type_case_id" id="type_case_id">
                      @foreach ($types_case as $key => $type_case)
                          <option value="{{$key}}" {{$key==$case->type_case_id ? 'selected' : ''}}>{{$type_case}}</option>
                      @endforeach
                      
                        
                      </select>                                    
                                                            </select>
    
                        </div>
                    </div>
    
    </div>
    </div>

</form>
