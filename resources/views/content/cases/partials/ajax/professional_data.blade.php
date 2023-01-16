 @foreach ($case->users()->where('type_user_id',8)->get() as $user )
                      <tr>
                  <td>{{$user->identification_number}}</td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->phone_number}}</td>
                  <td>{{$user->address}}</td>
                  <td>{{-- <button class="btn btn-success btn-sm btn_user_data" data-id="{{$user->id}}">
                  Detalles</button> --}}
                  @if(auth()->user()->can('eliminar_profesional_caso') OR (count($case->users()->where(['user_id'=>auth()->user()->id,'type_user_id'=>8])->get())>0 AND $user->pivot->type_user_id == '36'))
                   <button class="btn btn-danger btn-sm btn_delete_user"  data-type_user_id="{{ $user->pivot->type_user_id }}"  data-pivot_id="{{$user->pivot->id}}" data-id="{{$user->id}}">
                        Eliminar
                    </button>
                   @endif 
              @if(auth()->user()->can('edit_usuarios') OR auth()->user()->can('ver_perfil_usuario'))
               <a target="_blank" href="/admin/users/{{$user->id}}/edit" class="btn btn-primary btn-sm" data-type_user_id="21" data-pivot_id="{{$user->pivot->id}}" data-id="{{$user->id}}">
              Ver perfil</a>
              @endif
              </td>
                  </tr>
                  @endforeach   