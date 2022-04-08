@forelse($logs as $log)
<tr>
<td>
{{getDateForNotification($log->created_at)}}
</td>
<td>
{{$log->concept}}
</td>
{{-- <td>
{{$log->description}}
</td> --}}
<td>
@if(count($log->files)>0)
<a target="_blank" href="/oficina/descargar/documento/{{$log->files[0]->id}}" class="small-box-footer" >
    Descargar  <i class="fas fa-cloud-download-alt"></i>
</a>
@else
    Sin archivo
@endif
</td>
<td>
   <span style="display:block" class="badge badge-pill 
        {{$log->shared == 1 ? 'badge-success': 'badge-danger'}}">
    {{$log->shared == 1 ? 'Si': 'No'}}</span>         
</td>
<td>


<button class="btn btn-primary btn-sm btn_edit_log" data-id="{{$log->id}}">Editar</button>
<button class="btn btn-success btn-sm btn_show_log" data-id="{{$log->id}}">Detalles</button>
<button class="btn btn-danger btn-sm btn_delete_log" data-id="{{$log->id}}">Eliminar</button>

</td>
</tr>
@empty

@endforelse