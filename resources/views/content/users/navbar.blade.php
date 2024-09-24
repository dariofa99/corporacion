<?php 

if(!isset($modo_nav_crl)){

//modo oscuro/claro barra lateral 
$modo_nav_crl="light";
$modo_sidebar="light";
//modo oscuro/claro nav superior 
$color_nav="white";
$modo_nav="light";

}

?>

  <nav class="main-header navbar navbar-expand navbar-{{ $color_nav  }} navbar-{{ $modo_nav  }}">

    <!-- Left navbar links -->
    <ul class="navbar-nav"> 
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      @can('ver_usuarios')
      <li class="nav-item ">
        <a href="/admin/users" class="nav-link">Listar <span class="d-none d-sm-inline-block">perfiles</span></a>
      </li>
      @endcan
      @can('crear_usuarios')
       <li class="nav-item nav_btn_estado">
        <a href="#" id="btn_create_nwus" class="nav-link">Nuevo <span class="d-none d-sm-inline-block">perfil</span></a>
      </li>
      @endcan


    </ul>

    <!-- 
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
     -->

    <!-- Right navbar links -->
   @include('content.navbar_right')


  </nav>