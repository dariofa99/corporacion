
$( document ).ready(function() {


    $("#myModal_client_streaming_cases").on("click",'#newtab-stream-cases-client',function(e){
        $('#myModal_client_streaming_cases').modal("hide");
        $('#text-stream-cases-client').val('');
        
        $('#iframe-stream-cases-client').attr('src', '');


    });

    $('#myModal_client_streaming_cases').on('hidden.bs.modal', function (e) {
        $('#newtab-stream-cases-client').attr('href', '');
        $('#text-stream-cases-client').val('');
        $('#iframe-stream-cases-client').attr('src', '');

    });

    $(".content_list_bills").on('click','.btn_up_pay_support',function(e) {
       // var casef = new Case();       
        //var request = {'credit_id':$(this).attr('data-id')};
       $(".supload_supf input[name=payment_credit_id]").val($(this).attr('data-id'))
        $("#myModal_upload_pay_support #lbl_modal_title").text('Actualizando pago');
        $("#myModal_upload_pay_support").modal('show');
     
     });

     $("#myModal_upload_pay_support").on("change",'#type_category_payment_id',function() {       
        if(this.value!=''){
            $("#content_list_support_file").hide();
            $("#content_form_support_file").show();
           // $("#myFormSupportFilesDropzone input[name=type_category_id]").val(this.value);
        }        
     });

    


});