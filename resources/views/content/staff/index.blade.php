@extends('layouts.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->
<style>
 .option-card {
    padding-top: 0px !important;

 }
</style>
@endpush

@section('navbar')
<!-- aqui va el menu de cada vista -->
  @include('content.staff.navbar')
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
                      <i class="fas fa-user-tie"></i>
                      Personal
                    </h3>
                  </div>
                  <div class="col">
                  @if ($sw == "0")
                    <a class=" float-right" href="personal" ><i class="fas fa-times-circle"></i> Eliminar búsqueda</a>
                  @endif
                  </div>
                  
                </div>

              </div>
        <div class="card-body pb-0">

        
        @php($i = 1) {{-- contador $i para determinar donde va la etiqueta row--}}
        @foreach ($users as $user )
          @if ($i === 1)
            <div class="row">
          @endif
         
      
          
            <div class="col-md-4">
              <!-- Widget: user widget style 1 -->
              <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-warning">
                  <h3 class="widget-user-username">{{$user->name}}</h3>
                  <h6 class="widget-user-desc">{{$user->email}}</h6>
                </div>
                <div class="widget-user-image">
                  <img class="img-circle elevation-2" src="{{$user->image}}" alt="User Avatar">
                </div>
                <div class="card-footer">
                  <div class="row">
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                        <h5 class="description-header">{{count($user->cases()->where('type_user_id',8)->where('type_status_id', '!=',15)->get())}}</h5>
                        <span class="description-text">Asignados</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                        <h5 class="description-header">{{count($user->cases()->where('type_user_id',8)->where('type_status_id',9)->get())}}</h5>
                        <span class="description-text">Abiertos</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                      <div class="description-block">
                        <h5 class="description-header">{{count($user->cases()->where('type_user_id',8)->where('type_status_id',10)->get())}}</h5>
                        <span class="description-text">Cerrados</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
                  <div class="card-footer option-card">
                    <div class="text-right">
                      <a href="/casos?type=identification_number&data={{$user->identification_number}}" class="btn btn-sm bg-success">
                        <i class="fas fa-folder-open"></i> Casos
                      </a>
                      <a href="/admin/users/{{$user->id}}/edit" class="btn btn-sm btn-primary">
                        <i class="fas fa-user"></i> ver perfil
                      </a>
                    </div>
                  </div>
              </div>
              <!-- /.widget-user -->
            </div>
            <!-- /.col -->

          @if ($i === 3)
          </div>
          <!-- /.row 1 -->
            @php($i = 0)
          @endif

          @php($i = $i+1)
        @endforeach
        @if ($i === 2 or $i === 3)
        </div>
        <!-- /.row 2 -->
        @endif
       





















        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <nav aria-label="Contacts Page Navigation ">
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

@endpush

