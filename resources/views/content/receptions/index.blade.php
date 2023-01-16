@extends('layouts.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->
@endpush

@section('navbar')
<!-- aqui va el menu de cada vista -->
   @include('content.navbar')
@endsection

@section('content')

             <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1>@yield('title')</h1>
          </div>
        
        </div>
      </div><!-- /.container-fluid -->
    </section>
<!-- Content Header (Page header) -->



    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
     <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Selecciona
               
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                <div class="row">
                <div class="col-12 table-responsive p-0" >
               
                 <table class="table table-bordered text-nowrap">
                <thead>
                  <tr class="text-center">
                    <th>No. Recepción</th>
                    <th>Usuario</th>
                  
                    <th>Estado</th>
                    
                    <th>Acciones</th>
                  </tr>
                  </thead>
                  <tbody>
                  @if(isset($receptions))
                  @foreach ($receptions as $reception )     
                  <tr>
                    <td>{{$reception->number}}</td>

                    <td>{{$reception->user->name}}
                      @if($reception->user->type_status_id==16)
                      <small id="cont_stauser-{{$reception->user->id}}">                      
                        <div class="text-left"> 
                          <span style="color:red">Sin activar!</span>
                          - Fecha registro:  {{getDateForNotification($reception->user->created_at)}}
                        </div>
                      </small>
                      @endif
                    </td>
             
                    <td>{{$reception->type_status->name}}</td>
                    <td>
                      @if($reception->user->type_status_id!=16)
                        <a href="{{ $reception->user->type_status_id == 16 ? "#" : "/recepciones/$reception->id/edit"  }}" class="btn btn-success btn-block btn-sm" {{ $reception->user->type_status_id==16 ? "disabled" : ""}}>
                        <i class="fa fa-check"></i>Seleccionar
                        </a> 
                       
                      @endif
                    </td>
                  </tr>
                  @endforeach
                  @endif
                 
                   </tbody>
                  </table>

               </div>
                              
                </div>

              </div>
              <!-- /.card-body -->
        </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->


@endsection

@push('scripts')
<!-- aqui van los scripts de cada vista -->

@endpush

