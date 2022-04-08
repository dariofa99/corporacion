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
    width: auto;
    height:80px;
}
    </style>
</head>
<body>

<table>
<thead>
<th colspan="2" align="center">
<img src="{{asset('/dist/img/legalis.jpg')}}" alt="User Image" >
</th>
</thead>
<tbody>
<tr>
<td colspan="2">
@if($notification_message=='documento')
    {{ env("MAIL_FROM_NAME") }} ha creado un nuevo documento en tu cuenta, ingresa para ver más sobre esta novedad.
  @elseif($notification_message=='notificacion')
     {{ env("MAIL_FROM_NAME") }} ha creado una nueva notificación en tu cuenta, ingresa para ver más sobre esta novedad.
@elseif($notification_message=='cliente')
   Solicitante {{auth()->user()->name}}, con número de caso <b>{{$caseL->case->case_number}}</b>, ha enviado un nuevo documento.
    <b>{{$caseL->files[0]->original_name}}</b>. Ingresa al sistema para ver más sobre esta novedad. <a href="{{url('/pruebas')}}">Aqui</a>
@endif   
</td>
</tr>

<tr>
<td colspan="2">


</td>
</tr>

</tbody>
</table>
<hr>
<i> AMATAI, Ingeniería Informática SAS.</i>
   {{--  <p> <strong>Fecha</strong> 
     {!! \Carbon\Carbon::parse($fecha)->diffForHumans()!!}</p>
   <p> <strong>Hora</strong> {!!$hora!!}</p>   
   <p> <strong>Motivo</strong> {!!$motivo!!}</p> --}}
 
</body>
</html>