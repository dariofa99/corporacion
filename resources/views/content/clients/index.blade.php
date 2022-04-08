@extends('layouts.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->
<style>
 .size-text {
    font-size: 19px;
  }
  .img-user {
    max-height: 250px;
  }
</style>
@endpush

@section('navbar')
<!-- aqui va el menu de cada vista -->
  @include('content.clients.navbar')
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
      <div class="card card-solid card-primary card-outline">
              <div class="card-header">
                <div class="row">
                  <div class="col">
                    <h3 class="card-title">
                      <i class="fas fa-users"></i>
                      Solicitantes
                    </h3>
                  </div>
                  <div class="col">
                  @if ($sw == "0")
                    <a class=" float-right" href="/clientes" ><i class="fas fa-times-circle"></i> Eliminar búsqueda</a>
                  @endif
                  </div>
                  
                </div>

              </div>
        <div class="card-body pb-0">
          <div class="row d-flex align-items-stretch">

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

            @foreach ($users as $user )
              <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                <div class="card bg-light size-text">
                  <div class="card-header text-muted border-bottom-0">
                    @if($user->type_status_id==16)
                    <small id="cont_stauser-{{$user->id}}">                      
                      <div class="text-left"> 
                        <span style="color:red">Sin activar!</span>
                        - Fecha registro:  {{getDateForNotification($user->created_at)}}
                      </div>
                    </small>
                    @endif
                  </div>
                  <div class="card-body pt-0">
                    <div class="row">
                      <div class="col-7">
                        <h2 class="lead"><b>{{$user->name}}</b></h2>
                        <p class="text-muted text-sm"><b>Documento: </b> {{$user->identification_number}} </p>
                        <ul class="ml-4 mb-0 fa-ul text-muted">
                          <li class="small"><span class="fa-li"><i class="fas fa-home"></i></span> Dirección: {{$user->address}}</li>
                          <li class="small"><span class="fa-li"><i class="fas fa-city"></i></span> Municipio: {{$user->town}}</li>
                        
                          <li class="small"><span class="fa-li"><i class="fas fa-envelope"></i></span> Correo: {{$user->email}}</li>
                          <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone" style="font-size: 15px;"></i></span> Teléfono: {{$user->phone_number}}</li>
                           {{--<li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span>  Empresa: </li>--}}
                        </ul>
                      </div>
                      <div class="col-5 text-center">
                        <img src="{{$user->image}}" alt="" class="img-circle img-fluid img-user">
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="text-right">
                     
                      @if($user->type_status_id==16)
                      <a href="#" id="btn_chstatus-{{$user->id}}" class="btn btn-sm bg-orange btn_changestatus_us" data-id="{{$user->id}}">
                        <i class="fas fa-check"></i> Activar 
                      </a> 
                      @endif
                      <a href="{{ $user->getCasesUrl()}}" class="btn btn-sm bg-teal">
                        <i class="fas fa-comments"></i> Chat 
                      </a>
                      <a href="/admin/users/{{$user->id}}/edit" class="btn btn-sm btn-primary">
                        <i class="fas fa-user"></i> ver perfil
                      </a>
                    </div>
                  </div>
                </div>
              </div>

            @endforeach



  

          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <nav aria-label="Contacts Page Navigation">
            
              {{ $users->appends(request()->query())->links() }}

     
          </nav>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->

@endsection

@push('scripts')
<!-- aqui van los scripts de cada vista -->
<script src="{{asset("/our/js/user.js")}}"></script>
@endpush

