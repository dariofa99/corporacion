<div class="row">

    @forelse($user->notes()->where('type_status_id','<>','15')->get() as $note)
    <div class="col-md-4">
        <div class="card" style="min-height: 8.5rem;max-height: 8.5rem; font-size:16px">
            <div class="card-body">
              {{-- <h5 class="card-title">Card title</h5> --}}
              <div class="content" style="min-height: 5rem;max-height: 5rem;overflow:auto">
            <p class="card-text" id="content_note_text-{{$note->id}}">
                    {!!nl2br($note->note)!!} 
            </p>

        <textarea style="display: none;height: 78px;" name="data" id="input_note-{{$note->id}}" no-resize class="form-control form-control-sm" rows="4">{{$note->note}}</textarea>
               
           
              </div>
        
            <div class="row">
                <div class="col-md-12 pl-2 mt-1" id="content_btns_edit-{{$note->id}}">
                    <a href="#" class="card-link btn_delete_note" data-id="{{$note->id}}"><i class="fa fa-trash"></i></a>
                    <a href="#" class="card-link btn_edit_note" data-id="{{$note->id}}"><i class="fa fa-edit"></i></a>
                </div>      
                <div class="col-md-12 pl-2 mt-1" style="display: none" id="content_btns_update-{{$note->id}}">
                    <a href="#" class="card-link btn_cancel_update_note" data-id="{{$note->id}}"><i class="fa fa-times"></i></a>
                    <a href="#" class="card-link btn_update_note" data-id="{{$note->id}}"><i class="fa fa-check"></i></a>
                </div>    
            </div>
        </div>
        </div> 
    </div>
    @empty
  {{--   <div class="col-md-4">

        <div class="card" style="min-height: 10rem;max-height: 10rem">
            <div class="card-body">
            {{--   <h5 class="card-title">Card title</h5> 
             
            <textarea name="data" id="dat_user" no-resize class="form-control form-control-sm" rows="5"> Some quick example text to build on the card title and make up the bulk of the card's content.</textarea>
             
            </div>
        </div> 
    </div> --}}
    @endforelse
</div>


   
       

   

  
