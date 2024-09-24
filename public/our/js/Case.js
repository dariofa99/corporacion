import { HttpService } from "./services/http.js";
import { CaseM } from "./services/case.js";
import { AppService } from "./services/appservice.js";
const httpService = new HttpService()
const casef = new CaseM();
const appService = new AppService();




$("#content_cases").on('click', '.pagination a', function (e) {
    // alert("sss")
    e.preventDefault();
    var page = $(this).attr('href');
    var request = {};
    window.history.pushState(null, '', page);
    casef.index(request, page);
});

$("#myFormSearchIndex").on("submit", function (e) {
    var request = $(this).serialize();
    var url = $(this).attr('action');
    //alert(url);

    if ($('#myFormSearchIndex select[name=type]').val() == 'view_all') {
        request = {};
        window.history.pushState(null, '', url);
    } else {
        window.history.pushState(null, '', url + '?' + request);
    }
    $("#wait").show();
    casef.index(request, url);


    e.preventDefault();
});

$("#myFormSearchLog").on("submit", function (e) {
    var request = $(this).serialize() + '&case_id=' + $("#case_id").val();
    var url = $(this).attr('action');

    if ($('#myFormSearchIndex select[name=type]').val() == 'view_all') {
        request = {};
    }
    $("#wait").show();
    casef.indexLog(request, url);


    e.preventDefault();
});

$('#myFormSearchIndex select[name=type]').on('change', function (e) {
    $(".input_data").prop('disabled', true).hide().val('');
    $('#myFormSearchIndex input[id=types_text]').attr("type","text");
           
    switch (this.value) {
        case 'view_all':
            $('#myFormSearchIndex input[id=types_text]').show();
            break;
        case 'case_number':
        case 'identification_number':
        case 'user_name':
            $('#myFormSearchIndex input[id=types_text]').prop('disabled', false).show();
            break;
        case 'type_case':
            $('#myFormSearchIndex select[id=types_case]').prop('disabled', false).show();
            break;
        case 'branch_law':
            $('#myFormSearchIndex select[id=types_branch_law]').prop('disabled', false).show();
            break;
        case 'status':
            $('#myFormSearchIndex select[id=types_status]').prop('disabled', false).show();
            break;
        case 'created_at':
             $('#myFormSearchIndex input[id=types_text]').show().attr("type","date").prop('disabled', false);
            break;
        case 'rol_type':
                var data = JSON.parse($("#data_roles").val())
                var option = ""
                console.log(data);
                Object.keys(data).forEach(key => {
                    option+=`
                    <option value="${key}"> ${data[key]} </option>
                `
                });
               
                
                $('#myFormSearchIndex select[name=data]').html(option)
                .prop('disabled', false).show();
                //$('#myFormSearchIndex input[id=types_text]').show().attr("type","date").prop('disabled', false);
               break;
        default:
            break;
    }
});


$('#myFormSearchLog select[name=type]').on('change', function (e) {
    $("#myFormSearchLog .input_data").prop('disabled', true).hide().val('');
    switch (this.value) {
        case 'view_all':
            $('#myFormSearchLog input[id=types_text]').show();
            break;
        case 'created_at':
            $('#myFormSearchLog input[id=types_text]').attr('type', 'date').prop('disabled', false).show();
            break;
        case 'category':
            $('#myFormSearchLog select[id=types_category]').prop('disabled', false).show();
            break;

        default:
            $('#myFormSearchLog input[id=types_text]').attr('type', 'text').val('Buscar').show();
            break;
    }
});


$(".btnAddUserCase").on('click', function (e) {
    $("#myformCreateUser")[0].reset();
    $("#myformCreateUser input[name=type_user_id]").val($(this).attr('data-type_user_id'));
    $("#myformCreateUser #lbl_rol_status").text('');
    $("#myformCreateUser button[type=button]").hide();
    $("#myformCreateUser button[type=submit]").show();
    $("#cont_select_new_professional").hide();
    $("#content_chk_sel_prof").hide();
    $(".contentDefendant").hide();
    $("#myformCreateUser select[name=type_defendant").prop('disabled', true);
    $("#cont_form_new_professional").show();
    $("#cont_select_new_professional select").prop('disabled', true);
    $("#cont_form_new_professional input").prop('disabled', false);
    $("#cont_select_new_professional select").prop('disabled', true);
    $("#cont_form_new_professional select").prop('disabled', false);
    $("#myformCreateUser #lbl_rol_status").text('');
    if ($(this).attr('data-type_user_id') == 8 || $(this).attr('data-type_user_id') == 36) {
        //si el usuario que se va agregar es profesional
        $("#cont_select_new_professional").show();
        $("#content_chk_sel_prof").show();
        $("#cont_form_new_professional").hide();
        $("#cont_select_new_professional select").prop('disabled', false);
        $("#myformCreateUser button[type=button]").show();
        $("#myformCreateUser button[type=submit]").hide();
        $("#cont_form_new_professional input").prop('disabled', true);
        $("#cont_form_new_professional select").prop('disabled', true);
        $("#cont_select_new_professional select").prop('disabled', false);
        $("#myformCreateUser select[id=vo_role_id").prop('disabled', true).hide();
        $("#myformCreateUser select[id=prof_role_id").prop('disabled', false).show();

    } else if ($(this).attr('data-type_user_id') == 7) {
        //si el usuario que se va agregar es cliente            
        $("#myformCreateUser select[id=vo_role_id").prop('disabled', false).show();
        $("#myformCreateUser select[id=prof_role_id").prop('disabled', true).hide();
    } else if ($(this).attr('data-type_user_id') == 21 || $(this).attr('data-type_user_id') == 25) {
        //si el usuario que se va agregar es contraparte  
        $("#myformCreateUser select[name=role_id").prop('disabled', true).hide();
        $("#myformCreateUser select[name=type_defendant").prop('disabled', false);
        if ($(this).attr('data-type_user_id') == 21) $("#lbl_type_user_defendant").text('Tipo contraparte');
        if ($(this).attr('data-type_user_id') == 25) $("#lbl_type_user_defendant").text('Tipo interventor');
        $(".contentDefendant").show();

        $("#myformCreateUser #lbl_rol_status").text('No se asignará rol');
        //$("#myformCreateUser select[id=prof_role_id").prop('disabled',true).hide();
    }
    $("#myModal_create_user").modal('show');

});

$(".btnAddCaseNovelty").on('click', function (e) {
    $("#myformCreateNovelty")[0].reset();
    $("#myModal_create_novelty").modal('show');

});


$('#types_category_novelty').on('change', function() {
    var selectedValue = $(this).val();
    var $stateSelect = $('#state_novelty');

    if (selectedValue !== 'view_all') {
        $.ajax({
            url: '/casos/find/novelty/options/' + selectedValue, // Adjust the URL as needed
            type: 'GET',
            success: function(response) {
                $stateSelect.empty(); // Clear existing options
                $stateSelect.append('<option value="view_all">Seleccione...</option>');

                $.each(response, function(key, value) {
                    $stateSelect.append('<option value="' + key + '">' + value + '</option>');
                });
            },
            error: function() {
                console.error('Error fetching data.');
            }
        });
    } else {
        $stateSelect.empty(); // Clear existing options if "view_all" is selected
        $stateSelect.append('<option value="view_all">Seleccione...</option>');
    }
});

document.getElementById('state_novelty').addEventListener('change', function() {
    var selectedValue = this.options[this.selectedIndex].text;
    
    document.getElementById('value_novelty').value = selectedValue;
});


$(".btnAddCaseNoveltyHas").on('click', function (e) {
    $("#myformCreateNoveltyHas")[0].reset();
    $("#myModal_create_novelty_has").modal('show');

});


$('#types_category_novelty_has').on('change', function() {
    var selectedValue = $(this).val();
    var $stateSelect = $('#state_novelty_has');

    if (selectedValue !== 'view_all') {
        $.ajax({
            url: '/casos/find/novelty/options/' + selectedValue, // Adjust the URL as needed
            type: 'GET',
            success: function(response) {
                $stateSelect.empty(); // Clear existing options
                $stateSelect.append('<option value="view_all">Seleccione...</option>');

                $.each(response, function(key, value) {
                    $stateSelect.append('<option value="' + key + '">' + value + '</option>');
                });
            },
            error: function() {
                console.error('Error fetching data.');
            }
        });
    } else {
        $stateSelect.empty(); // Clear existing options if "view_all" is selected
        $stateSelect.append('<option value="view_all">Seleccione...</option>');
    }
});

document.getElementById('state_novelty_has').addEventListener('change', function() {
    var selectedValue = this.options[this.selectedIndex].text;
    
    document.getElementById('value_novelty_has').value = selectedValue;
});


$("input[name=radio_change_revisor]").on("change", function () {
    if ($(this).val() == 'select_user') {
        $("#cont_select_new_professional").show();
        $("#cont_form_new_professional").hide();
        $("#cont_form_new_professional input").prop('disabled', true);
        $("#cont_form_new_professional select").prop('disabled', true);
        $("#cont_select_new_professional select").prop('disabled', false);
        // $("#myFormCreateNewProfessional input[type=button]").hide();
        //$("#myFormCreateNewProfessional input[type=submit]").show();
        $("#myformCreateUser button[type=button]").show();
        $("#myformCreateUser button[type=submit]").hide();

    } else {
        $("#cont_select_new_professional").hide();
        $("#cont_form_new_professional").show();
        $("#cont_form_new_professional input").prop('disabled', false);
        $("#cont_select_new_professional select").prop('disabled', true);
        $("#cont_form_new_professional select").prop('disabled', false);
        // $("#myFormCreateNewProfessional input[type=button]").show();
        // $("#myFormCreateNewProfessional input[type=submit]").hide();
        $("#myformCreateUser button[type=button]").hide();
        $("#myformCreateUser button[type=submit]").show();
    }
})



$("#myformCreateUser input[name=type_identification_id]").on('change', function () {
    var identification_number = $("#myformCreateUser input[name=identification_number]").val();
    if (identification_number != '') {
        var request = {
            'identification_number': identification_number,
            'type_identification_id': this.value
        }

        casef.findUser(request);
    }
})

$("#myformCreateUser input[name=identification_number]").on('blur', function () {
    var type_identification = $("#myformCreateUser select[name=type_identification_id]").val();
    if (this.value != '') {
        var request = {
            'identification_number': this.value,
            'type_identification_id': type_identification
        }

        casef.findUser(request);
    }
});

$("#myformCreateUser button[type=button]").on('click', function (e) {
    $("#myFormCreateCase input[name=user_id]").val($("#myformCreateUser input[name=id]").val());
    $("#myFormCreateCase input[name=user_identification_number]").val($("#myformCreateUser input[name=identification_number]").val())

    var case_id = $("#myFormEditCase input[name=id]").val();
    if (case_id !== undefined) {
        var request = $("#myformCreateUser").serialize() + "&case_id=" + case_id;

        casef.insertUser(request);
    }

    $("#myModal_create_user").modal('hide');
});

$("#myformCreateUser").on('submit', function (e) {
    var case_id = $("#myFormEditCase input[name=id]").val();
    var request = $(this).serialize();
    if (case_id !== undefined) {
        request = request + "&case_id=" + case_id;
    }


    casef.storeUser(request);
    e.preventDefault();
});

$("#myFormCreateCase").on("submit", function (e) {
    var user_number = $("#myFormCreateCase input[name=user_identification_number]").val();
    var user_id = $("#myFormCreateCase input[name=user_id]").val();
    if (user_number != '' || user_id != '') {

        var request = $(this).serialize();
        casef.store(request);
    } else {
        Swal.fire({
            title: 'Error!',
            text: "El campo No Identificación no puede estar vacio.",
            type: 'warning',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Entendido',
        });
    }

    e.preventDefault();
});

$("#myFormEditCase").on("submit", function (e) {

    casef.id = $("#myFormEditCase input[name=id]").val()
    var request = $(this).serialize();
    casef.update(request);
    e.preventDefault();
});

$(".input_case_data").on('blur', function () {
    if (this.value != $("#olderInputValue").val()) {
        var request = {
            'section': 'case_data',
            'value': this.value,
            'type_data_id': $(this).attr('data-type_id'),
            'case_id': $("#myFormEditCase input[name=id]").val()

        }

        casef.insertData(request);
        //console.log(request)
    }
});

$(".input_change_case_data").on('change', function () {

    var request = {
        'section': 'case_data',
        'value': this.value,
        'type_data_id': $(this).attr('data-type_id'),
        'case_id': $("#myFormEditCase input[name=id]").val()

    }

    casef.insertData(request);
    //console.log(request)

});


$(".content_ajax_list_users").on("click", '.btn_user_data', function (e) {
    var request = { 'user_id': $(this).attr('data-id') };

    casef.getUserData(request)
});

$("#table_list_defendant").on("click", '.btn_delete_user', function (e) {
    var request = {
        'user_id': $(this).attr('data-id'),
        'pivot_id': $(this).attr('data-pivot_id'),
        'case_id': $("#case_id").val(),
        'type_user_id': $(this).attr('data-type_user_id')
    };
    Swal.fire({
        title: 'Esta seguro de eliminar el perfil del caso?',
        text: "Los cambios no podrán ser revertidos!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {

            casef.deleteUserCase(request);

        }
    });
});

$("#table_list_interventor").on("click", '.btn_delete_user', function (e) {
    var request = {
        'user_id': $(this).attr('data-id'),
        'pivot_id': $(this).attr('data-pivot_id'),
        'case_id': $("#case_id").val(),
        'type_user_id': $(this).attr('data-type_user_id')
    };
    Swal.fire({
        title: 'Esta seguro de eliminar el perfil del caso?',
        text: "Los cambios no podrán ser revertidos!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {

            casef.deleteUserCase(request);

        }
    });
});

$('#myformCreateNovelty').on('submit', function(event) {
    event.preventDefault();

    // Extract values from the form
    var questionId = document.getElementById('types_category_novelty').value;
    var optionId = document.getElementById('state_novelty').value;
    var value = document.getElementById('value_novelty').value;

    var request = {
        'case_id': $("#case_id").val(),
        'component': $("#component").val(),
        'data': [
            {
                'question_id': questionId,
                'options': [
                    {
                        'option_id': optionId,
                        'value': value
                    }
                ]
            }
        ]
    };

    casef.addNoveltyCase(request);
  });

  

$("#table_list_novelty").on("click", ".btn_delete_novelty", function (e) {
    var request = {
        'id': $(this).attr('data-id'),
        'case_id': $("#case_id").val(),
    };
    Swal.fire({
        title: 'Esta seguro de eliminar la novedad del caso?',
        text: "Los cambios no podrán ser revertidos!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {

            casef.deleteNoveltyCase(request);

        }
    });
});

$('#myformCreateNoveltyHas').on('submit', function(event) {
    event.preventDefault();

    // Extract values from the form
    var questionId = document.getElementById('types_category_novelty_has').value;
    var optionId = document.getElementById('state_novelty_has').value;
    var value = document.getElementById('value_novelty_has').value;

    var request = {
        'case_id': $("#case_id").val(),
        'component': $("#component_has").val(),
        'data': [
            {
                'question_id': questionId,
                'options': [
                    {
                        'option_id': optionId,
                        'value': value
                    }
                ]
            }
        ]
    };

    casef.addNoveltyHasCase(request);
  });

$("#table_list_novelty_has").on("click", ".btn_delete_novelty_has", function (e) {
    var request = {
        'id': $(this).attr('data-id'),
        'case_id': $("#case_id").val(),
    };
    Swal.fire({
        title: 'Esta seguro de eliminar la novedad del caso?',
        text: "Los cambios no podrán ser revertidos!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {

            casef.deleteNoveltyHasCase(request);

        }
    });
});

$("#btn_user_data").on("click", async function (e) {
    $("#myModal_user_data").modal("show");

    /* var request = {
        'user_id': $(this).attr('data-id')
    };

    $("#wait").show()
    await httpService.get("users/get/data", request, async function (data) {
        toastr.success('Guardado con éxito!', '',
            { "positionClass": "toast-bottom-right", "timeOut": "1000" });
        console.log(data);
        $("#user_id").val(data.id);
        $("#wait").hide();
    }); */

    // casef.getUserData(request)
});




$(".set_old_value").on('focus', function () {
    $("#olderInputValue").val(this.value);
});





$(".content_user_data").on('blur', '.input_user_data', async function () {
    if (this.value != $("#olderInputValue").val()) {
        let obj = $(this);
        let data = getQuestionValues(obj);

        // console.log(data);
        var request = {
            'user_id': $("#user_id").val(),
            'component': 'case',
            data: data

        }
        //   console.log(request);
        /*  
         console.log(request);
         let respon = await httpService.post("users/insert/data", request, async function (data) {
             console.log(data);
         }); */

        /* if (!response.ok) {
            const message = `An error has occured: ${response.status}`;
            console.log(response);
            throw new Error(message);
        }
        const topics = await response.json();
        console.log(topics); */

        //casef.insertUserData(request)
    }
});



$("#btn_add_user_data").on('click', async function () {
    var request = {
        'value': '',
        'question_id': $("#data_user").val(),
        'user_id': $("#user_id").val(),
        'component': 'case',
        "case_id": $("#case_id").val()
    }
    $("#wait").show()
    await httpService.post("casos/insert/input/for/user", request, async function (data) {

        // $("#wait").hide()
        toastr.success('Asignado con éxito!', '',
            { "positionClass": "toast-bottom-right", "timeOut": "1000" });
        location.reload(true)
    });


});

$(".btn_close_modal").on("click", function (e) {
    $("#" + $(this).attr("data-modal")).modal("hide");
});

$(".btnAddLogCase").on("click", function (e) {
    $("#myformEditLog").attr('id', 'myformCreateLog');
    $('#myModal_create_log').modal({ backdrop: 'static', keyboard: false });
    $("#myformCreateLog")[0].reset();
    myDropzone_log.removeAllFiles(true);
    myDropzone_log.options.autoQueue = false;
    $("#actions_upload_logs .cancel").show();
    $("#myformCreateLog #log_files").html('');
    $("#myformCreateLog button[type=submit]").text('Agregar')
        .removeClass('btn-warning').addClass('btn-primary');

    $("#myformCreateLog .custom-file-label").html('Seleccione un archivo');
    $("#myformCreateLog input[name=fecha_c]").attr('type', 'date').prop('disabled', false)
    $("#myformCreateLog input[name=shared]").prop('checked', false).change();
    $("#myformCreateLog input[name=shared]").bootstrapToggle('enable');
    $("#myformCreateLog input[name=support_docs]").prop('checked', false).change();
    $("#myformCreateLog input[name=support_docs]").bootstrapToggle('enable');

    $("#myformCreateLog input[name=recordatory]").prop('checked', false).change();
    $("#myformCreateLog input[name=recordatory]").bootstrapToggle('enable')
    $("#myformCreateLog input[id=has_file]").val('0');


    $("#myformCreateLog input[name=type_log_id]").val($(this).attr('data-type_log_id'));
    $("#myformCreateLog #case_id").remove();
    $("#myformCreateLog").append($("#case_id").clone().attr('name', 'case_id'));
    $("#lbl_modal_title").text('Nueva actuación');
    $("#myformCreateLog #custom-tabs-four-home-tab").text('Datos');

    //$("#myformCreateLog #shared").remove(); 

    if ($(this).attr('data-type_log_id') == 23) {

        $(".log_r input").prop("disabled", true);
        $(".log_r select").prop("disabled", true);
        $(".log_r").hide();
        $("#lbl_modal_title").text('Nueva notificación');
        $(".optionsnav").hide();
        $("#myformCreateLog #custom-tabs-four-home-tab").text('Notificación');
        $("#myformCreateLog input[name=shared]").prop('checked', true).change().prop('disabled', false);
        $(".btn_datos").click();
    } else {
        $(".log_r input").prop("disabled", false);
        $(".log_r select").prop("disabled", false);
        $(".log_r").show();
        $(".optionsnav").show();
        $("#myformCreateLog input[name=shared]").prop('checked', false).change().prop('disabled', false);

    }
    $("#myformCreateLog input[name=share_on_diary]").prop('checked', false).change();
    $("#myformCreateLog input[name=share_on_diary]").bootstrapToggle('enable')

    $("#myformCreateLog .recordatoryclass").hide();
    $("#myformCreateLog .recordatoryclass input").prop('disabled', true);
    $("#myModal_create_log").modal('show');
});

$(".btnAddLogClientCase").on("click", function (e) {
    $("#myformEditLog").attr('id', 'myformCreateClientLog');
    $('#myModal_create_log').modal({ backdrop: 'static', keyboard: false });
    $("#myformCreateClientLog")[0].reset();
    $("#myformCreateClientLog button[type=submit]").text('Agregar')
        .removeClass('btn-warning').addClass('btn-primary');

    $("#myformCreateClientLog .custom-file-label").html('Seleccione un archivo');


    $("#myformCreateClientLog input[name=type_log_id]").val($(this).attr('data-type_log_id'));
    $("#myformCreateClientLog #case_id").remove();
    $("#myformCreateClientLog").append($("#case_id").clone().attr('name', 'case_id'));
    $("#lbl_modal_title").text('Nueva actuación');


    $(".log_r input").prop("disabled", false);
    $(".log_r select").prop("disabled", false);
    $(".log_r").show();
    $(".optionsnav").show();
    $("#myModal_create_log").modal('show');
});

$("#content_cases").on("click", '.btn_delete_case', function (e) {
    var request = {
        'case_id': $(this).attr('data-id'),

    };
    Swal.fire({
        title: 'Esta seguro de eliminar el caso?',
        text: "Los cambios no podrán ser revertidos!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {

            casef.delete(request)
        }
    });
});


$("#content_form_cl").on("submit", '#myformCreateLog', function (e) {

    var request = new FormData($(this)[0]);
    // $("#myModal_create_log").modal('hide');
    if (myDropzone_log.files.length == 0) {
    } else if (myDropzone_log.getRejectedFiles().length > 0) {

    } else {
        request.append("files", true);
    }
    casef.logStore(request);
    e.preventDefault();
    return false;
});

$("#content_form_cl").on("submit", '#myformCreateClientLog', function (e) {

    var request = new FormData($(this)[0]);

    casef.logStore(request);
    e.preventDefault();
    return false;
});


$("#content_form_cl").on("change", '#type_category_id', function (e) {
    if ($(this).val() == 'other') {
        $("#content_form_cl #category_name").attr('type', 'text').prop('disabled', false);
    } else {
        $("#content_form_cl #category_name").attr('type', 'hidden').prop('disabled', true);
    }

    e.preventDefault();
    return false;

});

$("#content_form_cl").on("change", '#support_docs', function (e) {
    if (($(this).is(":checked"))) {
        if ($("#has_file").val() == 0) $("#content_form_cl #logFile").prop('required', true);
        $("#content_form_cl #type_log_id").val(33);
    } else {
        $("#content_form_cl #logFile").prop('required', false);
        $("#content_form_cl #type_log_id").val(18);
    }
    e.preventDefault();
    return false;
});

$("#content_form_cl").on("change", '#shared_log', function (e) {
    if (($(this).is(":checked") && $("#has_file").val() == 0)) {
        //$("#content_form_cl #logFile").prop('required',true);           
    } else {
        $("#content_form_cl #logFile").prop('required', false);
    }
    e.preventDefault();
    return false;
});

$("#content_form_cl").on("change", '#recordatory', function (e) {
    if (($(this).is(":checked"))) {
        $("#content_form_cl .recordatoryclass").show();
        $("#content_form_cl #share_on_diary").prop('disabled', false);
        $("#content_form_cl #notification_date").prop('disabled', false);



    } else {
        $("#content_form_cl .recordatoryclass").hide();
        $("#content_form_cl #share_on_diary").prop('disabled', true);
        $("#content_form_cl #notification_date").prop('disabled', true);
    }



    e.preventDefault();
    return false;

});


$("#content_form_cl").on("submit", '#myformEditLog', function (e) {

    var request = new FormData($(this)[0]);
    $("#myModal_create_log").modal('hide');
    var id = $("#myformEditLog input[name=id]").val();
    if (myDropzone_log.files.length == 0) {

    } else if (myDropzone_log.getRejectedFiles().length > 0) {
        //alert("The attached file is invalid");
    } else {
        request.append("files", true);
    }
    casef.logUpdate(id, request);
    e.preventDefault();
    return false;

});

$("#content_form_cl").on("submit", '#myformEditClientLog', function (e) {

    var request = new FormData($(this)[0]);
    $("#myModal_create_log").modal('hide');
    var id = $("#myformEditClientLog input[name=id]").val();
    casef.logUpdate(id, request);
    e.preventDefault();
    return false;

});

$(".content_list_logs").on('click', '.btn_edit_log', function (e) {

    var request = { 'id': $(this).attr('data-id') };
    $(".log_r input").prop("disabled", false);
    $(".log_r select").prop("disabled", false);
    $(".log_r").show();
    $(".optionsnav").show();
    $("#lbl_modal_title").text('Actualizando actuación');
    $("#actions_upload_logs .cancel").hide();
    casef.logEdit(request);
    e.preventDefault();
});

$(".content_list_logs").on('click', '.btn_show_log', function (e) {

    var request = { 'id': $(this).attr('data-id') };

    $("#lbl_modal_title").text('Detalles');
    casef.logShow(request);
    e.preventDefault();
});

$(".content_list_logs").on('click', '.btn_delete_log', function (e) {
    var request = { 'id': $(this).attr('data-id') };
    Swal.fire({
        title: 'Esta seguro de elimina el registro?',
        text: "Los cambios no podrán ser revertidos!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {

            casef.logDelete(request);
        }
    });
    e.preventDefault();
});

$(".content_list_logs").on('click', '.btn_show_log_files', function (e) {
    var files_val = $("#input_show_log_files-" + $(this).attr('data-id')).val();
    var files = JSON.parse(files_val);
    var cadena = `<table class="table">`;
    files.forEach(file => {
        cadena += `<tr>
                            <td style="text-align:left"><a target="_blank" style="display:block" href="/oficina/descargar/documento/${file.id}">${file.original_name}</a></td>
                            <td>${(file.size / 1024 / 1024).toFixed(2)} MB</td>
                        </tr>`;
    });
    cadena += `</table>`;
    Swal.fire({
        title: 'Archivos',
        html: "" + cadena + "",
        type: 'info',
        showCancelButton: false,
    });
    e.preventDefault();
});



$('#logFile').on('change', function () {
    if (this.files || this.files.length > 1) {
        const size = (this.files[0].size / 1024 / 1024).toFixed(2);
        const name = (this.files[0].name);
        $(".custom-file-label").html('<small>' + name + ' <i>(' + size + 'MB)</i></small>');
    }
});

$('#logFile_df').on('change', function () {
    if (this.files || this.files.length > 1) {
        const size = (this.files[0].size / 1024 / 1024).toFixed(2);
        const name = (this.files[0].name);
        const type = (this.files[0].type);
        $(".custom-file-label").html('<small>' + name + ' <i>(' + size + 'MB)</i></small>');

        if (type != 'application/pdf') {
            $("#lbl_validate_file").text('El formato no es admitido');
            document.getElementById("logFile_df").value = null;
            document.getElementById("logFile_df").required;
        } else {
            $("#lbl_validate_file").text('');
        }
    }
});

$(".btn_get_logs").on('click', function (e) {

    var request = {
        'type_log_id': $(this).attr('data-type_id'),
        'case_id': $("#myFormEditCase input[name=id]").val()
    }
    casef.getLogs(request);
});

$("#btn_edit_case").on('click', function (e) {
    $("#myFormEditCase select").prop('disabled', false);
    $("#myFormEditCase input[name=case_number]").prop('disabled', false);

    $(".btns_update_case").show();
    $("#btn_edit_case").hide();
});
$("#btn_cancel_case").on("click", function (e) {
    $("#myFormEditCase select").prop('disabled', true);
    $("#myFormEditCase input[name=case_number]").prop('disabled', true);
    $(".btns_update_case").hide();
    $("#btn_edit_case").show();
});

$("#btnAddBillCase").on("click", function (e) {


    var request = {
        'case_id': $("#myFormEditCase input[name=id]").val()
    }
    casef.storePayment(request);
});

$(".content_list_bills").on('click', '.btn_edit_bill', function (e) {

    var request = { 'payment_id': $(this).attr('data-id') };

    $("#myModal_create_bill #lbl_modal_title").text('Actualizando cobro');
    casef.editPayment(request);
    e.preventDefault();
});
$(".content_list_bills").on('click', '.btn_delete_bill', function (e) {
    var request = { 'payment_id': $(this).attr('data-id') };
    Swal.fire({
        title: 'Esta seguro de elimina el cobro?',
        text: "Los cambios no podrán ser revertidos!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {

            casef.deletePayment(request);
        }
    });
    e.preventDefault();
});
$("#myModal_create_bill").on("change", '#type_category_payment_id', function () {
    if (this.value != '') {
        $("#content_list_support_file").hide();
        $("#content_form_support_file").show();
        // $("#myFormSupportFilesDropzone input[name=type_category_id]").val(this.value);
    }
});
$("#myModal_create_bill").on("click", '.btn_delete_file', function (e) {
    var request = {
        'id': $(this).attr('data-pivot'),
        "payment_id": $("#myformEditBill input[name=id]").val()
    };
    Swal.fire({
        title: 'Esta seguro de elimina el archivo?',
        text: "Los cambios no podrán ser revertidos!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {

            casef.deletePaymentSupport(request);
        }
    });
    e.preventDefault();
});

$("#content_list_support_file_log").on("click", '.btn_delete_file', function (e) {
    var request = {
        'id': $(this).attr('data-pivot'),
        "caseL_id": $("#myformEditLog input[name=id]").val()
    };
    Swal.fire({
        title: 'Esta seguro de elimina el archivo?',
        text: "Los cambios no podrán ser revertidos!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {

            casef.deleteLogSupport(request);
        }
    });
    e.preventDefault();
});


$("#myModal_create_bill").on("click", '#btn_end_import_support', function () {
    $("#myFormSupportFilesDropzone")[0].reset();
    $('div.dz-success').remove();
    $('div.dz-message').show();
    $("#myModal_create_bill #type_category_id").val("").change();
    $("#content_list_support_file").show();
    $("#content_form_support_file").hide();

});

$("#myformEditBillCredits").on('submit', function (e) {
    var request = $(this).serialize() + "&payment_id=" +
        $("#myformEditBill input[name=id]").val();

    casef.insertPaymentCredits(request);
    $("#myModal_create_bill").modal('hide');
    e.preventDefault();

});

$("#myformEditBill").on('submit', function (e) {
    var request = $("#myformEditBill").serialize();

    casef.updatePayment(request);
    e.preventDefault();
});

$("#myformEditBillCredits select[name=type_payment_id]").on("change", function () {
    if (this.value == 40) {
        $("#myformEditBillCredits .credit_options").show();
        $(".credit_options input").prop('disabled', false);
        $(".credit_options select").prop('disabled', false);
        $("#myformEditBillCredits .mp_options").hide();
        $(".mp_options select").prop('disabled', true);
        $(".mp_options textarea").prop('disabled', true);
        $("#myformEditBillCredits .des_mp").hide();
        $(".des_mp textarea").prop('disabled', true);

    } else {
        $("#myformEditBillCredits .credit_options").hide();
        $(".credit_options input").prop('disabled', true);
        $(".credit_options select").prop('disabled', true);
        $("#myformEditBillCredits .mp_options").show();
        $(".mp_options select").prop('disabled', false).val('');
    }
});

$("#myformEditBillCredits").on("blur", '.set_val_pcv', function () {
    set_val_pcv();
});

$(".payment_method_id").on("change", function () {
    console.log(this.value)
    if (this.value == 114 && this.value != '') {
        $("#myformEditBillCredits .des_mp").show();
        $("#myformPayCredits .des_mp").show();
        $(".des_mp textarea").prop('disabled', false).val('No cuenta: 88100013080 - Banco: BANCOLOMBIA');
        //   $(".des_mp textarea").prop('disabled',false);
        $(".des_url_pay").hide();
        $(".des_url_pay input").prop('disabled', true);
    } else if (this.value == 115 && this.value != '') {
        $("#myformEditBillCredits .des_mp").hide();
        $("#myformPayCredits .des_mp").hide();
        $(".des_mp textarea").prop('disabled', true);
        //$(".des_mp textarea").prop('disabled',true);

        //$("#myformEditBillCredits .des_mp").show();
        $(".des_url_pay").show();
        // $(".des_mp textarea").prop('disabled',false); 
        $(".des_url_pay input").prop('disabled', false);
    } else {
        $("#myformEditBillCredits .des_mp").hide();
        $("#myformPayCredits .des_mp").hide();
        $(".des_mp textarea").prop('disabled', true);
        // $(".des_mp textarea").prop('disabled',true); 
        $(".des_url_pay").hide();
        $(".des_url_pay input").prop('disabled', true);
    }
});


$(".content_list_bills").on('click', '.btn_pay_credit', function (e) {

    var request = { 'credit_id': $(this).attr('data-id') };

    $("#myModal_pay_credit #lbl_modal_title").text('Actualizando pago');

    casef.payCredit(request);
    e.preventDefault();
});



$(".content_list_bills").on('click', '.btn_confirm_pay_credit', function (e) {

    var request = { 'credit_id': $(this).attr('data-id'), 'type_status_id': 110 };
    Swal.fire({
        title: 'Esta seguro de confirmar el pago?',
        text: "Los cambios no podrán ser revertidos!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, confirmar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {

            casef.updateCredit(request, request.credit_id);
        }
    });
    e.preventDefault();

    /* $("#myModal_pay_credit #lbl_modal_title").text('Actualizando pago');
    
    casef.payCredit(request);
    e.preventDefault(); */
});

$("#myformPayCredits").on('submit', function (e) {

    var request = $(this).serialize();
    casef.updateCredit(request, $("#myformPayCredits input[name=id]").val());

    e.preventDefault();
});

$("#btnDNotification").on("click", function () {
    var select = $("#myformCreateDNotification select[id=destinatarios_df]");
    select.html("");
    var options = '';
    $(".input_user_defdata").each((index, element) => {
        var user = JSON.parse(element.value);
        options += `<option value="${user.id}">${user.name}</option>`;
        console.log(select, user)
    });
    select.html(options);
    $("#myModal_log_defendant_notification").modal('show');
});

$("#content_form_dnotification").on("submit", '#myformCreateDNotification', function (e) {

    var request = new FormData($(this)[0]);
    $("#myModal_log_defendant_notification").modal('hide');
    request.append("case_id", $("#case_id").val());
    casef.logStore(request)
    e.preventDefault();

    return false;

});

$("#myformCreateDNotification input[name=users_all_send]").on("change", function (e) {
    if ($(this).is(":checked")) {

        $("#myformCreateDNotification select[id=destinatarios_df]").prop("disabled", true)
    } else {
        $("#myformCreateDNotification select[id=destinatarios_df]").prop("disabled", false)
    }
});

$("#table_list_defendant").on("click", '.btn_get_umnotificaton', function (e) {
    var request = {
        'notification_id': $(this).attr('data-notification_id'),
        'case_id': $("#case_id").val()
    }

    casef.findUserCase(request)
    e.preventDefault();
});
$("#btnAsigReceptionCase").on("click", function (e) {
    var request = {
        "case_id": $("#case_id").val()
    }
    Swal.fire({
        title: 'Esta seguro de activar el chat?',
        text: "Los cambios no podrán ser revertidos!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, confirmar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {

            casef.asigReception(request);
        }
    });
});


var usersLogin = [];
//getUsersLogin();
function getUsersLogin() {
    $.ajax({
        url: '/get/users/login',
        type: 'POST',
        data: {},
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));

        },
        success: function (res) {
            try {
                if (usersLogin.length != res.length) {

                    /* $(".lbl_chatCountUsers").text(res.length);
                     var viewC = new ViewComponents();
                     var row = viewC.renderUsersLogin(res);
                     $("#list_users_login").html(row); 
                      res.forEach(user => {
                         usersLogin[user.id] = user; 
                     });*/

                }
                //$(".lbl_num_docs").text($(".num_doc").length);


            } catch (error) {
                //console.log(error)
            }

            //| $("#wait").hide()
        },
        error: function (data) {
            //console.log(data);
        }
    });
}

function fillModalEditBill(res) {

    $("#my-form-support-files-dropzone input[name=payment_id]").val(res.payment.id);
    $("#myformEditBill input[name=id]").val(res.payment.id);
    $("#myformEditBill select[name=type_category_id]").val(res.payment.type_category_id);
    $("#myformEditBill input[name=concept]").val(res.payment.concept);
    $("#myformEditBill textarea[name=description]").val(res.payment.description);
    $("#myformEditBillCredits input[name=value]").val(res.payment.value);
    $("#myformEditBillCredits select[name=type_payment_id]").val(res.payment.type_payment_id);
    $("#myformEditBillCredits input[name=num_payments]").val(res.payment.num_payments);
    $("#myformEditBillCredits select[name=type_periodpay_id]").val(res.payment.type_periodpay_id);
    $("#myformEditBillCredits select[name=payment_method_id]").val(113);
    $("#myformEditBill input[name=limit_payment_date]").val('');;
    $(".des_url_pay").hide();
    $("#myformEditBillCredits input[name=description_pmethod]").prop('disabled', true);

    if (res.payment.shared) {
        $("#myformEditBill input[name=shared]").prop('checked', true).change();
    } else {
        $("#myformEditBill input[name=shared]").prop('checked', false).change().bootstrapToggle('enable');
    }
    $("#myformEditBillCredits .mp_options").show();
    $("#myformEditBillCredits .des_mp").hide();
    $("#myformEditBillCredits input").prop('disabled', true);
    $("#myformEditBillCredits select").prop('disabled', true);
    $("#myformEditBillCredits textarea").prop('disabled', true);
    $("#myformEditBillCredits button[type=submit]").prop('disabled', true).hide();


    if (res.payment.credits && res.payment.credits.length > 0) {
        $("#myformEditBillCredits input[name=pay_credit_value]").val(res.payment.credits[0].value);
        first_payment_date = moment(res.payment.credits[0].limit_payment_date).format('YYYY-MM-DD');
        $('#myformEditBillCredits input[name=limit_payment_date]').val(first_payment_date);
        $("#myformEditBillCredits .credit_options").show();
        $("#myformEditBillCredits .mp_options").hide();
        $(".des_mp").hide();
        if (res.payment.type_payment_id == 39) {
            $("#myformEditBillCredits .credit_options").hide();
            $("#myformEditBillCredits select[name=payment_method_id]").val(res.payment.credits[0].payment_method_id);
            $("#myformEditBillCredits .mp_options").show();
            if (res.payment.credits[0].payment_method_id != 113) {
                $("#myformEditBillCredits .des_mp").show();
                $("#myformEditBillCredits textarea[name=description_pmethod]").val(res.payment.credits[0].description_pmethod);
            }
        }
        if (res.payment.credits[0].payment_method_id == 114) {
            $("#myformEditBillCredits .des_mp").show();
            $("#myformEditBillCredits textarea[name=description_pmethod]").val((res.payment.credits[0].description_pmethod)).prop('disabled', true);
        }
        if (res.payment.credits[0].payment_method_id == 115) {
            $("#myformEditBillCredits .des_mp").hide();
            $(".des_url_pay").show();
            $("#myformEditBillCredits input[name=description_pmethod]").val((res.payment.credits[0].description_pmethod)).prop('disabled', true).show();

        }
    } else {
        $("#myformEditBillCredits input[name=pay_credit_value]").val('');
        $("#myformEditBillCredits .credit_options").hide();
        $('#myformEditBillCredits input[name=limit_payment_date]').val('');
        if (res.payment.can_edit) {
            $("#myformEditBillCredits input").prop('disabled', false);
            $("#myformEditBillCredits select").prop('disabled', false);
            $(".credit_options input").prop('disabled', true);
            $(".credit_options select").prop('disabled', true);
            $("#myformEditBillCredits button[type=submit]").prop('disabled', false).show();
        }


    }
    set_val_pcv()
    //$("#myformEditBillCredits input[name=pay_credit_value]").val()
}
function set_val_pcv() {
    if ($("#myformEditBillCredits input[name=value]").val() != '' && $("#myformEditBillCredits input[name=num_payments]").val() != '') {
        var pay_credit_value = parseInt($("#myformEditBillCredits input[name=value]").val()) / parseInt($("#myformEditBillCredits input[name=num_payments]").val())
        $("#myformEditBillCredits input[name=pay_credit_value]").val(Math.ceil(pay_credit_value));
    }
}

function fillModalPayCredit(res) {
    //console.log(res)
    $("#myformPayCredits input[name=id]").val(res.id);
    $("#myformPayCredits input[name=value]").val(res.value);
    limit_payment_date = moment().format('YYYY-MM-DD');
    $("#myformPayCredits button[type=submit]").prop('disabled', false).show();
    $("#myformPayCredits .des_mp").hide();
    $("#myformPayCredits textarea[name=description_pmethod]").val('').prop('disabled', true);
    $("#myformPayCredits .des_url_pay").hide();
    // $("#myformPayCredits input[name=description_pmethod]").val('').prop('disabled',true);
    $("#myformPayCredits .des_button_pay").hide();
    if (res.can_edit) $("#myformPayCredits select[name=payment_method_id]").prop('disabled', false);;
    $("#myformPayCredits select[name=payment_method_id]").val(res.payment_method_id);;

    if (res.type_status_id == 110) {
        limit_payment_date = moment(res.payment_date).format('YYYY-MM-DD');
        $("#myformPayCredits select[name=payment_method_id]").val(res.payment_method_id).prop('disabled', true);;
        $("#myformPayCredits .mp_options_pay").show();
        $("#myformPayCredits button[type=submit]").prop('disabled', true).hide();
    }
    if (res.payment_method_id == 114) {
        $("#myformPayCredits .des_mp").show();
        $("#myformPayCredits textarea[name=description_pmethod]").val((res.description_pmethod)).prop('disabled', true);
        if (res.can_edit) {
            $("#myformPayCredits textarea[name=description_pmethod]").prop('disabled', false);
        }
    }
    if (res.payment_method_id == 115) {
        $("#myformPayCredits .des_url_pay").show();
        $("#myformPayCredits input[name=description_pmethod]").val((res.description_pmethod)).prop('disabled', true).show();
        if (!res.can_edit) {
            $("#myformPayCredits input[name=description_pmethod]").val((res.description_pmethod)).prop('disabled', true).hide();
            $("#myformPayCredits .des_url_pay").hide();
            $("#myformPayCredits a[id=button_pay]").attr('href', res.description_pmethod)
            $("#myformPayCredits .des_button_pay").show();
        } else {
            $("#myformPayCredits input[name=description_pmethod]").prop('disabled', false);

        }
    }
    $("#myformPayCredits input[name=payment_date]").val(limit_payment_date);

}
 
function fillModalCaseLog(res, image_list) {
    $("#myformCreateLog").attr('id', 'myformEditLog');
    $("#myformEditLog")[0].reset();
    $("#myformEditLog input[name=id]").val(res.id);
    $("#myformEditLog input[name=category_name]").val('').prop('disabled', true).attr('type', 'hidden');
    $("#myformEditLog input[name=filing_date]").val(res.filing_date)
    $("#myformEditLog input[name=concept]").val(res.concept)
    $("#myformEditLog input[name=fecha_c]").attr('type', 'text').val(res.created_at).prop('disabled', true)
    $("#myformEditLog input[name=type_log_id]").val(res.type_log_id)
    $("#myformEditLog textarea[name=description]").val(res.description);
    $("#myformEditLog select[name=type_category_id]").val(res.type_category_id)
    $("#myformEditLog input[name=shared]").prop('checked', res.shared).change();
    $("#myformEditLog input[name=share_on_diary]").prop('checked', false).change();
    myDropzone_log.removeAllFiles(true);
    if (res.type_log_id == 18) {
        $("#myformEditLog input[name=support_docs]").prop('checked', false).change()
    } else if (res.type_log_id == 33) {
        $("#myformEditLog input[name=support_docs]").prop('checked', true).change()
    }
    if (res.notification_date != null) {
        $("#myformEditLog input[name=recordatory]").prop('checked', true).change();
        $("#myformEditLog input[name=notification_date]").val(res.notification_date);
        if (res.share_on_diary) {
            $("#myformEditLog input[name=share_on_diary]").prop('checked', true).change();
            $("#myformEditLog input[name=share_on_diary]").bootstrapToggle('disable')
        } else {
            $("#myformEditLog input[name=share_on_diary]").prop('checked', false).change();
            $("#myformEditLog input[name=share_on_diary]").bootstrapToggle('enable')
        }
    } else {
        $("#myformEditLog input[name=recordatory]").prop('checked', false).change();
        $("#myformEditLog input[name=notification_date]").prop('disabled', true);
    }
    //
    if (res.files[0]) {
        $("#myformEditLog .custom-file-label").html('<small><i>' + res.files[0].original_name + '</i></small>')
        $("#myformEditLog input[id=has_file]").val('1');
        $("#myformEditLog #log_files").html(image_list);
        $("#content_form_cl #logFile").prop('required', false);

    } else {
        $("#myformEditLog .custom-file-label").html('<small><i>Sin  Archivo</i></small>')
        $("#myformEditLog input[id=has_file]").val('0');
        if (res.type_log_id == 33) {
            $("#content_form_cl #logFile").prop('required', true);
        }
    }
    $("#myformEditLog button[type=submit]").text('Actualizar')
        .removeClass('btn-primary').addClass('btn-warning')
    $("#wait").hide();
    $("#myModal_create_log").modal('show')

}

function fillModalCaseClientLog(res, image_list) {
    $("#myformCreateClientLog").attr('id', 'myformEditClientLog');
    $("#myformEditClientLog")[0].reset();
    $("#myformEditClientLog input[name=id]").val(res.id);
    $("#myformEditClientLog input[name=category_name]").val('').prop('disabled', true).attr('type', 'hidden');
    $("#myformEditClientLog input[name=concept]").val(res.concept)
    $("#myformEditClientLog input[name=fecha_c]").attr('type', 'text').val(res.created_at).prop('disabled', true)
    $("#myformEditClientLog input[name=type_log_id]").val(res.type_log_id)
    $("#myformEditClientLog textarea[name=description]").val(res.description);
    $("#myformEditClientLog select[name=type_category_id]").val(res.type_category_id)
    $("#myformEditClientLog input[name=shared]").prop('checked', res.shared).change();
    $("#myformEditClientLog input[name=share_on_diary]").prop('checked', false).change();

    //
    if (res.files[0]) {
        $("#myformEditClientLog .custom-file-label").html('<small><i>' + res.files[0].original_name + '</i></small>')
        $("#myformEditClientLog input[id=has_file]").val('1');
        $("#content_form_cl #logFile").prop('required', false);

    } else {
        $("#myformEditClientLog .custom-file-label").html('<small><i>Sin  Archivo</i></small>')
        $("#myformEditClientLog input[id=has_file]").val('0');
        if (res.type_log_id == 33) {
            $("#content_form_cl #logFile").prop('required', true);
        }
    }
    $("#myformEditClientLog button[type=submit]").text('Actualizar')
        .removeClass('btn-primary').addClass('btn-warning')
    $("#wait").hide();
    $("#myModal_create_log").modal('show')

}

function setUserDestSel(user) {
    var select = $("#myformCreateDNotification select[name=destinatarios]");
    var option = `<option value="${user.id}">${user.name}</option>`;
    select.append(option);
}
function getQuestionValues(obj) {
    let data = {};
    if ((($(obj).attr("data-type") == 58
        || $(obj).attr("data-type") == 136) && $(obj).is(":checked"))
        || (($(obj).attr("data-type") != 58 && $(obj).attr("data-type") != 136) && $(obj).val() != '')) {
        data = {
            value: $(obj).attr("data-option") != undefined ? $(obj).val() : $(obj).find(":selected").text(),
            section: $(obj).attr("data-section"),
            type: $(obj).attr("data-type"),
            name: $(obj).attr("data-name"),
            question_id: $(obj).attr("data-reference_id"),
            option_id: $(obj).attr("data-option") != undefined ? $(obj).attr("data-option") : $(obj).val(),
            value_is_other: $("#value_other_text-" + $(obj).attr("data-id")).val(),
        };
    } else {
        data = {
            value: "",
            section: $(obj).attr("data-section"),
            type: $(obj).attr("data-type"),
            name: $(obj).attr("data-name"),
            question_id: $(obj).attr("data-reference_id"),
            option_id: $(obj).attr("data-option") != undefined ? $(obj).attr("data-option") : $(obj).val(),
            value_is_other: "s",
        };
    }
    return data;
}