<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="style_css/bootstrap.min.css" rel="stylesheet">
  <script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="style_css/jquery.datetimepicker.css"/>
  <link rel="stylesheet" href="style_css/style.css">
  <script src="jscript/jquery.datetimepicker.js"></script>
  <script src="https://code.highcharts.com/stock/highstock.js"></script>
  <script src="https://code.highcharts.com/stock/modules/export-data.js"></script>
  <script src="https://code.highcharts.com/stock/modules/data.js"></script>
  <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
  <link rel="stylesheet" href="style_css/my_style.css">

  <title>My Test</title>
</head>
<body>

  <div class="container">
      <div class="table-responsive-sm">
        <table class="table table-bordered table-sm">
            <form method="post">
                <tr>
                    <th class="text-center lh-1">

                        <input
                            type="text"
                            autocomplete="off"
                            name="datetime_select"
                            id="datetimepicker_select"
                            value="<?php if(isset($_POST['datetime_select']) & !isset($_POST['reload'])){echo $_POST['datetime_select'];} else {echo date("Y-m-d H:i:s");} ?>"
                        />
                        <input
                            type="submit"
                            name="submit1"
                            id="btn-submit1"
                            value="Выбрать"
                        />
                        <input
                            type="submit"
                            name="reload"
                            id="btn-reload"
                            value="Обновить"
                        />

                        <input class="form-check-input" onclick="setobn(this)" name="radiobutton" type="radio" value="1000">1c
                        <input class="form-check-input" onclick="setobn(this)" name="radiobutton" type="radio" value="5000">5c
                        <input class="form-check-input" onclick="setobn(this)" name="radiobutton" type="radio" value="10000">10c
                        <input class="form-check-input" onclick="setobn(this)" name="radiobutton" type="radio" value="60000">60c
                    </th>
                </tr>
            </form>
        </table>
      </div>

        <form method="POST" action="index.php">
          <div class="row">
            <div class="input-group">
            <span class="input-group-text fs-5">Key and Value</span>
            <input type="text" aria-label="Key" class="form-control fs-4" name="key_txt">
            <input type="text" aria-label="Value" class="form-control fs-4" name="value_txt">
            <input type="submit" class="btn btn-secondary" value="Отправить">
            </div>
          </div>
        </form>

      <div id="block">
      <?php
            $txt = "./data/mydata.txt";
          if(isset($_POST['key_txt']) && isset($_POST['value_txt'])) {
                $data = $_POST['key_txt'] . ':' . $_POST['value_txt'] . "\r\n";
                $ret=fopen($txt,"a");
                if (flock($ret, LOCK_EX)) // установка исключительной блокировки на запись
                  {
                  fputs($ret,$data) or die("Ошибка записи"); // из массива в текст и записываем
                  flock($ret, LOCK_UN); // снятие блокировки
                  }
                  fclose($ret);
          }




           if(isset($_POST['datetime_select'])){ $find = $_POST['datetime_select'];
            $inv_log = fopen("./logs/inv_log", "r") or die("Unable to open file!");

                while(!feof($inv_log))
                 { $row = fgets($inv_log);

                    $pos = strpos($row, $find);

                    if ($pos === false) {
                       // echo "Строка '$find' не найдена";
                    } else {
                        // echo "Строка '$find' найдена<br>";
                        $myarr = explode("\t", $row);//создание массива из строки вхождения
                           }
                   }
            fclose($inv_log);
           }else{
            $lines = file("./logs/inv_log");
            $myarr = explode("\t", $lines[count($lines)-1]);
           }



           if(isset($_POST['datetime_select'])){ $find = $_POST['datetime_select'];
            $dcdc_log = fopen("./logs/dcdc_log", "r") or die("Unable to open file!");

                while(!feof($dcdc_log))
                 { $row = fgets($dcdc_log);

                    $pos = strpos($row, $find);

                    if ($pos === false) {
                       // echo "Строка '$find' не найдена";
                    } else {
                        // echo "Строка '$find' найдена<br>";
                        $dcdc_arr = explode("\t", $row);//создание массива из строки вхождения
                           }
                   }
            fclose($dcdc_log);
           }else{
            $lines = file("./logs/dcdc_log");
            $dcdc_arr = explode("\t", $lines[count($lines)-1]);
           }






            $vib1 = array(1, 6, 7, 8, 9, 2, 3, 10, 11, 12, 13, 54);//выборка полей данных для таблицы 1
            $array_tab1 = array();
            $i = 0;
            foreach ($vib1 as $value) {
                $array_tab1[$i] = $myarr[$value];//создание масива данных для таб1
                $i++;
            }

            $vib2 = array(15, 16, 17, 18, 22, 23, 24, 25, 26, 27, 21, 19, 35, 36, 37, 34, 54, 50);//выборка полей данных для таблицы 2
            $array_tab2 = array();
            $i = 0;
            foreach ($vib2 as $value) {
                $array_tab2[$i] = $myarr[$value];//создание масива данных для таб2
                $i++;
            }

             $vib3 = array(20, 28, 29, 30, 31, 32, 44, 51, 53);//выборка полей данных для таблицы 3
            $array_tab3 = array();
            $i = 0;
            foreach ($vib3 as $value) {
                $array_tab3[$i] = $myarr[$value];//создание масива данных для таб3
                $i++;
            }

             $vib4 = array(58, 59, 60, 61, 62);//выборка полей данных для таблицы 4
            $array_tab4 = array();
            $i = 0;
            foreach ($vib4 as $value) {
                $array_tab4[$i] = $myarr[$value];//создание масива данных для таб4
                $i++;
            }

             $vib5 = array(67, 68, 69);//выборка полей данных для таблицы 5
            $array_tab5 = array();
            $i = 0;
            foreach ($vib5 as $value) {
                $array_tab5[$i] = $myarr[$value];//создание масива данных для таб5
                $i++;
            }

             $vib6 = array(1,2,3,4,5,6,7,8,9,10,11,12,13);//выборка полей данных для таблицы 6
            $array_tab6 = array();
            $i = 0;
            foreach ($vib6 as $value) {
                $array_tab6[$i] = $dcdc_arr[$value];//создание масива данных для таб6
                $i++;
            }?>


          <!-- <p>Date time: <?php echo date("Y-m-d H:i:s"); ?> </p> -->

      <h4>Состояние инвертора</h4>
        <div class="table-responsive-sm">
          <table class="table table-bordered table-sm">
            <thead>
              <tr class="tb_tr">
                <th class="text-center lh-1 align-middle table-success tb_th_fs" scope="col">Инв.</th>
                <th class="text-center lh-1" scope="col">Сост. инв.</th>
                <th class="text-center lh-1" scope="col">Информ. сообщ.</th>
                <th class="text-center lh-1" scope="col">Предуп. инв.</th>
                <th class="text-center lh-1" scope="col">Ошибки. инв.</th>
                <th class="text-center lh-1" scope="col">Ошибки. инв. самоподтв.</th>
                <th class="text-center lh-1" scope="col">Информ. DC</th>
                <th class="text-center lh-1" scope="col">Предуп. DC</th>
                <th class="text-center lh-1" scope="col">Информ. AC</th>
                <th class="text-center lh-1" scope="col">Предуп. AC</th>
                <th class="text-center lh-1" scope="col">Ошибки. AC</th>
                <th class="text-center lh-1"scope="col">Ошибки. AC самоподтв.</th>
                <th class="text-center lh-1" scope="col">Статус связи</th>
              </tr>
            </thead>
            <tbody>
              <tr class="tb_td">
                <td class="text-center lh-1 table-success"></td>
                <?php
                      $arrey_div1 = array("in_st", "in_in", "in_wr", "in_fl", "in_fs", "dc_in", "dc_wr", "ac_in", "ac_wr", "ac_fl", "ac_fs", "st_st");
                        $i = 0;
                       foreach ($array_tab1 as $value) {?>

                      <td id = <?php echo $arrey_div1[$i]; ?> class = " text-center lh-1 "><div class="tb_tds"><?php echo $value; ?></div></td>
                <?php $i++; } ?>
              </tr>
            </tbody>
          </table>
        </div>

        <h4>Рабочие параметры инвертора</h4>
        <div class="table-responsive-sm">
          <table class="table table-bordered table-sm">
            <thead>
              <tr class="tb_tr">
                <th class="align-middle table-success text-center lh-1 tb_th_fs" scope="col" rowspan="2">Инв.</th>
                <th class="text-center lh-1" scope="col" colspan="4">Постоянный ток</th>
                <th class="text-center lh-1" scope="col" colspan="4">Инвертор</th>
                <th class="text-center lh-1" scope="col" colspan="2">Переменный ток</th>
                <th class="text-center lh-1" scope="col" colspan="2">Доп. данные</th>
              </tr>

              <tr class="tb_tr">
                <th class="text-center lh-1" scope="col" >U dc</th>
                <th class="text-center lh-1" scope="col" >I dc</th>
                <th class="text-center lh-1" scope="col" >P dc</th>
                <th class="text-center lh-1" scope="col" >R изол.</th>
                <th class="text-center lh-1" scope="col" >U inv <br> L1 L2 L3 </th>
                <th class="text-center lh-1" scope="col" >I inv <br> L1 L2 L3 </th>
                <th class="text-center lh-1" scope="col"  >F inv </th>
                <th class="text-center lh-1" scope="col"    >T в шкафу</th>
                <th class="text-center lh-1" scope="col" >U ac <br> L1 L2 L3 </th>
                <th class="text-center lh-1" scope="col"  >F ac </th>
                <th class="text-center lh-1" scope="col" >StartMode </th>
                <th class="text-center lh-1" scope="col" >InvOFF </th>
              </tr>
            </thead>

              <tr class="tb_td">
                <td  class="text-center table-success lh-1 tb_th_fs"></td>
                <td id = 'pv_v' class="text-center lh-1"><div class="tb_tds"><?php echo $array_tab2[0]; ?></div> </td>
                <td id = 'pv_i' class="text-center lh-1"><div class="tb_tds"><?php echo $array_tab2[1]; ?></div></td>
                <td id = 'pv_p' class="text-center lh-1"><div class="tb_tds"><?php echo $array_tab2[2]; ?></div></td>
                <td id = 'pv_r' class="text-center lh-1"><div class="tb_tds"><?php echo $array_tab2[3]; ?></div></td>
                <td id = 'in_v1' class="text-center lh-1"><div class="tb_tds"><?php echo $array_tab2[4].' '.$array_tab2[5].' '.$array_tab2[6]; ?></div></td>
                <td id = 'in_i1' class="text-center lh-1"><div class="tb_tds"><?php echo $array_tab2[7].' '.$array_tab2[8].' '.$array_tab2[9]; ?></div></td>
                <td id = 'in_f' class="text-center lh-1"><div class="tb_tds"><?php echo $array_tab2[10]; ?></div></td>
                <td id = 'in_t' class="text-center lh-1"><div class="tb_tds"><?php echo $array_tab2[11]; ?></div></td>
                <td id = 'ac_v1' class="text-center lh-1"><div class="tb_tds"><?php echo $array_tab2[12].' '.$array_tab2[13].' '.$array_tab2[14]; ?></div></td>
                <td id = 'ac_f' class="text-center lh-1"><div class="tb_tds"><?php echo $array_tab2[15]; ?></div></td>
                <td id = 'in_sm' class="text-center lh-1"><div class="tb_tds"><?php echo $array_tab2[16]; ?></div></td>
                <td id = 'in_of' class="text-center lh-1"><div class="tb_tds"><?php echo $array_tab2[17]; ?></div></td>
              </tr>

          </table>
        </div>

        <h4>Производительность инвертора</h4>
        <div class="table-responsive-sm">
          <table class="table table-bordered table-sm">
            <thead>
            <tr class="tb_tr">
                <th class="text-center align-middle table-success lh-1 tb_th_fs" scope="col" rowspan="2">Инв.</th>
                <th class="text-center lh-1" scope="col" colspan="4">Мощность</th>
                <th class="text-center lh-1" scope="col" colspan="2">Выработка</th>
                <th class="text-center lh-1" scope="col" colspan="3">Ограничения</th>
            </tr>
            <tr class="tb_tr">
                <th class="text-center lh-1" >cos(ф) </th>
                <th class="text-center lh-1" >S ac </th>
                <th class="text-center lh-1" >P ac </th>
                <th class="text-center lh-1" >Q ac </th>
                <th class="text-center lh-1" >W </th>
                <th class="text-center lh-1" >W all </th>
                <th class="text-center lh-1" >P lim </th>
                <th class="text-center lh-1" >Point lim </th>
                <th class="text-center lh-1" >cos(ф) lim </th>
            </tr>
            </thead>
            <tr class="tb_td">
                <td class="text-center table-success lh-1"></td>
                <?php
                $arrey_div1 = array("ac_cs", "ac_s", "ac_p", "ac_q", "w_d", "w_t", "in_lp", "in_lr",  "cs_sp");
                  $i = 0;
                 foreach ($array_tab3 as $value) {?>

                      <td id = <?php echo $arrey_div1[$i]; ?> class="text-center lh-1"><div class="tb_tds"> <?php echo $value; ?></div> </td>
                <?php $i++; } ?>

            </tr>

          </table>
        </div>

         <h4>Система заряда разряда батареи</h4>
        <div class="table-responsive-sm">
          <table class="table table-bordered table-sm">
            <thead>
              <tr class="tb_tr">
                <th class="text-center lh-1 align-middle table-success tb_th_fs" scope="col">Инв.</th>
                <th class="text-center lh-1" scope="col" >BMS Power ref</th>
                <th class="text-center lh-1" scope="col" >BMS U2  meas</th>
                <th class="text-center lh-1" scope="col" >BMS I2  meas</th>
                <th class="text-center lh-1" scope="col" >BMS E charge</th>
                <th class="text-center lh-1" scope="col" >BMS Status </th>
              </tr>
            </thead>

              <tr class="tb_td">
                <td  class="text-center table-success lh-1"></td>
                <?php
                      $arrey_div1 = array("b_ref", "u2_m", "i2_m", "e_ch", "b_st");
                        $i = 0;
                       foreach ($array_tab4 as $value) {?>

                      <td id = <?php echo $arrey_div1[$i]; ?> class = "text-center lh-1"><div class="tb_tds"> <?php echo $value; ?></div> </td>
                <?php $i++; } ?>
              </tr>

          </table>
        </div>

        <h4>Рабочие параметры Дизель Генератора</h4>
        <div class="table-responsive-sm">
          <table class="table table-bordered table-sm">
            <thead>
              <tr class="tb_tr">
                <th class="text-center lh-1 align-middle table-success tb_th_fs" scope="col">Инв.</th>
                <th class="text-center lh-1" scope="col" >Diesel ready </th>
                <th class="text-center lh-1" scope="col" >I diesel </th>
                <th class="text-center lh-1" scope="col" >P diesel</th>
              </tr>
            </thead>

              <tr class="tb_td">
                <td  class="text-center table-success lh-1"></td>
                <td id = 'bms_pr' class="text-center lh-1"><div class="tb_tds"><?php echo $array_tab5[0]; ?> </div></td>
                <td id = 'bms_u2m' class="text-center lh-1"><div class="tb_tds"><?php echo $array_tab5[1]; ?></div></td>
                <td id = 'bms_i2m' class="text-center lh-1"><div class="tb_tds"><?php echo $array_tab5[2]; ?></div></td>
              </tr>

          </table>
        </div>

        <h4>Рабочие параметры DC/DC преобразователя</h4>
        <div class="table-responsive-sm">
          <table class="table table-bordered table-sm">
            <thead>
              <tr class="tb_tr">
                <th class="text-center lh-1 align-middle table-success tb_th_fs" scope="col">Инв.</th>
                <th class="text-center lh-1" scope="col" >U dc2</th>
                <th class="text-center lh-1" scope="col" >U dc1</th>
                <th class="text-center lh-1" scope="col" >I dc2 L1</th>
                <th class="text-center lh-1" scope="col" >I dc2 L2</th>
                <th class="text-center lh-1" scope="col" >I dc2 L3</th>
                <th class="text-center lh-1" scope="col" >I dc2</th>
                <th class="text-center lh-1" scope="col" >T1</th>
                <th class="text-center lh-1" scope="col" >status</th>
                <th class="text-center lh-1" scope="col" >protect word</th>
                <th class="text-center lh-1" scope="col" >Idc2 max<br>charge</th>
                <th class="text-center lh-1" scope="col" >Idc2 max<br>discharge</th>
                <th class="text-center lh-1" scope="col" >Edc<br>charge</th>
                <th class="text-center lh-1" scope="col" >Edc<br>discharge</th>
              </tr>
            </thead>

              <tr class="tb_td">
                <td  class="text-center table-success lh-1"></td>
                <?php
                      $arrey_div1 = array("u_dc2", "u_dc1", "i_dc_l1", "i_dc_l2", "i_dc_l3", "i_dc2", "t1", "dc_st", "pr_w", "idc2_mc", "idc2_md", "edc_c", "edc_d");
                        $i = 0;
                       foreach ($array_tab6 as $value) {?>

                      <td id = <?php echo $arrey_div1[$i]; ?> class = "text-center lh-1"> <div class="tb_tds"><?php echo $value; ?></div> </td>
                <?php $i++; } ?>
              </tr>

          </table>
        </div>

       </div>
        <div id = "graf"></div>
      </div>


      <script>
        $('#datetimepicker_select').datetimepicker({
            lang:'ru',
            dayOfWeekStart: 1,
            step:1,
            format:'Y-m-d H:i:s'
        });
    </script>
    <script src="jscript/myscript.js"></script>
    <script src="jscript/bootstrap.bundle.min.js"></script>
</body>
</html>
