//var socket = io('https://lybra.juridicos.co:3000', {secure: true});
var socket = io('https://consultoriovirtual.udenar.edu.co:3000', {secure: true});

socket.on('edKXuiy2wUmX9_K64OMcQQlogin', function(data){

    var viewC = new ViewComponents();
    usersLogin[data.id]=data;
    var row = viewC.renderUsersLogin(usersLogin);
    $("#list_users_login").html(row);  
    var lenhgtUsers = usersLogin.filter(Boolean);
    $(".lbl_chatCountUsers").text(lenhgtUsers.length);
    //usersLogin = res;          

});

socket.on('edKXuiy2wUmX9_K64OMcQQlogout', function(data){
    
    console.log(usersLogin.length);
    usersLogin.splice( data.id, 1 );
    console.log(usersLogin);

    $(".user_login-"+data.id).remove();  
    var lenhgtUsers = usersLogin.filter(Boolean);
    $(".lbl_chatCountUsers").text(lenhgtUsers.length);
  
});

socket.on('edKXuiy2wUmX9_K64OMcQQstream'+$('#inputHash').val(), function(data){
    Swal.fire({
        allowOutsideClick: false,
        title: 'Invitación a videollamada, aceptar?',
        text: data,
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, aceptar!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.value) {
            $('#newtab-stream-cases-client').attr('href', data);
            //$('#copy-stream-cases-client').attr('data-frame', data);
            $('#text-stream-cases-client').val(data);
            $('#iframe-stream-cases-client').attr('src', data);
            $('#myModal_client_streaming_cases').modal({backdrop: 'static', keyboard: false});
            //$('#myModal_client_streaming_cases').modal('show');
        }
    });
  
});

socket.on('edKXuiy2wUmX9_K64OMcQQnotify', function(data){
    console.log("notify-----------", data);
});


 

