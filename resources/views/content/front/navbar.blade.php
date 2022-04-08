<?php 
if(!isset($nav_crl_modo)){
//modo oscuro/claro barra lateral 
$nav_crl_modo="light";
$sidebar_modo="light";
//modo oscuro/claro nav superior 
$nav_color="white";
$nav_moo="light";
}
?>


  <nav class="main-header navbar navbar-expand navbar-{{ $nav_color  }} navbar-{{ $nav_moo  }}">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link"></a>
      </li>
      @if($receptions_count==0)
      <li class="nav-item" style="border-bottom: 2px solid #D6DBDF">
        <a href="#" id="btn_new_reception" class="nav-link"  title="Nuevo solicitud"> 
          <span class="d-none d-sm-inline-block">Solicitar nuevo caso</span></a>
      </li>
      @endif
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <!-- <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search"> -->
        <div class="input-group-append">
         <!--  <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i> 
          </button> -->
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    @include('content.navbar_right')

  </nav>