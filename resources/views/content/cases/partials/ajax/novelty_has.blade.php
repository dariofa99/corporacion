@foreach ($case->case_novelty_has_data()->get() as $novelty )


<tr>
<td>
<input type="hidden" class="input_novelty_has_defdata" id="input_novelty_has_defdata-{{$novelty->id}}" value="{{json_encode($novelty)}}">
{{ $loop->iteration }}
</td>

<td>{{$novelty->question->name}}</td>
<td>{{$novelty->value}}</td>
 
<td>
<button class="btn btn-danger btn-sm btn_delete_novelty_has" data-id="{{$novelty->id}}">
Eliminar
</button>
<button class="btn btn-primary btn-sm btn_edit_novelty_has" data-id="{{$novelty->id}}">
Editar
</button> 
</td>
</tr>
@endforeach    