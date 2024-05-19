
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-{{ $sidebar_modo }}-primary elevation-4" style="background-color:#493d79">
    <!-- Brand Logo -->
    
      <a href="/home" class="brand-link" style="background-color: #ffffff;text-align: center;" >    
        <img src="{{asset('/dist/img/Logo_horizontal.png')}}" alt="Lybra" class="img-fluid"
            style="width:80px">
        <span class="brand-text font-weight-{{ $sidebar_brand_modo }}"></span>   </span>     
      </a>
    

    <!-- Sidebar -->
    <div class="sidebar" style="top:5px">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <a href="/admin/users/{{auth()->user()->id}}/edit" title="Ingresar a perfil">
          <img src="{{asset(auth()->user()->image)}}" id="image_profile_user_sidebar" class="img-circle elevation-2 image_profile" alt="User Image">
      
          </a>
        </div>
        <div class="info">
          <a href="/admin/users/{{auth()->user()->id}}/edit" id="name_profile_user_sidebar" title="Ingresar a perfil">{{Auth::user()->name}}</a>
          
<a  href="{{ route('logout') }}"
                                  onclick="event.preventDefault();setToken();
                                    document.getElementById('logout-form').submit();">
                                    <br>
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
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
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
           <li class="nav-item">
            <a href="/casos" class="nav-link">
              <i class="nav-icon fas fa-folder"></i>
              <p>
                Casos
                <span class="right badge badge-info">{{$num_cases}}</span>
              </p>
            </a>
          </li> 
          @if($num_recep>0)
          <li class="nav-item">
            <a href="/recepciones" class="nav-link">
              <i class="nav-icon fas fa-clipboard"></i>
              <p>
                Recepciones
                <span class="badge badge-info right">{{$num_recep}}</span>
              </p>
            </a>
          </li>
          @endif
          <li class="nav-item">
            <a href="/agenda" class="nav-link">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Agenda
                <span class="badge badge-info right">{{ $num_diarys }}</span>
              </p>
            </a>
          </li>
     

          <li class="nav-item">
            <a href="/clientes" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Solicitantes 
                <span class="badge badge-info right">{{$clients_c}}</span>
              </p>
            </a>
          </li>
 

          <li class="nav-item">
            <a href="/directorio" class="nav-link">
              <i class="nav-icon fa fa-address-book"></i>
              <p>
                Directorio
                <span class="badge badge-info right">{{$directories}}</span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/biblioteca" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Biblioteca
                <span class="badge badge-info right">{{$library_c}}</span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/reportes" class="nav-link">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>
                Reportes
               {{--  <span class="badge badge-info right">0</span> --}}
              </p>
            </a>
          </li>
          
          @can('ver_administracion')
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Administración
                <i class="fas fa-angle-left right"></i>
                {{-- <span class="badge badge-info right">6</span> --}}
              </p>
            </a>
            <ul class="nav nav-treeview">

@can('ver_roles_permisos')
              <li class="nav-item ml-3">
                <a href="/admin/roles" class="nav-link">
                  <i class="fas fa-users-cog nav-icon"></i>
                  <p>Roles y Permisos</p>
                </a>
              </li>
              @endcan
            @can('ver_usuarios')
              <li class="nav-item ml-3">
                <a href="{{route('users.index')}}" class="nav-link">
                  <i class="fas fa-user-plus nav-icon"></i>
                  <p>Usuarios</p>
                </a>
              </li>
              @endcan
              @can('ver_categorias')
              <li class="nav-item ml-3">
                <a href="{{route('categorias.index')}}" class="nav-link">
                  <i class="fas fa-bars nav-icon"></i>
                  <p>Categorias</p>
                </a>
              </li>
              @endcan
              @can('ver_auditoria')
              <li class="nav-item ml-3">
                <a href="{{route('auditoria.index')}}" class="nav-link">
                  <i class="fas fa-database nav-icon"></i>
                  <p>Auditoria</p>
                </a>
              </li>
              @endcan
          {{--     <li class="nav-item">
                <a href="pages/layout/fixed-footer.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fixed Footer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/collapsed-sidebar.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Collapsed Sidebar</p>
                </a>
              </li> --}}
            </ul>
          </li>
@endcan
@can('ver_administracion')
<li class="nav-item has-treeview ">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-mobile-alt"></i>
    <p>
      Botón de pánico
      <i class="fas fa-angle-left right"></i>
      {{-- <span class="badge badge-info right">6</span> --}}
    </p>
  </a>
  <ul class="nav nav-treeview">


    <li class="nav-item ml-3">
      <a href="{{route('panic.alerts')}}" class="nav-link">
        <i class="fas fa-bell nav-icon"></i>
        <p>Alertas</p>
      </a>
    </li>
 
  @can('ver_usuarios')
    <li class="nav-item ml-3">
      <a href="{{route('panic.directories')}}" class="nav-link">
        <i class="fas fa-address-card nav-icon"></i>
        <p>Usuarios - Directorio</p>
      </a>
    </li>
    @endcan
    
  


{{--     <li class="nav-item">
      <a href="pages/layout/fixed-footer.html" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Fixed Footer</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="pages/layout/collapsed-sidebar.html" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Collapsed Sidebar</p>
      </a>
    </li> --}}
  </ul>
</li>
@endcan

  
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>