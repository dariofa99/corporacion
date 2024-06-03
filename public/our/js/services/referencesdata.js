export class ReferenceData{
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
                        $("#sel_answer_type select").val(res.type_data_id) ;
                       
                        $("#aditional_options_table tbody").html("");
                        $("#content_aditional_options").hide();
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
                                                <input type="hidden" id="idoption-${item}"  name="options_id[]" value="${element.id}">
                                                <input type="checkbox" ${checked_} id="active-${item}" class="chk_active_other_input">
                                            </td>
                                            <td>
                                                <button type="button" id="btn_delete_option_row-${item}" data-item="${item}" class="btn btn-danger btn-sm btn_delete_option_row">
                                                <i class="fa fa-times"></i></button>
                                            </td>               
                                        </tr>`;
                                
                            });
                            $("#aditional_options_table tbody").html(row);
                            if(res.type_data_id==58 || res.type_data_id==136 ){
                                $("#content_aditional_options").show();
                            }
                            
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