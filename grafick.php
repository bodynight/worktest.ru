

<!DOCTYPE html>
<html lang="en">

<head>
       <!--  <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script
        src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->


       <!--  <script src="https://code.highcharts.com/stock/highstock.js"></script>
        <script src="https://code.highcharts.com/stock/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/stock/modules/data.js"></script>
        <script src="https://code.highcharts.com/stock/modules/exporting.js"></script> -->

        <title>Chart</title>
</head>

<body>
    <?php
if(isset($_POST['id'])){$value_var = $_POST['id'];}//получаем переменную через ajax post

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
                        'st_st' => 54,
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
        $unixdata = (strtotime($value[0])) * 1000;
        if (strpos($value[$arr_as[$val]], '.') !== false) {
                $val_num = floatval($value[$arr_as[$val]]);
            } else {
                $val_num = intval($value[$arr_as[$val]]);
            }
        $f[] = array($unixdata, $val_num); }
  }
  return $f;}

  // $value_var = 'ac_v1';                                 //тестовое значение для отбора
$arr_test = create_arr_for_var($arrmain, $arr_assoc_var, $value_var);   // создание тестового массива для тестовой переменной отбора

// echo print_r($arr_test);
  echo "value id = ".$value_var."<br>";
 for ($i=0 ; $i < 10 ; $i++ ) {
   echo $arr_test[$i][0].' '.$arr_test[$i][1].'|';
 }


  ?>

    <div class="container">
        <div class="row">
            <div class="col">
                 <div id="container1" style="height: 400px; min-width: 310px"></div>
            </div>
        </div>
    </div>



<script>

    var name_title = <?php echo json_encode($value_var);?>;
    console.log(name_title);
    var data = <?php echo json_encode($arr_test);?>;
    console.log(data);

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
                width: 50
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



</script>

</body>
</html>
