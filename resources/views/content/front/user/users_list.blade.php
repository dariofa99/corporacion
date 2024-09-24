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
{{--   <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>
                Modals & Alerts 
                <small>new</small>
              </h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Modals & Alerts</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
  </section> --}}
    <!-- /content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

       <!-- include('components.callout_info') -->
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
   <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

   
@endif

        <div class="row">
       

          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-users"></i>
                  Perfiles
                </h3>
              </div>
              <div class="card-body"> 
   
                <div class="row">
          <div class="col-12">
            <div class="table">
              <div class="card-header" style="min-height:50px">
                <h3 class="card-title"></h3>

               {{--  <div class="card-tools"> 
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Buscar">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div> --}}
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
               <table class="table table-bordered">
                <thead class="thead-dark">
                  <tr class="text-center">
                    <th>Nombres</th>
                    <th>No. Identificación</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Acciones</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($users as $user )
                    <tr>
                      <td>{{$user->name}}</td>
                      <td>{{$user->identification_number}}</td>
                      <td>{{$user->phone_number}}</td>                      
                      <td>{{$user->email}}</td>
                      <td class="text-center">
                      @if(Auth::user()->can('edit_usuarios'))
                      <a href="/admin/users/{{$user->id}}/edit" class="btn btn-primary">Editar</a>
                      @endif
                      @if(Auth::user()->can('delete_usuarios'))
                      <a href="#" id="{{$user->id}}"  class="btn btn-danger btn_delete_user">Eliminar</a>
                      @endif
                      </td>
                      
                  </tr>
                  @endforeach
                  
                   </tbody>
                  </table>
                  <hr>
                   {{ $users->appends(request()->query())->links() }}
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div><!-- /.row -->

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
@include('content.users.partials.modals.create')
@endsection

@push('scripts')
<!-- aqui van los scripts de cada vista -->
<script>  
  (function(){
    $("#btn_create_nwus").on('click',function(e){
      e.preventDefault();
      $("#myModal_create_user").modal('show');
    });

    $("#myformCreateUser").on('submit',function(e){
       $("#myModal_create_user").modal('hide');
         Swal.fire({
          title: 'Creando...',
          html: 'Espere por favor <strong></strong> .',
          timer: 2000,
          onBeforeOpen: () => {
            Swal.showLoading()
            timerInterval = setInterval(() => {      
            }, 100)
          } 
        });
    })

    $(".btn_delete_user").on('click',function(e){
      e.preventDefault();
      id = $(this).attr('id');
      Swal.fire({
      title: '¿Estas seguro de eliminar el registro?',
      text: "Los cambios no pueden ser revertidos!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'SI, eliminar!',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      if (result.value) {
       deleteUser(id)
      }
    });
     
    })

  })()

function deleteUser(id){

  var route = "/admin/users/"+id ;  

        	$.ajax({
			url: route,
			type: 'DELETE',
			datatype: 'json',
			data: {},
			cache: false,
			beforeSend: function (xhr) {
				xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
          Swal.fire({
          title: 'Eliminando...',
          html: 'Espere por favor <strong></strong> .',
          timer: 2000,
          onBeforeOpen: () => {
            Swal.showLoading()
            timerInterval = setInterval(() => {      
            }, 100)
          } 
        });
   
			},
			/*muestra div con mensaje de 'regristrado'*/
			success: function (res) {
        window.location.reload(true)
			},
			error: function (xhr, textStatus, thrownError) {
				alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
			}
		});
}
</script>

@endpush

