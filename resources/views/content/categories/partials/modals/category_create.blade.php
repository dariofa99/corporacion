@component('components.modal_medium')

    @slot('trigger')
        myModal_create_cate
    @endslot

    @slot('title')
        <h6><label id="lbl_modal_title">Nueva categoria</label></h6>
    @endslot


    @slot('body')
        <div class="row">
            <div class="col-md-10 offset-md-1" id="content_form_rc">

                <form method="POST" id="myformCreateRCategory" enctype="multipart/form-data">

                    {{ csrf_field() }}

                    <input id="category_id" name="id" type="hidden">

                    <div class="form-group">
                        <label>Usar en</label>
                        <select class="form-control form-control-sm" name="categories" id="select_categories"
                            data-placeholder="Seleccione..." style="width: 100%;">
                            {{--   <option value="type_data_case">Datos del caso</option> --}}
                            <option value="type_category_log">Bitácora</option>
                            <option value="type_data_user">Usuarios</option>
                            <option value="type_data_directory">Directorio</option>
                        </select>
                    </div>
                    <input type="hidden" value="26" name="type_data_id" id="type_data_id">

                    <div class="form-group content_section_users" id="content_section_users" style="display: none">
                        <label>Sección</label>
                        <select class="form-control form-control-sm" name="section" id="select_section_user"
                            data-placeholder="Seleccione..." style="width: 100%;">
                            <option value="case">Datos del caso</option>
                            <option value="about_me">Sobre mí</option>
                            <option value="aditional_info">Información personal</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="date">Nombre de la categoria</label>
                        <input type="text" name="name" id ="name_category" required class="form-control">
                    </div>
                    <div class="row">
                        {{-- <div class="col-md-5">
                            <div class="form-check form-check-inline ">
                                <input class="form-check-input" type="checkbox" name="chk_add_option" id="chk_add_option"
                                    value="true">
                                <label class="form-check-label" for="chk_add_option">Agregar opciones</label>
                            </div>
                        </div> --}}

                        <div class="col-md-12" id="sel_answer_type">
                            <label for="date">Tipo de la categoria</label>
                            <select required name="type_data_id" class="form-control form-control-sm" id="type_data_id_select">
                                @foreach ($typesQuestions as $key => $typeQuestion)
                                    <option value="{{ $key }}">{{ $typeQuestion }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="adoptions" style="display:none" id="content_aditional_options">
                        <table id="aditional_options_table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th> <small>Activa otro</small></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <table>
                            <tbody>
                                <tr>
                                    <td>
                                        <label style="cursor: pointer" class="btn_add_field">
                                            Agregar campo
                                        </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" id="btn-event-diary" class="mt-3 btn btn-primary btn-block">Crear</button>
                </form>
            </div>
        </div>
    @endslot

    @slot('footer')
        <div id="footer_modal-diary"> </div>
    @endslot

@endcomponent
<!-- /modal -->
