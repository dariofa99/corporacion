@extends('front.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->
<link rel="stylesheet" href="{{asset('plugins/dropzone57/dist/min/dropzone.min.css')}}?v={{ config('app.asset_version') }}">

@endpush

@section('navbar')
<!-- aqui va el menu de cada vista -->
 @include('content.front.navbar') 
@endsection

@section('content')

           <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">

      </div><!-- /.container-fluid -->
    </section>
<!-- Content Header (Page header) -->
  
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
     <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Caso {{session('session_case')->case_number}}: {{session('session_case')->type_branch_law->name}}</h3>

                <div class="card-tools">
                <!--
                  <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                   /.option -->
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">


<table class="table table-striped content_list_bills" id="content_list_bills">
 <thead>
            <tr>
              <th>
                Fecha 
              </th>
              <th>
                Categoria
              </th>
              <th>
                Concepto
              </th>
              <th>
                Tipo pago
              </th>
              <th>
                Valor
              </th>
              <th>
                Estado
              </th>
             <th></th>
              <th>
                Opciones
              </th>
            </tr>
            </thead>

            <tbody>
            @include("content.front.payments.ajax.index")
            </tbody>

            </table>

              </div>
              <!-- /.card-body -->
        </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->

@include('content.front.payments.partials.modals.bill_create')
@include('content.front.payments.partials.modals.upload_pay_support')
@include('content.front.payments.partials.modals.pay_credit')

@endsection


@push('scripts')
<!-- aqui van los scripts de cada vista -->
<script type="text/javascript" src="{{asset('plugins/dropzone57/dist/min/dropzone.min.js')}}?v={{ config('app.asset_version') }}"></script>

<script>

Dropzone.autoDiscover = false;          
var previewNode = document.querySelector("#template_2");
previewNode.id = "";
var previewTemplate = previewNode.parentNode.innerHTML;
previewNode.parentNode.removeChild(previewNode);
var CSRF_TOKEN = $("#token").attr('content');
var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
url: "/oficina/upload/supports", // Set the url
thumbnailWidth: 80,
thumbnailHeight: 80,
parallelUploads: 20,
previewTemplate: previewTemplate,
headers: {
              'x-csrf-token': CSRF_TOKEN,
          },
// autoProcessQueue: false,
autoQueue: true, // Make sure the files aren't queued until manually added
previewsContainer: "#previews", // Define the container to display the previews
clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
dictRemoveFileConfirmation:'Esta seguro...'
});

myDropzone.on("addedfile", function(file) {
// Hookup the start button
//myDropzone.enqueueFile(file)

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
               myDropzone.removeFile(file);             
            }
          }); 
 
   return false;
};
//$("#actions .cancel").prop("disabled",false);
//$("#actions .start").prop("disabled",false);



// myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
});

// Update the total progress bar
myDropzone.on("totaluploadprogress", function(progress) {
//document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
});

myDropzone.on("sending", function(file, xhr, formData) {
// Show the total progress bar when upload starts
//$("#actions .start").prop("disabled",true);
//document.querySelector('.fileupload-process').style.display = 'block';
//document.querySelector("#total-progress").style.opacity = "1";
formData.append("type_category_id", $("#type_category_payment_id").val());
formData.append("payment_credit_id", $(".supload_supf input[name=payment_credit_id]").val());
// And disable the start button

});

myDropzone.on("success", function(file,response) {

$("#content_list_bills tbody").html(response.render_view);
$("#myModal_upload_pay_support").modal('hide');
//myDropzone.removeFile(file);
//file.previewElement.querySelector(".cancel").setAttribute("disabled", "disabled");
$(file.previewElement.querySelector(".cancel")).removeClass('btn-warning').addClass('btn-success').prop('disabled',true)
$(file.previewElement.querySelector(".cancel")).children().removeClass('fa-minus-circle').addClass('fa-check')

//$("#actions .start").prop("disabled",true);
});

// Hide the total progress bar when nothing's uploading anymore
myDropzone.on("queuecomplete", function(progress) {
$("#actions .cancel").prop("disabled",false);
//myDropzone.removeAllFiles(true);
//document.querySelector("#total-progress").style.opacity = "0";
});


// Setup the buttons for all transfers
// The "add files" button doesn't need to be setup because the config
// `clickable` has already been specified.
/*document.querySelector("#actions .start").onclick = function() {  
  $("#actions .start").prop("disabled",true);
  $("#actions .cancel").prop("disabled",true);
  myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
};*/
document.querySelector("#actions .cancel").onclick = function() {
  myDropzone.removeAllFiles(true);
  $("#content_list_support_file").show();
  $("#content_form_support_file").hide();
  $("#myModal_create_bill #type_category_payment_id").val("").change();
};
///////////////////////////////
</script>
@endpush

