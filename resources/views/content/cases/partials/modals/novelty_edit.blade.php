@component('components.modal_medium')

	@slot('trigger')
        myModal_edit_novelty
	@endslot

	@slot('title')
		<h6><label id="lbl_modal_title">Editar Novedad </label></h6>
	@endslot


	@slot('body')


 	<div class="row">

		<div class="col-md-10 offset-md-1">
		       
        <form action="{{ route('cases.addnoveltydata') }}" method="POST" id="myformEditNovelty">
        <input type="hidden" name="component" id="component" value="case">
    {{ csrf_field() }}

    <div class="form-group">
        <!-- Novedad (question_id) -->
        <label for="novelty" class="strong">Novedad</label>
        <select class="form-control form-control-sm input_data" id="types_category_novelty_edit" name="data[0][question_id]">
            <option value="view_all">Seleccione...</option>
            @foreach ($types_categories_novelty as $key => $type_categories_novelty)
                <option value="{{ $key }}" {{ $noveltyData->reference_data_id == $key ? 'selected' : '' }}>
                    {{ $type_categories_novelty }}
                </option>
            @endforeach
        </select>

        <!-- Estado (option_id and value) -->
        <label for="state" class="strong">Estado</label>
        <select class="form-control form-control-sm input_data" id="state_novelty_edit" name="data[0][options][0][option_id]">
            <option value="view_all">Seleccione...</option>
            @foreach ($options as $key => $options)
                <option value="{{ $key }}" {{ $noveltyData->reference_data_option_id == $key ? 'selected' : '' }}>
                    {{ $options }}
                </option>
            @endforeach
        </select>

        <!-- Value input (associated with option_id) -->
        <input type="hidden" id="value_novelty_edit" name="data[0][options][0][value]">
    </div>

    <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
    <button type="button" style="display:none" class="btn btn-default btn-block">Actualizar</button>
</form>

         
		</div>
	</div>


	@endslot

  	@slot('footer')  
       
    @endslot
  
@endcomponent
<!-- /modal -->

