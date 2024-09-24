export class User {

    constructor(id = "", name = "") {
        this.id = id;
        this.name = name;

    }

    index(request, url) {
        $.ajax({
            url: url,
            type: 'GET',
            cache: false,
            data: request,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
            },
            success: function (res) {

                if (res.view) {
                    $("#content_cases").html(res.view);
                    // $("[data-toggle='toggle']").bootstrapToggle();
                }
                $("#wait").hide();
            },
            error: function (xhr, textStatus, thrownError) {
            }
        });
    }

    store(request) {
        // console.log(request) 
        $.ajax({
            url: '/admin/users',
            type: "POST",
            data: request,
            datatype: 'json',
            cache: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            xhr: function () {
                $("#wait").show()
                var xhr = $.ajaxSettings.xhr();
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', function (event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;
                        if (event.lengthComputable) { percent = Math.ceil(position / total * 100); }
                        $("#progress_bar").show();
                        $("#progressbarwait").css('display', 'block');
                        $("#progress_bar .progress-bar").css("width", + percent + "%");
                        $("#progress_bar .progress-bar").text(percent + "%");
                        $('#progressGeneral').css('width', percent + '%');
                        $('#progressGeneral').html(percent + '%');
                        if (percent >= 100) {
                            $("#progress_bar .progress-bar").text("Terminando el proceso...");
                            $('#progressGeneral').html('Terminando proceso...');
                        }
                    }, true);
                }
                return xhr;
            }
            //	mimeType:"multipart/form-data"
        }).done(function (res) { //
            $("#progress_bar").hide();
            $("#wait").hide();
            if (res.errors) {
                res.errors.forEach(error => {
                    toastr.error(error, '',
                        { "positionClass": "toast-top-right", "timeOut": "5000" });
                    console.log(error)
                });
            } else {
                try {
                    if (res.render_view || res.render_view == '') {
                        $("#content_list_users_table").html(res.render_view);
                        $("#myModal_create_user").modal('hide');

                    }
                    Toast.fire({
                        type: 'success',
                        title: 'Perfil agregado con éxito.'
                    });
                } catch (error) {
                    toastr.error('A ocurrido un error, refresque la página, si el error persiste, consulte con el adiministrador', 'Error',
                        { "positionClass": "toast-top-right", "timeOut": "50000" });
                }
            }
        });
    }

    delete(id) {

        var route = "/admin/users/" + id;

        $.ajax({
            url: route,
            type: 'DELETE',
            datatype: 'json',
            data: {},
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show();
            },
            /*muestra div con mensaje de 'regristrado'*/
            success: function (res) {
                $("#wait").hide();
                try {
                    if (res.render_view || res.render_view == '') {
                        $("#content_list_users_table").html(res.render_view);
                        Toast.fire({
                            type: 'success',
                            title: 'Los datos se eliminaron con éxito.'
                        });

                    }
                } catch (error) {
                    toastr.error('A ocurrido un error, refresque la página, si el error persiste, consulte con el adiministrador', 'Error',
                        { "positionClass": "toast-top-right", "timeOut": "50000" });
                }
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
                $("#wait").hide();
            }
        });
    }

    findUser(request) {
        $.ajax({
            url: '/users/find',
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
                if (Object.entries(res).length > 0 && res.identification_number !== null) {
                    $("#myformCreateNewUser input[name=id]").val(res.id);
                    $("#myformCreateNewUser input[name=name]").val(res.name).prop('disabled', true);
                    $("#myformCreateNewUser input[name=email]").val(res.email).prop('disabled', true);
                    $("#myformCreateNewUser input[name=phone_number]").val(res.phone_number).prop('disabled', true);
                    $("#myformCreateNewUser input[name=address]").val(res.address).prop('disabled', true);
                    $("#myformCreateNewUser select[name=role_id]").prop('disabled', true).hide();
                    $("#myformCreateNewUser select[name=password]").prop('disabled', true).hide();
                    if (res.roles != null && res.roles.length > 0) {
                        $("#myformCreateNewUser #lbl_rol_status").text(res.roles[0].display_name);
                    } else {
                        $("#myformCreateNewUser #lbl_rol_status").text('Sin rol asignado');
                    }

                    $("#myformCreateNewUser input[name=password]").val('').prop('disabled', true);
                    $("#myformCreateNewUser button[type=button]").show();
                    $("#myformCreateNewUser button[type=submit]").hide();
                } else {
                    $("#myformCreateNewUser #lbl_rol_status").text('');
                    $("#myformCreateNewUser input[name=id]").val('').prop('disabled', false);
                    $("#myformCreateNewUser input[name=name]").val('').prop('disabled', false);
                    $("#myformCreateNewUser input[name=email]").val($("#myformCreateNewUser input[name=identification_number]").val() + '@defaultmail.com').prop('disabled', false);
                    $("#myformCreateNewUser input[name=phone_number]").val('').prop('disabled', false);
                    $("#myformCreateNewUser input[name=address]").val('').prop('disabled', false);
                    $("#myformCreateNewUser select[name=role_id]").prop('disabled', false).show();
                    $("#myformCreateNewUser select[name=password]").prop('disabled', false).show();


                    $("#myformCreateNewUser input[name=password]").val(request.identification_number).prop('disabled', false);
                    $("#myformCreateNewUser button[type=button]").hide();
                    $("#myformCreateNewUser button[type=submit]").show();
                }
                //console.log(request)
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }



    update(data) {
        var route = "/admin/users/update";
        $.ajax({
            url: route,
            headers: { 'X-CSRF-TOKEN': token },
            type: 'POST',
            datatype: 'json',
            data: data,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show();
            },
            success: function (res) {
                $("#wait").hide();
                if (res.error) {

                    Toast.fire({
                        type: 'warning',
                        title: res.error
                    });
                } else if (res.errors) {
                    res.errors.forEach(error => {
                        toastr.error(error, '',
                            { "positionClass": "toast-top-right", "timeOut": "5000" });

                    });
                } else {
                    $(".lbl_user_name").text(res.name);

                    if (res.roles && res.roles.length > 0) $("#lbl_rol_name").text(res.roles[0].display_name);
                    if ($("#myformchangepassword").length > 0) $("#myformchangepassword")[0].reset();
                    if ($("#btn_chstatus-" + res.id).length > 0) $("#btn_chstatus-" + res.id).remove();
                    if ($("#cont_stauser-" + res.id).length > 0) $("#cont_stauser-" + res.id).remove();
                    Toast.fire({
                        type: 'success',
                        title: 'Los datos se actualizaron con éxito.'
                    });

                }
                $("#wait").hide();
                // window.location.reload()
            },
            error: function (xhr, textStatus, thrownError) {
                $("#wait").hide();
                Toast.fire({
                    type: 'warning',
                    title: 'Error.'
                });

            }
        });

    }

    addStaticData(request) {
        $.ajax({
            url: '/add/static/data',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                // $("#wait").show();                   
            },
            /*muestra div con mensaje de 'regristrado'*/
            success: function (res) {
                $("#wait").hide();
                try {
                    $("#content_user_question-" + request.reference_data_id).html(res.q_view);

                    toastr.success('Guardado con éxito!', '',
                        { "positionClass": "toast-bottom-right", "timeOut": "1000" });
                } catch (error) {

                }
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
                $("#wait").hide();
            }
        });
    }
}