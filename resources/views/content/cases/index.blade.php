@extends('layouts.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->

@endpush

@section('navbar')
<!-- aqui va el menu de cada vista -->
  @include('content.cases.navbar')
@endsection

@section('content')

<div class="content-header">
{{--   <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>
                Modals & Alerts 
                <small>new</small>
              </h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Modals & Alerts</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
  </section> --}}
    <!-- /content-header -->
</div>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

       <!-- include('components.callout_info') -->
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
   <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

   
@endif

        <div class="row">
       

          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-2">
                    <h3 class="card-title">
                      <i class="fas fa-folder"></i>
                      Casos
                    </h3>
                  </div>
                  <div class="col-md-10  ">
                  <form class="form-inline " id="myFormSearchIndex"  action="/casos">
                    <div class="col-md-5 offset-md-2">
                      <div class="form-group justify-content-end">
                        <select class="form-control" name="type">
                          <option value="view_all">Ver todo...</option>
                          <option value="case_number">No. caso</option>
                          <option value="identification_number">No. identificación</option>
                          <option value="user_name">Nombre</option>
                          <option value="type_case">Tipo de proceso</option>
                          <option value="branch_law">Tipo de Caso</option>
                          <option value="status">Estado caso</option>
                          <option value="created_at">Fecha de creación</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-5 ">
                      <div class="input-group ">
                        <input type="text" disabled id="types_text" class="form-control input_data" name="data" placeholder="Buscar..." aria-label="Buscar..." aria-describedby="basic-addon2">
                         <select style="display:none" class="form-control input_data" id="types_case" name="data">
                          <option value="view_all">Seleccione...</option>
                         @foreach ($types_case as $key => $type_case )
                              <option value="{{$key}}">{{$type_case}}</option>
                         @endforeach
                        </select>
                         <select style="display:none" class="form-control input_data" id="types_branch_law" name="data">
                          <option value="view_all">Seleccione...</option>
                         @foreach ($types_branch_law as $key => $type_branch_law )
                              <option value="{{$key}}">{{$type_branch_law}}</option>
                         @endforeach
                        </select>
                         <select style="display:none" class="form-control input_data" id="types_status" name="data">
                          <option value="view_all">Seleccione...</option>
                         @foreach ($types_status as $key => $type_status )
                              <option value="{{$key}}">{{$type_status}}</option>
                         @endforeach
                        </select>
                        
                        
                        <div class="input-group-append">
                          <button type="submmit" class="input-group-text" id="basic-addon2"> <i class="fas fa-search"></i></button>                         
                        </div>
                      </div>                   
                    </div>
                  </form>
                  </div>
                </div>




              </div>
              <div class="card-body table-responsive p-0" id="content_cases"> 
                @include("content.cases.partials.ajax.index")

              </div>
              <!-- /.card -->
            </div>

          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
      </div><!-- /.container-fluid -->

    </section>
    <!-- /.content -->
    

@endsection

@push('scripts')
<!-- aqui van los scripts de cada vista -->

<script>  
  var spanishLanguage = {
                "processing": "Procesando...",
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "emptyTable": "Ningún dato disponible en esta tabla",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "search": "Buscar:",
                "infoThousands": ",",
                "loadingRecords": "Cargando...",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad",
                    "collection": "Colección",
                    "colvisRestore": "Restaurar visibilidad",
                    "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
                    "copySuccess": {
                        "1": "Copiada 1 fila al portapapeles",
                        "_": "Copiadas %ds fila al portapapeles"
                    },
                    "copyTitle": "Copiar al portapapeles",
                    "csv": "CSV",
                    "excel": "Excel",
                    "pageLength": {
                        "-1": "Mostrar todas las filas",
                        "_": "Mostrar %d filas"
                    },
                    "pdf": "PDF",
                    "print": "Imprimir",
                    "renameState": "Cambiar nombre",
                    "updateState": "Actualizar"
                },
                "autoFill": {
                    "cancel": "Cancelar",
                    "fill": "Rellene todas las celdas con <i>%d<\/i>",
                    "fillHorizontal": "Rellenar celdas horizontalmente",
                    "fillVertical": "Rellenar celdas verticalmentemente"
                },
                "decimal": ",",
                "searchBuilder": {
                    "add": "Añadir condición",
                    "button": {
                        "0": "Constructor de búsqueda",
                        "_": "Constructor de búsqueda (%d)"
                    },
                    "clearAll": "Borrar todo",
                    "condition": "Condición",
                    "conditions": {
                        "date": {
                            "after": "Despues",
                            "before": "Antes",
                            "between": "Entre",
                            "empty": "Vacío",
                            "equals": "Igual a",
                            "notBetween": "No entre",
                            "notEmpty": "No Vacio",
                            "not": "Diferente de"
                        },
                        "number": {
                            "between": "Entre",
                            "empty": "Vacio",
                            "equals": "Igual a",
                            "gt": "Mayor a",
                            "gte": "Mayor o igual a",
                            "lt": "Menor que",
                            "lte": "Menor o igual que",
                            "notBetween": "No entre",
                            "notEmpty": "No vacío",
                            "not": "Diferente de"
                        },
                        "string": {
                            "contains": "Contiene",
                            "empty": "Vacío",
                            "endsWith": "Termina en",
                            "equals": "Igual a",
                            "notEmpty": "No Vacio",
                            "startsWith": "Empieza con",
                            "not": "Diferente de",
                            "notContains": "No Contiene",
                            "notStarts": "No empieza con",
                            "notEnds": "No termina con"
                        },
                        "array": {
                            "not": "Diferente de",
                            "equals": "Igual",
                            "empty": "Vacío",
                            "contains": "Contiene",
                            "notEmpty": "No Vacío",
                            "without": "Sin"
                        }
                    },
                    "data": "Data",
                    "deleteTitle": "Eliminar regla de filtrado",
                    "leftTitle": "Criterios anulados",
                    "logicAnd": "Y",
                    "logicOr": "O",
                    "rightTitle": "Criterios de sangría",
                    "title": {
                        "0": "Constructor de búsqueda",
                        "_": "Constructor de búsqueda (%d)"
                    },
                    "value": "Valor"
                },
                "searchPanes": {
                    "clearMessage": "Borrar todo",
                    "collapse": {
                        "0": "Paneles de búsqueda",
                        "_": "Paneles de búsqueda (%d)"
                    },
                    "count": "{total}",
                    "countFiltered": "{shown} ({total})",
                    "emptyPanes": "Sin paneles de búsqueda",
                    "loadMessage": "Cargando paneles de búsqueda",
                    "title": "Filtros Activos - %d",
                    "showMessage": "Mostrar Todo",
                    "collapseMessage": "Colapsar Todo"
                },
                "select": {
                    "cells": {
                        "1": "1 celda seleccionada",
                        "_": "%d celdas seleccionadas"
                    },
                    "columns": {
                        "1": "1 columna seleccionada",
                        "_": "%d columnas seleccionadas"
                    },
                    "rows": {
                        "1": "1 fila seleccionada",
                        "_": "%d filas seleccionadas"
                    }
                },
                "thousands": ".",
                "datetime": {
                    "previous": "Anterior",
                    "next": "Proximo",
                    "hours": "Horas",
                    "minutes": "Minutos",
                    "seconds": "Segundos",
                    "unknown": "-",
                    "amPm": [
                        "AM",
                        "PM"
                    ],
                    "months": {
                        "0": "Enero",
                        "1": "Febrero",
                        "10": "Noviembre",
                        "11": "Diciembre",
                        "2": "Marzo",
                        "3": "Abril",
                        "4": "Mayo",
                        "5": "Junio",
                        "6": "Julio",
                        "7": "Agosto",
                        "8": "Septiembre",
                        "9": "Octubre"
                    },
                    "weekdays": [
                        "Dom",
                        "Lun",
                        "Mar",
                        "Mie",
                        "Jue",
                        "Vie",
                        "Sab"
                    ]
                },
                "editor": {
                    "close": "Cerrar",
                    "create": {
                        "button": "Nuevo",
                        "title": "Crear Nuevo Registro",
                        "submit": "Crear"
                    },
                    "edit": {
                        "button": "Editar",
                        "title": "Editar Registro",
                        "submit": "Actualizar"
                    },
                    "remove": {
                        "button": "Eliminar",
                        "title": "Eliminar Registro",
                        "submit": "Eliminar",
                        "confirm": {
                            "_": "¿Está seguro que desea eliminar %d filas?",
                            "1": "¿Está seguro que desea eliminar 1 fila?"
                        }
                    },
                    "error": {
                        "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\/a&gt;).<\/a>"
                    },
                    "multi": {
                        "title": "Múltiples Valores",
                        "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
                        "restore": "Deshacer Cambios",
                        "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
                    }
                },
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "stateRestore": {
                    "creationModal": {
                        "button": "Crear",
                        "name": "Nombre:",
                        "order": "Clasificación",
                        "paging": "Paginación",
                        "search": "Busqueda",
                        "select": "Seleccionar"
                    },
                    "emptyError": "El nombre no puede estar vacio",
                    "removeConfirm": "¿Seguro que quiere eliminar este %s?",
                    "removeError": "Error al eliminar el registro",
                    "removeJoiner": "y",
                    "removeSubmit": "Eliminar",
                    "renameButton": "Cambiar Nombre",
                    "renameLabel": "Nuevo nombre para %s"
                }
            };

$('#cases_datatable').DataTable({
                processing: true,
                serverSide: true,
                //stateSave: true,
                orderMulti: true,
                order: [
                    [0, 'desc']
                ],
                searching: false,
                pageLength: 15,
                lengthMenu: [
                    [15], // Values to show
                    [15] // Labels corresponding to values
                ],
                language: spanishLanguage,
                ajax: {
                    url: "{{ url('casos') }}", // The route that handles the AJAX request
                    type: 'GET',
                    data: function (d) {
                        d.page = Math.ceil(d.start / d.length) + 1;
                        //d.page = d.draw;
                        d.start = 0;

                        // Extract parameters from the URL
                        var urlParams = new URLSearchParams(window.location.search);

                        if (urlParams.has('type')) {
                            d.type = urlParams.get('type');  // Pass `type` parameter
                        }
                        if (urlParams.has('data')) {
                            d.data = urlParams.get('data');  // Pass `data` parameter
                        }
                    },
                    dataSrc: function(json) {
                        // Append pagination links to a div
                        $("#wait").hide();
                        $('#pagination-links').html(json.links);
                        return json.data; // Return the actual data for DataTables
                    }
                },
                columns: [
                    {
                        data: 'case_number',
                        name: 'case_number'
                    },
                    {
                        data: 'user_type_7',
                        name: 'user_type_7'
                    },
                    {
                        data: 'type_case',
                        name: 'type_case'
                    },
                    {
                        data: 'branch_law',
                        name: 'branch_law'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
            });

</script>

@endpush

