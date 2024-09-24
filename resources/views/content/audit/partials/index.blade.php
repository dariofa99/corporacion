<table class="table table-bordered text-nowrap table-striped ">
    <thead>
      <tr class="text-center">
        <th>Nombre de perfil</th>
        <th>Tipo de evento</th>
        <th>Tabla afectada</th>
        <th>Descripción de cambios</th>
                
        <th>Acciones</th>
      </tr>
      </thead>
      <tbody>
      @foreach ($auditories as $audit )     
        <tr id="row-audit-{{$audit->id}}">
          <td>
            {{$audit->user_name}}
          </td>
         <td>
            {{$audit->event}}
         </td>
         <td>
            {{$audit->table_name}}
         </td>
         <td>
             <input value="{{$audit->model_description}}" id="lblJsonAudit-{{$audit->id}}" type="hidden">
           <span > {{Str::limit($audit->model_description,55)}}</span>
         </td>
         
          <td class="text-center">
         <a href="#" class="btn btn-success btn-sm btn_detalles_audit" data-id="{{$audit->id}}">
          <i class="fa fa-cogs"></i> Detalles</a>

         {{--  <button href="#" data-id="{{$audit->id}}" class="btn btn-danger btn-sm btn_delete_case">
          <i class="fa fa-trash"></i> Eliminar </button> --}}

          </td>  
          
      </tr>
      @endforeach
       
       </tbody>
      </table>
      <hr>
       {{ $auditories->appends(request()->query())->links() }}