

<!DOCTYPE html>
<html lang="en">

<head>
        <title>Chart</title>
</head>

<body>
    
    <?php

    if(isset($_POST['id'])){$value_var = $_POST['id'];}//получаем переменную через ajax post

    include 'dataAssociate.php';
    $arr_assoc_var = $arrAssoc;

   
$get_num_val = $arr_assoc_var[$value_var];//получаем номер выборки для массива по id
$get_num_val2 = $arr_assoc_var[$value_var];

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
if (is_string($get_num_val)){
    $get_num_val = intval($get_num_val);
    $arrmain = get_arr("./logs/dcdc_log");
} else {
        $arrmain = get_arr("./logs/inv_log");
}
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
$arr_test = create_arr_for_var($arrmain, $arr_assoc_var, $value_var);   // создание тестового массива для тестовой переменной отбора

  ?>

    <div class="container">
                <div class="row">
                    <div id="viewSelectWrap">
                        View Select:

                                <input class="form-check-input" id="rdb1" type="radio" name="toggler" value="divID-1" style="cursor:pointer;" checked/>
                                <label class="form-check-label" for="flexRadioDefault1">Static</label>


                                <input class="form-check-input" id="rdb2" type="radio" name="toggler" value="divID-2" style="cursor:pointer;" />
                                <label class="form-check-label" for="flexRadioDefault1">Dinamically</label>

                    </div>
                </div>
                </div>
                <div class="row">
                   <div class="col-sm-12 col-md-10 col-lg-8">
                    <div id="divID-1" class="toHide" style="position:relative;margin-bottom:-400px;"></div>
                    <div id="divID-2" class="toHide" style="position:relative;top:-9999em;opacity:0;"></div>
                   </div>
                   <div class="col-sm-12 col-md-2 col-lg-4"></div>
                </div>
    </div>



<script>

    var name_title = <?php echo json_encode($value_var);?>;
    console.log(name_title);
    var data = <?php echo json_encode($arr_test);?>;
    var value_num = <?php echo json_encode($get_num_val) ?>;
    var get_num_val2 = <?php echo json_encode($get_num_val2) ?>;
    $(function() {
    $('[name=toggler]').click(function () {
        $('.toHide').css({
            top: '-9999em',
            opacity: 0
        });
        var chartToShow = $(this).val();
        $('#' + chartToShow).css({
            top: 0,
            opacity: 1
        });
    });

    // Create the chart
    $('#divID-1').highcharts('StockChart',{
    // Highcharts.stockChart('container1', {

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
                width: 40
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
                text: "Charts for " + name_title
            },

            series: [{
            name: name_title,
            data: data,
            tooltip: {
                valueDecimals: 2
                     }
                }]
            });


        // Create the chart
        $('#divID-2').highcharts('StockChart',{
        // Highcharts.stockChart('container2', {
          chart: {
            events: {
            load: function () {
                // set up the updating of the chart each second
                var series = this.series[0];
                var lines = 0;
                var lastline = 0;
                setInterval(function () {
                    function get_data(log){
                        $.get(log, function(data) {
                            // Split the lines
                             lines = data.split('\n');
                             //проверка последнего эл-та массива если "" удаляем эл-т
                            if (lines[lines.length-1] == "") {lines.pop();}
                                 lastline = lines[lines.length-1];
                                var items = lastline.split('\t');
                                    // console.log('value_num = ' + value_num);
                                    // console.log('data = ' + items[0]);
                                    // console.log(Date.parse(items[0]));
                                    // console.log(Number(items[value_num]));
                                    var x = Date.parse(items[0]), //set first column from CSV as categorie
                                    y = Number(items[value_num]); //set second column from CSV as point value

                                series.addPoint([x, y], true, true);});
                        }
                    if (typeof get_num_val2 == "number") {
                        get_data('logs/inv_log');
                    } else {
                        get_data('logs/dcdc_log');
                    }
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
                width: 40
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
        text: "Dynamically updated data " + name_title
    },

    exporting: {
        enabled: true
    },

    series: [{
        name: name_title,
        data: data,
        tooltip: {
                valueDecimals: 2
                     }
    }]
});
});
</script>

</body>
</html>
