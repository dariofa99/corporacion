@forelse($case->logs()->whereIn('type_log_id',[18,22,33,23])
->where('type_status_id','<>',15)->orderBy('case_log.created_at','desc')->get() as $log)
<tr>
<td>
   
{{ $log->filing_date != null ? getDateForNotification($log->filing_date) : "Sin fecha"}}
</td>
<td>
{{$log->concept}}
</td> 
{{-- <td>
{{$log->description}}
</td> --}}
<td>
@if(count($log->files()->where('type_status_id','!=','15')->get())>1)
<input type="hidden" id="input_show_log_files-{{$log->id}}" value="{{json_encode($log->files)}}">

<a target="_blank" href="#" data-id="{{$log->id}}" id="btn_show_log_files-{{$log->id}}" class="small-box-footer btn_show_log_files" >
    Descargar  <i class="fas fa-cloud-download-alt"></i>

</a>
@elseif(count($log->files()->where('type_status_id','!=','15')->get())>0)
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


@if($log->type_log_id !=22)<button class="btn btn-primary btn-sm btn_edit_log" data-id="{{$log->id}}">Editar</button>@endif
<button class="btn btn-success btn-sm ml-1 btn_show_log" data-id="{{$log->id}}">Detalles</button>
<button class="btn btn-danger btn-sm ml-1 btn_delete_log" data-id="{{$log->id}}">Eliminar</button>

</td>
</tr>

@empty

@endforelse

@if(Session::has('mail_error'))
            
            <script>
                toastr.error('{{ Session::get("mail_error") }}','Error',
                    {"positionClass": "toast-top-right","timeOut":"10000"});
            </script> 
@endif