
                        @foreach($library as $file)
                          
                       
                          <div class="col-lg-3 col-6" id="{{$file->id}}">
                            <!-- small card -->
                            <div class="small-box {{ getBgColorDocument($file->name_file) }}">
                              <div class="inner bg-white archive" data-id="{{ $file->id }}" >
                                <h6 title="Nombre del archivo">{{ $file->description }}</h6>
                                <div class="row tmno">
                                  <div class="col-7">
                                    <p>Tamaño: {{ number_format(($file->size / 1048576),2) }} MB
                               
                                    </p>      
                                  </div>
                                  <div class="col-5 mx-auto">
                                    <a href="#" class="small-box-footer">
                                        Ver más...
                                    </a>
                                  </div>
                                </div>
                                <p>Subido: {{getDateForNotification($file->created_at)}}</p>
                              </div>
                              <div class="icon archive" data-id="{{ $file->id }}">
                                <i class="{{ getBgIconDocument($file->name_file) }}"></i>
                              </div>
                                <a target="_blank" href="/biblioteca/download/{{ $file->id }}" class="small-box-footer">Descargar  <i class="fas fa-cloud-download-alt"></i>
                                </a>
                            </div>
                          </div>

                        @endforeach



