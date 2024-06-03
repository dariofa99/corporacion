@extends('layouts.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- fullCalendar -->
  <link rel="stylesheet" href="{{asset('plugins/bootstrap-toggle4/bootstrap-toggle4.min.css')}}">

  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
   <!-- Tempusdominus Bbootstrap 4 timepiker datepiker-->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css')}}"> 

@endpush

@section('navbar')
<!-- aqui va el menu de cada vista -->
  @include('content.categories.navbar')
@endsection

@section('content')

    <!-- Content Header (Page header) -->
 {{--    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            
              <div class="alert alert-info alert-dismissible" id ="alert_diary">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                
              </div>
          
          </div>
        </div>
      </div>
    </section> --}}




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
                      <i class="far fa-calendar-alt"></i>
                      Categorias
                    </h3>
                  </div>
              
                  
                </div>

              </div>
              <div class="card-body p-0" id="content_list_categories">
                
                @include('content.categories.partials.ajax.index')
               
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

   

@include('content.categories.partials.modals.category_create')
@endsection

@push('scripts')
<!-- aqui van los scripts de cada vista -->
<!-- fullCalendar 2.2.5 -->
<script type="text/javascript" src="{{asset('plugins/bootstrap-toggle4/bootstrap-toggle4.min.js')}}"></script>

<script type="module" src="{{asset('our/js/references_data.js')}}"></script> 




@endpush

