 <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">

@forelse($user->getData() as $value)
        <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="data-{{$value->id}}">{{$value->name}}</label>
                                        <input type="text" data-type_id="{{$value->type_data_id}}" value="{{$value->value}}" required class="form-control form-control-sm input_user_data" id="data-{{$value->id}}" name="data[]">                               
                                    </div>
        </div>
                @empty
       
@endforelse
