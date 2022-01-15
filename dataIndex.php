<?php
   include 'dataAssociate.php'; 

   $f_inv = "logs/inv_log";
   $f_dc =  "logs/dcdc_log";
   function get_array($log){
              $lines = file($log);
              $myarr = explode("\t", $lines[count($lines)-1]); //или последняя строка из массива
              return $myarr;
   }
   $arr_data_in = get_array($f_inv);
   $arr_data_dc = get_array($f_dc);
   $arr_data = [];

   foreach ($arrAssoc as $key => $value) {
      if(is_integer($value)){
         $arr_data += [$key => $arr_data_in[$value]];
      }else{
         $arr_data += [$key => $arr_data_dc[(int)$value]];
      }
   }

   if($_GET['letarr'] == 'log'){
      echo json_encode($arr_data);
   }

   if(isset($_GET['arg']) && isset($_GET['val_arg']) ){
      $arg = $_GET['arg'];
      $val_arg = $_GET['val_arg'];
      $val = $arr_data[$arg];
      if(is_integer($val_arg)){
         $time = $arr_data_in[0];
         echo json_encode(array("time" => $time, "value" => $val));
      }else{
         $time = $arr_data_dc[0];
         echo json_encode(array("time" => $time, "value" => $val));
      }
   }

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


   function get_array_chart($var_pos, $f_inv, $f_dc){
      $arr = [];
      if(is_integer($var_pos)){
         $lines = file($f_inv);
         $tmp = array_shift($lines);
         $tmp = array_pop($lines);
         foreach ($lines as $value) {
            $line = explode("\t", $value);
            $unixdata = (strtotime($line[0])) * 1000;
            if (strpos($line[$var_pos], '.') !== false) {
                    $val_num = floatval($line[$var_pos]);
                } else {
                    $val_num = intval($line[$var_pos]);
                }
            $arr[] = array($unixdata,$val_num);
         }
      }else{
         $lines = file($f_dc);
         $tmp = array_shift($lines);
         $tmp = array_pop($lines);
         foreach ($lines as $value) {
            $line = explode("\t", $value);
            $unixdata = (strtotime($line[0])) * 1000;
            $arr[] = array($unixdata, (int)$line[(int)$var_pos]);
         }
      }
      return $arr;
   }

   if(isset($_GET['chart_arg'])){
      $get_num_val = $arrAssoc[$_GET['chart_arg']];
      $arr_chart = get_array_chart($get_num_val, $f_inv, $f_dc);
      echo json_encode(array('array' => $arr_chart, 'get_num_val' => $get_num_val));
   }
 ?>
