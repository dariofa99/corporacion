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

@livewireStyles
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
      @include('front.sidebar')
    <!-- /:main Sidebar Container -->
    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->  
      <input type="hidden" id="inputHash" value="{{sha1(Auth::user()->id)}}">
      <input type="hidden" id="connectedData" value='{"username":"{{Auth::user()->name}}","idusuario":"{{Auth::user()->id}}","correo":"{{ Auth::user()->email }}","imagen":"{{ asset(auth()->user()->image) }}"}'>




    @yield('content')

  


    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    @include('content.front.modals.client_streaming')

    <!-- Main Footer -->
      @include('front.footer')
    <!-- /:main Footer -->
  </div>
  <!-- ./wrapper -->
<div id="wait" style="display:none; position: absolute; width: 100%;min-height: 100%;height: auto;position: fixed;top:0; left:0;background-color: rgba(236, 240, 245, 0.8);" ><img src="{{asset('img/logo2.png')}}" id="load" width="67" height="71" style="margin-top:18%;margin-left:48%;padding:2px;" /><br><span style="margin-top:18%;margin-left:48%;padding:2px;color:#848484;font-size: 16px;">Cargando...<span></div>

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

<!-- OPTIONAL SCRIPTS -->
<script src="{{asset('dist/js/demo.js')}}?v={{ config('app.asset_version') }}"></script>

<!-- PAGE PLUGINS -->

<!-- moment -->
<script src="{{ asset('plugins/moment/moment.min.js')}}?v={{ config('app.asset_version') }}"></script>
<script src="{{ asset('plugins/moment/locale/es-us.js')}}?v={{ config('app.asset_version') }}"></script>
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}?v={{ config('app.asset_version') }}"></script> 
<script src="{{asset('plugins/toastr/toastr.min.js')}}?v={{ config('app.asset_version') }}"></script>
<!-- ChartJS -->
<!-- PAGE SCRIPTS -->
 @livewireScripts
<!-- NewPush -->
  <script>var tokendefault = 'sfdsdf';</script>
  {{-- <script src="{{ asset('plugins/new-push/io.js')}}?v={{ config('app.asset_version') }}"></script>
  <script src="{{asset('our/js/pusher.js')}}?v={{ config('app.asset_version') }}"></script>
  <script src="{{asset('our/js/newpush.js')}}?v={{ config('app.asset_version') }}"></script>
  <script src="{{asset('our/js/pushconnected.js')}}?v={{ config('app.asset_version') }}"></script> --}}
  
  <!-- our scripts -->
{{--   <script src="{{asset('our/js/AdminRoles.js')}}?v={{ config('app.asset_version') }}"></script> --}}
  <script src="{{asset('our/js/scripts.js')}}?v={{ config('app.asset_version') }}"></script>
  <script src="{{asset('our/js/Case.js')}}?v={{ config('app.asset_version') }}"></script>
  <script src="{{asset('our/js/front.js')}}?v={{ config('app.asset_version') }}"></script>
  <script src="{{asset('our/js/reception.js')}}?v={{ config('app.asset_version') }}"></script>


  <!-- PAGE PLUGINS -->
@stack('scripts')
@include('content.scripts')
