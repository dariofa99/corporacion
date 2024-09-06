export class CaseM {

    constructor(id = "", case_number = "", status = "", type_case = "", type_branch_law = "") {
        this.id = id;
        this.case_number = case_number;
        this.status = status;
        this.type_case = type_case;
        this.type_branch_law = type_branch_law;
    }

  
    
    index(request, url) {
        $.ajax({
            url: url,
            type: 'GET',
            cache: false,
            data: request,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show()
            },
            success: function (res) {

                if (res.view) {
                    $("#content_cases").html(res.view);
                    $("#content_list_users_table").html(res.view);
                    // $("[data-toggle='toggle']").bootstrapToggle();
                }
                $("#wait").hide();
            },
            error: function (xhr, textStatus, thrownError) {
            }
        });
    }

    store(request) {

        $.ajax({
            url: '/casos',
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
                Swal.fire({
                    title: 'Creado con éxito.',
                    type: 'success',
                });
                $("#myFormCreateCase")[0].reset();
                $("#myFormCreateCase input[name=case_number]").val(res.new_id);
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    update(request) {

        $.ajax({
            url: '/casos/' + this.id,
            type: 'PUT',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show();

            },
            success: function (res) {
                $("#wait").hide();
                Toast.fire({
                    title: 'Actualizado con éxito.',
                    type: 'success',
                });
                $("#myFormEditCase select").prop('disabled', true);
                $("#myFormEditCase input[name=case_number]").prop('disabled', true);
                $(".btns_update_case").hide();
                $("#btn_edit_case").show();
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    delete(request) {

        $.ajax({
            url: '/casos/' + request.case_id,
            type: 'DELETE',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show();

            },
            success: function (res) {
                $("#wait").hide();
                Swal.fire({
                    title: 'Eliminado con éxito.',
                    type: 'success',
                });
                $("#row-case-" + request.case_id).remove();
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
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
                    $("#myformCreateUser input[name=id]").val(res.id);
                    $("#myformCreateUser input[name=name]").val(res.name).prop('disabled', true);
                    $("#myformCreateUser input[name=email]").val(res.email).prop('disabled', true);
                    $("#myformCreateUser input[name=phone_number]").val(res.phone_number).prop('disabled', true);
                    $("#myformCreateUser input[name=address]").val(res.address).prop('disabled', true);
                    $("#myformCreateUser select[name=role_id]").prop('disabled', true).hide();
                    if (res.roles.length > 0) {
                        $("#myformCreateUser #lbl_rol_status").text(res.roles[0].display_name);
                    } else {
                        $("#myformCreateUser #lbl_rol_status").text('Sin rol asignado');
                    }

                    $("#myformCreateUser input[name=password]").val('').prop('disabled', true);
                    $("#myformCreateUser button[type=button]").show();
                    $("#myformCreateUser button[type=submit]").hide();
                } else {
                    $("#myformCreateUser #lbl_rol_status").text('');
                    $("#myformCreateUser input[name=id]").val('').prop('disabled', false);
                    $("#myformCreateUser input[name=name]").val('').prop('disabled', false);
                    $("#myformCreateUser input[name=email]").val($("#myformCreateUser input[name=identification_number]").val() + '@defaultmail.com').prop('disabled', false);
                    $("#myformCreateUser input[name=phone_number]").val('').prop('disabled', false);
                    $("#myformCreateUser input[name=address]").val('').prop('disabled', false);
                    if ($("#myformCreateUser input[name=type_user_id]").val() == 7) {
                        $("#myformCreateUser select[id=vo_role_id]").prop('disabled', false).show();
                    } else if ($("#myformCreateUser input[name=type_user_id]").val() == 8) {
                        $("#myformCreateUser select[id=prof_role_id]").prop('disabled', false).show();
                    } else {
                        $("#myformCreateUser #lbl_rol_status").text('No se asignará rol');
                    }
                    $("#myformCreateUser input[name=password]").val(request.identification_number).prop('disabled', false);
                    $("#myformCreateUser button[type=button]").hide();
                    $("#myformCreateUser button[type=submit]").show();
                }
                //console.log(request)
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    findUserCase(request) {
        $.ajax({
            url: '/casos/find/notification',
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
                if (Object.entries(res.notification).length > 0) {
                    $("#content_notification_defendant_details p[id=concept]").text(res.notification.log.concept);
                    var text = res.notification.log.description.replace(/\r?\n/g, '<br />');
                    $("#content_notification_defendant_details p[id=description]").html(text);
                    $("#content_notification_defendant_details p[id=created_at]").text(res.notification.created_at);
                    if (res.notification.log.files.length > 0) {
                        $("#content_notification_defendant_details a[id=log_file_name]").attr('href', '/oficina/descargar/documento/' + res.notification.log.files[0].id).text(res.notification.log.files[0].original_name);
                        $("#content_notification_defendant_details p[id=log_size]").text((res.notification.log.files[0].size));
                        if (res.notification.log.files[0].size > 1024) {
                            $("#content_notification_defendant_details p[id=log_size]").text((res.notification.log.files[0].size / 1024 / 1024).toFixed(2) + 'MB');
                        }
                    }
                    $("#content_notification_defendant_details p[id=notification_status]").text(res.notification.status);
                    if (res.notification.access_address) {
                        $("#content_notification_defendant_details span[id=lbl_accadd_browser]").text((res.notification.access_address.browser));
                        $("#content_notification_defendant_details span[id=lbl_ipaddress]").text((res.notification.access_address.ip));
                        $("#content_notification_defendant_details span[id=lbl_os]").text((res.notification.access_address.os));
                        $("#content_notification_defendant_details span[id=lbl_time]").text((res.notification.access_address.time));
                        $("#content_notification_defendant_details span[id=lbl_country]").text((res.notification.access_address.country));
                        $("#content_notification_defendant_details span[id=lbl_city]").text((res.notification.access_address.city));

                        $("#content_notification_defendant_details #cont_access_data").show();
                    } else {
                        $("#content_notification_defendant_details #cont_access_data").hide()
                    }

                    $("#myModal_notification_defendant_details").modal('show')
                }

            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    storeUser(request) {
        $.ajax({
            url: '/admin/users',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show();

            },
            success: function (res) {
                if ((res.user)) {
                    $("#myFormCreateCase input[name=user_id]").val(res.user.id);
                    $("#myFormCreateCase input[name=user_identification_number]").val(res.user.identification_number)
                    if (res.user.type_user_id == 7 && (res.render_view || res.render_view == '')) {
                        $("#content_client_data").html(res.render_view);
                    }
                    if (res.user.type_user_id == 21 && (res.render_view || res.render_view == '')) {
                        $("#table_list_defendant tbody").html(res.render_view);
                        //setUserDestSel(res.user)
                    }
                    if (res.user.type_user_id && res.user.type_user_id == 8 && (res.render_view || res.render_view == '')) {
                        $("#table_list_professional tbody").html(res.render_view)
                    }
                    if (res.user.type_user_id && res.user.type_user_id == 25 && (res.render_view || res.render_view == '')) {
                        $("#table_list_interventor tbody").html(res.render_view);
                        //setUserDestSel(res.user);
                    }
                    $("#myModal_create_user").modal('hide');
                }
                if (res.errors) {
                    res.errors.forEach(error => {
                        /*   Toast.fire({
                              title: error,
                              type: 'error', 
                              timer: 5000,               
                            });  */
                        toastr.error(error, '',
                            { "positionClass": "toast-top-right", "timeOut": "5000" });

                    });
                }

                $("#wait").hide();



            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
                $("#wait").hide();
            }
        });
    }

    insertData(request) {
        $.ajax({
            url: '/casos/insert/data',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));

            },
            success: function (res) {

                toastr.success('Guardado con éxito!', '',
                    { "positionClass": "toast-bottom-right", "timeOut": "1000" });
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    insertUserData(request) {
        var casef = this;
        $.ajax({
            url: '/users/insert/data',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));

            },
            success: function (res) {
                var viewC = new ViewComponents();
                var row = viewC.loadUserData(res.data);
                $(".content_user_data").html(row);
                toastr.success('Guardado con éxito!', '',
                    { "positionClass": "toast-bottom-right", "timeOut": "1000" });
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    getUserData(request) {
        var casef = this;
        $.ajax({
            url: '/users/get/data',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show();
            },
            success: function (res) {
                var viewC = new ViewComponents();
                var row = viewC.loadUserData(res.data)
                $(".content_user_data").html(row);
                $("#myModal_user_data").modal("show");
                $("#user_id").val(res.id);
                $("#wait").hide();
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    deleteUserCase(request) {
        $.ajax({
            url: '/casos/delete/user',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show();
            },
            success: function (res) {
                ////console.log(res) 
                $("#wait").hide();          
                if (request.type_user_id == 7) {
                    $("#wait").show();
                   location.reload(true)
                   toastr.success('Eliminado con éxito!', '',
                   { "positionClass": "toast-bottom-right", "timeOut": "1000" });
           
                    //$("#content_client_data").html(res.render_view);
                }
                if (request.type_user_id == 21 && (res.render_view || res.render_view == '')) {
                    $("#table_list_defendant tbody").html(res.render_view);
                }
                if (request.type_user_id == 8 && (res.render_view || res.render_view == '')) {
                    $("#table_list_professional tbody").html(res.render_view)
                }
                if (request.type_user_id == 25 && (res.render_view || res.render_view == '')) {
                    $("#table_list_interventor tbody").html(res.render_view);
                }
               
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    deleteNoveltyCase(request) {
        $.ajax({
            url: '/casos/delete/novelty',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show();
            },
            success: function (res) {
                ////console.log(res) 
                $("#wait").hide();
                toastr.success('Eliminado con éxito!', '',
                    { "positionClass": "toast-bottom-right", "timeOut": "1000" });
                
                /* if (request.type_user_id == 7) {
                    $("#wait").show();
                   location.reload(true)
                   toastr.success('Eliminado con éxito!', '',
                   { "positionClass": "toast-bottom-right", "timeOut": "1000" });
           
                    //$("#content_client_data").html(res.render_view);
                } */
                $("#table_list_novelty tbody").html(res.render_view);
               
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    editNoveltyCase(id) {
        $.ajax({
            url: '/casos/edit/noveltydata/'+id,
            type: 'GET',
            datatype: 'json',
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show();
            },
            success: function (res) {
                ////console.log(res) 
                $("#wait").hide();
                
                if ($('body').find('#myModal_edit_novelty').length === 0) {
                    const casef = new CaseM();
                    
                    $("body").append(res.render_view);
                    document.getElementById('state_novelty_edit').addEventListener('change', function() {
                        var selectedValue = this.options[this.selectedIndex].text;
                        
                        document.getElementById('value_novelty_edit').value = selectedValue;
                    });

                    $('#myformEditNovelty').on('submit', function(event) {
                        event.preventDefault();
                    
                        // Extract values from the form
                        var questionId = document.getElementById('types_category_novelty_edit').value;
                        var optionId = document.getElementById('state_novelty_edit').value;
                        var value = document.getElementById('value_novelty_edit').value;
                    
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
                    
                        casef.updateNoveltyCase(request);
                      });
                }
                $("#myModal_edit_novelty").modal('show');
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    addNoveltyCase(request) {
        $.ajax({
            url: '/casos/add/noveltydata',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show();
            },
            success: function (res) {
                ////console.log(res) 
                $("#wait").hide();
                $("#myModal_create_novelty").modal('hide');
                toastr.success('Guardado con éxito!', '',
                    { "positionClass": "toast-bottom-right", "timeOut": "1000" });
                
                $("#table_list_novelty tbody").html(res.render_view);
               
            },
            error: function (xhr, textStatus, thrownError) {
                $("#myModal_create_novelty").modal('hide');
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    updateNoveltyCase(request) {
        $.ajax({
            url: '/casos/add/noveltydata',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show();
            },
            success: function (res) {
                ////console.log(res) 
                $("#wait").hide();
                $("#myModal_edit_novelty").modal('hide');
                toastr.success('Guardado con éxito!', '',
                    { "positionClass": "toast-bottom-right", "timeOut": "1000" });
                
                $("#table_list_novelty tbody").html(res.render_view);
               
            },
            error: function (xhr, textStatus, thrownError) {
                $("#myModal_edit_novelty").modal('hide');
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }


    deleteNoveltyHasCase(request) {
        $.ajax({
            url: '/casos/delete/novelty_has',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show();
            },
            success: function (res) {
                ////console.log(res) 
                $("#wait").hide();
                toastr.success('Eliminado con éxito!', '',
                    { "positionClass": "toast-bottom-right", "timeOut": "1000" });
                
                /* if (request.type_user_id == 7) {
                    $("#wait").show();
                   location.reload(true)
                   toastr.success('Eliminado con éxito!', '',
                   { "positionClass": "toast-bottom-right", "timeOut": "1000" });
           
                    //$("#content_client_data").html(res.render_view);
                } */
                $("#table_list_novelty_has tbody").html(res.render_view);
               
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    editNoveltyHasCase(id) {
        $.ajax({
            url: '/casos/edit/noveltyhasdata/'+id,
            type: 'GET',
            datatype: 'json',
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show();
            },
            success: function (res) {
                ////console.log(res) 
                $("#wait").hide();
                
                if ($('body').find('#myModal_edit_novelty_has').length === 0) {
                    const casef = new CaseM();
                    
                    $("body").append(res.render_view);
                    document.getElementById('state_novelty_has_edit').addEventListener('change', function() {
                        var selectedValue = this.options[this.selectedIndex].text;
                        
                        document.getElementById('value_novelty_has_edit').value = selectedValue;
                    });

                    $('#myformEditNoveltyHas').on('submit', function(event) {
                        event.preventDefault();
                    
                        // Extract values from the form
                        var questionId = document.getElementById('types_category_novelty_has_edit').value;
                        var optionId = document.getElementById('state_novelty_has_edit').value;
                        var value = document.getElementById('value_novelty_has_edit').value;
                    
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
                    
                        casef.updateNoveltyHasCase(request);
                      });
                }
                $("#myModal_edit_novelty_has").modal('show');
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    addNoveltyHasCase(request) {
        $.ajax({
            url: '/casos/add/noveltyhasdata',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show();
            },
            success: function (res) {
                ////console.log(res) 
                $("#wait").hide();
                $("#myModal_create_novelty_has").modal('hide');
                toastr.success('Guardado con éxito!', '',
                    { "positionClass": "toast-bottom-right", "timeOut": "1000" });
                
                $("#table_list_novelty_has tbody").html(res.render_view);
               
            },
            error: function (xhr, textStatus, thrownError) {
                $("#myModal_create_novelty_has").modal('hide');
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    updateNoveltyHasCase(request) {
        $.ajax({
            url: '/casos/add/noveltyhasdata',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show();
            },
            success: function (res) {
                ////console.log(res) 
                $("#wait").hide();
                $("#myModal_edit_novelty_has").modal('hide');
                toastr.success('Guardado con éxito!', '',
                    { "positionClass": "toast-bottom-right", "timeOut": "1000" });
                
                $("#table_list_novelty_has tbody").html(res.render_view);
               
            },
            error: function (xhr, textStatus, thrownError) {
                $("#myModal_edit_novelty_has").modal('hide');
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }



    insertUser(request) {
        var casef = this;
        $.ajax({
            url: '/casos/insert/user',
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
                if (res.type_user_id == 7) {
                    $("#wait").show();
                    toastr.success('Guardado con éxito!', '',
                    { "positionClass": "toast-bottom-right", "timeOut": "1000" });
                    
                    location.reload(true)
                }
                if (res.type_user_id == 21 && (res.render_view || res.render_view == '')) {
                    $("#table_list_defendant tbody").html(res.render_view);
                    //setUserDestSel(res.user);
                }
                if (res.type_user_id == 8 && (res.render_view || res.render_view == '')) {
                    $("#table_list_professional tbody").html(res.render_view);
                }
                if (res.type_user_id == 25 && (res.render_view || res.render_view == '')) {
                    $("#table_list_interventor tbody").html(res.render_view);
                    //setUserDestSel(res.user);
                }
                
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    indexLog(request, url) {
        $.ajax({
            url: url,
            type: 'GET',
            cache: false,
            data: request,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
            },
            success: function (res) {

                if (res.render_view || res.render_view == '') {
                    $("#table_list_logs tbody").html(res.render_view);
                }
                $("#wait").hide();
            },
            error: function (xhr, textStatus, thrownError) {
            }
        });
    }

    logStore(request) {

        $.ajax({
            url: '/casos/logs',
            type: "POST",
            data: request,
            contentType: false,
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
                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }

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
            try {
                if (res.type_log_id == '22') {
                    $("#content_list_doc_send").html(res.view);
                    $("#myModal_create_log").modal('hide');
                    Toast.fire({
                        title: 'Documento creado con éxito.',
                        type: 'success',
                        timer: 2000,
                    });
                } else if (res.type_log_id == '18' || res.type_log_id == '33' || res.type_log_id == '23') {
                    $("#table_list_logs tbody").html(res.view);
                    if (res.render_suport_logs) {
                        $("#accordion_support_logs").html(res.render_suport_logs);
                    }
                    if (res.new_category) {
                        var option = `<option value="${res.type_category_id}">${res.new_category}</option>`;
                        $("#content_form_cl #type_category_id").append(option);
                    }
                    if (Object.entries(res.caseL).length > 0) {
                        $("#myformCreateLog input[name=id]").val(res.caseL.id);
                        if (myDropzone_log.files.length == 0) {
                            $("#myModal_create_log").modal('hide');
                        } else if (myDropzone_log.getRejectedFiles().length > 0) {
                            //alert("The attached file is invalid");
                        } else {
                            $("#actions_upload_logs .start").trigger('click');
                            $("#custom-tabs-data-tab").removeClass("active").attr('aria-selected', false);;
                            $("#custom-tabs-data").removeClass("active").removeClass("show");
                            $("#custom-tabs-options-tab").removeClass("active").attr('aria-selected', false);
                            $("#custom-tabs-options").removeClass("active").removeClass("show");
                            $("#custom-tabs-files-tab").addClass("active").attr('aria-selected', true);;
                            $("#custom-tabs-files").addClass("active").addClass("show");
                        }
                    }
                    Toast.fire({
                        title: 'Actuación creada con éxito.',
                        type: 'success',
                        timer: 2000,
                    });
                    // $("#table_list_logs tbody [data-toggle='toggle']").bootstrapToggle();
                } else if (res.type_log_id == '23') {
                    Toast.fire({
                        type: 'success',
                        title: 'La notificación se ha enviado con éxito.'
                    });
                } else if (res.type_log_id == '105' && (res.render_view || res.render_view == '')) {
                    $("#table_list_defendant tbody").html(res.render_view);
                    $('[data-toggle="tooltip"]').tooltip();

                }
            } catch (error) {

            }
            if (res.mail_error) {
                toastr.error(res.mail_error, 'Error',
                    { "positionClass": "toast-top-right", "timeOut": "10000" });
            }
        });


    }

    logEdit(request) {
        $.ajax({
            url: '/casos/logs/' + request.id + '/edit',
            type: 'GET',
            data: request,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show()
            },
            success: function (res) {
                $("#wait").hide();
                if (res.caseL.type_log_id != 22) {
                    $('#myModal_create_log').modal({ backdrop: 'static', keyboard: false })
                    fillModalCaseLog(res.caseL, res.image_list);
                    myDropzone_log.options.autoQueue = true;
                } else if (res.caseL.type_log_id == 22) {
                    //if($("#myformEditClientLog").length>0){
                    fillModalCaseClientLog(res.caseL, res.image_list)
                    //}

                }

            },
            error: function (data) {
                //console.log(data);
            }
        });
    }
    
   
    logShow(request) {

        $.ajax({
            url: '/casos/logs/' + request.id,
            type: 'GET',
            data: request,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show()
            },
            success: function (res) {

                //console.log(res)                   
                $("#wait").hide();
                $("#content_form_details_log #concept").text(res.concept);
                var text = res.description.replace(/\r?\n/g, '<br />');
                $("#content_form_details_log #description").html(text)
                $("#content_form_details_log #category").text(res.type_category.name);
                $("#content_form_details_log #created_at").text(res.created_at);
                var filing_date = res.filing_date != null ? res.filing_date : 'Sin fecha';
                $("#content_form_details_log #lbl_filing_date").text(filing_date);

                $("#content_form_details_log #user_created").text(res.user.name);
                var table = $("#list_files_log_details tbody");
                if (res.files.length > 0) {
                    var row = '';
                    res.files.forEach(file => {
                        row += `
                            <tr>
                                <td>${file.original_name}</td>
                                <td>${(file.size / 1024 / 1024).toFixed(2)} MB</td>
                            </tr>`;
                    });
                    table.html(row);
                } else {
                    row += `
                        <tr>
                            <td colspan="2">Sin archivos</td>
                        </tr>`;
                    table.html(row);
                }

                $("#myModal_log_details").modal('show')
            },
            error: function (data) {
                //console.log(data);
            }
        });
    }

    logUpdate(id, request) {

        $.ajax({
            url: '/casos/update/logs/' + id,
            type: "POST",
            data: request,
            contentType: false,
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
                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }
                        $("#progress_bar").show();
                        $("#progress_bar .progress-bar").css("width", + percent + "%");
                        $("#progress_bar .progress-bar").text(percent + "%");
                        if (percent >= 100) {
                            $("#progress_bar .progress-bar").text("Terminando el proceso...");
                        }
                    }, true);
                }
                return xhr;
            }
            //	mimeType:"multipart/form-data"
        }).done(function (res) { //
            $("#progress_bar").hide();
            $("#wait").hide();


            try {
                if (res.type_log_id == '18' || res.type_log_id == '33' || res.type_log_id == '23') {
                    $("#table_list_logs tbody").html('');
                    $("#table_list_logs tbody").html(res.view);
                    if (res.render_suport_logs || res.type_log_id == '33') {
                        $("#accordion_support_logs").html(res.render_suport_logs);
                    }
                    //  $("#table_list_logs tbody [data-toggle='toggle']").bootstrapToggle();
                }
                if (res.type_log_id == '22') {
                    $("#content_list_doc_send").html(res.view);
                }

                if (res.new_category) {
                    var option = `<option value="${res.type_category_id}">${res.new_category}</option>`;
                    $("#content_form_cl #type_category_id").append(option);
                }
                Toast.fire({
                    title: 'Actuación actualizada con éxito.',
                    type: 'success',
                    timer: 2000,
                });


            } catch (error) {

            }
        });


    }

    logDelete(request) {
        $.ajax({
            url: '/casos/logs/' + request.id,
            type: 'DELETE',
            data: request,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show()
            },
            success: function (res) {
                try {
                    if (res.type_log_id == '18' || res.type_log_id == '33' || res.type_log_id == '23') {
                        $("#table_list_logs tbody").html('');
                        $("#table_list_logs tbody").html(res.view);
                        if (res.render_suport_logs || res.render_suport_logs == '') {
                            $("#accordion_support_logs").html(res.render_suport_logs);
                        }
                    }
                    toastr.success('Eliminado con éxito!', '',
                        { "positionClass": "toast-bottom-right", "timeOut": "2000" });

                    if (res.type_log_id == '22') {
                        $("#content_list_doc_send").html(res.view);
                    }
                    /*    var viewC = new ViewComponents();
                       var logs = [];
                       logs[0] = res;
                       var row = viewC.listLogsTable(logs);
                       $("#table_list_logs tbody").append(row);  */
                } catch (error) {
                    console.log(error)
                }
                $("#table_list_logs tbody [data-toggle='toggle']").bootstrapToggle();
                $("#wait").hide()
            },
            error: function (data) {
                //console.log(data);
            }
        });
    }

    getLogs(request) {
        //console.log(request)
        $.ajax({
            url: '/casos/get/logs',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show()
            },
            success: function (res) {
                var viewC = new ViewComponents();
                $("#content_logs_notification").hide();
                $("#myModal_create_show_logs #title_titular_modal").text('Documentos');
                if (request.type_log_id == 18) {
                    $(".item-tab-rec-logs").show();
                    var logs = [];
                    logs = res.logs_send;
                    var row = viewC.renderLogs(logs);
                    $("#content_logs_send").html(row);
                    var logs2 = [];
                    logs2 = res.logs_rec;
                    var row2 = viewC.renderLogs(logs2);
                    $("#content_logs_rec").html(row2);
                } else if (request.type_log_id == 23) {
                    $(".item-tab-rec-logs").hide();
                    var row = viewC.renderNotifications(res.logs_notif);
                    $("#myModal_create_show_logs #title_titular_modal").text('Notificaciones');
                    $("#content_logs_notification").html(row).show();
                }
                $("#wait").hide()
                $("#myModal_create_show_logs").modal('show')
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    storePayment(request) {

        $.ajax({
            url: '/casos/store/payment',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show()
            },
            success: function (res) {
                fillModalEditBill(res)
                if (res.render_view) {
                    $("#table_list_bills tbody").html(res.render_view);
                    $("#content_list_support_file #payment_files").html(res.image_list);
                }
                $("#wait").hide();
                Toast.fire({
                    title: 'Nuevo cobro creado con éxito.',
                    type: 'info',
                    timer: 5000,
                });
                $("#myModal_create_bill").modal('show');
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    editPayment(request) {

        $.ajax({
            url: '/casos/edit/payment',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show()
            },
            success: function (res) {
                //console.log(res)              
                fillModalEditBill(res);
                if (res.image_list) {
                    $("#content_list_support_file #payment_files").html(res.image_list);
                    $("#content_list_support_file").show()
                }
                $("#wait").hide();
                $("#myModal_create_bill").modal('show');
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }
    deletePayment(request) {

        $.ajax({
            url: '/casos/delete/payment',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show()
            },
            success: function (res) {
                ////console.log(res)   
                if (res.render_view || res.render_view == '') {
                    $("#table_list_bills tbody").html(res.render_view);
                    var get_total_payments = new Intl.NumberFormat("es-CO").format(res.payment.get_total_payments)
                    $("#lbl_get_total_payments").text(get_total_payments);
                    var get_balance_payments = new Intl.NumberFormat("es-CO").format(res.payment.get_balance_payments);
                    $("#lbl_get_balance_payments").text(get_balance_payments);
                    Toast.fire({
                        title: 'Eliminado con éxito.',
                        type: 'success',
                        timer: 2000,
                    });
                }

                $("#wait").hide();


            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    deletePaymentSupport(request) {

        $.ajax({
            url: '/payments/delete/supports',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show()
            },
            success: function (res) {
                //fillModalEditBill(res)  ;
                $("#content_list_support_file #item-" + request.id).remove();
                toastr.success('Eliminado con éxito!', '',
                    { "positionClass": "toast-bottom-right", "timeOut": "1000" });

                //if(res.image_list)$("#content_list_support_file #payment_files").html(res.image_list);
                $("#wait").hide();
                $("#myModal_create_bill").modal('show');
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    deleteLogSupport(request) {

        $.ajax({
            url: '/log/delete/supports',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show()
            },
            success: function (res) {
                //fillModalEditBill(res)  ;
                $("#log_files #item-" + request.id).remove();

                toastr.success('Eliminado con éxito!', '',
                    { "positionClass": "toast-bottom-right", "timeOut": "1000" });
                $("#table_list_logs tbody").html(res.view);
                //if(res.image_list)$("#content_list_support_file #payment_files").html(res.image_list);
                $("#wait").hide();
                // $("#myModal_create_bill").modal('show');
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    insertPaymentCredits(request) {
        $.ajax({
            url: '/payments/insert/credits',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show()
            },
            success: function (res) {
                console.log(res, request)
                if (res.render_view || res.render_view == '') {
                    $("#table_list_bills tbody").html(res.render_view);
                    //$("#content_list_support_file #payment_files").html(res.image_list);
                    var get_total_payments = new Intl.NumberFormat("es-CO").format(res.payment.get_total_payments)
                    $("#lbl_get_total_payments").text(get_total_payments);
                    var get_balance_payments = new Intl.NumberFormat("es-CO").format(res.payment.get_balance_payments);
                    $("#lbl_get_balance_payments").text(get_balance_payments);
                    toastr.success('Guardado con éxito!', '',
                        { "positionClass": "toast-bottom-right", "timeOut": "1000" });
                }

                $("#wait").hide();

            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
                $("#wait").hide();
            }
        });
    }

    updatePayment(request) {
        $.ajax({
            url: '/casos/update/payment',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show()
            },
            success: function (res) {

                if (res.render_view) {
                    $("#table_list_bills tbody").html(res.render_view);
                }

                $("#wait").hide();
                toastr.success('Guardado con éxito!', '',
                    { "positionClass": "toast-bottom-right", "timeOut": "1000" });
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
                $("#wait").hide();
            }
        });
    }

    payCredit(request) {
        $.ajax({
            url: '/payments/pay/credit',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show()
            },
            success: function (res) {

                //console.log(res)
                $("#wait").hide();
                fillModalPayCredit(res)
                $("#myModal_pay_credit").modal('show');
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
                $("#wait").hide();
            }
        });
    }

    updateCredit(request, id) {
        $.ajax({
            url: '/creditos/' + id,
            type: 'PUT',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show()
            },
            success: function (res) {


                if (res.error) {
                    Toast.fire({
                        title: res.error,
                        type: 'error',

                    });
                } else if (res.render_view) {
                    $("#table_list_bills tbody").html(res.render_view);
                    var get_total_payments = new Intl.NumberFormat("es-CO").format(res.payment.get_total_payments)
                    $("#lbl_get_total_payments").text(get_total_payments);
                    var get_balance_payments = new Intl.NumberFormat("es-CO").format(res.payment.get_balance_payments);
                    $("#lbl_get_balance_payments").text(get_balance_payments);

                    toastr.success('Guardado con éxito!', '',
                        { "positionClass": "toast-bottom-right", "timeOut": "1000" });
                }

                $("#wait").hide();

                $("#myModal_pay_credit").modal('hide');
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
                $("#wait").hide();
            }
        });
    }

    asigReception(request) {
        $.ajax({
            url: '/casos/asig/reception',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show()
            },
            success: function (res) {
                window.location.reload(true);
                $("#wait").hide();
                //$("#myModal_pay_credit").modal('hide');
            },
            error: function (xhr, textStatus, thrownError) {
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
                $("#wait").hide();
            }
        });

    }

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