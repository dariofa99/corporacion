@extends('layouts.dashboard')

@push('styles')
    <!-- aqui van los estilos de cada vista -->
@endpush

@section('navbar')
    <!-- aqui va el menu de cada vista -->
    @include('content.users.navbar')
@endsection

@section('content')
    <div class="content-header">
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
                                    <i class="fas fa-users"></i>
                                    Usuarios
                                </h3>
                               
                                <form class="form-inline " id="myFormSearchIndex" action="/admin/users">
                                  <input type="hidden" value="{{$roles}}" id="data_roles"> 
                                  <div class="col-md-5 offset-md-2">
                                        <div class="form-group justify-content-end">
                                            <select class="form-control" name="type">
                                                <option value="view_all">Ver todo...</option>
                                                <option value="identification_number">No. identificación</option>
                                                <option value="user_name">Nombre</option>
                                                <option value="rol_type">Rol de usuario</option>
                                          </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5 ">
                                        <div class="input-group ">
                                            <input type="text" disabled="" id="types_text"
                                                class="form-control input_data" name="data" placeholder="Buscar..."
                                                aria-label="Buscar..." aria-describedby="basic-addon2">
                                         
                                            <select style="display:none" class="form-control input_data" name="data">
                                            
                                            </select>


                                            <div class="input-group-append">
                                                <button type="submmit" class="input-group-text" id="basic-addon2"> <i
                                                        class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            {{--  <div class="card-header" style="min-height:50px">
                

               <h3 class="card-title"></h3> <div class="card-tools"> 
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Buscar">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div> 
              </div> --}}
                                            <!-- /.card-header -->
                                            <div class="card-body table-responsive p-0" id="content_list_users_table">


                                                @include('content.users.partials.ajax.index')
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div><!-- /.row -->

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
        @include('content.users.partials.modals.create')
    @endsection

    @push('scripts')
        <!-- aqui van los scripts de cada vista -->
        <script type="module" src="{{ asset('our/js/user.js') }}"></script>

        <script>
            //const user = new User();

            (function() {
                



            })()
        </script>
    @endpush
