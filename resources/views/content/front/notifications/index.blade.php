@extends('front.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->
@endpush

@section('navbar')
<!-- aqui va el menu de cada vista -->
 @include('content.front.navbar') 
@endsection

@section('content')

           <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">

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


<div class="row">

<div class="col-md-12">
 @foreach ($data as $key => $logs) 
 
            <!-- The time line -->
            <div class="timeline">
              <!-- timeline time label -->
              <div class="time-label">
                <span class="bg-red">{{getDateForNotification($key)}}</span>
              </div>
              <!-- /.timeline-label -->
              <!-- timeline item --> 

              @foreach ($logs as $key => $log) 
                <div>
                <i class="fa fa-info bg-blue"></i>
                <div class="timeline-item">
                  <span class="time"><i class="fas fa-clock"></i> {{$log->difforHumans}}</span>
                  <h3 class="timeline-header"><a href="#">{{$log->name}}: </a>
                  {{$log->description}}
                  </h3>
                {{-- 
                  <div class="timeline-body">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                    weebly ning heekya handango imeem plugg dopplr jibjab, movity
                    jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                    quora plaxo ideeli hulu weebly balihoo...
                  </div>
                  <div class="timeline-footer">
                    <a class="btn btn-primary btn-sm">Read more</a>
                    <a class="btn btn-danger btn-sm">Delete</a>
                  </div> --}}
                </div>
              </div>
              <!-- END timeline item -->
              @endforeach


           

            
             
           <!-- timeline time label -->
              {{-- <div class="time-label">
                <span class="bg-blue">13 Feb. 2014</span>
              </div> --}}
            <!-- /.timeline-label -->
        @endforeach    
        
              <div>
                <i class="fas fa-clock bg-gray"></i>
              </div>
            </div>
            <!-- The end time line -->


          </div>
          </div>



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

@endpush

