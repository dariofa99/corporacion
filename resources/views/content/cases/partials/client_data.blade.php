@php
    $users_ = $case->getUsersByType(7);
@endphp
<div class="content_client_data">

    <div class="row" >
        <div class="col-md-2">
            <button class="btn btn-primary btn-sm btn-block btnAddUserCase" data-type_user_id="7" data-view="create"
                id="btnAddUserCase"><i class="fa fa-user"> </i> Agregar solicitante</button>
        </div>
        <div class="col-md-5">
        </div>
        @if ((count($users_) > 0)  and (auth()->user()->can('editar_perfil_cliente') or auth()->user()->can('ver_perfil_usuario')))
            <div class="col-md-2">
                <div class="form-group">
                    <a href="/admin/users/{{ $users_[0]->id }}/edit" class="btn btn-block btn-primary btn-sm">
                        Ver perfil</a>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">

                    <button id="btn_user_data" class="btn btn-success btn-block btn-sm btn_user_data"
                        data-id="{{ $users_[0]->id }}">Agregar campo</button>
                </div>
            </div>

            @if (count($users_) == 1 and $case->users[0])
                
                  {{--   <div class="col-md-2">
                        <div class="form-group">
                            <br>
                            <button class="btn btn-success btn-block btn-sm btn_guardar_cambios_user"
                                data-type_user_id="7" data-pivot_id="{{ $users_[0]->pivot->id }}"
                                data-id="{{ $users_[0]->id }}">
                                Guardar cambios</button>
                        </div>
                    </div> --}}
                    <div class="col-md-1">
                        <div class="form-group">
                          
                            <button class="btn btn-danger btn-block btn-sm btn_delete_user" data-type_user_id="7"
                                data-pivot_id="{{ $users_[0]->pivot->id }}" data-id="{{ $users_[0]->id }}">
                                Eliminar</button>
                        </div>
                    </div>
               
            @endif

        @endif
    </div>
    <br>
    <div class="content_ajax_list_users" id="content_client_data">
        @include('content.cases.partials.ajax.client_data')
    </div>

</div>
