import { User } from "./services/user.js";
import { HttpService } from "./services/http.js";
import { convertFormToJSON } from "./scripts.js";
const user = new User();
const httpService = new HttpService();
(function () {

  $("#btn_create_nwus").on('click', function (e) {
    e.preventDefault();
    $("#myModal_create_user").modal('show');
  });

  $("#myformCreateNewUser").on('submit', function (e) {
    var request = $(this).serialize() + '&view=user';
    user.store(request)
    /* Swal.fire({
  title: 'Creando...',
  html: 'Espere por favor <strong></strong> .',
  timer: 2000,
  onBeforeOpen: () => {
    Swal.showLoading()
    timerInterval = setInterval(() => {      
    }, 100)
  }  
}); */
    e.preventDefault();
  });

  $("#myformCreateNewUser input[name=type_identification_id]").on('change', function () {
    var identification_number = $("#myformCreateNewUser input[name=identification_number]").val();
    if (identification_number != '') {
      var request = {
        'identification_number': identification_number,
        'type_identification_id': this.value
      }

      user.findUser(request);
    }
  })

  $("#myformCreateNewUser input[name=identification_number]").on('blur', function () {
    var type_identification = $("#myformCreateNewUser select[name=type_identification_id]")
      .val();
    if (this.value != '') {
      var request = {
        'identification_number': this.value,
        'type_identification_id': type_identification
      }
      user.findUser(request);
    }
  });

  $("#content_list_users_table").on('click', '.btn_delete_user', function (e) {
    e.preventDefault();
    var id = $(this).attr('id');
    Swal.fire({
      title: '¿Estas seguro de eliminar el registro?',
      text: "Los cambios no pueden ser revertidos!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'SI, eliminar!',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      if (result.value) {
        user.delete(id)
      }
    });

  });


  $("#btn_asignar_rol").on('click', function (e) {
    $("#myModal_asignar_rol").modal('show');
    e.preventDefault();
  });
  /*   $(".setOlderValue").on('focus', '.input_user_data', function () {
      $("#olderInputValue").val(this.value);
    }); */

  $(".setOlderValue").on('focus', '.user_static_data_other', function () {
    $("#olderInputValue").val(this.value);
  });

  $("#myformAsigRol").on('submit', function (e) {
    var data = $(this).serialize();
    var id = $("#myformAsigRol input[name='id']").val();
    $("#myModal_asignar_rol").modal('hide');
    user.update(data);
    e.preventDefault();

  });

  $("#myformEditUser").on("submit", async function (e) {
    e.preventDefault();
    var request = convertFormToJSON("myformEditUser") // $(this).serialize();
    //user.update(request);
    await httpService.post("admin/users/update", request, function (data) {
      console.log(data);
      Toast.fire({
        type: 'success',
        title: "Actualizado con éxito"
      });
    })

  })


  $("#myformchangepassword").on('submit', function (e) {
    var id = $("#myformEditUser input[name='id']").val();
    var data = $(this).serialize() + '&id=' + id;
    user.update(data);
    e.preventDefault();

  });

  $("#btn_cambiar_password").on('click', function (e) {
    $("#myformEditUser input[name='password']").prop('disabled', !$("#myformEditUser input[name='password']").is(':disabled'))
    e.preventDefault();
  });
  $("#change_photo").on('click', function () {
    $("#image").click();
  });

  $('#image').on('change', function () {
    if (this.files || this.files.length > 1) {
      const size = (this.files[0].size / 1024 / 1024).toFixed(2);
      const name = (this.files[0].name);
      if (this.files[0].type == "image/jpeg" || this.files[0].type == "image/png") {
        var formulario = new FormData($('#myformEditUser')[0]);
        updatePhoto(formulario);
      } else {
        Swal.fire(
          "Error!",
          "El formato no es valido!",
          "error");
      }

    }
  });

  $(".btn_add_data_user").on("click", function (e) {

    var section = $(this).attr('data-section')
    Swal.fire({
      title: 'Agregando información adicional',
      input: 'text',
      inputValue: '',
      showCancelButton: true,
      confirmButtonText: 'Crear',
      cancelButtonText: 'Cancelar',

      inputValidator: async (value) => {
        if (!value) {
          return 'No puede estar vacio!'
        } else {
          var request = {
            'active_other_input': [0],
            'option_name': [value],
            'name': value,
            'categories': 'type_data_user',
            'type_data_id': '26',
            'table': 'users',
            'section': section,
            'user_id': $("#myformEditUser input[name=id]").val(),
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
              $("#wait").show()
              window.location.reload()
              toastr.success('Guardado con éxito!', '',
                { "positionClass": "toast-bottom-right", "timeOut": "1000" });
            }
          })
        }
      }
    })
  });

  $("#bt_add_user_note").on("click", function (e) {

    Swal.fire({
      title: 'Ingrese una nota',
      input: 'text',
      inputValue: '',
      showCancelButton: true,
      confirmButtonText: 'Crear',
      cancelButtonText: 'Cancelar',

      inputValidator: (value) => {
        if (!value) {
          return 'No puede estar vacio!'
        } else {
          var request = {
            'note': value,
            'type_status_id': 16,
            'user_id': $("#myformEditUser input[name=id]").val(),
          }
          insertNote(request)
        }
      }
    })
  });

  /*  $("#content_user_data_about_me").on("blur", '.input_user_data', function (e) {
     if (this.value != $("#olderInputValue").val()) {
       var request = {
         'value': this.value,
         'type_data_id': $(this).attr('data-type_id'),
         'user_id': $("#myformEditUser input[name=id]").val(),
         'component': 'about_me'
 
       }
       insertData(request)
     } else {
       $("#content_user_data_about_me #lbl_btn_dedit-" + $(this).attr('data-type_id')).show();
       $("#content_user_data_about_me #input_about_me-" + $(this).attr('data-type_id')).attr('type', 'hidden');
       //$("#content_user_data_about_me #input_about_me-"+$(this).attr('data-type_id')).focus()
     }
   }); */


  /*  $("#content_user_aditional_data").on("blur", '.input_user_data', function (e) {
     if (this.value != $("#olderInputValue").val()) {
       var request = {
         'value': this.value,
         'type_data_id': $(this).attr('data-type_id'),
         'user_id': $("#myformEditUser input[name=id]").val(),
         'component': 'case'
 
       }
       //insertData(request)
     }
   }); */


  $("#content_user_data_about_me").on("click", '.btn_dedit', function (e) {
    $("#content_user_data_about_me #lbl_btn_dedit-" + $(this).attr('data-id')).hide();
    $("#content_user_data_about_me #input_about_me-" + $(this).attr('data-id')).attr('type', 'text');
    $("#content_user_data_about_me #input_about_me-" + $(this).attr('data-id')).focus()
  });
  $("#content_user_notes").on("click", '.btn_edit_note', function (e) {
    var id = $(this).attr('data-id');
    openUpdateNotes(id);
    e.preventDefault();
  });
  $("#content_user_notes").on("click", '.btn_cancel_update_note', function (e) {
    var id = $(this).attr('data-id');
    closeUpdateNotes(id)
    e.preventDefault();
  });

  $("#content_user_notes").on("click", '.btn_update_note', function (e) {
    e.preventDefault();
    var request = {
      'note': $("#input_note-" + $(this).attr('data-id')).val(),
      'user_id': $("#myformEditUser input[name=id]").val(),
      'id': $(this).attr('data-id'),
    }
    updateNote(request)
  });


  $("#content_user_notes").on("click", '.btn_delete_note', function (e) {
    var request = {
      'id': $(this).attr('data-id'),
      'user_id': $("#myformEditUser input[name=id]").val(),
    };
    Swal.fire({
      title: 'Esta seguro de elimina la nota?',
      text: "Los cambios no podrán ser revertidos!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, eliminar!',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.value) {
        deleteNote(request);
      }
    });
    e.preventDefault();
  });

  $("#content_user_static_data").on("change", '.user_static_data', function (e) {
    var request = {
      'reference_data_option_id': $(this).attr('data-id'),
      'value': $(this).val(),
      'user_id': $("#myformEditUser input[name=id]").val(),
      'reference_data_id': $(this).attr('data-reference_id'),
    }
    if ($(this).attr('data-active_other') == 1) {
      $("#content_input_other-" + $(this).attr('data-id')).show();
    } else {
      $("#content_input_other-" + $(this).attr('data-id')).hide();
    }
    console.log($(this).attr('type'))
    if ($(this).attr('type') == 'checkbox') {
      console.log($(this).is(":checked"))
      if (!$(this).is(":checked")) {
        request['fire'] = 'delete';
      } else {
        request['fire'] = 'insert';
      }
    }
    user.addStaticData(request);
  });
  $("#content_user_static_data").on("blur", '.user_static_data_other', function (e) {
    if (this.value != $("#olderInputValue").val()) {
      var request = {
        'reference_data_option_id': $(this).attr('data-id'),
        'value_is_other': $(this).val(),
        'user_id': $("#myformEditUser input[name=id]").val(),
        'reference_data_id': $(this).attr('data-reference_id'),
      }
      user.addStaticData(request);
    }
  });
  /*  $("#content_user_static_data").on("blur", '.input_user_data', function (e) {
     if (this.value != $("#olderInputValue").val()) {
       var request = {
         'value': this.value,
         'type_data_id': $(this).attr('data-question_id'),
         'user_id': $("#myformEditUser input[name=id]").val(),
         'component': 'case'
 
       }
       insertData(request)
     }
   }); */


  $(".btn_changestatus_us").on("click", async function (e) {
    var id = $(this).attr("data-id");
    Swal.fire({
      title: 'Atencion!',
      html: `
       <h2>¿Esta seguro de activar el usuario?</h2>
    
        Se recepcionará una solicitud
      `,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Activar!',
      cancelButtonText: 'Cancelar'
    }).then(async (result) => {
      if (result.value) {
        // var user = new User();
        var request = {
          'id': id,
          'type_status_id': 141
        }
        //user.update(request);
        await httpService.post("recepciones", request, async function (data) {

          await httpService.post("admin/users/update", request, function (res) {
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
          })
        })
      }
    });
  });




})();

function openUpdateNotes(id) {
  $("#content_note_text-" + id).hide();
  $("#input_note-" + id).show();
  $("#content_btns_edit-" + id).hide();
  $("#content_btns_update-" + id).show();
}

function closeUpdateNotes(id) {
  $("#content_note_text-" + id).show();
  $("#input_note-" + id).hide();
  $("#content_btns_edit-" + id).show();
  $("#content_btns_update-" + id).hide();
}


function updatePhoto(data) {
  var route = "/admin/users/photo/update";
  $.ajax({
    url: route,
    type: "POST",
    data: data,
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
    if (res.isAuth) {
      $(".image_profile").attr('src', '/' + res.image);
    }
    $("#image_profile").attr('src', '/' + res.image);
  });



}
function insertTypeData(data) {
  var route = "/admin/users/insert/type/data";
  $.ajax({
    url: route,
    headers: { 'X-CSRF-TOKEN': token },
    type: 'POST',
    datatype: 'json',
    data: data,
    cache: false,
    beforeSend: function (xhr) {
      xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
      $("#wait").show()
    },
    success: function (res) {
      // $(".lbl_user_name").text(res.name)   
      $("#wait").hide()
      Toast.fire({
        type: 'success',
        title: 'Los datos se actualizaron con éxito.'
      });
      if (res.view && request.section == 'about_me') {
        $("#content_user_data_about_me").html(res.view)
      } else if (res.view && request.section == 'case') {
        $("#content_user_aditional_data").html(res.view)
      }
      //window.location.reload()
      $("#wait").hide()
    },
    error: function (xhr, textStatus, thrownError) {
      Toast.fire({
        type: 'warning',
        title: 'Error.'
      });
      $("#wait").hide()
    }
  });
}
function updateNote(data) {
  var route = "/admin/users/update/note";
  $.ajax({
    url: route,
    headers: { 'X-CSRF-TOKEN': token },
    type: 'POST',
    datatype: 'json',
    data: data,
    cache: false,
    beforeSend: function (xhr) {
      xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
      $("#wait").show()
    },
    success: function (res) {
      // $(".lbl_user_name").text(res.name)
      Toast.fire({
        type: 'success',
        title: 'Los datos se actualizaron con éxito.'
      });
      if (res.render_view || res.render_view == '') {
        $("#content_user_notes").html(res.render_view)
      }
      //window.location.reload()
      $("#wait").hide()
    },
    error: function (xhr, textStatus, thrownError) {
      Toast.fire({
        type: 'warning',
        title: 'Error.'
      });
      $("#wait").hide()
    }
  });
}

function deleteNote(data) {
  var route = "/admin/users/delete/note";
  $.ajax({
    url: route,
    headers: { 'X-CSRF-TOKEN': token },
    type: 'GET',
    datatype: 'json',
    data: data,
    cache: false,
    beforeSend: function (xhr) {
      xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
      $("#wait").show()
    },
    success: function (res) {
      // $(".lbl_user_name").text(res.name)
      Toast.fire({
        type: 'success',
        title: 'Los datos se actualizaron con éxito.'
      });
      if (res.render_view || res.render_view == '') {
        $("#content_user_notes").html(res.render_view)
      }
      //window.location.reload()
      $("#wait").hide()
    },
    error: function (xhr, textStatus, thrownError) {
      Toast.fire({
        type: 'warning',
        title: 'Error.'
      });
      $("#wait").hide()

    }
  });
}

function insertNote(data) {
  var route = "/admin/users/insert/note";
  $.ajax({
    url: route,
    headers: { 'X-CSRF-TOKEN': token },
    type: 'POST',
    datatype: 'json',
    data: data,
    cache: false,
    beforeSend: function (xhr) {
      xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
      $("#wait").show()
    },
    success: function (res) {
      // $(".lbl_user_name").text(res.name)
      Toast.fire({
        type: 'success',
        title: 'Los datos se actualizaron con éxito.'
      });
      if (res.render_view || res.render_view == '') {
        $("#content_user_notes").html(res.render_view)
      }
      //window.location.reload()
      $("#wait").hide()
    },
    error: function (xhr, textStatus, thrownError) {
      Toast.fire({
        type: 'warning',
        title: 'Error.'
      });
    }

  });
}

function insertData(request) {
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

      toastr.success('Guardado con éxito!', '',
        { "positionClass": "toast-bottom-right", "timeOut": "1000" });

      $("#content_user_data_about_me #lbl_btn_dedit-" + request.type_data_id).show();
      $("#content_user_data_about_me #lbl_btn_dedit-" + request.type_data_id + ' span').text(request.value);
      $("#content_user_data_about_me #input_about_me-" + request.type_data_id).attr('type', 'hidden');
      //$("#content_user_data_about_me #input_about_me-"+request.type_data_id).focus()

    },
    error: function (xhr, textStatus, thrownError) {
      alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
    }
  });

}

