@extends('layouts.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- fullCalendar -->
  <link rel="stylesheet" href="{{ asset('plugins/fullcalendar/main.min.css')}}?v={{ config('app.asset_version') }}">
  <link rel="stylesheet" href="{{ asset('plugins/fullcalendar-daygrid/main.min.css')}}?v={{ config('app.asset_version') }}">
  <link rel="stylesheet" href="{{ asset('plugins/fullcalendar-timegrid/main.min.css')}}?v={{ config('app.asset_version') }}">
  <link rel="stylesheet" href="{{ asset('plugins/fullcalendar-bootstrap/main.min.css')}}?v={{ config('app.asset_version') }}">

  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}?v={{ config('app.asset_version') }}">
   <!-- Tempusdominus Bbootstrap 4 timepiker datepiker-->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}?v={{ config('app.asset_version') }}">
    <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css')}}?v={{ config('app.asset_version') }}"> 

  <style>
    #calendar .fc-today {
      background: #f7f7f7 !important;
    }

    #calendar .fc-today > .fc-day-number {
      background-color: #007bff !important;
      border-radius: 2px !important;
      padding: 0px 5px 0px 5px !important;
      font-weight: bold !important;
    }
  .modal-header {
    padding: 1rem 1rem 0rem 1rem !important;
  }
  #select2-select2_staff_diary-container {
    margin-top: -8px !important;
  }
  </style>
@endpush

@section('navbar')
<!-- aqui va el menu de cada vista -->
  @include('content.diary.navbar')
@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            @if($selecteduser == 0) 
              <div class="alert alert-info alert-dismissible" id ="alert_diary">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h6><i class="icon fas fa-info"></i> Agregue un evento pulsando click en una fecha del calendario:</h6>
              </div>
            @endif  
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>




    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-6">
                    <h3 class="card-title">
                      <i class="far fa-calendar-alt"></i>
                      Agenda
                    </h3>
                  </div>
                  @if(auth()->user()->can('ver_agendas'))
                  <div class="col-md-4 offset-md-2">
                    <select class="form-control select2" style="width: 100%;" name = "agendas" id="select2_staff_diary"  data-placeholder="Seleccione otras agendas..." >
                      <option value="0" @if($selecteduser==0) selected @endif>Ver otras agendas...</option>
                      @foreach ($users_prof as $user ) 
                        <option value="{{$user->id}}" @if($selecteduser==$user->id) selected @endif >{{$user->name}}</option>
                      @endforeach
                      <option value="{{auth()->user()->id}}" @if($selecteduser==auth()->user()->id) selected @endif>Mi agenda</option>
                    </select>
                  </div>
                  @endif
                  
                </div>

              </div>
              <div class="card-body p-0">
                <!-- THE CALENDAR -->
               @include('content.diary.partials.diary')
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    @include('content.diary.modals.diary_create')
    @include('content.diary.modals.diary_show')


@endsection

@push('scripts')
<!-- aqui van los scripts de cada vista -->
<!-- fullCalendar 2.2.5 -->
<script src="{{ asset('plugins/moment/moment.min.js')}}?v={{ config('app.asset_version') }}"></script>
<script src="{{ asset('plugins/fullcalendar/main.min.js')}}?v={{ config('app.asset_version') }}"></script>
<script src="{{ asset('plugins/fullcalendar-daygrid/main.min.js')}}?v={{ config('app.asset_version') }}"></script>
<script src="{{ asset('plugins/fullcalendar-timegrid/main.min.js')}}?v={{ config('app.asset_version') }}"></script>
<script src="{{ asset('plugins/fullcalendar-interaction/main.min.js')}}?v={{ config('app.asset_version') }}"></script>
<script src="{{ asset('plugins/fullcalendar-bootstrap/main.min.js')}}?v={{ config('app.asset_version') }}"></script>
<script src="{{ asset('plugins/fullcalendar/locales/es-us.js')}}?v={{ config('app.asset_version') }}"></script>
<!-- Page specific script -->

<!-- bootstrap color picker -->
<script src="{{ asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}?v={{ config('app.asset_version') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}?v={{ config('app.asset_version') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js')}}?v={{ config('app.asset_version') }}"></script>



<script>
  $(function () {    

     var infoEvent;

    /* initialize the calendar
     -----------------------------------------------------------------*/

    var Calendar = FullCalendar.Calendar;

    var calendarEl = document.getElementById('calendar');

    // initialize the external events
    // -----------------------------------------------------------------

    var calendar = new Calendar(calendarEl, {
      plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid' ],
      locale: 'es-us',

      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'dayGridMonth,timeGridWeek,timeGridDay'
      },slotLabelFormat:{
             hour: '2-digit',
             minute: '2-digit',
             hour12: true
             },//se visualizara de esta manera 01:00 AM en la columna de horas
eventTimeFormat: {
               hour: '2-digit',
               minute: '2-digit',
               hour12: true
              },
      'themeSystem': 'bootstrap',
      //Random default events
      events    : [

         @foreach ($diarys as $diary )     
            { 
             
              title          : '{{$diary->title}}',
              start          : '{{$diary->inicio}}',
              end            : '{{$diary->fin}}',
              allDay         : false,
              backgroundColor: '{{$diary->color}}', 
              borderColor    : '{{$diary->color}}',
              id             : '{{$diary->id}}'

            },
          @endforeach

      ],
      editable  : true,
      droppable : true, // this allows things to be dropped onto the calendar !!!
      eventDrop: function(info) {
          Swal.fire({
                title: 'Esta seguro de cambiar la fecha del evento?',
                text: "El evento se actualizará con la nueva fecha!",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, cambiar!',
                cancelButtonText: 'Cancelar'
              }).then((result) => {
                if (result.value) {
                    start= moment(info.event.start, 'YYYY-MM-DDTHH:mm:ssZ').format('YYYY-MM-DD HH:mm:ss');
                    end= moment(info.event.end, 'YYYY-MM-DDTHH:mm:ssZ').format('YYYY-MM-DD HH:mm:ss');
                    var id =info.event.id;
                    var request = {'id':id, 'inicio':start, 'fin':end};
                    $.ajax({
                      url: '/agenda/edit',
                      type: 'POST',
                      datatype: 'json',
                      data: request,
                      cache: false,
                      beforeSend: function (xhr) {
                          xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                          $("#wait").show();
                          
                      },
                      success: function (res) {
                    
                      $("#wait").hide()
                      
                      },
                      error: function (xhr, textStatus, thrownError) {
                         info.revert();
                          alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
                         
                      }
                    });
                        
                } else {
                  info.revert();
                }
              });




          
        
  
      },
      //evento click para todos los eventos del calendario "ver, editar y eliminar"
      eventClick: function(info) {
        infoEvent = info;
        
        //edit
        $("#lbl_modal_title_diary").html('Editar evento');//titulo modal
        $('#diary_id').val(info.event.id); //campo descripcion
        $("#fecha_evento_diary").prop( "disabled", false );//campo fecha
        $("#fecha_evento_diary").val(moment(info.event.start, 'YYYY-MM-DDTHH:mm:ssZ').format('YYYY-MM-DD')); //campo fecha
        $('#input-date-picker1').val(moment(info.event.start, 'YYYY-MM-DDTHH:mm:ssZ').format('LT')); //campo inicio
        $("#input-date-picker1").prop( "disabled", false );//campo inicio
        $('#input-date-picker2').val(moment(info.event.end, 'YYYY-MM-DDTHH:mm:ssZ').format('LT')); //campo fin
        $('#title_diary').val(info.event.title); 
        //$('#title_url').val(info.event.url); //campo titulo
        $('#description_diary').val(''); //campo descripcion
        $("#btn-event-diary").html('Editar'); //sutmit editar
        $('#select2_users_diary').val(null).trigger('change');//select invitados 



        $.ajax({
            url: '/agenda/source/'+info.event.id,
            type: 'GET',              
            cache       : false,
            contentType : false,
            processData : false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                $("#wait").show()
            },
            success: function(res)
            {
              
              if (res.userowner) {
                $("#fecha_evento_diary").val(moment(res.inicio, 'YYYY-MM-DDTHH:mm:ssZ').format('YYYY-MM-DD')); //campo fecha
                $('#input-date-picker1').val(moment(res.inicio, 'YYYY-MM-DDTHH:mm:ssZ').format('LT')); //campo inicio
                $('#input-date-picker2').val(moment(res.fin, 'YYYY-MM-DDTHH:mm:ssZ').format('LT')); //campo fin
                $('#title_url').val(res.url);
                $('#arf_title_url').attr("href",res.url).text(res.url);
                $('#title_diary').val(res.title); // //campo titulo
                $('#description_diary').val(res.description); //campo descripcion
                $("#btn-event-diary").html('Editar'); //sutmit editar
                $('#input-color-diary').val(res.color);
                $('#color-diary').css("background-color", res.color); 
                $("#footer_modal-diary").html('<button type="button" id ="delete_event_diary" class="btn btn-danger">Eliminar evento</button>');//boton eliminar
                var userselect = [];
                res.users.forEach(function(user){

                  if (user.pivot.owner == 0) {
                    userselect.push(user.id); 
                  }
                  
                });

                // selecciona en el select2 a los usuarios a los que se ha compartido el evento
                $('#select2_users_diary').val(userselect);
                $('#select2_users_diary').trigger('change');
                $("#myModal_create_diary").modal("show");

              } else {
                    //show
                  username='';
                  res.users.forEach(function(user){
                  if (user.pivot.owner == 1) {
                    username = user.name;
                  }
                  });
                //  alert("si")
                $("#lbl_modal_title_diary_show").html('Invitación evento');//titulo modal
                $("#fecha_evento_diary_show").val(moment(info.event.start, 'YYYY-MM-DDTHH:mm:ssZ').format('YYYY-MM-DD')); //campo fecha
                $('#input-date-picker1_show').val(moment(res.inicio, 'YYYY-MM-DDTHH:mm:ssZ').format('LT')); //campo inicio
                $('#input-date-picker2_show').val(moment(res.fin, 'YYYY-MM-DDTHH:mm:ssZ').format('LT')); //campo fin
                $('#title_diary_show').val(res.title);
                $('#arf_title_url').attr("href",res.url).text(res.url); //campo titulo
                $('#description_diary_show').val(res.description); //campo descripcion
                $("#footer_modal-diary-show").html('<p style="margin: -10px 10px !important;">Creado por: '+username+'</p>');//boton eliminar
                $("#myModal_show_diary").modal("show");
                //fin_show


              }
            
              $("#wait").hide()
            },
            error: function(data)
            {
                console.log(data);
            }
        });





        
        
        // change the border color just for fun
        info.el.style.borderColor = 'black';
  },
  //evento click para los dias del calendario "crear"
  dateClick: function(info) {
    $("#lbl_modal_title_diary").html('Nuevo evento: '+fecha_string(info.date)); //titulo modal
    $('#diary_id').val('0');
    $("#fecha_evento_diary").val(moment(info.date, 'YYYY-MM-DDTHH:mm:ssZ').format('YYYY-MM-DD')); //campo fecha
    $("#fecha_evento_diary").prop( "disabled", true );//campo fecha
    var hora = info.date.getHours();
    if (hora != 0) { 
      $('#input-date-picker1').val(moment(info.date, 'YYYY-MM-DDTHH:mm:ssZ').format('LT'));//campo inicio
      $("#input-date-picker1").prop( "disabled", true );//campo inicio
    } else {
      $("#input-date-picker1").val('');//campo inicio
      $("#input-date-picker1").prop( "disabled",false );//campo inicio
    }
    $('#input-date-picker2').val(''); //campo fin
    $('#title_diary').val(''); //campo titulo
    $('#title_url').val(''); //campo url
    $('#description_diary').val(''); //campo descripcion
    $('#select2_users_diary').val(null).trigger('change');//select invitados    
    $("#btn-event-diary").html('Crear');
    $("#footer_modal-diary").html('');
    $("#myModal_create_diary").modal("show");






//finañadir evento
  }  
    });
   
function addcalendar(title, start, end, color, id){

calendar.addEvent({
    title: title,
    start: start,
    end: end,
    allDay : false,
    id: id,
    backgroundColor: color,
    borderColor    : color
    });

  }



    calendar.render();



$("#myformCreateDiary").on('submit',function(e){
    var route = "";
    if ($("#btn-event-diary").html() ==  "Editar") {
      route="/agenda/update";

    } else if ($("#btn-event-diary").html() ==  "Crear") {
      route="/agenda/create";

    }
    //toma datos del formulario para crear o actulizar el evento en tiempo real
      var title = $("#myformCreateDiary input[name=title]").val();
      var fecha = $("#myformCreateDiary input[name=fecha]").val();
      var start = $("#myformCreateDiary input[name=inicio]").val();
      var end = $("#myformCreateDiary input[name=fin]").val();
      var color = $("#myformCreateDiary input[name=color]").val();
      start = moment(start, ["h:mm A"]).format("HH:mm");
      end = moment(end, ["h:mm A"]).format("HH:mm");
      start= moment(fecha+' '+start, 'YYYY-MM-DDTHH:mm:ssZ').format('YYYY-MM-DD HH:mm:ss');
      end= moment(fecha+' '+end, 'YYYY-MM-DDTHH:mm:ssZ').format('YYYY-MM-DD HH:mm:ss');


    var request = $(this).serialize(); 
     request = request+"&start="+start; 
     request = request+"&end="+end; 


          
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
        success: function (res) {
          // console.log(res);
           
          if ($("#btn-event-diary").html() ==  "Editar") {
            infoEvent.event.remove();
          }
            addcalendar(title, start, end, color, res.id);
 

         $("#wait").hide()
         
        },
        error: function (xhr, textStatus, thrownError) {
            alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
        }
    });
    





  $("#myModal_create_diary").modal('hide');

return false;


 });


 $("#myModal_create_diary").on("click",'#delete_event_diary',function(e){

 Swal.fire({
        title: 'Esta seguro de elimina el evento?',
        text: "Los cambios no podrán ser revertidos!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.value) {
            var id =$('#diary_id').val();
            var request = {'id':id};
            $.ajax({
              url: '/agenda/delete',
              type: 'POST',
              datatype: 'json',
              data: request,
              cache: false,
              beforeSend: function (xhr) {
                  xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                  $("#wait").show();
                  
              },
              success: function (res) {
                  $("#myModal_create_diary").modal('hide');
                  infoEvent.event.remove();
            
              $("#wait").hide()
              
              },
              error: function (xhr, textStatus, thrownError) {
                  alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
              }
            });
                
        }
      });




 
         
      
 

  
 });







});//




function fecha_string(date) {
var meses = [
  "Enero", "Febrero", "Marzo",
  "Abril", "Mayo", "Junio", "Julio",
  "Agosto", "Septiembre", "Octubre",
  "Noviembre", "Diciembre"
]
var jornada ='';
var minutos = date.getMinutes();
var hora = date.getHours();
var dia = date.getDate();
var mes = date.getMonth();
var yyy = date.getFullYear();
if (hora == 0 ) {
var fecha_formateada = meses[mes] + ' ' + dia + ' de ' + yyy;
} else {
  if (minutos < 10) { minutos = '0'+minutos; }
  if (hora < 12) { hora = hora;  jornada = 'AM';  } else {  hora = hora - 12; if (hora == 0) { hora = 12; } jornada = 'PM'; }
  var fecha_formateada = meses[mes] + ' ' + dia + ' de ' + yyy+ ' a las ' +hora+':'+minutos+' '+jornada;
}
return fecha_formateada;

}

  //Timepicker
    $('#timepicker1').datetimepicker({
      format: 'LT'
    })
    $('#timepicker2').datetimepicker({
      format: 'LT'
    })
  //color picker
    $(function () {
    
    $('#cp2').colorpicker({"color": "#11a643"});
  //select2
    $('.select2').select2();


 
   $('#alert_diary').fadeIn();     
  setTimeout(function() {
       $("#alert_diary").fadeOut();           
  },15000);


  $('#select2_staff_diary').on('select2:select', function (e) {
      var data = e.params.data;
      if (data.id == 0) {
        window.location='/agenda';
      } else {
        var url = '/agenda?search='+data.id;
        window.location=url;
      }

      //console.log(data.id);
  });
 

  });
</script>

@endpush

