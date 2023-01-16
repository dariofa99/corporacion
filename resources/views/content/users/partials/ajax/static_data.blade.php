<div class="row">    
      @foreach($data_aditional_info as $key => $question)
        <div class="col-md-4 setOlderValue ctn_question" id="content_user_question-{{$question->id}}">
          @include('content.users.partials.ajax.static_data_question')
        </div>
      @endforeach  
  </div>