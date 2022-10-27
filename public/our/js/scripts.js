
$( document ).ready(function() {

$(document).ajaxStart(function() {
  
  });
  $(document).ajaxStop(function() {
   
    
});



$('body').on('change', function () {



});


$(".btn_unread_notifications").on("click",function () {  
  unreadNotifications();  
});

$("#content-notifications").on("click",'.btn_notification_delete',function (e) {
  e.preventDefault();
  var request = {
    "id":$(this).attr('data-id')
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

$("#btn_more_notifications").on("click",function(e) {
  e.preventDefault();
  let limit = parseInt($(this).attr('data-limit')) + 5;
  viewNotifications(limit);
  $(this).attr('data-limit',limit);
});

});

var unreadNotifications = function(){
  var url = "/admin/users/unread/notifications";
  $.ajax({ 
    url: url,
    type: 'GET',
    cache: false,
    data: {},
    beforeSend: function(xhr){
      xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
    },
    success: function(res) {
      
      if(res.view){
        $("#content_cases").html(res.view);
       // $("[data-toggle='toggle']").bootstrapToggle();
      }
            $("#wait").hide();
     },
    error: function(xhr, textStatus, thrownError) {
    }
});
}

let deleteNotification = function (request) {
  var url = "/admin/users/delete/notifications/"+request.id
  $.ajax({ 
    url: url,
    type: 'GET',
    cache: false,
    data: request,
    beforeSend: function(xhr){
      xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
    },
    success: function(res) {
      
      if(res.view || res.view ==''){
        $("#content-notifications").html(res.view);
       // $("[data-toggle='toggle']").bootstrapToggle();
      }
            $("#wait").hide();
     },
    error: function(xhr, textStatus, thrownError) {
    }
});
}

let viewNotifications = function (limit) {
  var url = "/admin/users/view/notifications/?limit="+limit
  $.ajax({ 
    url: url,
    type: 'GET',
    cache: false,
    data: {},
    beforeSend: function(xhr){
      xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
      $("#wait").show();
    },
    success: function(res) {
      if(res.view){
        $("#content-notifications").html(res.view);
       // $("[data-toggle='toggle']").bootstrapToggle();
      }
      $("#wait").hide();
    },
    error: function(xhr, textStatus, thrownError) {
    }
});
}