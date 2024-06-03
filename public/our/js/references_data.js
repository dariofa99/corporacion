import { ReferenceData } from "./services/referencesdata.js";
import { convertFormToJSON } from "./scripts.js";
import { HttpService } from "./services/http.js";
let itemsDel = [];
const httpService = new HttpService();
$(function () {

    $("#btn_new_category").on('click', function (e) {
        $("#myformEditRCategory").attr('id', 'myformCreateRCategory');
        $("#myformCreateRCategory")[0].reset();
        $("#content_section_users").hide();
        $("#content_section_users select").prop('disabled', true);
        $(".adoptions_g").hide();
        $("#aditional_options_table input").prop('disabled', true);
        // $("#content_section_users select").prop('disabled',true);
        $("#myformCreateRCategory button[type=submit]").text('Crear')
            .removeClass('btn-warning').addClass('btn-primary');
        $("#lbl_modal_title").text("Nueva categoria");

        $("#myModal_create_cate").modal('show');
        e.preventDefault();
    });

    $("#content_form_rc").on("submit", '#myformCreateRCategory', async function (e) {
        e.preventDefault();
        var request = convertFormToJSON("myformCreateRCategory") // $(this).serialize();
        //var reference = new ReferenceData();
        if (request.type_data_id == 58 || request.type_data_id == 136) {
            let options = request.option_name;
            if (options == undefined) {
                Swal.fire({
                    title: 'No hay opciones de repuesta?',
                    text: "La pregunta requiere de opciones de respuesta!",
                    type: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Entendido!',
                })
                return
            }
        } else {
            request.option_name = [request.name];
            request.active_other_input = [0]
        }

        await httpService.post("categorias", request, function (data) {
            if (data.errors != undefined && data.errors.length > 0) {
                Swal.fire({
                    title: 'Error',
                    text: data.errors[0],
                    type: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Entendido!',
                })
            } else {
                if (data.render_view || data.render_view == '') {
                    $("#content_list_categories").html(data.render_view);
                    Toast.fire({
                        type: 'success',
                        title: 'Categoria creada con éxito.'
                    });
                }
                $("#myModal_create_cate").modal('hide');

            }
        })
        // reference.store(request);
        console.log(request);

    });

    $("#content_list_categories").on("click", '.btn_edit_category', function (e) {
        let id = $(this).attr('data-id')
        var reference = new ReferenceData();
        itemsDel = [];
        reference.edit(id);
        e.preventDefault();
    });

    $("#content_form_rc").on("submit", '#myformEditRCategory', async function (e) {
        e.preventDefault();
        var request = convertFormToJSON("myformEditRCategory");// $(this).serialize();
        if (request.type_data_id == 58 || request.type_data_id == 136 || request.type_data_id == 147) {

            if (request.option_name == undefined) {
                Swal.fire({
                    title: 'No hay opciones de repuesta?',
                    text: "La pregunta requiere de opciones de respuesta!",
                    type: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Entendido!',
                })
                return
            }
        } else if (request.option_name == undefined) {
            request['option_name'] = [request.name];
            request.active_other_input = [0]
        }
        if (itemsDel.length > 0) {
            request["itemsDelete"] = itemsDel
        }
        await httpService.put("categorias/" + request.id, request, function (res) {
            if (res.render_view || res.render_view == '') {
                $("#content_list_categories").html(res.render_view);
                Toast.fire({
                    type: 'success',
                    title: 'Categoria actualizada con éxito.'
                });
            }
            $("#myModal_create_cate").modal('hide');
        });
    });

    $("#select_categories").on("change", function (e) {
        /* $(".chkadoptions").hide();
        $(".adoptions").hide();
        $(".adoptions input").prop('disabled',true); */
        $("#type_data_id").val(26)
        if ($(this).val() == 'type_data_user') {
            $("#content_section_users").show()
            $("#content_section_users select").prop('disabled', false);
        } else {
            $("#content_section_users").hide();
            $("#content_section_users select").prop('disabled', true)
        }
    });
    $("#type_data_id_select").on("change", function (e) {
        $("#content_aditional_options").hide()
        itemsDel=[];
        if ($(this).val() == '58' || $(this).val() == '136' || $(this).val() == '147') {
            $("#content_aditional_options").show()
            var item = $(".option_row").length;
            if (item == 0) addOptionTable(item);
        } else {
            $("#aditional_options_table tbody").html("")
        }

    });

    $("#select_section_user").on("change", function (e) {
        /* $(".adoptions").hide();
        $(".adoptions input").prop('disabled',true);
        $("#chk_add_option").prop("checked",false);
        $("#type_data_id").val(26)
          if($(this).val()=='aditional_info'){
              $(".chkadoptions").show();
          }else{
            $(".chkadoptions").hide();
          } */
    });

    $("#content_list_categories").on('click', '.btn_delete_category', function (e) {
        var request = { 'id': $(this).attr('data-id') };
        Swal.fire({
            title: 'Esta seguro de eliminar la categoría?',
            text: "Los cambios no podrán ser revertidos!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                var reference = new ReferenceData();
                reference.delete(request);
            }
        });
        e.preventDefault();
    });

    $(".btn_add_field").on("click", function (e) {
        var item = $(".option_row").length;
        addOptionTable(item);

    });

    $("#chk_add_option").on("change", function (e) {
        if ($(this).is(":checked")) {
            var item = $(".option_row").length;
            if (item == 0) {
                addOptionTable(item);
            }
            $(".adoptions").show();
            $(".adoptions input").prop('disabled', false);
            $("#type_data_id").val(58);
            $("#sel_answer_type").show();
            $("#sel_answer_type select").prop('disabled', false);
        } else {
            $(".adoptions").hide();
            $(".adoptions input").prop('disabled', true);
            $("#type_data_id").val(26);
            $("#sel_answer_type").hide();
            $("#sel_answer_type select").prop('disabled', true);
        }

    });

    $("#content_aditional_options").on("click", '.btn_delete_option_row', function (e) {
        var older_row = ($(this).attr('data-item'));
        var optionde = $("#idoption-" + older_row).val();
        if (optionde != null && optionde != 'null') itemsDel.push(optionde);
        $("#option_row-" + older_row).remove();
        $(".option_row").each((row, obj) => {
            var current_row = $(obj).attr('data-item') - 1;
            if ((current_row) == older_row) {
                $(obj).attr('data-item', older_row);
                $(obj).attr('id', 'option_row-' + older_row);
                $(obj).find('button').attr('data-item', older_row)
                $(obj).find('button').attr('id', 'option_row-' + older_row);
                older_row = parseInt(older_row) + 1;
                $(obj).find('input[id=active_other_input-' + older_row + ']').attr('id', 'active_other_input-' + current_row);
                $(obj).find('input[id=active-' + older_row + ']').attr('id', 'active-' + current_row);
            }

        });
        if (older_row <= 0) {
            $("#chk_add_option").prop("checked", false);
            $(".adoptions").hide();
            $("#type_data_id").val(26)
        }
    });

    $("#content_aditional_options").on("click", '.chk_active_other_input', function (e) {
        var item = $(this).attr('id').split('-')[1];
        console.log(item);
        if ($(this).is(":checked")) {
            $("#active_other_input-" + item).val(1)
        } else {
            $("#active_other_input-" + item).val(0)
        }
    });

});

function addOptionTable(item) {
    var row = `<tr class="option_row" data-item="${item}" id="option_row-${item}">
                <td>
                    <input  type="text" required name="option_name[]" class="form-control form-control-sm">
                </td>
                <td>
                    <input type="hidden" id="active_other_input-${item}" name="active_other_input[]" value="0">
                    <input type="hidden" id="idoption-${item}"  name="options_id[]" value="null">
                    <input type="checkbox" id="active-${item}" class="chk_active_other_input" data-size="xs" data-style="order-check" data-width="60" data-toggle="toggle" data-on="1" data-off="0" data-onstyle="primary" data-offstyle="warning">
                </td>
                <td>
                    <button type="button" id="btn_delete_option_row-${item}" data-item="${item}" class="btn btn-danger btn-sm btn_delete_option_row">
                    <i class="fa fa-times"></i></button>
                </td>               
            </tr>`;
    $("#aditional_options_table tbody").append(row);

}