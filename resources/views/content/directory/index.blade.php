@extends('layouts.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->
  <!-- Ionicons -->

@endpush

@section('navbar')
<!-- aqui va el menu de cada vista -->
  @include('content.directory.navbar')
@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>




    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-2">
                    <h3 class="card-title">
                      <i class="fa fa-address-book"></i>
                      Directorio
                    </h3>
                  </div>
                  
                  <div class="col-md-10  ">
                  <form class="form-inline " id="myFormSearchIndexDirectory"  action="/directorio">
                    <div class="col-md-5 offset-md-2">
                      <div class="form-group justify-content-end">
                        <select class="form-control" name="type">
                          <option value="view_all">Ver todo...</option>
                          <option value="general_search">Búsqueda general</option>
                          <option value="type_status_id">Estado</option>
                          <option value="created_at">Fecha de creación</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-5 ">
                      <div class="input-group ">
                        <input type="text" disabled id="types_text" class="form-control input_data" name="data" placeholder="Buscar..." aria-label="Buscar..." aria-describedby="basic-addon2">
                        <select style="display:none" class="form-control input_data" id="type_status_id" name="data">
                          <option value="view_all">Seleccione...</option>
                         @foreach ($types_status_id as $key => $type_status )
                              <option value="{{$key}}">{{$type_status}}</option>
                         @endforeach
                        </select>
                        <div class="input-group-append">
                          <button type="submmit" class="input-group-text" id="basic-addon2"> <i class="fas fa-search"></i></button>                         
                        </div>
                      </div>                   
                    </div>
                  </form>
                  </div>

                </div><!-- End Row -->

              </div>
              <div class="card-body p-3" >
                <select id="type_field_directory" class="form-control form-control-sm" style="display: none">
                  @foreach($types_data_directory as $key => $value)
                    <option value="{{$key}}">{{$value}}</option>
                  @endforeach
               </select>  

                <!-- THE CALENDAR -->
                <div class="row" id="content_directories_list">

                  @include('content.directory.partials.ajax.index')

                </div>
               
                <!-- THE CALENDAR -->

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    @include('content.directory.partials.modals.directory_create',[
      'formId'=>'myformCreateDirectory',
      'modalId'=>'myModal_create_directory',
      'labelTitle'=>'Nuevo contacto',
      'labelButton'=>'Guardar',
      'buttonClass'=>'btn-primary'
    ])
     @include('content.directory.partials.modals.directory_create',[
      'formId'=>'myformEditDirectory',
      'modalId'=>'myModal_edit_directory',
      'labelTitle'=>'Editar contacto',
      'labelButton'=>'Actualizar',
      'buttonClass'=>'btn-warning'
    ])
@endsection

@push('scripts')
<!-- aqui van los scripts de cada vista -->
<script src="{{asset('our/js/directory.js')}}?v={{ config('app.asset_version') }}"></script>



<script>
  let directory = new Directory();
  $(function () {    
    $("#btn_new_directory").on("click",function(e){
      $("#myformCreateDirectory .content_new_input").html("")
      e.preventDefault();
      $("#myModal_create_directory").modal('show');
    });  
    
    $("#myformCreateDirectory").on('submit',function(e) {
      let request = $(this).serialize();
      directory.store(request)
      e.preventDefault();
    });

    $("#myformEditDirectory").on('submit',function(e) {
      let request = $(this).serialize();    
      let id = $("#myformEditDirectory input[name=id]").val();
      directory.update(request,id)
      e.preventDefault();
    });

    $("#content_directories_list").on("click",'.btn_edit_directory',function(e) {
      let id = $(this).attr('data-id');
      $("#myformEditDirectory .content_new_input").html("")
      directory.edit(id)
      e.preventDefault();
    });

    $("#content_directories_list").on("click",'.btn_delete_directory',function(e) {
      let id = $(this).attr('data-id');
      Swal.fire({
          title: 'Esta seguro de eliminar el contacto?',
          text: "Los cambios no podrán ser revertidos!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, eliminar!',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.value) {
            directory.delete(id);           
          }
        });
      
      e.preventDefault();
    });

    $(".btn_new_field_directory").on("click",function(e) {
      let form = $(this).attr('data-form')
      setInputs(form) 
    });

    $(".content_new_input").on("click",'.btn_delete_row',function(e){
      let id = $(this).attr('data-id');
      $(".aditional_data_rows-"+id).remove();
    });

    $(".content_old_addata_input").on("click",'.btn_delete_old_row',function(e){
      let id = $(this).attr('data-id');
      $(".aditional_old_data_rows-"+id).remove();
    });


    $("#content_directories_list").on("click",'.btn_change_display_aditional_data',function(e) {
      let id = $(this).attr('data-id');
      if($(this).attr("data-status") == 'true'){
        $("#ul_list_adtional_data-"+id).slideUp(100)  ;
        $(this).attr("data-status",'false');
        $(this).text("Ver más...");
      }else{
        $("#ul_list_adtional_data-"+id).slideToggle(100)  ;
        $(this).attr("data-status",'true');
        $(this).text("Ver menos...");
      }
      
      
      console.log(id)   
    });


  });

  


  function setInputs(form) {
    let id = $("#"+form+" .aditional_data_rows").length    
    let row_id = id != 0 ? (id + 1) : 1;
    let row = `<div style="padding:3px 0px 3px 0px ; background:#F2F3F4;border-radius:3px" class="row mb-2 aditional_data_rows aditional_data_rows-${row_id}">
      <div class= "col-md-11 col-11 col-sm-11 col-xs-11">
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text" id="btnGroupAddon"> <i class="fa fa-th"></i>        </div>
                        </div>
                        <input type="text"  name="aditional_field[]" class="form-control form-control-sm"  aria-describedby="btnGroupAddon">
                      </div>                     
                  </div>  
                  
                  <div class= "col-1">
                    <div class="input-group pt-1 btn_delete_row" data-id="${row_id}">
                      <i class="fa fa-times"></i>
                    </div>                    
                  </div> 
       
                <div class= "col-11 mt-1">
                  <div class="input-group">                     
                      <select name="type_field_directory[]" class="form-control form-control-sm">`
                        $("#type_field_directory option").each(function(){
                         row +=`<option value="${$(this).val()}"> ${$(this).text()}</option>`;
                        });
                 row+= `</select>               
                  </div>                     
              </div>
      </div>`;
    
    $(".content_new_input").append(row);    
  }

</script>

@endpush

