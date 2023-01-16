
<!-- Trigger the modal with a button -->
<div  id="mymodal" class="modal fade" role="dialog" >
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">
	<div class="row"  id="tituloturnos"  >
	</div>
	</h4>
      </div>
      <div class="modal-body">


     <div>

      <div class="row">
        <div class="col-md-12">
           <table id="tbl_turnos_list" class="table table-bordered table-striped dataTable" role="grid">

                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Nombre</th>
                      <th>Curso</th>
                    </tr>
                  </thead>
                <tbody id="contencalendarid">
                </tbody>
                </table>
        </div>
      </div>

      </div>


      <div class="modal-footer">
       {{--  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button> --}}
      </div>
    </div>

  </div>
</div>

</div>
