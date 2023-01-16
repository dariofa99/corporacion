<table class="table">
    <thead>
       <th>
           Nombre
       </th>
    </thead>
     <tbody>
       @foreach($roles as $key => $rol)
       <tr>
           <td>
               {{$rol->name}}
           </td>
           <td>
               <button type="button" class="btn btn-primary btn-sm btn_edit_rol" data-name="{{$rol->name}}" data-id="{{$rol->id}}">Editar</button>
               <button type="button" class="btn btn-danger btn-sm btn_delete_rol" data-id="{{$rol->id}}">Eliminar</button>
           </td>
       </tr>
       @endforeach
     </tbody>
 </table>