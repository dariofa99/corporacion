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
                    <form class="form-inline " id="myFormSearchPD" action="/panic/directories">
                     <div class="col-md-3 offset-md-2">
                        <div class="form-group justify-content-end">
                       {{--    <select class="form-control" name="type">
                            <option value="view_all">Ver todo...</option>
                            <option value="name">Nombre</option>
                            <option value="created_at">Fecha de creación</option>
                            <option value="type_status">Estado</option>
                            <option value="case_asig">Asignado caso</option>
                     </select> --}}
                        </div>
                      </div>
                      <div class="col-md-7 ">
                        <div class="input-group ">
                          <input type="text" required id="types_text" @if(request()->has('data') and request()->get('data')!="") value="{{request()->get('data')}}" @endif class="form-control form-control-navbar input_data" name="data" placeholder="Ingrese un nombre..." aria-label="Buscar..." aria-describedby="basic-addon2">
                         {{--    <select style="display:none" class="form-control input_data" id="types_status" name="data">
                              @foreach($types_status as $id => $type_status)
                                <option value="{{$id}}">{{$type_status}}</option>
                              @endforeach
                            </select>
                           <select style="display:none" class="form-control input_data" id="types_case_asig" name="data">
                            <option value="si">Asignado</option>
                            <option value="no">Sin asignar</option>
                                  </select>   --}}                     
                          
                          <div class="input-group-append">
                            <button type="submmit" class="input-group-text" id="basic-addon2"> 
                              <i class="fas fa-search"></i>
                            </button>  
                            <button type="button" @if(request()->has('data') and request()->get('data')!="") style="display: block" @else style="display: none" @endif  class="input-group-text ml-1" id="btn_submf"> 
                              <i class="fas fa-times"></i>
                            </button>                        
                          </div>
                        </div>                   
                      </div>
                    </form>
                    </div>
                  
                </div>

              </div>
        <div class="card-body pl-2">
          <div class="row" id="content_panic_directories">  
                
              @include('content.panic_api.partials.ajax.directories')

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
<script src="{{asset("/our/js/panic_api.js")}}"></script>
@endpush

