<!-- Modal -->
<div class="modal bd-example-modal-lg fade" id="{{$trigger}}"  tabindex="-1" aria-labelledby="{{$trigger}}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="{{$trigger}}" >{{$title}}</h5>
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






