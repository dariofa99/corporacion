<table class="table table-bordered text-nowrap">
    <thead>
        <tr class="text-center">
            <th>No. Recepción</th>
            <th>Usuario</th>

            <th>Estado</th>

            <th>Fecha de recepción</th>

            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($receptions))
            @foreach ($receptions as $reception)
                <tr>
                    <td>{{ $reception->number }}</td>

                    <td>{{ $reception->user->name }}
                        @if ($reception->user->type_status_id == 16)
                            <small id="cont_stauser-{{ $reception->user->id }}">
                                <div class="text-left">
                                    <span style="color:red">Sin activar!</span>
                                    - Fecha registro:
                                    {{ getDateForNotification($reception->user->created_at) }}
                                </div>
                            </small>
                        @endif
                    </td>

                    <td>{{ $reception->type_status->name }}</td>

                    <td>{{ getSmallDateWithHour($reception->created_at) }}</td>


                    <td>
                        @if ($reception->user->type_status_id != 16)
                            <a href="{{ $reception->user->type_status_id == 16 ? '#' : "/recepciones/$reception->id/edit" }}"
                                class="btn btn-success btn-block btn-sm"
                                {{ $reception->user->type_status_id == 16 ? 'disabled' : '' }}>
                                <i class="fa fa-check"></i>Seleccionar
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif

    </tbody>
</table>