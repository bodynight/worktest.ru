<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="style_css/bootstrap.min.css" rel="stylesheet">
  <script src="jscript/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" type="text/css" href="style_css/jquery.datetimepicker.css"/>
  <link rel="stylesheet" href="style_css/style.css">
  <script src="jscript/jquery.datetimepicker.js"></script>
  <script src="jscript/highchart/highstock.js"></script>
  <script src="jscript/highchart/export-data.js"></script>
  <script src="jscript/highchart/data.js"></script>
  <script src="jscript/highchart/exporting.js"></script>
  <script src="jscript/highchart/boost.js"></script>
  <link rel="stylesheet" href="style_css/my_style.css">

  <title>My Test</title>
</head>
<body>
   <?php require 'db.php'; ?>

  <div class="container">
      <?php require "navbar.php"; ?>
      <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-8">
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
                            type="button"
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

                        <input class="form-check-input ci" onclick="setobn(this)" name="radiobutton" type="radio" value="1000">1c
                        <input class="form-check-input ci" onclick="setobn(this)" name="radiobutton" type="radio" value="5000">5c
                        <input class="form-check-input ci" onclick="setobn(this)" name="radiobutton" type="radio" value="10000">10c
                        <input class="form-check-input ci" onclick="setobn(this)" name="radiobutton" type="radio" value="60000">60c
                        <input id="radio_off" class="form-check-input ci" onclick="setobn(this)" name="radiobutton" type="radio" value="0" checked>Off
                    </th>
                </tr>
            </form>
        </table>
      </div>
      </div>
    </div>

    <div id='error_mes'></div>

   <div class="row">
    <div class="col-sm-12 col-md-10 col-lg-8">
      <div id="inv_state"><h4>Состояние инвертора: </h4></div>
        <div class="table-responsive-sm">
          <table class="table table-bordered table-sm">
            <thead>
              <tr class="tb_tr">
                <th class="text-center lh-1" scope="col">Сост. инв.</th>
                <!-- <th class="text-center lh-1" scope="col">Информ. сообщ.</th> -->
                <th class="text-center lh-1" scope="col">Предуп. инв.</th>
                <!-- <th class="text-center lh-1" scope="col">Ошибки. инв.</th> -->
                <th class="text-center lh-1" scope="col">Ошибки. инв. самоподтв.</th>
                <!-- <th class="text-center lh-1" scope="col">Информ. DC</th> -->
                <th class="text-center lh-1" scope="col">Предуп. DC</th>
                <th class="text-center lh-1" scope="col">Информ. AC</th>
                <th class="text-center lh-1" scope="col">Предуп. AC</th>
                <!-- <th class="text-center lh-1" scope="col">Ошибки. AC</th> -->
                <th class="text-center lh-1"scope="col">Ошибки. AC самоподтв.</th>
                <!-- <th class="text-center lh-1" scope="col">Статус связи</th> -->
              </tr>
            </thead>
            <tbody>
              <tr class="tb_td">
                <?php
                      $arrey_div1 = array("in_st", "in_wr", "in_fs", "dc_wr", "ac_in", "ac_wr", "ac_fs");
                       foreach ($arrey_div1 as $value) {?>
                      <td id = <?php echo $value; ?> class = " text-center lh-1 "><div class="tb_tds"></div></td>
                <?php  } ?>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="col-sm-12 col-md-10 col-lg-8">
        <h4>Рабочие параметры инвертора</h4>
        <div class="table-responsive-sm">
          <table class="table table-bordered table-sm">
            <thead>
              <tr class="tb_tr">
                <th class="text-center lh-1" scope="col" colspan="4">Постоянный ток</th>
                <th class="text-center lh-1" scope="col" colspan="8">Инвертор</th>
                <th class="text-center lh-1" scope="col" colspan="4">Переменный ток</th>
                <th class="text-center lh-1" scope="col" colspan="2">Доп. данные</th>
              </tr>
              <tr class="tb_tr">
                <th class="text-center lh-1" scope="col" >U dc</th>
                <th class="text-center lh-1" scope="col" >I dc</th>
                <th class="text-center lh-1" scope="col" >P dc</th>
                <th class="text-center lh-1" scope="col" >R изол.</th>
                <th class="text-center lh-1 graf3" id="in_v" scope="col" colspan="3">U inv <br> L1 L2 L3 </th>
                <th class="text-center lh-1 graf3" id="in_i" scope="col" colspan="3">I inv <br> L1 L2 L3 </th>
                <th class="text-center lh-1" scope="col"  >F inv </th>
                <th class="text-center lh-1" scope="col"    >T в шкафу</th>
                <th class="text-center lh-1 graf3" id="ac_v" scope="col" colspan="3" >U ac <br> L1 L2 L3 </th>
                <th class="text-center lh-1" scope="col"  >F ac </th>
                <th class="text-center lh-1" scope="col" >StartMode </th>
                <th class="text-center lh-1" scope="col" >InvOFF </th>
              </tr>
            </thead>
              <tr class="tb_td">
                <?php
                      $arrey_div1 = array("pv_v", "pv_i", "pv_p", "pv_r", "in_v1", "in_v2", "in_v3", "in_i1", "in_i2", "in_i3", "in_f", "in_t", "ac_v1", "ac_v2", "ac_v3", "ac_f", "in_sm", "in_of");
                       foreach ($arrey_div1 as $value) {?>
                      <td id = <?php echo $value; ?> class = " text-center lh-1 "><div class="tb_tds"></div></td>
                <?php  } ?>
             </tr>
          </table>
        </div>
      </div>

      <div class="col-sm-12 col-md-10 col-lg-8">
        <h4>Производительность инвертора</h4>
        <div class="table-responsive-sm">
          <table class="table table-bordered table-sm">
            <thead>
            <tr class="tb_tr">
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
                <?php
                $arrey_div1 = array("ac_cs", "ac_s", "ac_p", "ac_q", "w_d", "w_t", "in_lp", "in_lr",  "cs_sp");
                 foreach ($arrey_div1 as $value) {?>
                      <td id = <?php echo $value; ?> class="text-center lh-1"><div class="tb_tds"></div> </td>
                <?php  } ?>
            </tr>
          </table>
        </div>
      </div>

      <div class="col-sm-12 col-md-2 col-lg-2"></div>
      <div class="col-sm-12 col-md-5 col-lg-4">
         <h4>Система заряда разряда батареи</h4>
         <div id="status_bms"><h5></h5></div>
        <div class="table-responsive-sm">
          <table class="table table-bordered table-sm">
            <thead>
              <tr class="tb_tr">
                <th class="text-center lh-1" scope="col" >BMS Power ref</th>
                <th class="text-center lh-1" scope="col" >BMS U2  meas</th>
                <th class="text-center lh-1" scope="col" >BMS I2  meas</th>
                <th class="text-center lh-1" scope="col" >BMS E charge</th>
                <th class="text-center lh-1" scope="col" >BMS Status </th>
              </tr>
            </thead>
              <tr class="tb_td">
                <?php
                      $arrey_div1 = array("b_ref", "u2_m", "i2_m", "e_ch", "b_st");
                       foreach ($arrey_div1 as $value) {?>
                      <td id = <?php echo $value; ?> class = "text-center lh-1"><div class="tb_tds"></div> </td>
                <?php } ?>
              </tr>
          </table>
        </div>
      </div>

      <div class="col-sm-12 col-md-5 col-lg-4">
        <h4>Рабочие параметры ДГ</h4>
        <h5>(с анализатора кач-ва эл. энергии)</h5>
        <div class="table-responsive-sm">
          <table class="table table-bordered table-sm">
            <thead>
              <tr class="tb_tr">
                <th class="text-center lh-1 graf3" id="jd_v" scope="col" colspan="3">Uдг<br> L1 L2 L3</th>
                <th class="text-center lh-1 graf3" id="jd_i" scope="col" colspan="3">Iдг<br> L1 L2 L3</th>
                <th class="text-center lh-1" scope="col" >Pдг</th>
              </tr>
            </thead>
              <tr class="tb_td">
                <?php
                      $arrey_div1 = array("jd_v1", "jd_v2", "jd_v3", "jd_i1", "jd_i2", "jd_i3", "jd_p");
                       foreach ($arrey_div1 as $value) {?>
                      <td id = <?php echo $value ?> class = "text-center lh-1"><div class="tb_tds"></div> </td>
                <?php } ?>
              </tr>
          </table>
        </div>
      </div>

      <div class="col-sm-12 col-md-10 col-lg-8">
        <h4>Рабочие параметры DC/DC преобразователя</h4>
        <div id="status_dc"><h5></h5></div>
        <div id="protect_dc"><h5></h5></div>
        <div class="table-responsive-sm">
          <table class="table table-bordered table-sm">
            <thead>
              <tr class="tb_tr">
                <th class="text-center lh-1" scope="col" >U dc2</th>
                <th class="text-center lh-1" scope="col" >U dc1</th>
                <th class="text-center lh-1 graf3" id="i_dc_l" scope="col" colspan="3">I dc2<br> L1 L2 L3</th>
                <th class="text-center lh-1" scope="col" >I dc2</th>
                <th class="text-center lh-1" scope="col" >T1</th>
                <th class="text-center lh-1" scope="col" >Статус</th>
                <th class="text-center lh-1" scope="col" >Защиты</th>
                <th class="text-center lh-1" scope="col" >Idc2 max<br>charge</th>
                <th class="text-center lh-1" scope="col" >Idc2 max<br>discharge</th>
                <th class="text-center lh-1" scope="col" >Edc<br>charge</th>
                <th class="text-center lh-1" scope="col" >Edc<br>discharge</th>
              </tr>
            </thead>
              <tr class="tb_td">
                <?php
                      $arrey_div1 = array("u_dc2", "u_dc1", "i_dc_l1", "i_dc_l2", "i_dc_l3", "i_dc2", "t1", "dc_st", "pr_w", "idc2_mc", "idc2_md", "edc_c", "edc_d");
                       foreach ($arrey_div1 as $value) {?>
                      <td id = <?php echo $value ?> class = "text-center lh-1"><div class="tb_tds"></div> </td>
                <?php } ?>
              </tr>
          </table>
        </div>
      </div>
    </div>
    <div id = "graf"></div>
  </div>

    <script src="jscript/myscript.js"></script>
    <script src="jscript/bootstrap.bundle.min.js"></script>
</body>
</html>
