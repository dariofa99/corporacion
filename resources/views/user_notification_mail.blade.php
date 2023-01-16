@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Notificaciones Judiciales</div>
<div class="card-body">
@if(request()->session()->has('file'))
                
                   <h5> Esta es una notificación oficial de Legalis S.A.S, para mayor información descargue el documento.
                 </h5><br>
                 <h6>El enlace caducará al cerrar la ventana!</h6>
                 <hr>
                 <a href="/notificaciones/download/log/{{session('file')->id}}" target="_blank" class="btn btn-primary btn-block"><i class="fa fa-download"></i> Descargar archivo</a>
            

            @else
 <h4>El enlace está disponible solo una vez.<br>
 Para mayor información comunícate con nosotros! </h4> <br>
 <h5>
    <b>Celular:</b> 3185460451 <br>
    <b>Correo electrónico:</b> contacto@legalisabogados.com <br>
    <b>Dirección Oficinas:</b> Calle 19 # 22-66 Centro. <small><br><i>( A uncostado de la notaría 4 o
    frente al Paraninfo de la universidad de Nariño sede centro)</i></small><br>
 </h5>



@endif
    </div>
            </div>
        </div>
    </div>
</div>
@endsection
