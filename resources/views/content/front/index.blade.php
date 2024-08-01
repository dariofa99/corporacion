@extends('front.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->
@endpush

@section('navbar')
<!-- aqui va el menu de cada vista -->
   @include('content.front.navbar')
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
                <h3 class="card-title">Selecciona un caso 
                @if(session()->has('session_case'))
                (Actual  {{session('session_case')->case_number}})
                @endif
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
                    <th>No. Caso</th>
                    <th>Tipo de proceso</th>
                    <th>Tipo de Caso</th>
                    <th>Estado</th>                    
                    <th>Acciones</th>
                  </tr>
                  </thead>
                  <tbody>
                  @if(isset($receptions))
                  @foreach ($receptions as $reception )     
                  <tr>
                    <td>{{$reception->number}}</td>
                    <td>Sin asignar</td>
                    <td>Sin asignar</td>
                    <td>{{$reception->type_status->name}}</td>
                    <td><a href="{{route("office.reception",$reception->id)}}" class="btn btn-success btn-block btn-sm">
                      <i class="fa fa-check"></i> 
                          Selecionar
                      </a>
                    </td>
                  </tr>
                  @endforeach
                  @endif
                  @if(isset($cases))
                    @foreach ($cases as $case )     
                          <tr>
                            <td>{{$case->case_number}}</td>

                            <td>{{$case->type_case->name}}</td>

                            <td>{{$case->type_branch_law->name}}</td>

                            <td> 
                            <span style="display:block" class="badge badge-pill 
                            {{$case->status->id=='9' ? 'badge-success':''}}
                            {{$case->status->id=='10' ? 'badge-primary':''}}
                            ">
                            {{$case->status->name}}</span>
                            
                              </td>
                          
                            <td class="text-center">
                      

                          
                            @if(session()->has('session_case'))
                                  @if(session('session_case')->id==$case->id)
                                      <button disabled class="btn btn-success btn-block btn-sm">
                                        <i class="fa fa-check"></i> 
                                  Seleccionado
                                        </button>
                                  @else

                              <a href="/oficina?user_case_id={{$case->id}}" class="btn btn-success btn-block btn-sm">
                                    <i class="fa fa-check"></i> 
      Selecionar
                                    </a>
                      @endif
                      @else
      <a href="/oficina?user_case_id={{$case->id}}" class="btn btn-success btn-sm">
                                    <i class="fa fa-check"></i> 
      Selecionar
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

