<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="style_css/style.css">
  <link rel="stylesheet" type="text/css" href="style_css/jquery.datetimepicker.css"/>
  <script src="jscript/jquery.datetimepicker.js"></script>

  <script src="https://code.highcharts.com/stock/highstock.js"></script>
        <script src="https://code.highcharts.com/stock/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/stock/modules/data.js"></script>
        <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>






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

                        <input onclick="setobn(this)" name="radiobutton" type="radio" value="1000">1c
                        <input onclick="setobn(this)" name="radiobutton" type="radio" value="5000">5c
                        <input onclick="setobn(this)" name="radiobutton" type="radio" value="10000">10c
                        <input onclick="setobn(this)" name="radiobutton" type="radio" value="60000">60c
                    </th>
                </tr>
            </form>
        </table>
      </div>


      <div id="block">
      <?php


           if(isset($_POST['datetime_select'])){ $find = $_POST['datetime_select'];
            $inv_log = fopen("./logs/inv_log", "r") or die("Unable to open file!");

                while(!feof($inv_log))
                 { $row = fgets($inv_log);

                    $pos = strpos($row, $find);

                    if ($pos === false) {
                       // echo "Строка '$find' не найдена";
                    } else {
                        echo "Строка '$find' найдена<br>";
                        $myarr = explode("\t", $row);//создание массива из строки вхождения
                           }
                   }
            fclose($inv_log);
           }else{
            $lines = file("./logs/inv_log");
            $myarr = explode("\t", $lines[count($lines)-1]);
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
            }?>


          <p>Date time: <?php echo date("Y-m-d H:i:s"); ?> </p>

      <h4>Состояние инвертора</h4>
        <div class="table-responsive-sm">
          <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <th class="text-center lh-1 align-middle table-success" scope="col">Инв.</th>
                <th class="text-center lh-1" scope="col">Состояние инвертора</th>
                <th class="text-center lh-1" scope="col">Информ. сообщения</th>
                <th class="text-center lh-1" scope="col">Предупрежд. инв.</th>
                <th class="text-center lh-1" scope="col">Ошибки. инв.</th>
                <th class="text-center lh-1" scope="col">Ошибки. инв. самоподтв.</th>
                <th class="text-center lh-1" scope="col">Информ. DC</th>
                <th class="text-center lh-1" scope="col">Предупрежд. DC</th>
                <th class="text-center lh-1" scope="col">Информ. AC</th>
                <th class="text-center lh-1" scope="col">Предупрежд. AC</th>
                <th class="text-center lh-1" scope="col">Ошибки. AC</th>
                <th class="text-center lh-1"scope="col">Ошибки. AC самоподтв.</th>
                <th class="text-center lh-1" scope="col">Статус связи</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-center lh-1 table-success">39.1</td>
                <?php
                      $arrey_div1 = array("in_st", "in_in", "in_wr", "in_fl", "in_fs", "dc_in", "dc_wr", "ac_in", "ac_wr", "ac_fl", "ac_fs", "st_st");
                        $i = 0;
                       foreach ($array_tab1 as $value) {?>

                      <td id = <?php echo $arrey_div1[$i]; ?> class = "text-center lh-1"> <?php echo $value; ?> </td>
                <?php $i++; } ?>
              </tr>
            </tbody>
          </table>
        </div>

        <h4>Рабочие параметры инвертора</h4>
        <div class="table-responsive-sm">
          <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <th class="align-middle table-success text-center lh-1 " scope="col" rowspan="2">Инв.</th>
                <th class="text-center lh-1" scope="col" colspan="4">Постоянный ток</th>
                <th class="text-center lh-1" scope="col" colspan="4">Инвертор</th>
                <th class="text-center lh-1" scope="col" colspan="2">Переменный ток</th>
                <th class="text-center lh-1" scope="col" colspan="2">Доп. данные</th>
              </tr>

              <tr>
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

              <tr>
                <td  class="text-center table-success lh-1">39.1</td>
                <td id = 'pv_v' class="text-center lh-1"><?php echo $array_tab2[0]; ?> </td>
                <td id = 'pv_i' class="text-center lh-1"><?php echo $array_tab2[1]; ?></td>
                <td id = 'pv_p' class="text-center lh-1"><?php echo $array_tab2[2]; ?></td>
                <td id = 'pv_r' class="text-center lh-1"><?php echo $array_tab2[3]; ?></td>
                <td id = 'in_v1' class="text-center lh-1"><?php echo $array_tab2[4].' '.$array_tab2[5].' '.$array_tab2[6]; ?></td>
                <td id = 'in_i1' class="text-center lh-1"><?php echo $array_tab2[7].' '.$array_tab2[8].' '.$array_tab2[9]; ?></td>
                <td id = 'in_f' class="text-center lh-1"><?php echo $array_tab2[10]; ?></td>
                <td id = 'in_t' class="text-center lh-1"><?php echo $array_tab2[11]; ?></td>
                <td id = 'ac_v1' class="text-center lh-1"><?php echo $array_tab2[12].' '.$array_tab2[13].' '.$array_tab2[14]; ?></td>
                <td id = 'ac_f' class="text-center lh-1"><?php echo $array_tab2[15]; ?></td>
                <td id = 'in_sm' class="text-center lh-1"><?php echo $array_tab2[16]; ?></td>
                <td id = 'in_of' class="text-center lh-1"><?php echo $array_tab2[17]; ?></td>
              </tr>

          </table>
        </div>

        <h4>Производительность инвертора</h4>
        <div class="table-responsive-sm">
          <table class="table table-bordered table-sm">
            <thead>
            <tr>
                <th class="text-center align-middle table-success lh-1" scope="col" rowspan="2">Инв.</th>
                <th class="text-center lh-1" scope="col" colspan="4">Мощность</th>
                <th class="text-center lh-1" scope="col" colspan="2">Выработка</th>
                <th class="text-center lh-1" scope="col" colspan="3">Ограничения</th>
            </tr>
            <tr>
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
            <tr>
                <td class="text-center table-success lh-1">39.1</td>
                <?php
                $arrey_div1 = array("ac_cs", "ac_s", "ac_p", "ac_q", "w_d", "w_t", "in_lp", "in_lr",  "cs_sp");
                  $i = 0;
                 foreach ($array_tab3 as $value) {?>

                      <td id = <?php echo $arrey_div1[$i]; ?> class="text-center lh-1"> <?php echo $value; ?> </td>
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
</body>
</html>
