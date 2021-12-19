<?php 

//получаем общий массив из строк по нужному логу
function get_arr($log){
    $inv_log = fopen($log, "r") or die("Unable to open file!");//открываем файл лога

    $ii = 0;
      while(!feof($inv_log)){

           $row = fgets($inv_log);//получение строки
           $arrmain[$ii] = explode("\t", $row);//создание массива из строки
           $ii++;
      }
    fclose($inv_log);
    $tmp = array_shift($arrmain);
    return $arrmain;
}
// определяем из какого лога делать массив и создаем массив
$arrmain = get_arr("./logs/inv_log");

//создание массива отобранных данных для нужной переменной из всего массива лог файла
function create_arr_for_var($arr, $arr_as, $val){     
  $f = array();
  foreach ($arr as  $value) {
    if (is_numeric($value[$arr_as[$val]])) {

            $unixdata = (strtotime($value[0])) * 1000;
            if (strpos($value[$arr_as[$val]], '.') !== false) {
                    $val_num = floatval($value[$arr_as[$val]]);
                } else {
                    $val_num = intval($value[$arr_as[$val]]);
                }
            $f[] = array($unixdata, $val_num);
    }
  }
  return $f;}
  // создание  массива для  переменной отбора
$arr_p_ac_10 = create_arr_for_var($arrmain, $arrAssoc, 'p_ac_10');
$arr_f_ac_10 = create_arr_for_var($arrmain, $arrAssoc, 'f_ac_10');
$get_num_val_f = $arrAssoc['f_ac_10'];//получаем номер выборки для массива по id
$get_num_val_p = $arrAssoc['p_ac_10'];

 ?>

 <script>

  var name_title = 'График работы ОПРЧ';
  console.log(name_title);
  var frequency = <?php echo json_encode($arr_f_ac_10);?>;
  var power = <?php echo json_encode($arr_p_ac_10);?>;
  var value_num_f = <?php echo json_encode($get_num_val_f) ?>;
  var value_num_p = <?php echo json_encode($get_num_val_p) ?>;
  
  // Create the chart
  $('#container').highcharts('StockChart',{
      // Highcharts.stockChart('container2', {
          chart: {
            events: {
            load: function () {
                // set up the updating of the chart each second
                var freq = this.series[0];
                var pow = this.series[1];
                var lines = 0;
                var lastline = 0;
                setInterval(function () {
                    function get_data(log, value_num, series){
                        $.get(log, function(data) {
                            // Split the lines
                             lines = data.split('\n');
                             //проверка последнего эл-та массива если "" удаляем эл-т
                            if (lines[lines.length-1] == "") {lines.pop();}
                                 lastline = lines[lines.length-1];
                                  var items = lastline.split('\t');
                                  var x = Date.parse(items[0]), //set first column from CSV as categorie
                                  y = Number(items[value_num]); //set second column from CSV as point value

                                  series.addPoint([x, y], true, true);
                        });
                      }
                    
                      get_data('./logs/inv_log', value_num_f, freq);
                      get_data('./logs/inv_log', value_num_p, pow);
                    
                }, 1000);
            }
          }
        },

    plotOptions: {
        series: {
           turboThreshold: 0,
            }
        },

    time: {
        useUTC: false
    },

    rangeSelector: {
         inputDateFormat: '%Y-%m-%d %H:%M:%S',
            inputEditDateFormat:'%Y-%m-%d %H:%M:%S',
            inputBoxWidth: 150,
            buttonTheme: {
                width: 30
            },
            buttons: [{
            count: 10,
            type: 'second',
            text: '10c'
            },{
            count: 20,
            type: 'second',
            text: '20c'
            },{
            count: 1,
            type: 'minute',
            text: '1M'
            },{
            count: 2,
            type: 'minute',
            text: '2M'
            },{
            count: 5,
            type: 'minute',
            text: '5M'
            },{
            count: 10,
            type: 'minute',
            text: '10M'
            },{
            count: 20,
            type: 'minute',
            text: '20M'
            }, {
            type: 'all',
            text: 'All'
            }],

            inputEnabled: true,
            selected: 7
    },

    title: {
        text: name_title
    },

    xAxis: {
                    type: 'datetime',
                    gridLineWidth: 2,
                },

     yAxis: [{
                        labels: {
                            align: 'right',
                            format: '{value: point.y:.2f}',
                            x: -3,
                            style: {
                                    color: Highcharts.getOptions().colors[0]
                                   }
                        },
                        title: {
                            text: 'Частота: Гц',
                            style: {
                                    color: Highcharts.getOptions().colors[0]
                                   }
                        },
                        lineWidth: 1,
                        opposite: false
                    }, {
                        labels: {
                            align: 'left',
                            format: '{value}',
                            x: 3
                        },
                        title: {
                            text: 'Мощность: кВт'
                        },
                        lineWidth: 1,
                    }],

    exporting: {
        enabled: true
    },

    series:[{
             name: 'Частота',
             data: frequency,
             tooltip: {
                      valueDecimals: 2,
                      valueSuffix: 'Гц'
                     },
             yAxis: 0        
            },
            {
             name: 'Мощность',
             data: power,
             tooltip: {
                      valueDecimals: 2,
                      valueSuffix: 'кВт'
                     },
             yAxis: 1         
            }]
  });
</script>
