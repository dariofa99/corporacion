class ReferenceData{
    constructor(id="",name=""){
        this.id = id;
        this.name = name;
        
    }

    store(request){

        var route = "/categorias";  
      
                  $.ajax({
                  url: route,
                  type: 'POST',
                  datatype: 'json',
                  data: request,
                  cache: false,
                  beforeSend: function (xhr) {
                      xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                      $("#wait").show();                   
                  },
                  /*muestra div con mensaje de 'regristrado'*/
                  success: function (res) {
                    $("#wait").hide();      
                    try {
                        console.log(res)
                      if(res.render_view || res.render_view==''){                           
                        $("#content_list_categories").html(res.render_view);     
                            Toast.fire({
                                type: 'success',
                                title: 'Categoria creada con éxito.'
                            });                                
                        }
                        $("#myModal_create_cate").modal('hide');
                    } catch (error) {              
                        toastr.error('A ocurrido un error, refresque la página, si el error persiste, consulte con el adiministrador','Error',
                            {"positionClass": "toast-top-right","timeOut":"50000"});           
                    }
                  },
                  error: function (xhr, textStatus, thrownError) {
                      alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
                      $("#wait").hide();      
                  }
              });
      }

      edit(id){

        var route = "/categorias/"+id+'/edit';  
      
                  $.ajax({
                  url: route,
                  type: 'GET',
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
                        $("#myformCreateRCategory").attr('id','myformEditRCategory');
                        $("#myformEditRCategory input[name=id]").val(res.id);
                        $("#myformEditRCategory select[name=categories]").val(res.categories);
                        $("#myformEditRCategory input[name=name]").val(res.name);
                        $("#myformEditRCategory button[type=submit]").text('Actualizar')
                        .removeClass('btn-primary').addClass('btn-warning');
                        $("#myModal_create_cate").modal('show');
                        $("#lbl_modal_title").text("Actualizar categoria");
                        $("#content_section_users").hide()
                        $(".content_section_users select").prop('disabled',true)
                        if(res.categories=='type_data_user'){
                            $("#content_section_users").show()
                            $("#content_section_users select").prop('disabled',false)
                            $("#myformEditRCategory select[name=section]").val(res.section);
                        }
                        $("#sel_answer_type select").val(res.type_data_id) 
                        if(res.options.length > 0){
                            var row = '';
                            res.options.forEach((element,item) => {
                                let checked_ = '';
                                let value = '0';
                                if(element.active_other_input){
                                    checked_ = 'checked';
                                    value = '1';
                                }
                                 row += `<tr class="option_row" data-item="${item}" id="option_row-${item}">
                                            <td>
                                                <input value="${element.value}" type="text" required name="option_name[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="hidden" id="active_other_input-${item}" name="active_other_input[]" value="${value}">
                                                <input type="hidden"  name="options_id[]" value="${element.id}">

                                                <input type="checkbox" ${checked_} id="active-${item}" class="chk_active_other_input">
                                            </td>
                                            <td>
                                                <button type="button" id="btn_delete_option_row-${item}" data-item="${item}" class="btn btn-danger btn-sm btn_delete_option_row">
                                                <i class="fa fa-times"></i></button>
                                            </td>               
                                        </tr>`;
                                
                            });
                            $("#aditional_options_table tbody").html(row);
                            $(".adoptions_g").show();
                            $(".adoptions input").prop('disabled',false);
                            $("#chk_add_option").prop("checked",true);
                            $("#sel_answer_type").show();
                            $("#sel_answer_type select").prop('disabled',false);
                            
                        }else if(res.section=='aditional_info'){
                            $("#chk_add_option").prop("checked",false);
                            $(".chkadoptions").show();
                            $(".adoptions").hide();
                            $("#sel_answer_type").hide();
                            $("#sel_answer_type select").prop('disabled',true);
                            
                            $(".adoptions input").prop('disabled',false);
                            $("#aditional_options_table tbody").html('');
                        }else{
                            $(".adoptions_g").hide();    
                            $("#chk_add_option").prop("checked",false);                       
                            $("#aditional_options_table tbody").html('');
                           
                        }

                    } catch (error) {              
                        toastr.error('A ocurrido un error, refresque la página, si el error persiste, consulte con el adiministrador','Error',
                            {"positionClass": "toast-top-right","timeOut":"50000"});  
                            console.log(error)         
                    }
                  },
                  error: function (xhr, textStatus, thrownError) {
                      alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
                      $("#wait").hide();      
                  }
              });
      }

       update(request,id){
        var route = "/categorias/"+id;        
                  $.ajax({
                  url: route,
                  type: 'PUT',
                  datatype: 'json',
                  data: request,
                  cache: false,
                  beforeSend: function (xhr) {
                      xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                      $("#wait").show();                   
                  },
                  /*muestra div con mensaje de 'regristrado'*/
                  success: function (res) {
                    $("#wait").hide();      
                    try {                       
                      if(res.render_view || res.render_view==''){                           
                        $("#content_list_categories").html(res.render_view);     
                            Toast.fire({
                                type: 'success',
                                title: 'Categoria actualizada con éxito.'
                            });                                
                        }
                        $("#myModal_create_cate").modal('hide');
                    } catch (error) {              
                        toastr.error('A ocurrido un error, refresque la página, si el error persiste, consulte con el adiministrador','Error',
                            {"positionClass": "toast-top-right","timeOut":"50000"});           
                    }
                  },
                  error: function (xhr, textStatus, thrownError) {
                      alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
                      $("#wait").hide();      
                  }
              });
      }

      delete(request){

        var route = "/categorias/"+request.id;  
      
                  $.ajax({
                  url: route, 
                  type: 'DELETE',
                  datatype: 'json',
                  data: request,
                  cache: false,
                  beforeSend: function (xhr) {
                      xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                      $("#wait").show();                   
                  },
                  /*muestra div con mensaje de 'regristrado'*/
                  success: function (res) {
                    $("#wait").hide();      
                    try {
                       
                      if(res.render_view || res.render_view==''){                           
                        $("#content_list_categories").html(res.render_view);     
                            Toast.fire({
                                type: 'success',
                                title: 'Categoria eliminada con éxito.'
                            });                                
                        }
                        
                    } catch (error) {              
                        toastr.error('A ocurrido un error, refresque la página, si el error persiste, consulte con el adiministrador','Error',
                            {"positionClass": "toast-top-right","timeOut":"50000"});           
                    }
                  },
                  error: function (xhr, textStatus, thrownError) {
                      alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
                      $("#wait").hide();      
                  }
              });
      }

}


$(function () { 

    $("#btn_new_category").on('click',function(e){
        $("#myformEditRCategory").attr('id','myformCreateRCategory');
        $("#myformCreateRCategory")[0].reset();
        $("#content_section_users").hide();
        $("#content_section_users select").prop('disabled',true);
        $(".adoptions_g").hide();
        $("#aditional_options_table input").prop('disabled',true);
       // $("#content_section_users select").prop('disabled',true);
        $("#myformCreateRCategory button[type=submit]").text('Crear')
        .removeClass('btn-warning').addClass('btn-primary');
        $("#lbl_modal_title").text("Nueva categoria");

        $("#myModal_create_cate").modal('show');
        e.preventDefault(); 
    });

    $("#content_form_rc").on("submit",'#myformCreateRCategory',function(e){
      var request = $(this).serialize();
      var reference = new ReferenceData();
      reference.store(request);
      e.preventDefault();
    });

    $("#content_list_categories").on("click",'.btn_edit_category',function(e){
        let id = $(this).attr('data-id')
        var reference = new ReferenceData();
        reference.edit(id);
        e.preventDefault();
    });

    $("#content_form_rc").on("submit",'#myformEditRCategory',function(e){
        var request = $(this).serialize();
        var reference = new ReferenceData();
        let id = $("#myformEditRCategory input[name=id]").val();
        reference.update(request,id);
        e.preventDefault();
      });

      $("#select_categories").on("change",function(e){
        $(".chkadoptions").hide();
        $(".adoptions").hide();
        $(".adoptions input").prop('disabled',true);
        $("#type_data_id").val(26)
          if($(this).val()=='type_data_user'){
                $("#content_section_users").show()
                $("#content_section_users select").prop('disabled',false);
             }else{
                $("#content_section_users").hide();
                $("#content_section_users select").prop('disabled',true)
          }


      });

      $("#select_section_user").on("change",function(e) {
        $(".adoptions").hide();
        $(".adoptions input").prop('disabled',true);
        $("#chk_add_option").prop("checked",false);
        $("#type_data_id").val(26)
          if($(this).val()=='aditional_info'){
              $(".chkadoptions").show();
          }else{
            $(".chkadoptions").hide();
          }
      });

      $("#content_list_categories").on('click','.btn_delete_category',function(e) {
        var request = {'id':$(this).attr('data-id')};
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

    $(".btn_add_field").on("click",function(e) {       
        var item = $(".option_row").length;
        addOptionTable(item);
        
    });

    $("#chk_add_option").on("change",function (e) {
        if($(this).is(":checked")){
            var item = $(".option_row").length;
            if(item==0){
                addOptionTable(item);               
            } 
            $(".adoptions").show();
            $(".adoptions input").prop('disabled',false);
            $("#type_data_id").val(58);
            $("#sel_answer_type").show();
            $("#sel_answer_type select").prop('disabled',false);
        }else{
            $(".adoptions").hide();
            $(".adoptions input").prop('disabled',true);
            $("#type_data_id").val(26);
            $("#sel_answer_type").hide();
            $("#sel_answer_type select").prop('disabled',true);
        }
       
    });

    $("#content_aditional_options").on("click",'.btn_delete_option_row',function (e) {
        var older_row = ($(this).attr('data-item'));
        $("#option_row-"+older_row).remove();
        $(".option_row").each((row , obj)=> {
            var current_row = $(obj).attr('data-item') - 1;
            if((current_row) == older_row){
                $(obj).attr('data-item',older_row);
                $(obj).attr('id','option_row-'+older_row);              
                $(obj).find('button').attr('data-item',older_row)
                $(obj).find('button').attr('id','option_row-'+older_row);   
                older_row = parseInt(older_row) + 1;
                $(obj).find('input[id=active_other_input-'+older_row+']').attr('id','active_other_input-'+current_row);            
                $(obj).find('input[id=active-'+older_row+']').attr('id','active-'+current_row);             
            }
           
        });
        if(older_row<=0){
            $("#chk_add_option").prop("checked",false);
             $(".adoptions").hide();
             $("#type_data_id").val(26)
        } 
    });

    $("#content_aditional_options").on("click",'.chk_active_other_input',function (e) {
        var item = $(this).attr('id').split('-')[1];      
        if($(this).is(":checked")){
            $("#active_other_input-"+item).val(1)
        }else{
            $("#active_other_input-"+item).val(0)
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
                    <input type="hidden"  name="options_id[]" value="null">
                    <input type="checkbox" id="active-${item}" class="chk_active_other_input" data-size="xs" data-style="order-check" data-width="60" data-toggle="toggle" data-on="1" data-off="0" data-onstyle="primary" data-offstyle="warning">
                </td>
                <td>
                    <button type="button" id="btn_delete_option_row-${item}" data-item="${item}" class="btn btn-danger btn-sm btn_delete_option_row">
                    <i class="fa fa-times"></i></button>
                </td>               
            </tr>`;
        $("#aditional_options_table tbody").append(row);
        
   }