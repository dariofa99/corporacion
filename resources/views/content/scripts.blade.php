<script>
class ViewComponents {

    constructor(component = ''){
      this.component = component;
    }

    renderLogs(array){
      console.log(array,'logs')
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
})
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