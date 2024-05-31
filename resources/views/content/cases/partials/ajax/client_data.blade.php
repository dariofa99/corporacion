<div class="row content_table_list_clients" @if (count($users_) <= 1) style="display:none" @endif>
    <div class="col-md-12 table-responsive p-0">
        <table class="table table-hover table_list_users_case table-striped" id="table_list_clients">
            <thead>
                <th>
                    No. Identificación
                </th>
                <th>
                    Nombre
                </th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </thead>
            <tbody>
                @foreach ($users_ as $user)
                    <tr>
                        <td>{{ $user->identification_number }} </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td>{{ $user->address }}</td>
                        <td>
                            {{--  <button class="btn btn-success btn-sm btn_user_data" data-id="{{$user->id}}">
              Detalles</button> --}}

                            <button class="btn btn-danger btn-sm btn_delete_user" data-type_user_id="7"
                                data-pivot_id="{{ $user->pivot->id }}" data-id="{{ $user->id }}">
                                Eliminar</button>
                            @if (auth()->user()->can('editar_perfil_cliente') or auth()->user()->can('ver_perfil_usuario'))
                                <a target="_blank" href="/admin/users/{{ $user->id }}/edit"
                                    class="btn btn-primary btn-sm" data-type_user_id="7"
                                    data-pivot_id="{{ $user->pivot->id }}" data-id="{{ $user->id }}">
                                    Ver perfil</a>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>

<div class="row content_user_all_data" @if (count($users_) > 1 || count($users_) < 1) style="display:none" @endif>
   
<input type="hidden" name="user_id" id="user_id"
@if (count($users_) == 1) value="{{ $users_[0]->id }}" @endif>
    <div class="col-md-3">
        <div class="form-group">
            <label for="num_identificacion">Tipo documento</label>
            <select disabled name="type_identification_id" id="type_identification_id"
                class="form-control form-control-sm">
                @foreach ($types_identification as $key => $tipo_doc)
                    <option @if (count($case->users) == 1 and count($users_) > 0 and $users_[0]->type_identification_id == $key) selected @endif value="{{ $key }}">
                        {{ $tipo_doc }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="num_identificacion">No de identificación</label>
            <input disabled @if (count($users_) == 1) value="{{ $users_[0]->identification_number }}" @endif
                type="text" required class="form-control form-control-sm" name="identification_number"
                id="identification_number">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" disabled @if (count($users_) == 1) value="{{ $users_[0]->name }}" @endif
                required class="form-control form-control-sm" id="name" name="name" value="">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" disabled
                @if (count($users_) == 1) value="{{ $users_[0]->first()->email }}" @endif required
                class="form-control form-control-sm" id="email" name="email" value="">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="telephone">Teléfono</label>
            <input type="number" disabled
                @if (count($users_) == 1) value="{{ $users_[0]->phone_number }}" @endif required
                class="form-control form-control-sm" id="phone_number" name="phone_number" value="">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="address">Dirección</label>
            <input type="text" disabled @if (count($users_) == 1) value="{{ $users_[0]->address }}" @endif
                required class="form-control form-control-sm" id="phone_number" name="phone_number" value="">
        </div>
    </div>


    @if (count($users_) > 0 and count(
            $case->inputsForUser()->where('user_id', $users_[0]->id)->get()) > 0)
        @include('content.categories.partials.questions', [
            'col' => 3,
            'model' => $users_[0],
            'data' => $case->inputsForUser()->where('user_id', $users_[0]->id)->get(),
        ])
    @endif


</div>




