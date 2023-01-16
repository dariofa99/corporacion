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
Se ha creado una cuenta en el sistema Lybra.<br>
Para ingresar da clic en el enlace: <a href="{{url('/')}}">{{url('/')}}</a><br>   
</td>
</tr>


<tr>
<td colspan="2">Nombre de usuario: {{$user->email}}</td>
</tr>
<tr>
<td colspan="2">Contraseña: {{$password_send}}</td>
</tr>
<tr>
    <td colspan="2"><small>Para mayor seguridad, recuerda que puedes cambiar la contraseña desde el perfil de usuario.</small>   </td>
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