<?php

if (!isset($nav_crl_modo)) {
    //barra lateral izquierda
    $sidebar_modo = 'dark';
    $sidebar_color = '#191d36';
    $sidebar_brand_modo = 'dark';
    $sidebar_brand_color = '#191d36';
    //barra navegación superior
    $nav_color = 'white';
    $nav_modo = 'dark';
    $nav_crl_modo = 'light';
}

?>




<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-{{ $sidebar_modo }}-primary elevation-4" style="background-color:#493d79">
    <!-- Brand Logo -->

    <a href="/oficina" class="brand-link" style="background-color:#ffffff; padding: .4125rem .5rem;text-align: center;">
        <img src="{{ asset('/dist/img/logoliderezasheader.png') }}" alt="Lybra" class="img-fluid"
            style="border-radius: 20px;">
        <span class="brand-text font-weight-{{ $sidebar_brand_modo }}"></span> </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset(auth()->user()->image) }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="/oficina/user/edit/{{ Auth::user()->id }}" class="d-block">{{ Auth::user()->name }}</a>

                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    {{ __('Salir') }}
                </a>
            </div>

            <hr>


            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                {{--     <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Expedientes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nuevo expediente</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li>
            </ul>
          </li> --}}
                @if ($num_cases > 1)
                    <li class="nav-item ">
                        <a href="{{ route('oficina.index') }}" class="nav-link {{ active('oficina') }}">
                            <i class="nav-icon fa fa-reply-all"></i>
                            <p></p>
                            Cambiar
                            <span class="badge badge-info right">{{ $num_cases }}</span>
                            </p>
                        </a>
                    </li>
                @endif


                @if (session()->has('session_reception'))
                    <li class="nav-item">
                        <a href="{{ route('office.reception', session('session_reception')->id) }}"
                            class="nav-link {{ active('oficina/chat/view') }}">
                            <i class="nav-icon fa fa-comments "></i>
                            <p>
                                Chat
                                <span id="lbl_chatCountUsers"
                                    class=" lbl_chatCountUsers right badge badge-success">0</span>
                            </p>
                        </a>
                    </li>
                @elseif(session()->has('session_case'))
                    <li class="nav-item">
                        <a href="{{ route('office.chat') }}" class="nav-link {{ active('oficina/chat/view') }}">
                            <i class="nav-icon fa fa-comments "></i>
                            <p>
                                Chat
                                <span id="lbl_chatCountUsers"
                                    class=" lbl_chatCountUsers right badge badge-success">0</span>
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('office.docs') }}" class="nav-link {{ active('oficina/documentos/view') }}">
                            <i class="nav-icon fa fa-folder-open"></i>
                            <p>
                                Documentos
                                <span class="badge badge-info right">
                                    {{ count(session('session_case')->logs()->where('type_status_id', '!=', 15)->where('type_log_id', 22)->get()) }}</span>
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('office.notification') }}"
                            class="nav-link {{ active('oficina/notificaciones/view') }}">
                            <i class="nav-icon fa fa-info-circle"></i>
                            <p>
                                Notificaciones
                                <span
                                    class="badge badge-info right">{{ count(session('session_case')->logs()->where('type_log_id', 23)->get()) }}</span>
                            </p>
                        </a>
                    </li>



                    <li class="nav-item">
                        <a href="{{ route('office.diary') }}" class="nav-link {{ active('oficina/diary/view') }}">
                            <i class="nav-icon far fa-calendar-alt"></i>
                            <p>
                                Agenda
                                <span
                                    class="badge badge-info right">{{ count(auth()->user()->diarys()->where('inicio', '>=', date('Y-m-d H:i:s'))->get()) }}</span>
                            </p>
                        </a>
                    </li>
                @endif






            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
