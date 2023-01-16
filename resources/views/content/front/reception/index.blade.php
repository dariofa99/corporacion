@extends('front.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->
@endpush

@section('navbar')
<!-- aqui va el menu de cada vista -->
  @include('content.front.navbar')
@endsection

@section('content')

         <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
         
        </div>
      </div><!-- /.container-fluid -->
    </section>
<!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
     <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Recepción de caso </h3>

                <div class="card-tools">
                  <!--
                  <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                   /.option -->
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                <div class="row d-flex justify-content-center">               
                  <div class="col-md-9">
                    <div class="card">
                      <div class="card-body">
                        @if(session('session_chat_token'))
                        @include('content.chat.chat',[
                              'token'=>session('session_chat_token'),
                          ]) 
                          @else
                          <div class="alert alert-info">
                              Activar chat
                          </div>
                        @endif
                      </div>
                    </div>                  
                  </div>
                </div> 

              </div>
              <!-- /.card-body -->
        </div>

    </section>
    <!-- /.content -->


@endsection

@push('scripts')
<!-- aqui van los scripts de cada vista -->
<script>
(function(){
    $(".chat_open").on("click",function(){
        var user_ds_id = $(this).attr('data-id');
        var user_ds_name = $(this).text();
        var user_name = "{{Auth::user()->name}}";
        var user_id = "{{Auth::user()->id}}";
        var image = "{{Auth::user()->image}}";

        var request = `user_name=${user_name}&
                       user_id=${user_id}&
                       user_ds_id=${user_ds_id}&
                       user_ds_name=${user_ds_name}&
                       image=${image}`;

        var src = "http://127.0.0.1:7000/chat?"+request;
        console.log(src)
         $("#chat_iframe").attr("src", src)
    })

   
    
  })();




      
    </script>



@endpush

