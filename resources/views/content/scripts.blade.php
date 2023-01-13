<script src="{{ asset('js/app.js') }}" ></script>
<script>
  
    localStorage.setItem("token", "898");          
    //Echo.connector.options.auth.headers['Authorization'] = 'Bearer '+localStorage.getItem("token");;

class ViewComponents {

    constructor(component = ''){
      this.component = component;
    }

    renderLogs(array){
   
      var row = '';          
                row += `<ul class="products-list product-list-in-card pl-2 pr-2" style="overflow: auto;max-height:300px">`
                array.forEach(log_f => { 
                 if((log_f.files.length)>0){      
                  log_f.files.forEach(log => {             
                              
                  row += `<li class="item">                    
                    <div class="product-inf">
                      <a href="#" class="product-titl" style="color:#000000">${log_f.description}
                        <span class="badge badge-warning float-right">${log.created_at}</span>
                      </a>
                      <span class="product-description">                         
                            <a target="_blank" href="/oficina/descargar/documento/${log.id}" class="small-box-footer">
                               ${log.original_name}
                            </a>                     
                      </span>  
                    </div>
                  </li>`;

                }); 
                }    
              });
               row += `</ul>`;
            

            return row;
    }

     renderNotifications(array){

      var row = '';          
                row += `<ul class="products-list product-list-in-card pl-2 pr-2" style="overflow: auto;max-height:400px">`
                array.forEach(log => {                                  
                  row += `<li class="item">                    
                    <div class="product-inf">
                      <a href="#" class="product-titl" style="color:#000000">${log.description}
                        <span class="badge badge-warning float-right">${log.created_at}</span>
                      </a>
                    
                    </div>
                  </li>`
                   
              });
               row += `</ul>`;
            

            return row;
    }

  renderUsersLogin(array){
     var row = '';
            array.forEach(element => {
                row += `  <a href="#" class="dropdown-item user_login-${element.id}" >
            <!-- Message Start -->
            <div class="media">
              <img src="{{asset('${element.image}')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  ${element.name}
                  <span class="float-right text-sm text-danger">
                  <!-- icon --></span>
                </h3>
                <p class="text-sm"><!-- Message --></p>
                <p class="text-sm text-muted">
                <!--
                <i class="far fa-clock mr-1"></i>
                                 tiempo -->
                 
                 </p>
              </div>
            </div>
            <!-- Message End -->
          </a>

          <div class="dropdown-divider user_login-${element.id}" ></div> `;
            });

            return row;
      }

        loadUserData(user_data){
            var row = '';
            user_data.forEach(element => {
                row += `<div class="col-md-3">
                 <div class="form-group">
                 <label for="data-${element.id}">${element.name} </label>
                 <input type="text" data-type_id="${element.type_data_id}" value="${element.value}"  required class="form-control form-control-sm  input_user_data" name="data[]">                               
                </div>
                </div>`;
            });

            return row;
        }

       listUsersTable(res){
           var row = '';
           res.forEach(element => {     
                     row += `<tr>
                    <td>${element.identification_number}</td>
                    <td>${element.name}</td>
                    <td>${element.email}</td>
                    <td>${element.phone_number}</td>
                    <td>${element.address}</td>
                    <td><button class="btn btn-success btn-sm btn_user_data" data-id="${element.id}">Detalles</button></td></tr>`
           });
          
          return row;
       } 
        listLogsTable(logs){
          var row = '';
           logs.forEach(log => {     
            row += `<tr>
                        <td>
                        ${log.concept}
                        </td>
                        <td>
                        ${log.description}
                        </td>
                        <td>
                        <button  class="btn btn-primary btn-sm btn_log_edit" data-id="${log.id}">Editar</button>
                        <button disabled class="btn btn-success btn-sm">Detalles</button>
                        </td>
                        </tr>`
           });
          
          return row;

          


        }

        rederUserLogin = (user) => {
          var file = '';
            file =    ` 
                <a href="/admin/users/${user.id}/edit?chat=true" id="user_connect-${user.id}" class="dropdown-item">
                  <!-- Message Start -->
                  <div class="media">
                    <img src="${user.profile_image}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                    <div class="media-body">
                      <h3 class="dropdown-item-title">
                        ${user.name}
                        <span class="float-right text-sm text-green"><i class="fas fa-circle"></i></span>
                      </h3>
                      
                    </div>
                  </div>
                  <!-- Message End -->
                </a>
                `
          $("#list_users_login").append(file);



                  }

}



//var token = localStorage.getItem('tokensessionpc');
$(document).ready(function(){
    $("#logout-form").on('submit',function(e){
      if (typeof(Storage) !== 'undefined') {
        // Código cuando Storage es compatible
        var token = localStorage.getItem('tokensessionpc');
        //token = token;
       $(this).append($('<input>',{
            'type':'text',
            'value':token,
            'name':'token'
        }));
    } else {
       // Código cuando Storage NO es compatible
    } 
    e.preventDefault();
});


var channel = Echo.join('notify.stream.{{Auth::user()->id}}');
                channel.listen('.notify-stream', function(data) {
                  //console.log(data);
                  Swal.fire({
                  allowOutsideClick: false,
                  title: 'Invitación a videollamada, aceptar?',
                  text: data.room,
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, aceptar!',
                  cancelButtonText: 'Cancelar'
                }).then((result) => {
                  if (result.value) {
                      $('#newtab-stream-cases-client').attr('href', data.room);
                      //$('#copy-stream-cases-client').attr('data-frame', data);
                      $('#text-stream-cases-client').val(data.room);
                      $('#iframe-stream-cases-client').attr('src', data.room);
                      $('#myModal_client_streaming_cases').modal({backdrop: 'static', keyboard: false});
                      $('#myModal_client_streaming_cases').modal('show');
                  }
              });
            });

});
let view = new ViewComponents();
users_connect = [];
var channel = Echo.join('login');
    channel.listen('.event-login', function(data) {
        
    }).here(users => {
      users.forEach(user => {
        if(user.id != {{auth()->user()->id}}){
          view.rederUserLogin(user);
          users_connect.push(user);
        }        
      });
     
      $(".lbl_chatCountUsers").text(users_connect.length)
     }).joining(user => {
      users_connect.push(user)
      view.rederUserLogin(user);
      $(".lbl_chatCountUsers").text(users_connect.length)
      
    }).leaving(user => {
        users_connect =  users_connect.filter(function(user_l){ 
            return user_l.id != user.id; 
        });

        $("#user_connect-"+user.id).remove();
        $(".lbl_chatCountUsers").text(users_connect.length)
        
    });

//console.log(token)

function setToken(){
  if (typeof(Storage) !== 'undefined') {
        // Código cuando Storage es compatible
        var token = localStorage.getItem('tokensessionpc');
        //token = token;
       $('#logout-form').append($('<input>',{
            'type':'text',
            'value':token,
            'name':'token'
        }));
    } else {
       // Código cuando Storage NO es compatible
    }
}


</script>

@if (Cookie::get('tokenpc') !== null)
  
  <script>
    localStorage.setItem('tokensessionpc', '{{Cookie::get("tokenpc")}}');
  </script>     
@endif

@foreach (['danger', 'warning', 'success', 'info'] as $key)
        @if(Session::has($key))            
            <script>
                if('{{$key}}' == 'success'){
                      toastr.success('{{ Session::get($key) }}','',
                        {"positionClass": "toast-top-right","timeOut":"5000"});
                }             
            </script> 
        @endif
@endforeach

@if(Session::has('mail_error'))
            
            <script>
                toastr.error('{{ Session::get("mail_error") }}','Error',
                    {"positionClass": "toast-top-right","timeOut":"10000"});
            </script> 
@endif
