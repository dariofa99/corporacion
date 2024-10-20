@extends('layouts.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->

@endpush

@section('navbar')
<!-- aqui va el menu de cada vista -->
  @include('content.panic_api.navbar')
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
                  <div class="col-md-4">
                    <h3 class="card-title">
                      <i class="fas fa-bell"> </i> 
                       Alertas de pánico
                    </h3>
                  </div>
                  <div class="col-md-8">
                    <form class="form-inline " id="myFormSearchPA" action="/panic/alerts">
                     <div class="col-md-3 offset-md-2">
                        <div class="form-group justify-content-end">
                          <select class="form-control" name="type">
                            <option value="view_all">Ver todo...</option>
                            <option value="name">Nombre</option>
                            <option value="created_at">Fecha de creación</option>
                            <option value="type_status">Estado</option>
                            <option value="case_asig">Asignado caso</option>
                     </select>
                        </div>
                      </div>
                      <div class="col-md-7 ">
                        <div class="input-group ">
                          <input type="text" disabled  id="types_text" class="form-control input_data" name="data" placeholder="Buscar..." aria-label="Buscar..." aria-describedby="basic-addon2">
                            <select style="display:none" class="form-control input_data" id="types_status" name="data">
                              @foreach($types_status as $id => $type_status)
                                <option value="{{$id}}">{{$type_status}}</option>
                              @endforeach
                            </select>
                           <select style="display:none" class="form-control input_data" id="types_case_asig" name="data">
                            <option value="si">Asignado</option>
                            <option value="no">Sin asignar</option>
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
        <div class="card-body pl-2">
          <div class="row">  
            <div class="col-md-12" id="content_panic_alerts">                
                @include('content.panic_api.partials.ajax.index')
            </div>
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
@include('content.panic_api.partials.modals.change_status')
@endsection

@push('scripts')
<!-- aqui van los scripts de cada vista -->
<script src="{{asset('/our/js/panic_api.js')}}?v={{ config('app.asset_version') }}"></script>
@endpush

