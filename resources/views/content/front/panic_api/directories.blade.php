@extends('front.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->

@endpush

@section('navbar')
<!-- aqui va el menu de cada vista -->
  @include('content.front.panic_api.navbar')
@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">

      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-solid card-primary card-outline ml-1 mr-1">
              <div class="card-header">
                <div class="row">
                  <div class="col">
                    <h3 class="card-title">
                      <i class="fas address-card"></i>
                      Directorio
                    </h3>
                  </div>
                
                  
                </div>

              </div>
        <div class="card-body pl-2">
          <div class="row">  
                
              @include('content.front.panic_api.partials.ajax.directories')

          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer"> 
         
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->

@endsection

@push('scripts')
<!-- aqui van los scripts de cada vista -->
<script src="{{asset('/our/js/panic_api.js')}}?v={{ config('app.asset_version') }}"></script>
@endpush

