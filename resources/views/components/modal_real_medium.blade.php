<div  id="{{$trigger}}"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{$title}}</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{$body}}
      </div>
      <div class="modal-footer">
        {{$footer}}   
        <button type="button" id="btn_close" data-bs-dismiss="modal" class="btn btn-default">Cancelar</button>

      </div>
    </div>
  </div>
</div>


