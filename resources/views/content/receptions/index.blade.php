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
                <form class="form-inline " id="myFormSearchIndex" action="/recepciones">
                    <div class="col-md-5 offset-md-2">
                        <div class="form-group justify-content-end">
                            <select class="form-control" name="type">
                                <option value="view_all">Ver todo...</option>
                                <option value="case_number">No. solicitud</option>
                                <option value="identification_number">No. identificación</option>
                                <option value="user_name">Nombre</option>
                                <option value="created_at">Fecha de creación</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5 ">
                        <div class="input-group ">
                            <input type="text" disabled id="types_text" class="form-control input_data" name="data"
                                placeholder="Buscar..." aria-label="Buscar..." aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button type="submmit" class="input-group-text" id="basic-addon2"> <i
                                        class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <div class="row">
                    <div class="col-12 table-responsive p-0" id="content_cases">

                      @include('content.receptions.partials.ajax.index')

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
