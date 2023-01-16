@extends('layouts.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->
@endpush

@section('navbar')
<!-- aqui va el menu de cada vista -->
  @include('content.roles_admin.navbar')
@endsection

@section('content')
<div class="content-header">
  {{-- <section class="content-header">
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

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

       <!-- include('components.callout_info') -->

        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h6 class="card-title">
                 Roles
                
                </h6>
              </div>
              <div class="card-body">
   
              <div class="row">
                <div class="col-md-4" id="content_form">
                <div class="card card-light">
                   <div class="card-header"  style="min-height:50px">
                     Nuevo rol
                  </div>
                <div class="card-body">
                <form class="for" action="{{url('roles')}}" id="myFormCreateRole">
                    @csrf
                    <input type="hidden" required class="form-control" id="id" name="id">
                  
                    <div class="form-group">
                        <label for="display_name">Nombre largo</label>
                        <input type="text" required class="form-control" id="display_name" name="display_name">
                    </div>

                    <div class="form-group">
                        <label for="name">Nombre corto</label>
                        <input type="text" required class="form-control" id="name" name="name">
                    </div>

                    <div class="form-group">
                        <label for="description">Descripción</label>
                    <textarea required class="form-control" name="description" rows="2" id="description"></textarea>    
                    </div>

                    <button type="submit" id="btn_save_role" name="button" class="btn btn-success btn-block">Guardar</button>
                    
                    <button type="button" style="display:none" data-form="myFormCreateRole" id="btn_save_cancel" class="btn btn-default btn-block">Cancelar</button>
                    
                </form>
                </div>

                </div>
              
                

                </div>

                <div class="col-md-8">

            <div class="card-body table-responsive p-0 ">
            <div class="card card-light ">
              <div class="card-header"  style="min-height:50px">
                <div class="card-tools"> 
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body content_ajax">
               @include('content.roles_admin.roles_list_ajax')
              </div>
            </div>
               
            </div>
                </div>


              </div>

              </div>
              <!-- /.card-body -->
            </div>

          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
      </div><!-- /.container-fluid -->

    </section>
    <!-- /.content -->

@endsection

@push('scripts')
<!-- aqui van los scripts de cada vista -->

@endpush

