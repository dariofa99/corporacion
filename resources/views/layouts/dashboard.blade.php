<?php 

if(!isset($modo_nav_crl)){

//barra lateral izquierda
$modo_nav_crl="light";
$sidebar_modo="dark";
$sidebar_color="#191d36";
$sidebar_brand_modo="dark";
$sidebar_brand_color="#191d36";
//barra navegación superior 
$color_nav="white";
$modo_nav="dark";

}

?>






<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  
    <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}" id="token"> 
  <title>{{env('APP_NAME','Lybra')}}</title>
  
  <link rel="shortcut icon" href="{{ asset('dist/img/favicon.png') }}">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}?v={{ config('app.asset_version') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}?v={{ config('app.asset_version') }}">
 
  <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}?v={{ config('app.asset_version') }}">
 <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}?v={{ config('app.asset_version') }}">
 
 
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}?v={{ config('app.asset_version') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- Custom -->
  <!-- <link href="{{ asset('our/css/custom.css') }}" rel="stylesheet"> -->



  <!-- Style plugins -->
    @stack('styles')
  <!-- our styles -->
  
    <!-- Our Styles -->
    <link href="{{ asset('our/css/app.css') }}?v={{ config('app.asset_version') }}" rel="stylesheet">


</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
 
  <div class="wrapper">
    <!-- Navbar -->
      @yield('navbar')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
      @include('layouts.sidebar')
    <!-- /:main Sidebar Container -->
    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      @include('content.frm_modal_showmessage')
      <!-- Content Header (Page header) -->  
       <input type="hidden" id="olderInputValue">
       <input type="hidden" id="inputHash" value="{{sha1(Auth::user()->id)}}">
       <input type="hidden" id="connectedData" value='{"ver_conectados_chat":"{{Auth::user()->can("ver_conectados_chat") ? "true": "false"}}","role":"{{(Auth::user()->roles[0]->name)}}","username":"{{Auth::user()->name}}","idusuario":"{{Auth::user()->id}}","correo":"{{ Auth::user()->email }}","imagen":"{{ asset(auth()->user()->image) }}"}'>
        
      
    @yield('content')
    
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-{{ $modo_nav_crl  }}">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
      @include('layouts.footer')
    <!-- /:main Footer -->
  </div>
  <!-- ./wrapper -->
   <!-- wait  es la barra de carga de la pagina-->
  <div id="wait" style="display:none; position: absolute; width: 100%;min-height: 100%;height: auto;position: fixed;top:0; left:0;background-color: rgba(236, 240, 245, 0.8);" >
    <div class="container" style="margin-top:15%;padding:2px;">
      <div class="row justify-content-md-center">
        <div class="col col-lg-2">
         
        </div>
        <div class="col-md-auto text-center ">
          <img src="{{asset('img/logo2.png')}}" id="load" width="67" height="71"/><br>
          <span style="color:#515151;font-size: 16px;">Cargando...</span>
          
        </div>
        <div class="col col-lg-2">
        
        </div>
      </div>
            <div class="row justify-content-md-center">
        <div class="col col-lg-2">
         
        </div>
        <div class="col-md-auto text-center justify-content-center" >
          <div class="progress" id="progressbarwait"  style="min-width: 350px; height: 21px; background-color: #a5a5a5; display: none; ">
	          <div class="progress-bar progress-bar-striped" id="progressGeneral" style="width:0%; height: 21px;">0%</div>
          </div>        
        </div>
        <div class="col col-lg-2">
        
        </div>
      </div>
    </div>

  </div>
  <!-- ./wait  es la barra de carga de la pagina-->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}?v={{ config('app.asset_version') }}"></script>
<!-- jQuery UI -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}?v={{ config('app.asset_version') }}"></script>
<!-- Bootstrap -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}?v={{ config('app.asset_version') }}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}?v={{ config('app.asset_version') }}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}?v={{ config('app.asset_version') }}"></script>
<!-- moment -->
<script src="{{ asset('plugins/moment/moment.min.js')}}?v={{ config('app.asset_version') }}"></script>
<script src="{{ asset('plugins/moment/locale/es-us.js')}}?v={{ config('app.asset_version') }}"></script>
<!-- NewPush -->
<script>var tokendefault = '';</script>
{{-- <script src="{{ asset('plugins/new-push/io.js?v=1')}}?v={{ config('app.asset_version') }}"></script> --}}

<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

<link  href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<!-- OPTIONAL SCRIPTS -->
<script src="{{asset('dist/js/demo.js')}}?v={{ config('app.asset_version') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>


<!-- PAGE PLUGINS -->


<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}?v={{ config('app.asset_version') }}"></script>
<script src="{{asset('plugins/toastr/toastr.min.js')}}?v={{ config('app.asset_version') }}"></script>
<!-- ChartJS -->
<!-- PAGE SCRIPTS -->
<script src="{{ asset('js/app.js') }}?v={{ config('app.asset_version') }}" ></script>


  <!-- our scripts -->
  
  {{-- <script src="{{asset('our/js/pusher.js')}}?v={{ config('app.asset_version') }}"></script>
  <script src="{{asset('our/js/pushconnected.js')}}?v={{ config('app.asset_version') }}"></script>
  <script src="{{asset('our/js/newpush.js')}}?v={{ config('app.asset_version') }}"></script> --}}
  <script src="{{asset('our/js/app.js')}}?v={{ config('app.asset_version') }}"></script>
 {{--  <script src="{{asset('our/js/AdminRoles.js')}}?v={{ config('app.asset_version') }}"></script> --}}
 
  <script type="module" src="{{asset('our/js/scripts.js')}}?v={{ config('app.asset_version') }}"></script>
  <script type="module" src="{{asset('our/js/Case.js')}}?v={{ config('app.asset_version') }}"></script>

  <script>//para que funcionen los tooltip
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });
  </script>
  <!-- PAGE PLUGINS -->
@include('content.scripts') 
@stack('scripts')




