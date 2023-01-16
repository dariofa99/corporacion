@extends('layouts.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->

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
                <div class="row">
                  <div class="col-md-2">
                    <h3 class="card-title">
                      <i class="fas fa-folder"></i>
                      Casos
                    </h3>
                  </div>
                  <div class="col-md-10  ">
                  <form class="form-inline " id="myFormSearchIndex"  action="/casos">
                    <div class="col-md-5 offset-md-2">
                      <div class="form-group justify-content-end">
                        <select class="form-control" name="type">
                          <option value="view_all">Ver todo...</option>
                          <option value="case_number">No. caso</option>
                          <option value="identification_number">No. identificación</option>
                          <option value="user_name">Nombre</option>
                          <option value="type_case">Tipo de proceso</option>
                          <option value="branch_law">Rama del derecho</option>
                          <option value="status">Estado caso</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-5 ">
                      <div class="input-group ">
                        <input type="text" disabled id="types_text" class="form-control input_data" name="data" placeholder="Buscar..." aria-label="Buscar..." aria-describedby="basic-addon2">
                         <select style="display:none" class="form-control input_data" id="types_case" name="data">
                          <option value="view_all">Seleccione...</option>
                         @foreach ($types_case as $key => $type_case )
                              <option value="{{$key}}">{{$type_case}}</option>
                         @endforeach
                        </select>
                         <select style="display:none" class="form-control input_data" id="types_branch_law" name="data">
                          <option value="view_all">Seleccione...</option>
                         @foreach ($types_branch_law as $key => $type_branch_law )
                              <option value="{{$key}}">{{$type_branch_law}}</option>
                         @endforeach
                        </select>
                         <select style="display:none" class="form-control input_data" id="types_status" name="data">
                          <option value="view_all">Seleccione...</option>
                         @foreach ($types_status as $key => $type_status )
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
                </div>




              </div>
              <div class="card-body table-responsive p-0" id="content_cases"> 
                @include("content.cases.partials.ajax.index")

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

@endsection

@push('scripts')
<!-- aqui van los scripts de cada vista -->

<script>  
  (function(){
    


  })();

</script>

@endpush

