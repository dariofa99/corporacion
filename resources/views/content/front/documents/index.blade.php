@extends('front.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->
<style>
  .small-box {
    padding-top: 5px;
  }
  .small-box > .inner {
    color: #000000;
    background-color: #000;
    margin: 10px 0px 10 10px !important;
  }
  .small-box > .inner > p {
    margin: 0px !important;
    font-size:12px;
    color:#555;
  }
</style>
<link rel="stylesheet" href="{{asset('plugins/bootstrap-toggle4/bootstrap-toggle4.min.css')}}?v={{ config('app.asset_version') }}">
@endpush

@section('navbar')
<!-- aqui va el menu de cada vista -->

  @include('content.front.navbar')
@endsection

@section('content')

  
           <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1>@yield('title')</h1>
          </div>
        
        </div>
      </div><!-- /.container-fluid -->
    </section>
<!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
     <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Caso {{session('session_case')->case_number}}: {{session('session_case')->type_branch_law->name}}</h3>

                <div class="card-tools">
                <!--
                  <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                   /.option -->
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">

            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">
                    Enviados</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">
                    Recibidos</a>
                  </li>              
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                    <input type="hidden" id="case_id" name="case_id" value="{{session('session_case')->id}}">
                  <div class="row">
                    <div class="col-md-3">

                    <button class="btn btn-primary btn-sm btn-block btnAddLogClientCase" data-type_log_id="22"  id="btnAddLogClientCase">
                      <i class="fa fa-newspaper"></i> 
                    Agregar documento</button>
                    <div class="progress" style="margin-top:2px;display:none" id="progress_bar">
                      <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">25%</div>
                    </div>

                    </div>
                  </div> 
<br>
                    <div class="row content_list_logs" id="content_list_doc_send">
                      @include('content.front.documents.ajax.index')
                    </div>


                  </div><!--TabPanel-->


                  <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                      <div class="row content_list_logs" id="content_list_doc_recived">
                      @foreach (session('session_case')->logs()
                      ->where('type_status_id','<>',15)->whereIn('type_log_id',[18,33])->where(
                          ['shared'=>1])->orderBy('created_at','desc')->get() as $log) 

                                @if($log->files()->first())
                                  <div class="col-lg-3 col-6 num_doc">
                                    <!-- small card -->
                                    <div class="small-box  {{ getBgColorDocument($log->files()->first()->original_name, count($log->files)) }}">
                                      <div class="inner bg-white">
                                        <h6 title="Nombre del archivo">@if(count($log->files)>1)
                                        {{ count($log->files) }} Archivos
                                        @else
                                        {{$log->files()->first()->original_name}}
                                        @endif
                                        </h6>
                                        <p>Tamaño: {{ getTotalSizeFiles($log->files) }} MB
                                        </p>
                                        <p>Subido: {{getDateForNotification($log->created_at)}}
                                        <br>               
                                        </p>
                                      </div>
                                      <div class="icon">
                                        <i class="{{ getBgIconDocument($log->files()->first()->original_name, count($log->files)) }}"></i>
                                      </div>
                                      <div class="row footer-small-box">
                                        <div class="col-md-12" align="center">
                                        @if(count($log->files()->where('type_status_id','!=','15')->get())>1)
                                            <input type="hidden" id="input_show_log_files-{{$log->id}}" value="{{json_encode($log->files)}}">

                                            <a target="_blank" href="#" data-id="{{$log->id}}" id="btn_show_log_files-{{$log->id}}" class="small-box-footer btn_show_log_files" >
                                                Descargar  <i class="fas fa-cloud-download-alt"></i>

                                            </a>
                                            @elseif(count($log->files()->where('type_status_id','!=','15')->get())>0)
                                              <a target="_blank" href="/oficina/descargar/documento/{{$log->files()->first()->id}}" class="small-box-footer" >
                                                Descargar  <i class="fas fa-cloud-download-alt"></i>
                                                </a>
                                            @else
                                            
                                            @endif                
                                        
                                        </div>
                                    {{--   <div class="col-md-4">                
                                        <a href="#" data-id="{{$log->id}}" class="btn_edit_log small-box-footer float-right" title="Editar...">
                                        <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" data-id="{{$log->id}}" class="btn_delete_log small-box-footer float-right" title="Eliminar...">
                                        <i class="fas fa-trash"></i>
                                        </a>
                                      </div> --}}
                                      </div>
                                    
                                    </div>
                                  </div>       
                                  <!-- ./col -->
                                  @endif
                        @endforeach
                    </div>                   
                  </div>
                 
                </div>
              </div>
              <!-- /.card -->
            </div>




                
 
             

                  

         
        
      
        <!-- /.row -->

              </div>
              <!-- /.card-body -->
        </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->

@include('content.front.documents.partials.modals.create_document')
@endsection

@push('scripts')
<!-- aqui van los scripts de cada vista -->
<script type="text/javascript" src="{{asset('plugins/bootstrap-toggle4/bootstrap-toggle4.min.js')}}?v={{ config('app.asset_version') }}"></script>

@endpush

