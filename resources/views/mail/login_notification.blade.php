 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    table  {
width:100%;

}

table thead {
border:1px solid #000000; 
text-align:center;

}
img{
    width:auto;
    height:80px;
}
    </style>
</head>
<body>

<table>
<thead>
<th colspan="2" align="center">
<img src="{{asset('/dist/img/legalis.jpg')}}" alt="User Image">
</th>
</thead>
<tbody>
<tr>
<td colspan="2">
    Se ha detectado un inicio de sesión desde un equipo 
     @if($session->locked)   
     registrado como
    <strong> BLOQUEADO</strong>  @if($session->confirm) y <strong> CONFIRMADO</strong> @endif
    @elseif($session->confirm)
    registrado como <strong>SEGURO</strong> 
    @if($session->logout)
        y con la<strong> SESIÓN CERRADA</strong>
    @endif
    @else  

   sin confirmar @if($session->logout)
        y con la<strong> SESIÓN CERRADA</strong>
    @endif

 
@endif
 en tu cuenta de {{ env("MAIL_FROM_NAME") }}.<br>   
</td>
</tr>

<tr>
<td width="10%">Fecha y hora</td><td>{{$data['time']}}</td>
</tr>
<tr>
<td>Lugar</td><td>{{$data['city'] != '' ? $data['city'] ."," : '' }} {{$data['country']}}</td>
</tr>
<tr>
<td>Navegador</td><td>{{$data['browser']}}</td>
</tr>
<tr>
<td>Sistema Operativo</td><td>{{$data['os']}}</td>
</tr>
<tr>
<td colspan="2">

@if($session->locked)   
   Si<strong> NO has sido tú</strong> y crees que hay problemas de seguridad, te recomedamos cambiar la contraseña.</strong>  
   {{-- <strong> SI has sido tú</strong> y quieres <strong> DESBLOQUEAR EL EQUIPO</strong> , dar clic en el siguiente <a target="_blank" href="{{url('/token/admin/session/'.$session->token_confirm.'/unlocked')}}">enlace</a> para bloquear el equipo.<br>
 --}}
 
@elseif(!$session->confirm and !$session->logout)   
   Para confirmar como un equipo seguro, dar clic en el siguiente <a target="_blank" href=" {{url('/token/admin/session/'.$session->token_confirm.'/confirm')}}">enlace. </a> <br>
   Si <strong>NO</strong> has sido tú, dar clic en el siguiente <a target="_blank" href="{{url('/token/admin/session/'.$session->token_confirm.'/locked')}}">enlace</a> para bloquear el equipo.<br>
   Si solamente quieres <strong>CERRAR LA SESIÓN</strong>, da clic en el siguiente <a target="_blank" href="{{url('/token/admin/session/'.$session->token_confirm.'/logout')}}">enlace</a>.
@elseif($session->logout)   
   Para confirmar como un equipo seguro y habilitar nuevamente la sesión, dar clic en el siguiente <a target="_blank" href=" {{url('/token/admin/session/'.$session->token_confirm.'/unconfirmed')}}">enlace. </a> <br>

@endif
</td>
</tr>

</tbody>
</table>
<hr>
<i> AMATAI, Ingeniería Informática SAS. </i>
   {{--  <p> <strong>Fecha</strong> 
     {!! \Carbon\Carbon::parse($fecha)->diffForHumans()!!}</p>
   <p> <strong>Hora</strong> {!!$hora!!}</p>   
   <p> <strong>Motivo</strong> {!!$motivo!!}</p> --}}
 
</body>
</html>