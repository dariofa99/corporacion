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
<img src="{{asset('/dist/img/legalis.jpg')}}" alt="User Image" >
</th>
</thead>
<tbody>
<tr>
<td colspan="2">
<p align="justify">{!! nl2br(e($caseL->description)) !!}</p> 
<h1>
Para mayor información sobre esta notificación visite el siguiente
  <a href="{{url('/notificaciones/view/log/'.$token)}}">ENLACE</a>
</h1>

</td>
</tr>

<tr>
<td colspan="2">


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