@extends('layouts.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->
<style>


</style>


@endpush

@section('navbar')
<!-- aqui va el menu de cada vista -->
  @include('content.library.navbar')
@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          
        </div><!-- /.container-fluid -->
    </div>
      <!-- /.content-header -->
  
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
  
          <div class="row">
            <div class="col-md-12">
              <div class="card content-archive card-primary card-outline">
                <div class="card-header">
                <div class="row">
                  <div class="col-3 col-md-3">
                    <h3 class="card-title">
                      <i class="fas fa-book"></i>
                      Biblioteca
                    </h3>
                  </div>
                  <div class="col-5  col-md-6 ">
                  @if ($sw_search == "1")
                    <a class=" float-right" href="biblioteca" ><i class="fas fa-times-circle"></i> Eliminar búsqueda</a>
                  @endif
                  </div>

                  <div class="col-4 col-md-3 ">
                      <button type="button" class="btn btn-default float-right" data-toggle="modal" data-target="#myModal_library_search"><i class="fas fa-search"></i> Búsqueda...</button>
                  </div>
                </div>




              </div>

                <!-- /.card-header -->
                <div class="card-body">
                      <div class="row" id="library_id">
                      @include('content.library.ajax.index')


                      </div>
                      <!-- /.row -->

                  <!-- /.row -->
                        
                </div>
                <!-- ./card-body -->
                <div class="card-footer">
                  <div class="row">

                  </div>
                  <!-- /.row -->
                </div>
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
  
          <!-- Main row -->
          <div class="row">

  
            <div class="col-md-4">

              <!-- /.info-box -->

            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div><!--/. container-fluid -->
      </section>
      <!-- /.content -->

    @include('content.library.modals.library_create')
    @include('content.library.modals.library_show')
    @include('content.library.modals.library_search')

@endsection

@push('scripts')
<!-- aqui van los scripts de cada vista -->
<!-- bs-custom-file-input -->
<script src="../../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>


<script>

$(".content-archive").on("click",'.archive',function(e){
  //deja en blanco todos los campos
  
  $("#lbl_modal_title_diary").html('Actualizar documento');
  $("#library_id").val('');
  $("#name_file_library").html('Seleccione archivo...');
  $('#customFileLibrary').removeAttr("required");
  $("#descriptionLibrary").val('');
  $("#branch_lawLibrary").val('');
  $("#categoryLibrary").val('');
  $("#fecha_max_library").val('');
  $("#btn-file-library").html('Actualizar');

  //campos show
  $("#library_name_show").html('');
  $("#modal_description_show").html('');
  $("#library_law_show").html('');
  $("#library_cat_show").html('');
  $("#library_size_show").html('');
  $("#library_date_show").html('');
  $("#library_owner_show").html('');  
  
  //llena los campos segun los datos de la bd
  var id = $(this).attr('data-id');
  var request = {'id':id};
  $.ajax({
    url: '/biblioteca/source',
    type: 'POST',
    datatype: 'json',
    data: request,
    cache: false,
    beforeSend: function (xhr) {
      xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
      $("#wait").show();//muestra el loader   
    },
    success: function (res) {
      //console.log(res.ramader);
      //console.log(res.category);
      if (res.owner) {
        $("#library_id").val(res.id);
        $("#name_file_library").html(res.name_file);
        $("#descriptionLibrary").val(res.description);
        $("#branch_lawLibrary").val(res.type_branch_law_id);
        $("#categoryLibrary").val(res.category_id);
        $("#fecha_max_library").val(res.limit_date);
        $("#footer_modal-library").html('<button type="button" id ="delete_file_library" data-delete="'+res.id+'"class="btn btn-danger">Eliminar Archivo</button>');//boton eliminar
        $("#myModal_create_library").modal("show");
      } else {
        $("#library_name_show").html(res.name_file);
        $("#modal_description_show").html(res.description);
        $("#library_law_show").html(res.ramader);
        $("#library_cat_show").html(res.category);
        $("#library_size_show").html(roundTo((res.size/1024)/1024, 2)+' MB');
        $("#library_date_show").html(moment(res.created_at).format('LL'));
        $("#library_owner_show").html(res.name);  
        $("#footer_library_show").html('<a target="_blank" href="/biblioteca/download/'+res.id+'" class="btn btn-primary">Descargar</a>');
                     
         
        $("#myModal_library_show").modal("show");

      }
      
      $("#wait").hide();//oculta el loader
    },
    error: function (xhr, textStatus, thrownError) {
       
        alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
       
    }
  });

 
  
  
});
 function roundTo(value, places){
     var power = Math.pow(10, places);
     return Math.round(value * power) / power;
 }
//nuevo archivo
$("#new_document").click(function(e){
  //deja en blanco todos los campos
  $("#lbl_modal_title_diary").html('Nuevo documento');
  $("#library_id").val('');
  $("#name_file_library").html('Seleccione archivo...');
  $('#customFileLibrary').prop("required", true);
  $("#descriptionLibrary").val('');
  $("#branch_lawLibrary").val('');
  $("#categoryLibrary").val('');
  $("#fecha_max_library").val('');

  $("#btn-file-library").html('Crear');
  $("#footer_modal-library").html('');
  
  $("#myModal_create_library").modal("show");
});

$("#myformCreateLibrary").on('submit',function(e){
    var route = "";
    if ($("#btn-file-library").html() ==  "Actualizar") {
      route="/biblioteca/update";

    } else if ($("#btn-file-library").html() ==  "Crear") {
      route="/biblioteca/create";

    }

    
    //toma datos del formulario para crear o actulizar el evento en tiempo real

    var request = new FormData($(this)[0]);
    request.append("id",  $("#library_id").val());

    e.preventDefault();
    $.ajax({
      url : route,
      type: "POST",
      data : request,
      contentType: false,
      cache: false,
      processData:false,
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      xhr: function(){      
      $("#wait").show()       
      var xhr = $.ajaxSettings.xhr();                 
      if (xhr.upload) {
          xhr.upload.addEventListener('progress', function(event) {
            var percent = 0;
            var position = event.loaded || event.position;
            var total = event.total;
            if (event.lengthComputable) {
                percent = Math.ceil(position / total * 100);
            } 
            $("#progressbarwait").css('display','block');
            $('#progressGeneral').css('width', percent+'%');
            $('#progressGeneral').html(percent+'%');
            if(percent>=100){
                $('#progressGeneral').html('Terminando proceso...'); 
            }                       
          }, true);
      }
      return xhr;
    }
    //	mimeType:"multipart/form-data"
    }).done(function(res){ //
      $('#library_id').html(res.view);
        
      $("#progress_bar").hide(); 
      $("#wait").hide();
      Toast.fire({
        type: 'success',
        title: 'La información se ha guardado con éxito.'
      })

    });


 

  $("#myModal_create_library").modal('hide');

  return false;


 });

 $("#footer_modal-library").on("click",'#delete_file_library',function(e){

          Swal.fire({
                title: 'Esta seguro de eliminar el documento?',
                text: "El documento de eliminará de forma definitiva!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'Cancelar'
              }).then((result) => {
                if (result.value) {

                  //llena los campos segun los datos de la bd
                  var id = $(this).attr('data-delete');
                  var request = {'id':id};
                  $.ajax({
                    url: '/biblioteca/delete',
                    type: 'POST',
                    datatype: 'json',
                    data: request,
                    cache: false,
                    beforeSend: function (xhr) {
                      xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                      $("#wait").show();//muestra el loader   
                    },
                    success: function (res) {
                      console.log(res);
                      $('#'+res).remove();
                        
                      $("#wait").hide();//oculta el loader
                    },
                    error: function (xhr, textStatus, thrownError) {
                      
                        alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
                      
                    }
                  });

                
                      $("#myModal_create_library").modal("hide");
                        
                } 
              });

  
});
</script>

@endpush

