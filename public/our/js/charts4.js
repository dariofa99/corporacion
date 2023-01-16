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
    if($("#select_filter_cruce").val()==selected_option || $("#select_filter_cruce").val()==null){
      $("#select_filter_graphic option").each(function()
      {
        if($(this).val()!=selected_option){
          options += `<option value="${$(this).val()}">${$(this).text()}</option>`;
        }   
      });    
      $("#select_filter_cruce").html(options);
    }
 
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
      lineGraphic(res);
            console.log(res)         
      },
      error: function (xhr, textStatus, thrownError) {              
          alert("Hubo un error con el servidor ERROR::" + thrownError, textStatus);
      }
  });
}
//am4core.ready(function() {

  function pieGraphic(data_v) {
    //am4core.useTheme(am4themes_animated);

    var chart = am4core.create("chartdiv", am4charts.PieChart);
    chart.data = data_v;
      // Add data
      data = [ {
        "country": "Lithuania",
        "litres": 1002.9
      }, {
        "country": "Czechia",
        "litres": 301.9
      }, {
        "country": "Ireland",
        "litres": 201.1
      }, {
        "country": "Germany",
        "litres": 165.8
      }, {
        "country": "Australia",
        "litres": 139.9
      }, {
        "country": "Austria",
        "litres": 128.3
      }, {
        "country": "UK",
        "litres": 200
      }, {
        "country": "Belgium",
        "litres": 60
      }, {
        "country": "The Netherlands",
        "litres": 230
      } ];
      //console.log(chart.data)
      // Add and configure Series
      var pieSeries = chart.series.push(new am4charts.PieSeries());
      pieSeries.dataFields.value = "counter";
      pieSeries.dataFields.category = "label";
      pieSeries.slices.template.stroke = am4core.color("#fff");
      pieSeries.slices.template.strokeWidth = 2;
      pieSeries.slices.template.strokeOpacity = 1;
      
      // This creates initial animation
      pieSeries.hiddenState.properties.opacity = 1;
      pieSeries.hiddenState.properties.endAngle = -90;
      pieSeries.hiddenState.properties.startAngle = -90;
  
      chart.legend = new am4charts.Legend();
  }
//});


function lineGraphic(data_v) {
  // Create chart instance
      var chart = am4core.create("chartdiv", am4charts.XYChart);
      chart.data = data_v;
      data = [{
        "date": new Date(2018, 3, 20),
        "value": 90
      }, {
        "date": new Date(2018, 3, 21),
        "value": 102
      }, {
        "date": new Date(2018, 3, 22),
        "value": 65
      }, {
        "date": new Date(2018, 3, 23),
        "value": 62
      }, {
        "date": new Date(2018, 3, 24),
        "value": 55
      }, {
        "date": new Date(2018, 3, 25),
        "value": 81
      }];
      // Create axes
      var dateAxis = chart.xAxes.push(new am4charts.CategoryAxis());

      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

      // Create series
      var lineSeries = chart.series.push(new am4charts.LineSeries());
      console.log(lineSeries);
      lineSeries.dataFields.valueY = "value";
      lineSeries.dataFields.valueX = "category";
    //  lineSeries.name = "Estado";
      lineSeries.strokeWidth = 3;
      // Add simple bullet
      var bullet = lineSeries.bullets.push(new am4charts.Bullet());
      var image = bullet.createChild(am4core.Image);
      image.href = "https://www.amcharts.com/lib/images/star.svg";
      image.width = 30;
      image.height = 30;
      image.horizontalCenter = "middle";
      image.verticalCenter = "middle";

}

am4core.ready(function() {
 
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