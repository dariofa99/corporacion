 options = {
    'cases':[
        {
            'value':'Rama del derecho',
            'option_value':'rama_derecho'
        },
        {
            'value':'Estado',
            'option_value':'estado'
        },
        { 
            'value':'Tipo Procedimiento',
            'option_value':'tipo_procedimiento'
        },
        {
            'value':'Tipo de Documento',
            'option_value':'tipo_doc',
            'option_id':'tipodoc_id', 
            'table':'users'       
        },
        {
            'value':'Género',
            'option_value':'genero',
            'option_id':'genero_id',
            'table':'users'   
        },
        {
            'value':'Departamento',
            'option_value':'departamento',
            'option_id':'expdepto_id',
            'table':'expedientes'   
        },
        {
          'value':'Municipio',
          'option_value':'municipio',
          'option_id':'expmunicipio_id',
          'table':'expedientes'   
        },
        {
          'value':'Tipo de Vivienda',
          'option_value':'tipo_vivienda',
            'option_id':'exptipovivien_id',
            'table':'expedientes'   
        },
        {
          'value':'Estrato',
          'option_value':'estrato',
            'option_id':'estrato_id',
            'table':'users'   
        },
        {
          'value':'Estado Civil',
          'option_value':'estado_civil',
          'option_id':'estadocivil_id',
          'table':'users'   
        }
        
    ],
    'actuaciones':[
        {
            'value':'Estado',
            'option_value':'estado_act'
        }
    ],
    'requerimientos':[
        {
            'value':'Estado',
            'option_value':'estado_req'
        }
    ]
};

var filter_label;
var options_cruce_label;

function setFilter(value){
    var options_v = "";
    console.log(options[value])
     options[value].forEach(element => {
       options_v += `<option>${element.value} </option>`;
    }); 
    $("#select_filter_table").html(options_v);
}
function setFilterCruce(selected_option) {
  var options = '';
    //if($("#select_filter_cruce").val()==selected_option || $("#select_filter_cruce").val()==null){
      $("#select_filter_graphic option").each(function()
      {
        if($(this).val()!=selected_option){
          options += `<option value="${$(this).val()}">${$(this).text()}</option>`;
        }   
      });    
      $("#select_filter_cruce").html(options);
  //  }
 
}

function getGData(request) {
  $.ajax({
      url: '/reportes/get/graphics/data',
      type: 'POST',
      datatype: 'json',
      data: request,
      cache: false,
      beforeSend: function (xhr) {
          xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
          $("#wait").show();
          
      },
      success: function (res) {
      $("#wait").hide();
      setChart(res)
            console.log(res)         
      },
      error: function (xhr, textStatus, thrownError) {              
          alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
      }
  });
}
function setChart(data) {
  var radio = $('input[name=type_graphic]:checked', '#myFormGenerateRG').val();
  $("#inlineRadio1").prop("disabled",false);
  filter_label =  $("#select_filter_graphic option:selected").text();
  options_cruce_label = $("#select_filter_cruce option:selected").text();
 
  if($("#check_hab_cruce").is(":checked") && radio=='pie'){
    $("#inlineRadio1").prop("disabled",true);
    $("#inlineRadio2").prop("checked",true);
    multi_line_chart(data)
  }else if($("#check_hab_cruce").is(":checked") && radio=='linea'){  
    $("#inlineRadio1").prop("disabled",true); 
    multi_line_chart(data)
  }else if($("#check_hab_cruce").is(":checked") && radio=='column'){   
    $("#inlineRadio1").prop("disabled",true);
    multi_column_chart(data);
  }else{
    if(radio=='pie'){
      pieGraphic(data)
    }
    if(radio=='linea'){    
        lineGraphic(data)   
      
    }
    if(radio=='column'){
      column_chart(data)
    }
  }
  
}

//am4core.ready(function() {


  function pieGraphic(data_v) {
    chart = new AmCharts.AmPieChart();

                // title of the chart
                chart.addTitle(filter_label, 16);

                chart.dataProvider = data_v;
                chart.titleField = "category";
                chart.valueField = "value";
                chart.sequencedAnimation = true;
                chart.startEffect = "elastic";
                chart.innerRadius = "30%";
                chart.startDuration = 2;
                chart.labelRadius = 15;
                chart.balloonText = "[[category]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
                // the following two lines makes the chart 3D
               // chart.depth3D = 10;
               // chart.angle = 15;

                var legend = new AmCharts.AmLegend();
                legend.markerBorderColor = "#000000";
                legend.switchType = undefined;
                legend.align = "left";
                chart.addLegend(legend);
                chart.write("chartdiv");

    
  }
//});

function column_chart(data_v){
  // SERIAL CHART
        chart = new AmCharts.AmSerialChart();
        chart.dataProvider = data_v;
        chart.categoryField = "category";
        chart.startDuration = 1;

        // AXES
        // category
        var categoryAxis = chart.categoryAxis;
        categoryAxis.labelRotation = 90; // this line makes category values to be rotated
        categoryAxis.gridAlpha = 0;
        categoryAxis.fillAlpha = 1;
        categoryAxis.fillColor = "#FAFAFA";
        categoryAxis.gridPosition = "start";

        // value
        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.dashLength = 5;
        valueAxis.title = filter_label;
        valueAxis.axisAlpha = 0;
        chart.addValueAxis(valueAxis);

        // GRAPH
        var graph = new AmCharts.AmGraph();
        graph.valueField = "value";
        graph.title = 'value';
        graph.balloonText = "<b>[[category]]: [[value]]</b>";
        graph.type = "column";
        graph.lineAlpha = 1;
       // graph.fillColorsField = 'color';
        graph.colorField = "color";
        graph.fillAlphas = 1;
        //graph.bullet = "round";
        graph.labelText = "[[value]]";
         
        chart.addGraph(graph);

      

        

        // CURSOR
        var chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorAlpha = 0;
        chartCursor.zoomable = true;
        chartCursor.categoryBalloonEnabled = false;
        chart.addChartCursor(chartCursor);

        chart.creditsPosition = "bottom-left";

        // LEGEND
        var legend = new AmCharts.AmLegend();
        legend.useGraphSettings = true;
        chart.addLegend(legend);

        // WRITE
        chart.write("chartdiv");

         
}

function lineGraphic(data_v) {
  // Create chart instance
  chart = new AmCharts.AmSerialChart();
  chart.dataProvider = data_v;
  chart.categoryField = "category";
  chart.startDuration = 1;

  // AXES
  // category
  var categoryAxis = chart.categoryAxis;
  categoryAxis.labelRotation = 90; // this line makes category values to be rotated
  categoryAxis.gridAlpha = 0;
  categoryAxis.fillAlpha = 1;
  categoryAxis.fillColor = "#FAFAFA";
  categoryAxis.gridPosition = "start";

  // value
  var valueAxis = new AmCharts.ValueAxis();
  valueAxis.dashLength = 5;
  valueAxis.title = filter_label;
  valueAxis.axisAlpha = 0;
  chart.addValueAxis(valueAxis);

  // GRAPH
  var graph = new AmCharts.AmGraph();
  graph.valueField = "value";
  graph.title = 'value';
  graph.balloonText = "<b>[[category]]: [[value]]</b>";
  //graph.type = "column";
  graph.lineAlpha = 1;
  graph.colorField = "color";
  graph.fillColorsField = 'color';
  graph.fillAlphas = 0;
  graph.bullet = "round";
  graph.labelText = " ";
   
  chart.addGraph(graph);



  

  // CURSOR
  var chartCursor = new AmCharts.ChartCursor();
  chartCursor.cursorAlpha = 0;
  chartCursor.zoomable = true;
  chartCursor.categoryBalloonEnabled = false;
  chart.addChartCursor(chartCursor);

  chart.creditsPosition = "top-left";

  // LEGEND
  var legend = new AmCharts.AmLegend();
  legend.useGraphSettings = true;
  chart.addLegend(legend);

  // WRITE
  chart.write("chartdiv");

}


function multi_line_chart(res){
  // SERIAL CHART
              chart = new AmCharts.AmSerialChart();
              chart.dataProvider = res.data;
              chart.categoryField = "encabezado";
              chart.startDuration = 1;

              // AXES
              // category
              var categoryAxis = chart.categoryAxis;
              categoryAxis.labelRotation = 90; // this line makes category values to be rotated
              categoryAxis.gridAlpha = 0;
              categoryAxis.fillAlpha = 1;
              categoryAxis.fillColor = "#FAFAFA";
              categoryAxis.gridPosition = "start";

              // value
              var valueAxis = new AmCharts.ValueAxis();
              valueAxis.dashLength = 5;
              valueAxis.title = filter_label+' - '+options_cruce_label;
              valueAxis.axisAlpha = 0;
              chart.addValueAxis(valueAxis);

              // GRAPH
              for (var i = res.graph.length - 1; i >= 0; i--) {
                  var graph = new AmCharts.AmGraph();
                  graph.valueField = res.graph[i].value_graph;
                  graph.title = res.graph[i].value_graph;
                  graph.balloonText = "<b>[[category]]: "+res.graph[i].value_graph+": [[value]] ";
                  //graph.type = "column";
                  graph.lineAlpha = 1;
                  //graph.fillColorsField = 'color';
                  graph.fillAlphas = 0;
                  graph.bullet = "round";
                  graph.labelText = " ";
                   
                  chart.addGraph(graph);
              }
              

            

              

              // CURSOR
              var chartCursor = new AmCharts.ChartCursor();
              chartCursor.cursorAlpha = 0;
              chartCursor.zoomable = true;
              chartCursor.categoryBalloonEnabled = false;
              chart.addChartCursor(chartCursor);

              chart.creditsPosition = "top-left";

              // LEGEND
              var legend = new AmCharts.AmLegend();
              legend.useGraphSettings = true;
              chart.addLegend(legend);

              // WRITE
              chart.write("chartdiv");

              
}
function multi_column_chart(res){
  // SERIAL CHART
        chart = new AmCharts.AmSerialChart();
        chart.dataProvider = res.data;
        chart.categoryField = "encabezado";
        chart.startDuration = 1;

        // AXES
        // category
        var categoryAxis = chart.categoryAxis;
        categoryAxis.labelRotation = 90; // this line makes category values to be rotated
        categoryAxis.gridAlpha = 0;
        categoryAxis.fillAlpha = 1;
        categoryAxis.fillColor = "#FAFAFA";
        categoryAxis.gridPosition = "start";

        // value
        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.dashLength = 5;
        valueAxis.title = filter_label+' - '+options_cruce_label;;
        valueAxis.axisAlpha = 0;
        chart.addValueAxis(valueAxis);

        // GRAPH
         for (var i = res.graph.length - 1; i >= 0; i--) {
            var graph = new AmCharts.AmGraph();
            graph.valueField = res.graph[i].value_graph;
            graph.title = res.graph[i].value_graph;
            graph.balloonText = "<b>[[category]]: "+res.graph[i].value_graph+": [[value]] ";
            graph.type = "column";
            graph.lineAlpha = 1;
            //graph.fillColorsField = 'color';
            graph.fillAlphas = 1;
            //graph.bullet = "round";
            graph.labelText = " ";
             
            chart.addGraph(graph);
        }

      

        

        // CURSOR
        var chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorAlpha = 0;
        chartCursor.zoomable = true;
        chartCursor.categoryBalloonEnabled = false;
        chart.addChartCursor(chartCursor);

        chart.creditsPosition = "bottom-left";

        // LEGEND
        var legend = new AmCharts.AmLegend();
        legend.useGraphSettings = true;
        chart.addLegend(legend);

        // WRITE
        chart.write("chartdiv");

        
}

AmCharts.ready(function() {
 
    $("#select_filter_graphic").on("change",function(e){
      if($("#check_hab_cruce").is(":checked")){     
        var selected_option = $(this).val();
        setFilterCruce(selected_option)
      }
    });

    $("#check_hab_cruce").on("change",function(e) {
      if($(this).is(":checked")){ 
        $("#select_filter_cruce").prop("disabled",false);
        var selected_option = $("#select_filter_graphic").val();
        setFilterCruce(selected_option)
      }else{
        $("#select_filter_cruce").prop("disabled",true);
      }
    });

    $("#check_hab_rango_graphics").on("change",function (e) {
      if($(this).is(":checked")){
          $("#myFormGenerateRG input[name=fecha_ini]").prop("disabled",false);
          $("#myFormGenerateRG input[name=fecha_fin]").prop("disabled",false);            
      }else{
        $("#myFormGenerateRG input[name=fecha_ini]").prop("disabled",true);
        $("#myFormGenerateRG input[name=fecha_fin]").prop("disabled",true);        
      }
  });

  $(".generate_graf").on("change",function(e) {
    var request = $("#myFormGenerateRG").serialize();
    getGData(request)
  });

    
});