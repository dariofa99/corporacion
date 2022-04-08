$( document ).ready(function() {

    $('.onlynumber').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
      });
  
  $('.onlynumber').tooltip({
      placement: "top",
      trigger: "focus"
  });

  $('.tooltipfocus').tooltip({
    placement: "top",
    trigger: "focus"
});
   
   // tokenController();
});

function tokenController() {

    if (typeof(Storage) !== 'undefined') {

        // Código cuando Storage es compatible
        var token = localStorage.getItem('tokensessionpc');
        token = JSON.parse(token);
    } else {
       // Código cuando Storage NO es compatible
    } 



   

    $.ajax({
        url: '/verify/token',
        type: 'POST',
        datatype: 'json',
        data: token,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
            $("#wait").show();
            
        },
        success: function (res) {
            if(res !="") {
            localStorage.setItem('tokensessionpc', JSON.stringify(res));
            }

        $("#wait").hide();
           Swal.fire({
            title: 'Creado con éxito.',
            type: 'success',                
          });
        
        },
        error: function (xhr, textStatus, thrownError) {              
            alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
        }
    });
   
  


   // localStorage.setItem('items', JSON.stringify(itemsArray));

    
}