<form class="form-horizontal" action="{{route('users.update',$user->id)}}" method="POST" id="myformEditUser">
               
    {{ csrf_field() }} 
    <input type="file" id="image" name="image" style="display:none">
    <input type="hidden" value="{{$user->id}}" id="id" name="id" style="display:none">
                     <div class="form-group">
                       <label for="inputName" class="col-sm-10 control-label">Tipo identificación</label>

                       <div class="col-sm-10">
                            <select disabled name="type_identification_id" id="type_identification" class="form-select" required>
                              @foreach ($types_identification as $key => $tipo_doc)
                                  <option value="{{ $key }}" {{ $key == $user->type_identification_id ? 'selected' : '' }}>{{ $tipo_doc }}</option>
                              @endforeach
                            </select>
                       </div>

                     </div>

                     <div class="form-group">
                       <label for="inputName" class="col-sm-10 control-label">Número de identificación</label>

                       <div class="col-sm-10">
                        <input type="text" disabled value="{{$user->identification_number}}" required class="form-control form-control-sm onlynumber" name="identification_number" id="identification_number">
                      </div>

                     </div>

                     <div class="form-group">
                       <label for="inputName" class="col-sm-2 control-label">Nombres</label>

                       <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" {{$canedit ? '':'disabled'}} id="name" name="name" value="{{$user->name}}">                               
                       </div>

                     </div>

                     <div class="form-group">
                       <label for="inputEmail" class="col-sm-3 control-label">Correo electrónico</label>

                       <div class="col-sm-10">
                         <input type="email" class="form-control form-control-sm" {{$canedit ? '':'disabled'}} id="email" name="email" value="{{$user->email}}">                               
                           </div>
                     </div>
                     <div class="form-group">
                       <label for="inputName2" class="col-sm-2 control-label">Dirección</label>

                       <div class="col-sm-10">
                         <input type="text" class="form-control form-control-sm" {{$canedit ? '':'disabled'}} value="{{$user->address}}" name="address" id="address" placeholder="Dirección">
                       </div>
                     </div>

                     <div class="form-group">
                      <label for="inputName2" class="col-sm-2 control-label">Municipio</label>

                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" {{$canedit ? '':'disabled'}} value="{{$user->town}}" name="town" id="town" placeholder="Municipio">
                      </div>
                    </div>

                     <div class="form-group">
                       <label for="inputExperience" class="col-sm-2 control-label">Teléfono</label>

                       <div class="col-sm-10">
                         <input type="text" class="form-control form-control-sm onlynumber" {{$canedit ? '':'disabled'}} id="phone_number" name="phone_number" value="{{$user->phone_number}}">                               
                       </div>
                     </div>
                     <div class="form-group">
                      <label for="inputName" class="col-sm-10 control-label">Estado</label>
                      @if(auth()->user()->can('cambiar_estado_usuario'))
                      <div class="col-sm-10">
                        <select name="type_status_id" class="form-control form-control-sm">
                          @foreach ($types_status as $key => $type_status )
                            <option value="{{$key }}" {{$key == $user->type_status->id ? 'selected' : ''}}>{{$type_status}}</option>
                          @endforeach
                        </select>                     
                      </div>
                      @endif
                    </div>
               {{--       <div class="form-group">
                       <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                       <div class="col-sm-10">
                         <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                       </div>
                     </div> 
                     <div class="form-group">
                       <div class="col-sm-offset-2 col-sm-10">
                         <div class="checkbox">
                           <label>
                             <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                           </label>
                         </div>
                       </div>
                     </div>--}}
                     @if($canedit)
                     <div class="form-group">
                       <div class="col-sm-offset-2 col-sm-10">
                         <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                       </div>
                     </div>
                     @endif
                   </form>