

<!DOCTYPE html>
<html lang="en">

<head>
        <title>Chart</title>
</head>

<body>
    <?php

    if(isset($_POST['id'])){$value_var = $_POST['id'];}//получаем переменную через ajax post

    //создание ассоц массива для выборки по названию параметра то что в "value" для dcdc_log
    $arr_assoc_var = array( 'in_st' => 1,'in_in' => 6,'in_wr' => 7,'in_fl' => 8,'in_fs' => 9,'dc_in' => 2,'dc_wr' => 3,'ac_in' => 10,'ac_wr' => 11,
                            'ac_fl' => 12,'ac_fs' => 13,'st_st' => 54,'pv_v' => 15,'pv_i' => 16,'pv_p' => 17,'pv_r' => 18,'in_v1' => 22,'in_v2' => 23,
                            'in_v3' => 24,'in_i1' => 25,'in_i2' => 26,'in_i3' => 27,'in_f' => 21,'in_t' => 19,'ac_v1' => 35,'ac_v2' => 36,'ac_v3' => 37,
                            'ac_f' => 34,'in_sm' => 54,'in_of' => 50,'ac_cs' => 20,'ac_s' => 28,'ac_p' => 29,'ac_q' => 30,'w_d' => 31,'w_t' => 32,
                            'in_lp' => 44,'in_lr' => 51,'cs_sp' => 53,'bms_pr' => 67,'bms_u2m' => 68,'bms_i2m' => 69,'b_ref' => 58,'u2_m' => 59,'i2_m' => 60,
                            'e_ch' => 61 ,'b_st' => 62,'u_dc2' => "1",'u_dc1' => "2",'i_dc_l1' => "3",'i_dc_l2' => "4",'i_dc_l3' => "5",'i_dc2' => "6",'t1' => "7",
                            'dc_st' => "8",'pr_w' => "9",'idc2_mc' => "10",'idc2_md' => "11",'edc_c' => "12",'edc_d' => "13"
                             );

$get_num_val = $arr_assoc_var[$value_var];
$get_num_val2 = $arr_assoc_var[$value_var];


function get_arr($log){
    $inv_log = fopen($log, "r") or die("Unable to open file!");//открываем файл лога

    $ii = 0;
      while(!feof($inv_log)){

           $row = fgets($inv_log);//получение строки
           $arrmain[$ii] = explode("\t", $row);//создание массива из строки
           $ii++;
      }
    fclose($inv_log);
    return $arrmain;
}

if (is_string($get_num_val)){
    $get_num_val = intval($get_num_val);
    $arrmain = get_arr("./logs/dcdc_log");
} else {
        $arrmain = get_arr("./logs/inv_log");
}

function create_arr_for_var($arr, $arr_as, $val){     //создание массива отобранных данных для нужной переменной из всего массива лог файла
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
                    <h4>View Select</h4>
                    <label><input id="rdb1" type="radio" name="toggler" value="divID-1" style="cursor:pointer;" checked/>1</label>
                    <label><input id="rdb2" type="radio" name="toggler" value="divID-2" style="cursor:pointer;" />2</label>
                </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                 <div id="container1" style="height: 400px; min-width: 310px"></div>
            </div>
            <div class="col-sm-6">
                 <div id="container2" style="height: 400px; min-width: 310px"></div>
            </div>
        </div>
    </div>



<script>

    var name_title = <?php echo json_encode($value_var);?>;
    console.log(name_title);
    var data = <?php echo json_encode($arr_test);?>;
    var value_num = <?php echo json_encode($get_num_val) ?>;
    var get_num_val2 = <?php echo json_encode($get_num_val2) ?>;


    // Create the chart
    Highcharts.stockChart('container1', {

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
Highcharts.stockChart('container2', {
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


</script>

</body>
</html>
