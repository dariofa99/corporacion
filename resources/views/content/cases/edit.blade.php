@extends('layouts.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->
<link media="all" type="text/css" rel="stylesheet" href="{{ asset('plugins/client-chat/plyr.css')}}">
<link media="all" type="text/css" rel="stylesheet" href="{{ asset('plugins/client-chat/style-chat.css')}}">
<link rel="stylesheet" href="{{asset('plugins/bootstrap-toggle4/bootstrap-toggle4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/dropzone57/dist/min/dropzone.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css')}}">



@endpush

@section('navbar')
<!-- aqui va el menu de cada vista -->
  @include('content.cases.navbar')
@endsection

@section('content')
<div class="content-header">
{{--   <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>
                Modals & Alerts 
                <small>new</small>
              </h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Modals & Alerts</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
  </section> --}}
    <!-- /content-header -->
</div>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

       <!-- include('components.callout_info') -->
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
   <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

   
@endif

        <div class="row">
       

          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-folder"></i>
                  Caso: {{$case->type_branch_law->name}} 
                </h3>
              </div>
              <div class="card-body"> 
        <ul class="nav nav-tabs" id="myTab" role="tablist">

          <li class="nav-item">
            <a class="nav-link active" id="chat-tab" data-toggle="tab" href="#chat_tab" role="tab" aria-controls="chat_tab" aria-selected="false">
              Oficina virtual
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link " id="users-client" data-toggle="tab" href="#users_client" role="tab" aria-controls="users_client" aria-selected="false">
              Datos solicitante
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link " id="case-data" data-toggle="tab" href="#case_data" role="tab" aria-controls="case_data" aria-selected="true">
              Datos del caso
            </a>
          </li>
 
          <li class="nav-item">
            <a class="nav-link" id="log-tab" data-toggle="tab" href="#log_tab" role="tab" aria-controls="log_tab" aria-selected="false">
              Bitácora
            </a>
          </li>
<!--
          <li class="nav-item">
            <a class="nav-link" id="diary-tab" data-toggle="tab" href="#diary_tab" role="tab" aria-controls="diary_tab" aria-selected="false">
              Agenda
            </a>
          </li>
 -->
          <li class="nav-item">
            <a class="nav-link" id="assignment-tab" data-toggle="tab" href="#assignment_tab" role="tab" aria-controls="assignment_tab" aria-selected="false">
              Asignaciones
            </a>
          </li>




</ul>

<div class="tab-content" id="myTabContent">

  <div class="tab-pane fade show active" id="chat_tab" role="tabpanel" aria-labelledby="chat-tab">
          <div class="row content_log_data" >   
                <div class="col-md-8"> 
                
                   @if($case->reception)
                    {{-- @include('content.chat.chat',
                    [
                      'token'=>$case->reception->number
                    ]) --}}
                    @else
                    <a class="btn btn-success btn-sm" id="btnAsigReceptionCase">
                      <i class="fas fa-comment-alt"> </i> Activar chat </a>
                    @endif 
                </div>
                <div class="col-md-4" >                          
                <button class="btn btn-primary btn-sm btn-block btn_get_logs" data-type_id="18" id="btnViewDocuments">
                  <i class="fas fa-folder-open"> </i> Documentos </button>
                  <br> 
                  <button class="btn btn-warning btn-sm btn-block btn_get_logs" data-type_id="23" id="btnViewNotifications">
                  <i class="fa fa-info-circle"> </i> Notificaciones</button>
                  <br> 
                  <button class="btn btn-info btn-sm btn-block" data-type_id="" id="btnViewStreaming" >
                  <i class="fas fa-video"></i> Video llamada</button>
                  </div>
              </div> 
  </div>

  <div class="tab-pane fade " id="case_data" role="tabpanel" aria-labelledby="case-data-tab">  
      @include('content.cases.partials.general_data')
      @include('content.cases.partials.data')  
  </div>

  <div class="tab-pane fade " id="users_client" role="tabpanel" aria-labelledby="users-client-tab">
    @include('content.cases.partials.client_data')  
  </div>

  <div class="tab-pane fade" id="log_tab" role="tabpanel" aria-labelledby="log-tab">  
    @include('content.cases.partials.case_log')  
  </div>

  <div class="tab-pane fade" id="assignment_tab" role="tabpanel" aria-labelledby="assignment-tab">  
    @include('content.cases.partials.professional_data')  
  </div>




</div>

              </div>
              <!-- /.card -->
            </div>

          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
      </div><!-- /.container-fluid -->

    </section>
    <!-- /.content -->


  @include('content.cases.partials.modals.user_create')
  @include('content.cases.partials.modals.streaming')
   @include('content.cases.partials.modals.log_details')
  @include('content.users.partials.modals.user_data')
  @include('content.cases.partials.modals.show_logs')
  @include('content.cases.partials.modals.bill_create')
  @include('content.cases.partials.modals.pay_credit')
 @include('content.cases.partials.modals.log_defendant_notification')
 @include('content.cases.partials.modals.notification_defendant_details')

  
@endsection

@push('scripts')
<!-- aqui van los scripts de cada vista -->
<script type="text/javascript" src="{{asset('plugins/bootstrap-toggle4/bootstrap-toggle4.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/dropzone57/dist/min/dropzone.min.js')}}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script type="text/javascript" src="{{asset('our/js/dropzone_log.js')}}"></script>
<script type="text/javascript" src="{{asset('our/js/dropzone_bill.js')}}"></script>


<script>
$(document).ready(function(){     
$('.select2').select2();
Dropzone.autoDiscover = false;          

///////////////////////////////

         $(".add_log_button").on("click", function(){            
              if ($("#notification_date").attr("disabled") === "disabled") {
                if ($("#custom-tabs-four-profile-tab").hasClass("active")) {
                  $("#custom-tabs-four-profile-tab").removeClass("active");
                  $("#custom-tabs-four-profile").removeClass("active").removeClass("show");
                  $("#custom-tabs-four-home-tab").addClass("active");
                  $("#custom-tabs-four-home").addClass("active").addClass("show");
                }
              } else if ($("#notification_date").val() == "") {
                $("#custom-tabs-four-home-tab").removeClass("active");
                $("#custom-tabs-four-home").removeClass("active").removeClass("show");
                $("#custom-tabs-four-profile-tab").addClass("active");
                $("#custom-tabs-four-profile").addClass("active").addClass("show"); 
              } else {
                $("#custom-tabs-four-profile-tab").removeClass("active");
                $("#custom-tabs-four-profile").removeClass("active").removeClass("show");
                $("#custom-tabs-four-home-tab").addClass("active");
                $("#custom-tabs-four-home").addClass("active").addClass("show");
            }
            });



  $("#chat_tab").on("click",'#btnViewStreaming',function(e){
    
    $('#newtab-stream-cases').attr('href', 'https://meet.jit.si/lybra_{{ sha1($case->id) }}');
    $('#copy-stream-cases').attr('data-frame', 'https://meet.jit.si/lybra_{{ sha1($case->id) }}');
    $('#text-stream-cases').val('https://meet.jit.si/lybra_{{ sha1($case->id) }}');
    $('#iframe-stream-cases').attr('src', 'https://meet.jit.si/lybra_{{ sha1($case->id) }}');
    $('#myModal_create_streaming_cases').modal("show");


  });

  $("#myModal_create_streaming_cases").on("click",'#newtab-stream-cases',function(e){
    $('#myModal_create_streaming_cases').modal("hide");
    $('#text-stream-cases').val('');
    
    $('#iframe-stream-cases').attr('src', '');


  });
  $('#myModal_create_streaming_cases').on('hidden.bs.modal', function (e) {
    $('#newtab-stream-cases').attr('href', '');
    $('#text-stream-cases').val('');
    $('#iframe-stream-cases').attr('src', '');

  });
  $("#myModal_create_streaming_cases").on("click",'#ask-stream-cases',function(e){
  
     var request = {'id':$(this).attr('data-id')};
     notifyClientStream(request);
  

  });
  
  $("#myModal_create_streaming_cases").on("click",'#copy-stream-cases',function(e){

      copiarAlPortapapeles('content-text-stream-cases');
  

  });

  function notifyClientStream(request) {

      $.ajax({
          url: '/casos/stream',
          type: 'POST',
          datatype: 'json',
          data: request,
          cache: false,
          beforeSend: function (xhr) {
              xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
              $("#wait").show();
          },
          success: function (res) {
              $("#wait").hide();
              if (res.id != null) {
                  Toast.fire({
                    title: 'Invitación enviada con éxito.',
                    type: 'success', 
                    timer: 8000,               
                  });
              } else {
                  Toast.fire({
                    title: 'No hay usuarios registrados en el caso.',
                    type: 'error',  
                    timer: 8000,               
                  });
              }
            console.log(res);
          },
          error: function (xhr, textStatus, thrownError) {
              alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
          }
      });
  }


    //Función que lanza el copiado del código
    function copiarAlPortapapeles(id){
        var codigoACopiar = document.getElementById(id);    //Elemento a copiar
        //Debe estar seleccionado en la página para que surta efecto, así que...
        var seleccion = document.createRange(); //Creo una nueva selección vacía
        seleccion.selectNodeContents(codigoACopiar);    //incluyo el nodo en la selección
        //Antes de añadir el intervalo de selección a la selección actual, elimino otros que pudieran existir (sino no funciona en Edge)
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(seleccion);  //Y la añado a lo seleccionado actualmente
        try {
            var res = document.execCommand('copy'); //Intento el copiado
            if (res) {
                  Toast.fire({
                    title: 'Link copiado.',
                    type: 'success', 
                    timer: 5000,               
                  });
            } else {
                  Toast.fire({
                    title: 'Error de copiado, copie el link manualmente.',
                    type: 'error',
                    timer: 5000,                 
                  });
            }


        }
        catch(ex) {
                  Toast.fire({
                    title: 'Error de copiado, copie el link manualmente.',
                    type: 'error',
                    timer: 5000,                 
                  });
        }
        window.getSelection().removeRange(seleccion);
    }


});


 

</script>  



@endpush