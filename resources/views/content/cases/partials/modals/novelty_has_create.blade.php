@component('components.modal_medium')

	@slot('trigger')
        myModal_create_novelty_has
	@endslot

	@slot('title')
		<h6><label id="lbl_modal_title">Agregar Novedad </label></h6>
	@endslot


	@slot('body')


 	<div class="row">

		<div class="col-md-10 offset-md-1">
		       
        <form action="{{ route('cases.addnoveltyhasdata') }}" method="POST" id="myformCreateNoveltyHas">
    <input type="hidden" name="component" id="component_has" value="case_has"> <!-- component field -->
    {{ csrf_field() }}

    <div class="form-group">
        <!-- Novedad (question_id) -->
        <label for="novelty" class="strong">Novedad</label>
        <select class="form-control form-control-sm input_data" id="types_category_novelty_has" name="data[0][question_id]">
            <option value="view_all">Seleccione...</option>
            @foreach ($types_categories_novelty_has as $key => $type_categories_novelty_has)
                <option value="{{ $key }}">{{ $type_categories_novelty_has }}</option>
            @endforeach
        </select>

        <!-- Estado (option_id and value) -->
        <label for="state" class="strong">Estado</label>
        <select class="form-control form-control-sm input_data" id="state_novelty_has" name="data[0][options][0][option_id]">
            <option value="view_all">Seleccione...</option>
        </select>

        <!-- Value input (associated with option_id) -->
        <input type="hidden" id="value_novelty_has" name="data[0][options][0][value]">
    </div>

    <button type="submit" class="btn btn-primary btn-block">Agregar</button>
    <button type="button" style="display:none" class="btn btn-default btn-block">Agregar</button>
</form>

         
		</div>
	</div>


	@endslot

  	@slot('footer')  
       
    @endslot
  
@endcomponent
<!-- /modal -->

