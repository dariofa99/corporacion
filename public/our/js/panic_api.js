(function() {
    $("#myFormSearchPA").on("submit",function (e) {
        var request = $(this).serialize();
        var url = $(this).attr('action');	 
        //alert(url);
        var panic_alert = new PanicAlert();
       
            window.history.pushState(null, '', url+'?'+request);
        
        $("#wait").show();
        panic_alert.index(request,url);

       
        e.preventDefault();
    });
    $("#myFormSearchPD").on("submit",function (e) {
        var request = $(this).serialize();
        var url = $(this).attr('action');	 
        //alert(url);
        var panic_alert = new PanicAlert();
        if($('#myFormSearchPD input[name=data]').val()==''){
            request = {};       
            $("#btn_submf").hide();     
            window.history.pushState(null, '', url);
        }else{
            $("#btn_submf").show();
            window.history.pushState(null, '', url+'?'+request);
        }
          //  window.history.pushState(null, '', url+'?'+request);
        
        $("#wait").show();
        panic_alert.index(request,url);

       
        e.preventDefault();
    });
    $("#myFormSearchPD button[id=btn_submf]").on("click",function (e) {
        var panic_alert = new PanicAlert();
        request = {};   
        url = '/panic/directories' ;             
        window.history.pushState(null, '', url);
        $("#myFormSearchPD input[name=data]").val("")
        panic_alert.index(request,url);
        $("#btn_submf").hide();
     
    });
    $("#myFormSearchPA select[name=type]").on("change",function (e) {
        $("#myFormSearchPA select[name=data]").hide().prop("disabled",true);
        $("#myFormSearchPA input[name=data]").hide().prop("disabled",true);
        if($(this).val()=='view_all'){
            $("#myFormSearchPA input[name=data]").show().attr('type','text').prop("disabled",true).val("");
        }else if($(this).val()=='name'){
            $("#myFormSearchPA input[name=data]").show().attr('type','text').prop("disabled",false);
        }else if($(this).val()=='created_at'){
            $("#myFormSearchPA input[name=data]").show().attr('type','date').prop("disabled",false);
        }else if($(this).val()=='case_asig'){
            
            $("#myFormSearchPA select[id=types_case_asig]").show().prop("disabled",false); 
        }else if($(this).val()=='type_status'){
           // $("#myFormSearchPA input[name=data]").hide().prop("disabled",true);
            $("#myFormSearchPA select[id=types_status]").show().prop("disabled",false);
        }
    });

    $("#content_panic_alerts").on('click', '.pagination a', function (e) {
        e.preventDefault();
        page = $(this).attr('href');
        request = {};		 
        var panic_alert = new PanicAlert();        
        window.history.pushState(null, '', page);
        panic_alert.index(request,page);
    });

    $("#myformChangeStatus").on("submit",function (e) {
        panic_alert = new PanicAlert();
        var request = $(this).serialize();
        var id = $("#myformChangeStatus input[name=id]").val();
        panic_alert.update(id,request);
        e.preventDefault();
    });

    $("#content_panic_alerts").on("click",'.btn_change_status',function(e) {      // 
        id = $(this).attr("data-id");
        panic_alert = new PanicAlert();
        panic_alert.edit(id)
    });
    $("#content_panic_alerts").on("click",'.btn_view_directory',function(e) {      // 
        id = $(this).attr("data-id");
        panic_alert = new PanicAlert();
        panic_alert.view_directory(id)
    });
    
})();

class PanicAlert {
    constructor(id="",location="",city="",address="",longitude=""){
        this.id = id;
        this.location = location;
        this.city = city;
        this.address = address;
        this.longitude = longitude;
    }
    index(request,url){
		$.ajax({ 
			url: url,
			type: 'GET',
			cache: false,
			data: request, 
		  beforeSend: function(xhr){
              xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
              $("#wait").show();
			},
		  success: function(res) {
			  
			  if(res.view){
				  $("#content_panic_alerts").html(res.view);
                  $("#content_panic_directories").html(res.view);
				 // $("[data-toggle='toggle']").bootstrapToggle();
			  }
              $("#wait").hide();
		   },
			error: function(xhr, textStatus, thrownError) {
			}
	});
	}
    edit(id){
        $.ajax({
            url: '/panic/alerts/'+id+"/edit",
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
            $("#myformChangeStatus input[name=id]").val(res.id);
            $("#myformChangeStatus select[name=type_status_id]").val(res.type_status_id);
            $("#myformChangeStatus textarea[name=status_description]").val(res.status_description);

            $("#myModal_change_status").modal("show")


            },
            error: function (xhr, textStatus, thrownError) {              
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    update(id,request){
        $.ajax({
            url: '/panic/alerts/'+id,
            type: 'PUT',
            datatype: 'json',
            data:request,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show();
               
            },
            success: function (res) {
            $("#wait").hide();
           $("#panic_alert-"+id).html(res.view)
            $("#myModal_change_status").modal("hide")
            toastr.success('Actualizado con éxito!','',
            {"positionClass": "toast-top-right","timeOut":"1000"});

            },
            error: function (xhr, textStatus, thrownError) {              
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }

    view_directory(id){
        $.ajax({
            url: '/panic/alerts/view/directory/'+id,
            type: 'GET',
            datatype: 'json',
            data:{},
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show();
               
            },
            success: function (res) {
            $("#wait").hide();
          
            $("#myModal_change_status").modal("hide")
          

            },
            error: function (xhr, textStatus, thrownError) {              
                alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
            }
        });
    }
}