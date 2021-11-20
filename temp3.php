<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/data.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>


<script src="jscript/jquery.js"></script>



<?php

// if(isset($_POST['id'])){$value_var = $_POST['id'];}//получаем переменную через ajax post

$inv_log = fopen("./logs/inv_log", "r") or die("Unable to open file!");//открываем файл лога
  $ii = 0;
  while(!feof($inv_log)){

       $row = fgets($inv_log);//получение строки
       $arrmain[$ii] = explode("\t", $row);//создание массива из строки
       $ii++;
  }
            fclose($inv_log);

$arr_assoc_var = array( 'in_st' => 1,//создание ассоц массива для выборки по названию параметра
                        'in_in' => 6,
                        'in_wr' => 7,
                        'in_fl' => 8,
                        'in_fs' => 9,
                        'dc_in' => 2,
                        'dc_wr' => 3,
                        'ac_in' => 10,
                        'ac_wr' => 11,
                        'ac_fl' => 12,
                        'ac_fs' => 13,
                        'ac_fs' => 54,
                        'pv_v' => 15,
                        'pv_i' => 16,
                        'pv_p' => 17,
                        'pv_r' => 18,
                        'in_v1' => 22,
                        'in_v2' => 23,
                        'in_v3' => 24,
                        'in_i1' => 25,
                        'in_i2' => 26,
                        'in_i3' => 27,
                        'in_f' => 21,
                        'in_t' => 19,
                        'ac_v1' => 35,
                        'ac_v2' => 36,
                        'ac_v3' => 37,
                        'ac_f' => 34,
                        'in_sm' => 54,
                        'in_of' => 50,
                        'ac_cs' => 20,
                        'ac_s' => 28,
                        'ac_p' => 29,
                        'ac_q' => 30,
                        'w_d' => 31,
                        'w_t' => 32,
                        'in_lp' => 44,
                        'in_lr' => 51,
                        'cs_sp' => 53,
                         );


function create_arr_for_var($arr, $arr_as, $val){     //создание массива отобранных данных для нужной переменной из всего массива лог файла
  $f = array();
  foreach ($arr as  $value) {
    if (is_numeric($value[$arr_as[$val]])) {
    $f[] = $value[$arr_as[$val]];}
  }
  return $f;
}

$value_var = 'ac_v1';                                 //тестовое значение для отбора
$arr_test = create_arr_for_var($arrmain, $arr_assoc_var, $value_var);   // создание тестового массива для тестовой переменной отбора

// echo print_r($arr_test);
  echo "value id = ".$value_var."<br>";
 for ($i=0 ; $i < 100 ; $i++ ) {
   echo $arr_test[$i].' ';
 }


 ?>


<div id="container" style="height: 400px; min-width: 310px"></div>

<script>

  var data = <?php echo json_encode($arr_test);?>;
  console.log(data);

    Highcharts.stockChart('container', {
        plotOptions: {
        series: {
           turboThreshold: 0,
        }
    },

        rangeSelector: {
            selected: 1
        },

        title: {
            text: 'AAPL Stock Price'
        },

        series: [{

            name: 'AAPL',
            data: data,
            tooltip: {
                valueDecimals: 2
            }
        }]
    });

</script>
