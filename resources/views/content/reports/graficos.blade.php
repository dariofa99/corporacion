@extends('layouts.dashboard')

@push('styles')
<!-- aqui van los estilos de cada vista -->

@endpush

@section('navbar')
<!-- aqui va el menu de cada vista -->
  @include('content.navbar')
@endsection

@section('content')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

 <!-- Main content -->
 <section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <div class="row">
              <div class="col-md-6">
                <h3 class="card-title">
                  <i class="fa fa-address-book"></i>
                  Reportes
                </h3>
              </div>        
            </div>

          </div>
          <div class="card-body p-3" >
           <div class="row">
            <div class="col-md-12">
   
              <div class="row">
                <div class="col-md-5">
                <label for="select_table">Tabla Principal</label>
                <select class="form-control form-control-sm  generate_graf" id="select_table" name="select_table">
                  <option value="" selected="selected">Seleccione...</option>
                  <option value="cases">Casos</option>                  
                </select>

                </div>
                <div class="col-md-1"><br>
                <label for="">Hab. Rango</label>
                <input type="checkbox" id="check_hab_rango" class="generate_graf">
                </div>
                <div class="col-md-5"> 
                <div class="row">
                  <div class="col-md-6">
                            <label for="fecha_ini">Fecha Inicial</label>
                    <input class="form-control form-control-sm generate_graf" id="fecha_ini" disabled="" name="fecha_ini" type="date" value="2021-01-07">
                  </div>
                  <div class="col-md-6">
                    <label for="fecha_fin">Fecha Final</label>
                    
                    <input class="form-control form-control-sm generate_graf" id="fecha_fin" disabled="" name="fecha_fin" type="date" value="2021-01-14">
                  </div>
                </div>  
                </div>


                </div>
                <div class="row">  
                <div class="col-md-5">  
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                    <label class="form-check-label" for="inlineRadio1">Torta</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                    <label class="form-check-label" for="inlineRadio2">Linea</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                    <label class="form-check-label" for="inlineRadio3">Columnas</label>
                  </div>
                </div>
                <div class="col-md-1">  
                <label for="">Cruzar</label><br>
                <input type="checkbox" id="check_hab_cruce" class="generate_graf" disabled="">
                </div> 
                <div class="col-md-5">  
                <label for="select_filter_table">Opciones de Filtro</label>                    
                <select class="form-control form-control-sm generate_graf" id="select_filter_table" name="select_filter_table">
                 
                </select>
                
                </div>

                </div> 
                <div class="row">  
                <div class="col-md-6">  
                  <select class="form-control form-control-sm generate_graf" id="select_option_table_cruce" style="display:none" name="select_option_table_cruce">
                    <option value="" selected="selected"></option>
                  </select>
                </div> 
                <div class="col-md-5">
                    <select class="form-control form-control-sm generate_graf" id="select_option_table_cruce" style="display:none" name="select_option_table_cruce">
                      <option value="" selected="selected"></option>
                    </select>
                </div> 
                </div>

         
</div>
           </div>

            <!-- THE CALENDAR -->
            <div class="row">
              <div class="col-md-12 ml-3" id="chartdiv" style="width: 100%;height:500px">
                
              </div> 
             

            </div>
           
            <!-- THE CALENDAR -->

          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>







 




@endsection

@push('scripts')
<!-- aqui van los scripts de cada vista -->
<!-- ChartJS --> 
<script src="{{asset('plugins/amcharts4/core.js')}}?v={{ config('app.asset_version') }}"></script>
<script src="{{asset('plugins/amcharts4/charts.js')}}?v={{ config('app.asset_version') }}"></script>
<script src="{{asset('plugins/amcharts4/themes/material.js')}}?v={{ config('app.asset_version') }}"></script>
<script src="{{asset('our/js/charts.js')}}?v={{ config('app.asset_version') }}"></script>






<!-- page script -->
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label               : 'Digital Goods',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [28, 48, 40, 19, 86, 27, 90]
        },
        {
          label               : 'Electronics',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [65, 59, 80, 81, 56, 55, 40]
        },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas, { 
      type: 'line',
      data: areaChartData, 
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = jQuery.extend(true, {}, areaChartOptions)
    var lineChartData = jQuery.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, { 
      type: 'line',
      data: lineChartData, 
      options: lineChartOptions
    })

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Chrome', 
          'IE',
          'FireFox', 
          'Safari', 
          'Opera', 
          'Navigator', 
      ],
      datasets: [
        {
          data: [700,500,400,600,300,100],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions      
    })

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions      
    })

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = jQuery.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    var barChart = new Chart(barChartCanvas, {
      type: 'bar', 
      data: barChartData,
      options: barChartOptions
    })

    //---------------------
    //- STACKED BAR CHART -
    //---------------------
    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
    var stackedBarChartData = jQuery.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

    var stackedBarChart = new Chart(stackedBarChartCanvas, {
      type: 'bar', 
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })
  })
</script>



@endpush

