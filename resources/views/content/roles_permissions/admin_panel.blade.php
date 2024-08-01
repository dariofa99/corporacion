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
        <div class="card-body table-responsive" >
         <table id="table_list" class="table">
        <thead>
          <th width="5%">
          </th>
          @foreach($roles as $key => $rol)         
          <th align="center">
           <center>{{$rol->name}}</center> 
          </th>
          @endforeach      
        </thead>
        @foreach($permissions as $key => $permission)
          <tr>
            <td>
              {{$permission->name}}
            </td>
            @foreach($roles as $key_2 => $rol)
            <td align="center">              
              <input @if($rol->permissions()->where('permissions.id',$permission->id)->first()) checked @endif type="checkbox" class="check_permis_role" data-rol="{{$rol->id}}" data-permission="{{$permission->id}}">
            </td>          
            @endforeach
          </tr>
        @endforeach    
         </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          Footer
        </div>
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