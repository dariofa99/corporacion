<table class="table" >
    <thead>
    <th>
    Nombre
    </th>
    <th>
    Uso en
    </th>
    </thead>
    <tbody>
    @foreach ($categories as $category )
        <tr>
        <td>
        {{$category->name}}
        </td>
        <td>
        {{$category->getCategory()}} 
        </td>
        <td>
        <button class="btn btn-primary btn-sm btn_edit_category" data-id="{{$category->id}}">
        Editar
        </button>
        @if(!$category->logs()->where('case_log.type_category_id', $category->id)->exists() 
        and !$category->users()->where('user_data.type_data_id', $category->id)->exists()
        and !$category->type_aditional_data()->where('directory_has_addata.type_data_id', $category->id)->exists())
         <button class="btn btn-danger btn-sm btn_delete_category" data-id="{{$category->id}}">
        Eliminar
        </button>
        @else
        <button class="btn btn-danger btn-sm" disabled data-id="{{$category->id}}">
            Utilizado
            </button>
        @endif
        </td>
        </tr>
    @endforeach
    
    
    </tbody>
    </table>