@foreach ($case->case_novelty_data()->get() as $novelty )


<tr>
<td>
<input type="hidden" class="input_novelty_defdata" id="input_novelty_defdata-{{$novelty->id}}" value="{{json_encode($novelty)}}">
{{ $loop->iteration }}
</td>

<td>{{$novelty->question->name}}</td>
<td>{{$novelty->value}}</td>
 
<td>
<button class="btn btn-danger btn-sm btn_delete_novelty" data-id="{{$novelty->id}}">
Eliminar
</button>
</td>
</tr>
@endforeach    