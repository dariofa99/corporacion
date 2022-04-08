@extends('layouts.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- fullCalendar -->
 
@endpush

@section('navbar')
<!-- aqui va el menu de cada vista -->
  @include('content.audit.navbar')
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
                  <div class="col-md-6">
                    <h3 class="card-title">
                      <i style="font-size: 40px" class="far fa-calendar-alt">

                      </i>
                      <h2 class="mr-3">Auditoria de eventos</h2>
                    </h3>
                  </div>  
                  
                </div>

              </div>
              <div class="card-body p-0">
                <!-- THE CALENDAR -->
               @include('content.audit.partials.index')
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

@include('content.audit.partials.modals.details')
@endsection

@push('scripts')
<!-- aqui van los scripts de cada vista -->
<script>
(function(){
$(".btn_detalles_audit").on("click",function(e){
  var JsonText = $("#lblJsonAudit-"+$(this).attr("data-id")).val()
  var JsonText = JSON.stringify(JSON.parse(JsonText),null,4)
  console.log(JsonText);
  $("#myJsonParse").html(JsonText)
  $("#myModalDetalsAudit").modal('show')
  e.preventDefault()
})
})()
</script>
@endpush

