import { HttpService } from "./services/http.js";
const httpService = new HttpService()

var options = {
    'cases': [
        {
            'value': 'Todo',
            'option_value': 'all'
        },
        {
            'value': 'Rama del derecho',
            'option_value': 'rama_derecho'
        },
        {
            'value': 'Estado',
            'option_value': 'estado'
        },
        {
            'value': 'Tipo Procedimiento',
            'option_value': 'tipo_procedimiento'
        },
        {
            'value': 'Tipo de Documento',
            'option_value': 'tipo_doc',
            'option_id': 'tipodoc_id',
            'table': 'users'
        },
        {
            'value': 'Género',
            'option_value': 'genero',
            'option_id': 'genero_id',
            'table': 'users'
        }/* ,
        {
            'value':'Departamento',
            'option_value':'departamento',
            'option_id':'expdepto_id',
            'table':'expedientes'   
        },
        {
          'value':'Municipio',
          'option_value':'municipio',
          'option_id':'expmunicipio_id',
          'table':'expedientes'   
        },
        {
          'value':'Tipo de Vivienda',
          'option_value':'tipo_vivienda',
            'option_id':'exptipovivien_id',
            'table':'expedientes'   
        },
        {
          'value':'Estrato',
          'option_value':'estrato',
            'option_id':'estrato_id',
            'table':'users'   
        },
        {
          'value':'Estado Civil',
          'option_value':'estado_civil',
          'option_id':'estadocivil_id',
          'table':'users'   
        } */

    ],
    'actuaciones': [
        {
            'value': 'Estado',
            'option_value': 'estado_act'
        }
    ],
    'requerimientos': [
        {
            'value': 'Estado',
            'option_value': 'estado_req'
        }
    ]
};


(function () {

    //setFilter('cases')
    $("#select_table").on("change", function (e) {
        if ($(this).val() != '') {
            setFilter($(this).val());
            $("#exceldiv").show();
        } else {
            $("#exceldiv").hide();
            $("#select_filter_table").html("");
        }

    });

    $(".hih").on("click", function (e) {
        var prfid = $(this).attr("id").split("-")[1];
        if ($(this).is(":checked")) {
            $("#headerinput-" + prfid).prop("disabled", false);
            $("#userheaderinput-" + prfid).prop("disabled", false);
        } else {
            $("#headerinput-" + prfid).prop("disabled", true);
            $("#userheaderinput-" + prfid).prop("disabled", true);
        }

    });

    $("#MyFormDownloadExcel").on("submit",async function (e) {
        // e.preventDefault();
        $("#wait").show()

        var form = e.target;
        var url = form.action;
        var formData = new FormData(form);

        // Usar fetch para enviar los datos del formulario
        fetch(url, {
            method: 'POST',
            body: formData
        }) .then(response => response.json())
        .then(data => {
            // La respuesta debería contener la URL del archivo a descargar
            if (data.fileUrl) {
                var downloadUrl = data.fileUrl;    
                // Crear un enlace temporal para descargar el archivo
                var a = document.createElement('a');
                a.href = downloadUrl;
                a.download = '';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
    
                // Ocultar el indicador de espera
                document.getElementById('wait').style.display = 'none';
            } else {
                // Manejar el caso en que no se obtenga la URL del archivo
                document.getElementById('wait').style.display = 'none';
               // alert('No se pudo descargar el archivo.');
            }
        })
        .catch(error => {
            // Manejar errores de la petición fetch
            document.getElementById('wait').style.display = 'none';
           // alert('Error al intentar descargar el archivo.');
        });
    });

    $("#select_filter_table").on("change", function (e) {
        if ($(this).val() != 'all') {
            var request = {
                'filter_id': $(this).val()
            }
            getOptionFilter(request);
        } else {
            $("#select_options_filter_table").html("");
        }

    });
    $("#check_hab_rango").on("change", function (e) {
        if ($(this).is(":checked")) {
            $("#fecha_ini").prop("disabled", false);
            $("#fecha_fin").prop("disabled", false);
        } else {
            $("#fecha_ini").prop("disabled", true);
            $("#fecha_fin").prop("disabled", true);
        }
    });

})();

function getOptionFilter(request) {
    $.ajax({
        url: '/reportes/get/option/filter',
        type: 'POST',
        datatype: 'json',
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
            $("#wait").show();

        },
        success: function (res) {
            $("#wait").hide();
            if (res.options) {
                setOptionsFilter(res.options)
            }

        },
        error: function (xhr, textStatus, thrownError) {
            alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
        }
    });
}

function setFilter(value) {
    var options_v = "";
    options[value].forEach(element => {
        options_v += `<option>${element.value}</option>`;
    });
    $("#select_filter_table").html(options_v);
}
function setOptionsFilter(array) {
    var options_v = "";

    array.forEach(element => {
        options_v += `<option value="${element.id}">${element.value ? element.value : element.name}</option>`;
    });
    $("#select_options_filter_table").html(options_v);
}