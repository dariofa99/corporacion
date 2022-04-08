                     @forelse($types_data_user as $key => $value)    
                          <div class="col-md-4">
                            <div class="form-group">
                              <label style="font-size: 13px" for="data-{{$key}}">{{$value}}</label>
                              <input type="text" data-type_id="{{$key}}" 
                              @if($user->getDataValue($key)) value="{{$user->getDataValue($key)->value}}" @endif 
                              required class="form-control form-control-sm input_user_data" 
                              @if($canedit) id="data_us-{{$key}}" @else disabled @endif name="data[]">                               
                            </div>
                          </div> 
                          @empty
                      @endforelse       
 