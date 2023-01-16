
    <table class="table table-bordered">
                <thead class="thead-green">
                  <tr class="text-center">
                    <th>Nombres</th>
                    <th>No. Identificación</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Estado</th>
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
                      <td>{{$user->type_status->name}}</td>
                      <td class="text-center">
                      @if(Auth::user()->can('edit_usuarios'))
                      <a href="/admin/users/{{$user->id}}/edit" class="btn btn-primary btn-sm d-block">Editar</a>
                      @endif
                      @if(Auth::user()->can('delete_usuarios'))
                      <a href="#" id="{{$user->id}}"  class="btn btn-danger btn_delete_user btn-sm d-block mt-1">Eliminar</a>
                      @endif
                      </td>
                      
                  </tr>
                  @endforeach
                  
                   </tbody>
                  </table>
                  <hr>
                   {{ $users->appends(request()->query())->links() }}