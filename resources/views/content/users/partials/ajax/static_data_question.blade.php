
 
<label style="font-size: 13px">{{$question->name}}</label> 
   

  @if(count($question->options)>0)
  @foreach($question->options as $key_op => $option)
  @if($question->type_data_id==136)   
  <div class="form-check">
    <input data-active_other="{{$option->active_other_input}}" class="form-check-input user_static_data"
  @if($user->getAditionalDataValue($question->id,$option->id))  checked @endif
      type="checkbox" name="static_data-{{$question->id}}" data-reference_id="{{$question->id}}"
       data-id="{{$option->id}}" value="{{$option->value}}">
        <label class="form-check-label" for="inlineRadio2">{{$option->value}}</label>
      </div>
  @else
  <div class="form-check">
    <input data-active_other="{{$option->active_other_input}}" class="form-check-input user_static_data"
     @if($user->getAditionalDataValue($question->id,$option->id))  checked @endif
      type="radio" name="static_data-{{$question->id}}" data-reference_id="{{$question->id}}"
       data-id="{{$option->id}}" value="{{$option->value}}">
        <label class="form-check-label" for="inlineRadio2">{{$option->value}}</label>
      </div>
  @endif 
    @if($option->active_other_input and $user->getAditionalDataValue($question->id,$option->id))
    <div class="form-group">
      <input type="text" class="form-control form-control-sm user_static_data_other" data-reference_id="{{$question->id}}"
        data-id="{{$option->id}}" value="{{$user->getAditionalDataValueOther($question->id,$option->id)}}">
    </div>
    @endif
  @endforeach
  @else
  <div class="form-group">
    <input type="text" data-type_id="{{$question->id}}" 
    @if($user->getDataValue($question->id)) value="{{$user->getDataValue($question->id)->value}}" @endif 
    required class="form-control form-control-sm input_user_data" 
    name="data[]">    
  </div> 
  @endif
