@extends('layouts.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->
@endpush

@section('navbar')
<!-- aqui va el menu de cada vista -->
  @include('content.users.navbar')
@endsection

@section('content')
<div class="content-header">


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
 
       <!-- include('components.callout_info') -->

        <div class="row"> 
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-users"></i>
                  Actualizando perfil

                  @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



                

                </h3>
              </div>
              <div class="card-body">
   
                 <div class="container">
        
<div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center" style="position:relative !important">
                @if($canedit) <div id="change_photo"><i class="fa fa-camera"></i></div> @endif
                  <img id="image_profile" class="profile-user-img img-fluid img-circle" src="{{asset($user->image)}}" alt="User profile picture">
               <div class="progress" style="margin-top:2px;display:none" id="progress_bar"> 
                <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">25%</div>
              </div>
                </div>

                <h3 id="lbl_user_p_name" class="profile-username text-center lbl_user_name">{{$user->name}}</h3>

                <p class="text-muted text-center" id="lbl_rol_name"> 
                   
                {{ (count($user->roles)>0) ? $user->roles[0]->name : 'Asignar rol' }}
                </p>

            {{--     <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Casos asistidos</b> <a class="float-right">122</a>
                  </li>
                  <li class="list-group-item">
                    <b>Casos abiertos</b> <a class="float-right">53</a>
                  </li>
                 
                </ul> --}}
 @can('asig_rol')
                <a href="#" id="btn_asignar_rol" class="btn btn-warning btn-xs btn-block"><b>Cambiar rol</b></a>
                @endcan
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
  
            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Sobre mí</h3>
                <div class="float-right"> 
               @if($canedit and auth()->user()->can('crear_categorias')) <i class="fa fa-plus-circle btn_add_data_user" title="Agregar campo" data-section="about_me" id="btn_add_am_data_user"></i>@endif
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body setOlderValue" id="content_user_data_about_me">
                  @include("content.users.partials.ajax.about_me_component",[
                    'user'=>$user
                  ])
               </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                   <li class="nav-item">
                   <a class="nav-link active" href="#settings" data-toggle="tab">Información</a>
                   </li>
                 <li class="nav-item "><a class="nav-link" href="#timeline" data-toggle="tab">Otros datos</a></li>
                 @if($canedit)
                 <li class="nav-item "><a class="nav-link" href="#password" data-toggle="tab">Contraseña</a></li>
                @endif
                @if($canedit)
                <li class="nav-item "><a class="nav-link" href="#note" data-toggle="tab">Notas</a></li>
               @endif
              @if($canedit and auth()->user()->id != $user->id)
               <li class="nav-item "><a class="nav-link btn_chat" href="#chat" data-toggle="tab">Chat</a></li>
              @endif
                
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                    
                  <div class="tab-pane" id="timeline">
                              <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">    
                        @if($canedit and auth()->user()->can('crear_categorias'))  
                        <button title="Agregar campo" data-section="case" id="btn_add_ad_data_user" class="btn btn-success btn-block btn-sm btn_add_data_user" >
                           <i class="fa fa-plus-circle" > </i>
                          Agregar pregunta rápida</button>
                        @endif
                      </div>
                    </div>
                  </div>
                  
                    <div class="row setOlderValue" id="content_user_aditional_data">
                     @include("content.users.partials.ajax.aditional_data_component",[
                          'user'=>$user
                        ])
                    </div>
                    <hr> 
                    <div id="content_user_static_data">
                        @include('content.users.partials.ajax.static_data')
                    </div>
                


                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane active" id="settings">
                    @include("content.users.partials.form")
                  </div>
                  <!-- /.tab-pane -->

                                  <!-- /.tab-pane -->    
                  <div class="tab-pane" id="password">
                    @include("content.users.partials.password")
                  </div>
                  <!-- /.tab-pane -->

                  <!-- /.tab-pane -->    
                    <div class="tab-pane" id="note">
                      <div class="row mb-1">
                        <div class="col-md-3">
                           @if($canedit and auth()->user()->can('crear_categorias'))  
                          <button title="Agregar nota"  id="bt_add_user_note" class="btn btn-success btn-block btn-sm " >
                             <i class="fa fa-sticky-note" > </i>
                            Agregar nota</button>
                          @endif</div>
                      </div>
                     
                      <div class="row">
                        <div class="col-md-12" id="content_user_notes">
                          @include("content.users.partials.ajax.note_component")
                        </div>
                      </div>
                      
                    </div>

                    <div class="tab-pane" id="chat">
                      @include("content.users.partials.chat")
                    </div>
                    <!-- /.tab-pane -->

                                  <!-- /.tab-pane -->
                

                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>

            
              </div><!-- /.container -->

              </div>
              <!-- /.card -->
            </div>

          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
      </div><!-- /.container-fluid -->

    </section>
    <!-- /.content -->

@include('content.users.partials.modals.asignacion_rol')
@include('content.users.partials.modals.user_data')
@endsection

@push('scripts')
<!-- aqui van los scripts de cada vista -->
<script type="text/javascript" src="{{asset('our/js/user.js')}}"></script>
@if(Request::has("chat"))
<script>
  $(".btn_chat").click();
</script>
@endif
@endpush

