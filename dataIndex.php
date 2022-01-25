<?php
   include 'dataAssociate.php'; 
   $f_inv = "logs/inv_log";
   $f_dc =  "logs/dcdc_log";
   $f_jd =  "logs/janitza_diesel";

   //Создание массива данных из нужгого лога из последней строки
   function get_array($log){
      if(isset($_GET['date']) && $_GET['date'] != 0 ){
         $find = $_GET['date'];
         $file = fopen($log, "r") or die("Unable to open file!");
                  while(!feof($file))
                   { $row = fgets($file);
                      $pos = strpos($row, $find);
                      if ($pos === false) {
                      } else {
                          $myarr = explode("\t", $row);//создание массива из строки вхождения
                             }
                     }
              fclose($file);
      }else{
         $lines = file($log);
         $last = $lines[count($lines)-1];
         if(preg_match('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $last)){
            $myarr = explode("\t", $lines[count($lines)-1]); //или последняя строка из массива
         }
      }
      return $myarr;
   }
   $arr_data_in = get_array($f_inv);
   $arr_data_dc = get_array($f_dc);
   $arr_data_jd = get_array($f_jd);
   include 'ErrorMessage.php';
   $arr_data = [];
   //создание ассоциативного массива ключ значение из нужного массива 
   foreach ($arrAssoc as $key => $value) {
      if(in_array($key, $arr_jd_key)){
        $arr_data += [$key => $arr_data_jd[$value]];
      }else if(in_array($key, $arr_dc_key)){
         $arr_data += [$key => $arr_data_dc[$value]];
      }else if(in_array($key, $arr_in_key)){
         $arr_data += [$key => $arr_data_in[$value]];
      }
   }
   //подготовка данных для аях запроса, на страницу index.php для таблицы 
   if($_GET['letarr'] == 'log'){
      if($err_str_arr){
         $ar_error = $err_str_arr; 
      }else{
         $ar_error = 0;
      }
      $state_inv_string = $arr_state_name[$arr_data["in_st"]];
      $state_bms_string = $arr_state_bms[$arr_data["b_st"]];
      $state_dc_string = $arr_state_dc[$arr_data["dc_st"]];
      $state_dc_protect = $arr_protect_dc[$arr_data["pr_w"]];
      echo json_encode(array(
                             'arr_data'=>$arr_data,
                             'ar_error'=>$ar_error,
                             'inv_state'=>$state_inv_string,
                             'bms_state'=>$state_bms_string,
                             'dc_state'=>$state_dc_string,
                             'ds_protect'=>$state_dc_protect
      ));
   }
   //подготовка данных для аях запроса, на страницу grafick.php для графика динамик 
   if(isset($_GET['arg']) && isset($_GET['val_arg']) ){
      $arg = $_GET['arg'];
      $val_arg = $_GET['val_arg'];
      $val = $arr_data[$arg];
      if(in_array($arg, $arr_jd_key)){
         $time = $arr_data_jd[0];
         echo json_encode(array("time" => $time, "value" => $val));
      }else if(in_array($arg, $arr_in_key)){
         $time = $arr_data_in[0];
         echo json_encode(array("time" => $time, "value" => $val));
      }else if(in_array($arg, $arr_dc_key)){
         $time = $arr_data_dc[0];
         echo json_encode(array("time" => $time, "value" => $val));
      }
   }
   //подготовка данных для аях запроса, для таблиц опрч 
   if(isset($_GET['updateblock'])){
      if($_GET['updateblock'] == 'oprch_off'){
         $p_ac_10 = $arr_data['p_ac_10'];
         $f_ac_10 = $arr_data['f_ac_10'];
         echo json_encode(array("p_ac_10" => $p_ac_10, "f_ac_10" => $f_ac_10));
      }else if($_GET['updateblock'] == 'oprch_pf_in'){
         $ac_p = $arr_data['ac_p'];
         $in_f = $arr_data['in_f'];
         $p_fx = $arr_data['p_fx'];
         $in_lp = $arr_data['in_lp'];
         echo json_encode(array("ac_p" => $ac_p, "in_f" => $in_f, "p_fx" => $p_fx, "in_lp" => $in_lp));
      }else if($_GET['updateblock'] == 'oprch_pf_an'){
         $p_ac_10 = $arr_data['p_ac_10'];
         $f_ac_10 = $arr_data['f_ac_10'];
         $p_fx = $arr_data['p_fx'];
         $in_lp = $arr_data['in_lp'];
         echo json_encode(array("p_ac_10" => $p_ac_10, "f_ac_10" => $f_ac_10, "p_fx" => $p_fx, "in_lp" => $in_lp));
      }
   }
   
   function get_arr_gr($log, $var_pos){
         $lines = file($log);
         $tmp = array_shift($lines);
         $tmp = array_pop($lines);
         foreach ($lines as $value) {
            $line = explode("\t", $value);
            $unixdata = (strtotime($line[0])) * 1000;
            $val_num = $line[$var_pos]*1;
            $arr[] = array($unixdata, $val_num);
         }
            return $arr;
      }

   function get_array_chart($var_pos, $f_inv, $f_dc, $f_jd, $arg, $arr_jd_key, $arr_in_key, $arr_dc_key){
      if(in_array($arg, $arr_jd_key)){
         $arr = get_arr_gr($f_jd, $var_pos);
      }else if(in_array($arg, $arr_in_key)){
         $arr = get_arr_gr($f_inv, $var_pos);
      }else if(in_array($arg, $arr_dc_key)){
         $arr = get_arr_gr($f_dc, $var_pos);
      }
      return $arr;
   }
   //подготовка данных для аях запроса, на страницу grafick.php для графиков первичный массив данных
   if(isset($_GET['chart_arg'])){
      $chart_arg = $_GET['chart_arg'];
      $get_num_val = $arrAssoc[$_GET['chart_arg']];
      $arr_chart = get_array_chart($get_num_val, $f_inv, $f_dc, $f_jd, $chart_arg, $arr_jd_key, $arr_in_key, $arr_dc_key);
      echo json_encode(array('array' => $arr_chart, 'get_num_val' => $get_num_val));
   }

   //подготовка вводных данных для тройных графиков
   if(isset($_GET['graf3'])){
      $val = $_GET['graf3'];
      $get_num_val1 = $arrAssoc[$val.'1'];
      $get_num_val2 = $arrAssoc[$val.'2'];
      $get_num_val3 = $arrAssoc[$val.'3'];
      $arr_chart1 = get_array_chart($get_num_val1, $f_inv, $f_dc, $f_jd, $val.'1', $arr_jd_key, $arr_in_key, $arr_dc_key);
      $arr_chart2 = get_array_chart($get_num_val2, $f_inv, $f_dc, $f_jd, $val.'2', $arr_jd_key, $arr_in_key, $arr_dc_key);
      $arr_chart3 = get_array_chart($get_num_val3, $f_inv, $f_dc, $f_jd, $val.'3', $arr_jd_key, $arr_in_key, $arr_dc_key);
      echo json_encode(array(
                              'array1' => $arr_chart1,
                              'array2' => $arr_chart2,
                              'array3' => $arr_chart3
                           ));

   }
   //подготовка данных для аях запроса, на страницу grafick3.php для графика динамик 
   if(isset($_GET['series3'])){
      $arg = $_GET['series3'];
      $arg1 = $arg.'1';
      $arg2 = $arg.'2';
      $arg3 = $arg.'3';
      $val1 = $arr_data[$arg1];
      $val2 = $arr_data[$arg2];
      $val3 = $arr_data[$arg3];
      $time = $arr_data_in[0];
      echo json_encode(array(
         "time" => $time,
         "value1" => $val1,
         "value2" => $val2,
         "value3" => $val3
      ));
   }

   //Формируем ассоциативный массив для статусов фона презентации от логического кода
      //первая цифра фэм>0 => 1 , фэм=0 => 0
      //первая цифра invertor/AC>0 => 1 , invertor/AC=0 => 0, invertor/AC<0 => -1
      // третья цифра по аналогии для ДГУ
      // четвертая для мощности DC/DC 
      // пятая для условий DC/DC
   $fon_accoc = [
                  '1101' => 'url(../image/gen_fem_akym_charg_dcac_plus.jpg)',
                  '11001' => 'url(../image/gen_fem_akym_charg_dcac_plus.jpg)',
                  '110-1' => 'url(../image/gen_fem_akym_disch_dcac_plus.jpg)',
                  '1100' => 'url(../image/gen_fem_akym_charg_dcac_nul.jpg)',
                  '111-1' => 'url(../image/all_gen.jpg)',
                  '010-1' => 'url(../image/dcacPlus_akumMinus.jpg)',
                  '0-101' => 'url(../image/pv_pMinus_pdc_dc_outPlus.jpg)',
                  '0-1001' => 'url(../image/pv_pMinus_pdc_dc_outPlus.jpg)',
                  '0-100' => 'url(../image/pv_pMinus.jpg)',
                  '0000' => 'url(../image/allNul.jpg)',
                  '1001' => 'url(../image/femPlus_dcdcPlus.jpg)',
                  '10001' => 'url(../image/femPlus_dcdcPlus.jpg)',
                  '1-101' => 'url(../image/fem_dcacMinus_dcdcPlus.jpg)',
                  '1-1001' => 'url(../image/fem_dcacMinus_dcdcPlus.jpg)',
                  '1-100' => 'url(../image/pv_pMinus_femPlus.jpg)'
               ];
   //подготовка данных для аях запроса, на страницу present.php для графика динамик
   if(isset($_GET['present'])){
      $logical_st = "";
      $st_chsrge = 0;
      $pv_p = $arr_data['pv_p'] * 1;
      $jd_p = $arr_data['jd_p'] * 1;
      $pdc_dc_out = (int)($arr_data['u_dc2'] * $arr_data['i_dc2'] / 1000);
      $ac_p = $arr_data['ac_p'] * 1;
      $fem = abs($pv_p - $jd_p + $pdc_dc_out);
      $bat = $pdc_dc_out;//временно
      //определяем статус заряда акб
      if($arr_data['b_st'] * 1 == 5 && $arr_data['dc_st'] * 1 == 7 && $arr_data['i_dc2'] * 1 >= 0){
         $st_chsrge = 1;
      }
      //шифруем значения в логические статусы и формируем логический код в $logical_st
      if($fem > 0){$logical_st = $logical_st . '1';}else{$logical_st = $logical_st . '0';}
      if($pv_p > 0){$logical_st = $logical_st . '1';}else if($pv_p < 0){$logical_st = $logical_st . '-1';}else{$logical_st = $logical_st . '0';}
      if($jd_p > 0){$logical_st = $logical_st . '1';}else{$logical_st = $logical_st . '0';}
      if($pdc_dc_out > 0){$logical_st = $logical_st . '1';}else if($pdc_dc_out < 0){$logical_st = $logical_st . '-1';}else{$logical_st = $logical_st . '0';}
      if($st_chsrge == 1){$logical_st = $logical_st . '1';}

      // if(array_key_exists($logical_st, $fon_accoc)){
      //    $fon = $fon_accoc[$logical];
      // }else{
      //    $fon = 'url(../image/неопределен.jpg)';
      // }

      if($fem > 0 && $pv_p > 0 && $jd_p == 0 && $pdc_dc_out > 0){
         $fon = 'url(../image/gen_fem_akym_charg_dcac_plus.jpg)';
      }else if($fem > 0 && $pv_p > 0 && $jd_p == 0 && $pdc_dc_out == 0 && $st_chsrge == 1){
         $fon = 'url(../image/gen_fem_akym_charg_dcac_plus.jpg)';
      }else if($fem > 0 && $pv_p > 0 && $jd_p == 0 && $pdc_dc_out < 0){
         $fon = 'url(../image/gen_fem_akym_disch_dcac_plus.jpg)';
      }else if($fem > 0 && $pv_p > 0 && $jd_p == 0 && $pdc_dc_out == 0 && $st_chsrge != 1){
         $fon = 'url(../image/gen_fem_akym_charg_dcac_nul.jpg)';
      }else if($fem > 0 && $pv_p > 0 && $jd_p > 0 && $pdc_dc_out < 0){
         $fon = 'url(../image/all_gen.jpg)';
      }else if($fem == 0 && $pv_p > 0 && $jd_p == 0 && $pdc_dc_out < 0){
         $fon = 'url(../image/dcacPlus_akumMinus.jpg)';
      }else if($fem == 0 && $pv_p < 0 && $jd_p == 0 && $pdc_dc_out > 0){
         $fon = 'url(../image/pv_pMinus_pdc_dc_outPlus.jpg)';
      }else if($fem == 0 && $pv_p < 0 && $jd_p == 0 && $pdc_dc_out == 0 && $st_chsrge == 1){
         $fon = 'url(../image/pv_pMinus_pdc_dc_outPlus.jpg)';
      }else if($fem == 0 && $pv_p < 0 && $jd_p == 0 && $pdc_dc_out == 0 && $st_chsrge != 1){
         $fon = 'url(../image/pv_pMinus.jpg)';
      }else if($fem == 0 && $pv_p == 0 && $jd_p == 0 && $pdc_dc_out == 0 && $st_chsrge != 1){
         $fon = 'url(../image/allNul.jpg)';
      }else if($fem > 0 && $pv_p == 0 && $jd_p == 0 && $pdc_dc_out > 0){
         $fon = 'url(../image/femPlus_dcdcPlus.jpg)';
      }else if($fem > 0 && $pv_p == 0 && $jd_p == 0 && $pdc_dc_out == 0 && $st_chsrge == 1){
         $fon = 'url(../image/femPlus_dcdcPlus.jpg)';
      }else if($fem > 0 && $pv_p < 0 && $jd_p == 0 && $pdc_dc_out > 0){
         $fon = 'url(../image/fem_dcacMinus_dcdcPlus.jpg)';
      }else if($fem > 0 && $pv_p < 0 && $jd_p == 0 && $pdc_dc_out == 0 && $st_chsrge == 1){
         $fon = 'url(../image/fem_dcacMinus_dcdcPlus.jpg)';
      }else if($fem > 0 && $pv_p < 0 && $jd_p == 0 && $pdc_dc_out == 0 && $st_chsrge != 1){
         $fon = 'url(../image/pv_pMinus_femPlus.jpg)';
      }else{
         $fon = 'url(../image/неопределен.jpg)';
      }
      echo json_encode(array(
         "pv_p" => $pv_p,
         "jd_p" => $jd_p,
         "pdc_dc_out" => $pdc_dc_out,
         "ac_p" => $ac_p,
         "fem" => $fem,
         'bat' => $bat,
         'fon' => $fon,
         'logical' => $logical_st
      ));
      
   }
 ?>

