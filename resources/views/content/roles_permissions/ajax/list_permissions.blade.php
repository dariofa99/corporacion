<table class="table">
    <thead>
       <th>
           Nombre
       </th>
    </thead>
     <tbody>
       @foreach($permissions as $key => $permission)
       <tr>
           <td>
               {{$permission->name}}
           </td>
           <td>
               <button type="button" class="btn btn-primary btn-sm btn_edit_permission" data-name="{{$permission->name}}" data-id="{{$permission->id}}">Editar</button>
               <button type="button" class="btn btn-danger btn-sm btn_delete_permission" data-id="{{$permission->id}}">Eliminar</button>
           </td>
       </tr>
       @endforeach
     </tbody>
 </table>