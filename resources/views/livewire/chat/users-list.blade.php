<div>
    {{-- The Master doesn't talk, he acts. --}}

    <div class="card card-widget">
           
              
            <div class="card-footer card-comments" >
                @foreach ($users as $user )
                <div style="cursor:pointer" class="card-comment" wire:click="initChat('{{$user->name}}',{{$user->id}})">
                  <!-- User image -->
                    <img class="img-circle img-sm" src="{{asset($user->image)}}" alt="User Image">

                    <div class="comment-text">
                        <span class="username">
                     
                      {{$user->name}}

                         <span class="text-muted float-right">8:03 PM Today
                      
                      <i class="nav-icon far fa-circle  btn-chat bg-gray"></i>
                      </span>
                      
                    </span><!-- /.username -->
                    
                  </div>
                  <!-- /.comment-text -->
                   
                </div>
                <!-- /.card-comment -->
                @endforeach
              
          
              </div>
              <!-- /.card-footer -->
            
              <!-- /.card-footer -->
            </div>


</div>
