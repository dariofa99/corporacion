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
                <h3 class="card-title">
                  <i class="fas fa-folder"></i>
                  Nuevo Caso
                </h3>
              </div>
              <div class="card-body"> 
              <form action="" id="myFormCreateCase">
                <input @if(isset($user)) value="{{$user->id}}"  @endif type="hidden" name="user_id" id="user_id">
                @if(Request::has('puid'))
                  <input type="hidden" name="panic_alert_id" value="{{Request::get('puid')}}">
                @endif
                @if(Request::has('ruid'))
                <input type="hidden" name="reception_id" value="{{Request::get('ruid')}}">
              @endif
                <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                      <label for="case_number">No Caso</label>
                      <input type="text" required class="form-control form-control-sm" value="{{$case_number}}" name="case_number" id="case_number"  placeholder="00001">
                    </div>
                    </div>

                      <div class="col-md-4">   
                      <label for="user_identification_number">Usuario</label>   
                      <div class="input-group input-group-sm">
                    @if(!isset($user))
                      <div class="input-group-prepend">
                        <div class="input-group-text bg-green btnAddUserCase" data-type_user_id="7" data-view="create" id="btnAddUserCase" style="cursor:pointer">
                          Agregar
                          </div>  
                      </div>
                      @else
                      <div class="input-group-prepend">
                        <a class="input-group-text bg-green" href="/casos/create" style="cursor:pointer">
                          Cambiar
                        </a>  
                      </div>
                    @endif
                      <input @if(isset($user)) value="{{$user->identification_number}}"  @endif type="text" required readonly name="user_identification_number" id="user_identification_number" class="form-control form-control-sm" placeholder="No identificación"  aria-describedby="btnGroupAddon">
                    </div>
                    </div>

                    <div class="col-md-3">     
                      <div class="form-group">
                      <label for="type_case">Tipo de proceso</label>
                      <select required class="form-control form-control-sm" name="type_case_id" id="type_case_id">
                      @foreach ($types_case as $key => $type_case)
                          <option value="{{$key}}">{{$type_case}}</option>
                      @endforeach                                             
                      </select>
                    </div>
                    </div>

                      <div class="col-md-3">     
                      <div class="form-group">
                      <label for="type_branch_law">Tipo de Caso</label>
                      <select required class="form-control form-control-sm" name="type_branch_law_id" id="type_branch_law_id">
                          @foreach ($types_branch_law as $key => $type_branch_law)
                          <option value="{{$key}}">{{$type_branch_law}}</option>
                      @endforeach
                      </select>  
                    </div>
                    </div>           
                    </div>
                            
                    <hr>        
                    <div class="row">
                    
                      <div class="col-md-3">     
                      <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-sm btn-block">Guardar Caso</button>
                    </div>
                    </div>
                    </div>
                            
              </form>
 

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
@include('content.cases.partials.modals.novelty_create')
@include('content.cases.partials.modals.novelty_has_create')
@endsection

@push('scripts')
<!-- aqui van los scripts de cada vista -->

<script>  
  

</script>

@endpush

