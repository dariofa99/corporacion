        <table class="table table-bordered text-nowrap table-striped ">
                <thead>
                  <tr class="text-center">
                    <th>No. Caso</th>
                    <th>Solicitante</th>
                    <th>Tipo de proceso</th>
                    <th>Tipo de Caso</th>
                    <th>Fecha de creación</th>
                    
                    <th>Estado</th>
                    
                    <th>Acciones</th>
                  </tr>
                  </thead>
                  <tbody>
                   
                  @foreach ($cases as $case )     
                    <tr id="row-case-{{$case->id}}">
                      <td>{{$case->case_number}}</td>
                      <td>@if(count($case->users()->where('type_user_id',7)->get()) > 0)
                        
                        {{ $case->users()->where('type_user_id',7)->first()->name }}  @else Sin registrar @endif</td>

                      <td>
                        
                        <span   data-toggle="tooltip" @if(count($case->users()->where('type_user_id',21)->get()) > 0)
                          title="@foreach($case->users()->where('type_user_id',21)->get() as $user) {{$user->name}};  @endforeach" @else  title="Sin demandados" @endif>  {{$case->type_case}} </span>
                    
                      </td>

                       <td>{{$case->branch_law}}</td>
                       <td>{{getSmallDateWithHour($case->created_at)}}</td>

                       <td> 

                       <span style="display:block" class="badge badge-pill badge-{{$case->color}}">
                       {{$case->status}}</span>   
                       
                        </td>
                     
                      <td class="text-center">
                     <a href="/casos/{{$case->id}}/edit" class="btn btn-success btn-sm">
                      <i class="fa fa-cogs"></i> Administrar</a>

                      <button href="#" data-id="{{$case->id}}" class="btn btn-danger btn-sm btn_delete_case">
                      <i class="fa fa-trash"></i> Eliminar </button>

                      </td>  
                      
                  </tr>
                  @endforeach
                  
                   </tbody>
                  </table>
                  <hr>
                   {{ $cases->appends(request()->query())->links() }}