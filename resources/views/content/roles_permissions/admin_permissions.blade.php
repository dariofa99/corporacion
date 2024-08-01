@extends('layouts.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->

@endpush
@section('navbar')
@include('content.roles_permissions.header')
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content">
    <!-- Content Header (Page header) -->
  <section class="content-header mb-1">
    
    </section> 

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Roles y permisos</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>

          </div>
        </div>
        <div class="card-body" id="content_admin_permissions">
            <div class="row" style="font-size:14px">
                <div class="col-md-4" id="content_form">
                <div class="card card-dark">
                   <div class="card-header"  style="min-height:50px">
                     <h6>Nuevo permiso</h6>
                  </div>
                <div class="card-body">
                <form class="for" action="{{url('permissions')}}" id="myFormCreatePermission">
                    @csrf
                    <input type="hidden" required class="form-control" id="id" name="id">
                  
                    <div class="form-group">
                        <label for="display_name">Nombre largo</label>
                        <input type="text" required class="form-control" id="name" name="name">
                    </div>
{{-- 
                    <div class="form-group">
                        <label for="name">Nombre corto</label>
                        <input type="text" required class="form-control" id="name" name="name">
                    </div>

                    <div class="form-group">
                        <label for="description">Descripción</label>
                    <textarea required class="form-control" name="description" rows="2" id="description"></textarea>    
                    </div> --}}
                @if(Auth::user()->can('editar_permisos') || Auth::user()->can('crear_permisos'))
                    <button type="submit" id="btn_save_role" name="button" class="btn btn-success btn-block">Guardar</button>
                @endif   

                  
                    <button type="button" style="display:none" id="btn_save_cancel" class="btn btn-default btn-block">Cancelar</button>
                    
                </form>
                </div>

                </div>
              
                

                </div>

                <div class="col-md-8">

            <div class="card-body table-responsive p-0 ">
            <div class="card card-dark">
              <div class="card-header"  style="min-height:50px">
              <h6>Permisos activos</h6>
                <div class="card-tools"> 
                
                </div>
              </div>
              <div class="card-body content_permission_ajax" id="content_permission_ajax">
                @include('content.roles_permissions.ajax.list_permissions')              
              </div>
            </div>
               
            </div>
                </div>


              </div>
        </div>
        <!-- /.card-body -->
       
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@push('scripts')
<!-- aqui van los scripts de cada vista -->
<script src="{{asset('js/AdminRoles.js')}}?v={{ config('app.asset_version') }}"></script>

@endpush