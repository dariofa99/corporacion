var previewNode = document.querySelector("#template_3");
previewNode.id = "";
var previewTemplate = previewNode.parentNode.innerHTML;
previewNode.parentNode.removeChild(previewNode);
var CSRF_TOKEN = $("#token").attr('content');

var myDropzone_log = new Dropzone("div#cont_files", { // Make the whole body a dropzone
url: "/casos/insert/support/logs", // Set the url
thumbnailWidth: 80,
thumbnailHeight: 80,
parallelUploads: 20,
previewTemplate: previewTemplate,
headers: {
              'x-csrf-token': CSRF_TOKEN,
          },
//autoProcessQueue: false,
autoQueue: false, // Make sure the files aren't queued until manually added
previewsContainer: "#previews_logs", // Define the container to display the previews
clickable: "#fileinput-button_logs", // Define the element that should be used as click trigger to select files.
dictRemoveFileConfirmation:'Esta seguro...'
});

myDropzone_log.on("addedfile", function(file) {
// Hookup the start button
//myDropzone_log.addedfile(file)

$("#actions .cancel").prop("disabled",true);
 if(file.type != 'image/png' && file.type != 'image/jpg' && file.type != 'image/jpeg'){
      newimage = "/dist/img/dropzone_file.png"; 
      file.previewElement.querySelector("img").src = newimage;
    }

$(file.previewElement.querySelector("img")).css({'height':'70px','width':'80px'});
//file.previewElement.querySelector("img").width = '80';

//
file.previewElement.querySelector(".cancel").onclick = function() {
  Swal.fire({
            title: 'Esta seguro de cancelar la subida?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, cancelar!',
            cancelButtonText: 'Continuar'
          }).then((result) => {
            if (result.value) {
               myDropzone_log.removeFile(file);             
            }
          }); 
 
   return false;
};
//$("#actions .cancel").prop("disabled",false);
//$("#actions .start").prop("disabled",false);



// myDropzone_log.enqueueFiles(myDropzone_log.getFilesWithStatus(Dropzone.ADDED))
});

// Update the total progress bar
myDropzone_log.on("totaluploadprogress", function(progress) {
//document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
});

myDropzone_log.on("sending", function(file, xhr, formData) {
// Show the total progress bar when upload starts
//$("#actions .start").prop("disabled",true);
//document.querySelector('.fileupload-process').style.display = 'block';
//document.querySelector("#total-progress").style.opacity = "1";
//formData.append("type_category_id", $("#type_category_payment_id").val());
$("#wait").show();
//console.log($("#myformCreateLog input[name=id]").val())
if($("#myformCreateLog input[name=id]").val()!==undefined && $("#myformCreateLog input[name=id]").val()!=''){
  var caseL_id = $("#myformCreateLog input[name=id]").val()
}else{
  var caseL_id = $("#myformEditLog input[name=id]").val()
}

formData.append("caseL_id", caseL_id);
// And disable the start button

});

myDropzone_log.on("success", function(file,response) {
 
//$("#payment_files").html(response.image_list);
//myDropzone_log.removeFile(file);
//file.previewElement.querySelector(".cancel").setAttribute("disabled", "disabled");
$(file.previewElement.querySelector(".cancel")).removeClass('btn-warning').addClass('btn-success').prop('disabled',true)
$(file.previewElement.querySelector(".cancel")).children().removeClass('fa-minus-circle').addClass('fa-check')
$("#table_list_logs tbody").html(response.view);
if($("#myformCreateLog input[name=id]").val()==undefined){
  $("#myformEditLog #log_files").html(response.image_list);
}
//$("#actions .start").prop("disabled",true);
});

// Hide the total progress bar when nothing's uploading anymore
myDropzone_log.on("queuecomplete", function(progress) {
$("#actions_upload_logs .cancel").prop("disabled",false);
myDropzone_log.removeAllFiles(true);

if($("#myformCreateLog input[name=id]").val()!==undefined){
  $("#myModal_create_log").modal('hide');
}
$("#wait").hide();
//document.querySelector("#total-progress").style.opacity = "0";
});


// Setup the buttons for all transfers
// The "add files" button doesn't need to be setup because the config
// `clickable` has already been specified.
document.querySelector("#actions_upload_logs .start").onclick = function() {  
  $("#actions_upload_logs .start").prop("disabled",true);
  $("#actions_upload_logs .cancel").prop("disabled",true);
  myDropzone_log.enqueueFiles(myDropzone_log.getFilesWithStatus(Dropzone.ADDED));
};
document.querySelector("#actions_upload_logs .cancel").onclick = function() {
  myDropzone_log.removeAllFiles(true);
  $("#content_list_support_file").show();
  $("#content_form_support_file").hide();
  $("#myModal_create_bill #type_category_payment_id").val("").change();
};