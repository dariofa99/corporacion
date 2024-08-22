class Directory{
    
    constructor(id="",name=""){
        this.id = id;
        this.name = name;
       
    }

  
    store(request){   
           
            $.ajax({
                url: '/directorio',
                type: 'POST',
                datatype: 'json',
                data: request,
                cache: false,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                    $("#wait").show();                    
                },
                success: function (res) {
                    if(res.view || res.view==''){
                        $("#content_directories_list").html(res.view);
                    }
                    $("#wait").hide();
                    Toast.fire({
                        title: 'Contacto creado con éxito.',
                        type: 'success', 
                        timer: 2000,               
                      });   

                  $("#myModal_create_directory").modal('hide');
                },
                error: function (xhr, textStatus, thrownError) {              
                    alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
                }
            });
            
    }

    edit(id){   
           
        $.ajax({
            url: '/directorio/'+id+"/edit",
            type: 'GET',
            datatype: 'json',
            data: {},
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show();
                
            },
            success: function (res) {
                
                $("#wait").hide();
                $("#myformEditDirectory input[name=id]").val(res.id);
                $("#myformEditDirectory input[name=name]").val(res.name);
                $("#myformEditDirectory input[name=number_phone]").val(res.number_phone);
                $("#myformEditDirectory input[name=address]").val(res.address);
                $("#myformEditDirectory input[name=email]").val(res.email);
                if(res.aditional_data.length > 0){
                    let row = '';
                    res.aditional_data.forEach(aditional_data => {                  
                    row += `<div class="row mb-2 aditional_old_data_rows aditional_old_data_rows-${aditional_data.id}">
                        <div class="col-md-11 col-11 col-sm-11 col-xs-11">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <div class="input-group-text" id="btnGroupAddon"> <i class="fa fa-th"></i>        </div>
                                        </div>
                                        <input type="text" data-toggle="tooltip" data-placement="top" title="${aditional_data.type_aditional_data[0].name}" value="${aditional_data.value}" name="aditional_old_field[${aditional_data.id}]" class="form-control form-control-sm tooltipfocus"  aria-describedby="btnGroupAddon">
                                      </div>                     
                                  </div>                              
                                  <div class= "col-1 col-xs-1">
                                    <div class="input-group pt-1 btn_delete_old_row" data-id="${aditional_data.id}">
                                      <i class="fa fa-times"></i>
                                    </div>                    
                                  </div> 
                        </div>   
                     `;

                    });
                    $("#myformEditDirectory .content_old_addata_input").html(row);
                    $('.tooltipfocus').tooltip({
                        placement: "top",
                        trigger: "focus"
                    });
                }else{
                    $("#myformEditDirectory .content_old_addata_input").html("")
                }
                $("#myModal_edit_directory").modal('show');
            },
            error: function (xhr, textStatus, thrownError) {              
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
        
}

update(request,id){   
           
    $.ajax({
        url: '/directorio/'+id,
        type: 'PUT',
        datatype: 'json',
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
            $("#wait").show();
            
        },
        success: function (res) {
            
            if(res.view || res.view==''){
                $("#content_directories_list").html(res.view);
            }
            $("#wait").hide();
            Toast.fire({
                title: 'Contacto actualizo con éxito.',
                type: 'success', 
                timer: 2000,               
              });   

       
            $("#myModal_edit_directory").modal('hide');
        },
        error: function (xhr, textStatus, thrownError) {              
            alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
        }
    });
    
}

delete(id){   
           
    $.ajax({
        url: '/directorio/'+id,
        type: 'DELETE',
        datatype: 'json',
        data: {},
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
            $("#wait").show();
            
        },
        success: function (res) {
            
        if(res.view || res.view==''){
            $("#content_directories_list").html(res.view);
        }
        $("#wait").hide();
            Toast.fire({
                title: 'Contacto eliminado con éxito.',
                type: 'success',   
                timer: 2000,               
              });   
        },
        error: function (xhr, textStatus, thrownError) {              
            alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
        }
    });
    
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
                $("#content_directories_list").html(res.view);
                //$("#content_list_users_table").html(res.view);
                // $("[data-toggle='toggle']").bootstrapToggle();
            }
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
        }
    });
}
    
}

const directoryf = new Directory();

$("#myFormSearchIndexDirectory").on("submit", function (e) {
    var request = $(this).serialize();
    var url = $(this).attr('action');
    //alert(url);

    if ($('#myFormSearchIndexDirectory select[name=type]').val() == 'view_all') {
        request = {};
        window.history.pushState(null, '', url);
    } else {    
        window.history.pushState(null, '', url + '?' + request);
    }
    $("#wait").show();
    directoryf.index(request, url);


    e.preventDefault();
});

$('#myFormSearchIndexDirectory select[name=type]').on('change', function (e) {
    $(".input_data").prop('disabled', true).hide().val('');
    $('#myFormSearchIndexDirectory input[id=types_text]').attr("type","text");
           
    switch (this.value) {
        case 'view_all':
            $('#myFormSearchIndexDirectory input[id=types_text]').show();
            break;
        case 'name':
        case 'email':
        case 'number_phone':
        case 'address':
            $('#myFormSearchIndexDirectory input[id=types_text]').prop('disabled', false).show();
            break;
        case 'type_status_id':
            $('#myFormSearchIndexDirectory select[id=type_status_id]').prop('disabled', false).show();
            break;
        case 'created_at':
             $('#myFormSearchIndexDirectory input[id=types_text]').show().attr("type","date").prop('disabled', false);
            break;
        default:
            break;
    }
});