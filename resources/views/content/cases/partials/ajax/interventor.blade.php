@foreach ($case->users()->where('type_user_id',25)->get() as $user )
<tr>
<td>
<input type="hidden" class="input_user_defdata" id="input_user_defdata-{{$user->id}}" value="{{json_encode($user)}}">
{{$user->identification_number}}</td>
<td>{{$user->name}}</td>
<td>{{$user->email}}</td>
<td>{{$user->phone_number}}</td>                  
<td>{{$user->pivot->type_defendant }}</td>
 
<td>{{-- <button class="btn btn-success btn-sm btn_user_data" data-id="{{$user->id}}">
Detalles</button> --}}
<button class="btn btn-danger btn-sm btn_delete_user" data-type_user_id="25" data-pivot_id="{{$user->pivot->id}}" data-id="{{$user->id}}">
Eliminar
</button> 
@if(auth()->user()->can('editar_perfil_cliente') OR auth()->user()->can('ver_perfil_usuario'))
<a target="_blank" href="/admin/users/{{$user->id}}/edit" class="btn btn-primary btn-sm" data-type_user_id="21" data-pivot_id="{{$user->pivot->id}}" data-id="{{$user->id}}">
Ver perfil</a>
@endif
</td>
</tr>
@endforeach    