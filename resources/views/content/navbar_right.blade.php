<ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
          <span class="badge badge-danger navbar-badge lbl_chatCountUsers">0</span>
        </a> 
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="list_users_login">

      {{--     <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a> --}}

          <div class="dropdown-divider"></div>


          <div class="dropdown-divider"></div>
          {{-- <a href="#" class="dropdown-item dropdown-footer">Cargando usuarios...</a> --}}
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
   <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">
            {{count(auth()->user()->notifications )}}
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">
           Notificaciones</span>

            <div class="notification_content">
              @foreach(auth()->user()->notifications as $key => $notification)
         
              <div class="dropdown-divider"></div>
              <a @if(isset($notification->data['url']) and $notification->data['url'] and $notification->data['url']!='undefined') href="{{$notification->data['url']}}"  @endif class="dropdown-item">
                <i @if(isset($notification->data['icon']) and $notification->data['icon']
                 and $notification->data['icon']!='undefined')
                   class="{{$notification->data['icon']}} mr-2" @else class="fas fa-bell" @endif>
                  
                  </i>
                     <small class="itemnot">{{$notification->data['message']}}</small>
               
                
                
       
                <span class="float-right text-muted text-sm">{{$notification->data['created_at']}}</span>
              </a> -
              
              @endforeach
            </div>

       
         
         {{--  <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a> --}}
          <div class="dropdown-divider"></div>
         {{--  <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> --}}
        </div>
      </li>
      <!-- 
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
            class="fas fa-th-large"></i></a>
      </li>
       -->
</ul>