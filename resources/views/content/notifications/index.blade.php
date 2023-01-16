@extends('layouts.dashboard')

@push('styles')
    <!-- aqui van los estilos de cada vista -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css"
        integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />


    <style>
        body {
            margin-top: 20px;
            background-color: #f0f2f5;
        }

        .dropdown-list-image {
            position: relative;
            height: 2.5rem;
            width: 2.5rem;
        }

        .dropdown-list-image img {
            height: 2.5rem;
            width: 2.5rem;
        }

        .btn-light {
            color: #2cdd9b;
            background-color: #e5f7f0;
            border-color: #d8f7eb;
        }
    </style>
@endpush

@section('navbar')
    <!-- aqui va el menu de cada vista -->
    @include('content.notifications.navbar')
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
                {{-- <div class="row">
                    <div class="col">
                        <h3 class="card-title">
                            <i class="fas fa-users"></i>
                            Solicitantes
                        </h3>
                    </div>
                    <div class="col">
                    </div>
                </div> --}}
            </div>
            <div class="card-body">
                <div class="row justify-content-md-center">

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


                    <div class="col-lg-10 col-md-10">
                        <div class="box shadow-sm rounded bg-white mb-3">
                            <div class="box-title border-bottom p-3">
                                <h6 class="m-0">Notificaciones</h6>
                            </div>
                            <div class="box-body p-0" id="content-notifications">                          
                                @include('content.notifications.partials.ajax.index')                                
                            </div>

                            <div class="box-footer mt-3">
                                <button data-limit="10" class="btn btn-success btn-sm" id="btn_more_notifications"><i class="fa fa-plus"> </i> Ver más</button>
                            </div>
                        </div>                        
                    </div>
                   




                </div>
            </div>

        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->

@endsection

@push('scripts')
    <!-- aqui van los scripts de cada vista -->
   
@endpush
