@forelse($types_data_am_user as $key => $value)
               <strong><i class="fas fa-star mr-1"></i>{{$value}}</strong>
                <input type="hidden" id="input_about_me-{{$key}}" data-type_id="{{$key}}" 
                 @if($user->getDataValue($key)) value="{{$user->getDataValue($key)->value}}" @endif
                  required class="form-control form-control-sm input_user_data"> 
                   
                   
            <p class="text-muted" id="lbl_btn_dedit-{{$key}}">

@if($canedit)
              <i style="font-size:12px" id="btn_dedit-{{$key}}" data-id="{{$key}}" class="fa fa-edit  btn_dedit" >
             </i> 
@endif                 
                <span>
                   @if($user->getDataValue($key))
                    {{$user->getDataValue($key)->value}}
                    @else
                    --
                  @endif
                </span>
              
                
            </p>
                <hr>

                   
                    @empty
              @endforelse