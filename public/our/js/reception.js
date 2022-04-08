class Reception {

    constructor(id="",number="",token="",type_status_id=""){
        this.id = id;
        this.number = number;
        this.token = token;
        this.type_status_id = type_status_id;      
    }

    index(request,url){
		$.ajax({ 
			url: url,
			type: 'GET',
			cache: false,
			data: request, 
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

    store(request){   
           
        $.ajax({
            url: '/recepciones',
            type: 'POST',
            datatype: 'json',
            data: request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                Swal.fire({
                    title: 'Creando...',
                    html: 'Espere por favor <strong></strong> .',
                    timer: 2000,
                    onBeforeOpen: () => {
                      Swal.showLoading()                    
                    }  
                  });
                
            },
            success: function (res) {
            $("#wait").hide();
               Swal.fire({
                title: 'Creado con éxito.',
                type: 'success',                
              });
            window.location.reload(true) ;      
            },
            error: function (xhr, textStatus, thrownError) {              
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
        }

        update(request){   
           
            $.ajax({
                url: '/casos/'+this.id,
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
                  $("#myFormEditCase select").prop('disabled',true);
                  $("#myFormEditCase input[name=case_number]").prop('disabled',true);
                  $(".btns_update_case").hide();
                  $("#btn_edit_case").show();                  
                },
                error: function (xhr, textStatus, thrownError) {              
                    alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
                }
            });
    }




}



(function(){
   $("#btn_new_reception").on("click",function(e) {
       e.preventDefault();
      var request = {};
    Swal.fire({
        title: 'Esta seguro de solicitar una nueva atención?',
       // text: "Los cambios no podrán ser revertidos!",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, solicitar!',
        cancelButtonText: 'No, Cancelar'
      }).then((result) => {
        if (result.value) {
           var reception = new Reception();   
            reception.store(request);              
        }
      });   
   });
})();