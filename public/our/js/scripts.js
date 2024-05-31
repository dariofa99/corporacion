import { AppService } from "./services/appservice.js";
import { HttpService } from "./services/http.js";
const appService = new AppService();
const httpService = new HttpService()

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});
$(document).ready(function () {
  set_tab()
  $("body").on('focus', '.input_user_data', function () {
    $("#olderInputValue").val(this.value);
  });
  $("body").on('focus', '.input_other_rd', function () {
    $("#olderInputValue").val(this.value);
  });


  $("body").on("change", ".input_user_data", activeOtherInput);
  $("body").on('blur', '.input_other_rd', async function () {
    if (this.value != $("#olderInputValue").val()) {
      let id = $(this).attr('id').split("-", -1)[1]
      let obj = document.querySelector('input[name="static_data-' + id + '"]:checked');
      var request = appService.getAditionalQuestion(obj)
      await httpService.post("users/insert/data", request, async function (data) {
        toastr.success('Guardado con éxito!', '',
          { "positionClass": "toast-bottom-right", "timeOut": "1000" });

      });
    }
  });

  $("body").on('change', '.input_user_data', async function () {
    let obj = $(this);
    var request = appService.getAditionalQuestion(obj)
    await httpService.post("users/insert/data", request, async function (data) {
      toastr.success('Guardado con éxito!', '',
        { "positionClass": "toast-bottom-right", "timeOut": "1000" });

    });
  });

  $(".urlactive").on("click", function () {
    var target = $(this).attr("href")
    var url = window.location.href;
    url = url.split("#")[0] + target;
    history.pushState({}, "", url)

  });

  $(".btn_unread_notifications").on("click", function () {
    unreadNotifications();
  });

  $("#content-notifications").on("click", '.btn_notification_delete', function (e) {
    e.preventDefault();
    var request = {
      "id": $(this).attr('data-id')
    }
    Swal.fire({
      title: 'Esta seguro de eliminar la notificación?',
      text: "Los cambios no podrán ser revertidos!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, eliminar!',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.value) {
        deleteNotification(request);
      }
    });
  })

  $("#btn_more_notifications").on("click", function (e) {
    e.preventDefault();
    let limit = parseInt($(this).attr('data-limit')) + 5;
    viewNotifications(limit);
    $(this).attr('data-limit', limit);
  });

});




function activeOtherInput(e) {

  var elementType = $(e.target).prop("tagName").toLowerCase(); // Detecta si es select
  var active, id;
  if (elementType === "select") {
    var selectedOption = $(this).find("option:selected");
    active = selectedOption.attr("data-active_other");
    id = $(this).attr("data-reference_id");
  } else if ($(this).attr("type") === "checkbox" || $(this).attr("type") === "radio") {
    active = $(this).attr("data-active_other");
    id = $(this).attr("data-reference_id");
  }
  
  
    $("#lbl_other-" + id).hide();
    $("#value_other_text-" + id).attr("type", "hidden").val("");
    if (elementType === "select" || $(this).is(":checked")) {
      if (active == 1) {
        $("#lbl_other-" + id).show();
        $("#value_other_text-" + id).attr("type", "text");        
      } else {
        $("#lbl_other-" + id).hide();
        $("#value_other_text-" + id).attr("type", "hidden");
      }
    }
  

}
function set_tab() {
  var url = window.location.href;
  var activeTab = url.substring(url.indexOf("#") + 1);
  var elementoA = $("a[href='#" + activeTab + "']");
  if (activeTab) elementoA.click();
}
var unreadNotifications = function () {
  var url = "/admin/users/unread/notifications";
  $.ajax({
    url: url,
    type: 'GET',
    cache: false,
    data: {},
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

let deleteNotification = function (request) {
  var url = "/admin/users/delete/notifications/" + request.id
  $.ajax({
    url: url,
    type: 'GET',
    cache: false,
    data: request,
    beforeSend: function (xhr) {
      xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
    },
    success: function (res) {

      if (res.view || res.view == '') {
        $("#content-notifications").html(res.view);
        // $("[data-toggle='toggle']").bootstrapToggle();
      }
      $("#wait").hide();
    },
    error: function (xhr, textStatus, thrownError) {
    }
  });
}

let viewNotifications = function (limit) {
  var url = "/admin/users/view/notifications/?limit=" + limit
  $.ajax({
    url: url,
    type: 'GET',
    cache: false,
    data: {},
    beforeSend: function (xhr) {
      xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
      $("#wait").show();
    },
    success: function (res) {
      if (res.view) {
        $("#content-notifications").html(res.view);
        // $("[data-toggle='toggle']").bootstrapToggle();
      }
      $("#wait").hide();
    },
    error: function (xhr, textStatus, thrownError) {
    }
  });
}