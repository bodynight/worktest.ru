
  <?php 
  $arrSopost = ['Inverter_Operation_State' => 'in_st',  'PV_Inverter_Information' => 'in_in', 'PV_Inverter_Warning' => 'in_wr', 'PV_Inverter_Fault' => 'in_fl', 'PV_Inverter_Fault_SACK' => 'in_fs', 'PV_Input_DC_Information' => 'dc_in', 'PV_Input_DC_Warning' => 'dc_wr', 'PV_Output_AC_Information' => 'ac_in', 'PV_Output_AC_Warning' => 'ac_wr', 'PV_Output_AC_Fault' => 'ac_fl', 'PV_Output_AC_Fault_SACK' => 'ac_fs', 'StartMode' => 'st_st', 'PV_Voltage' => 'pv_v', 'PV_Current' => 'pv_i', 'PV_Power' => 'pv_p', 'DC_Isolation_Resistor' => 'pv_r', 'InvVoltL1_L2' => 'in_v1', 'InvVoltL2_L3' => 'in_v2', 'InvVoltL3_L1' => 'in_v3', 'InvCurrentL1' => 'in_i1', 'InvCurrentL2' => 'in_i2', 'InvCurrentL3' => 'in_i3', 'InvFrequency' => 'in_f', 'AmbientAirTemp' => 'in_t', 'GridVoltL1_L2' => 'ac_v1', 'GridVoltL2_L3' => 'ac_v2', 'GridVoltL3_L1' => 'ac_v3', 'GridFrequency' => 'ac_f', 'InverterOFF' => 'in_of', 'CosPhi' => 'ac_cs', 'InvTotalApparentPower' => 'ac_s', 'InvTotalTruePower' => 'ac_p', 'InvTotalReactivePower' => 'ac_q', 'DayEnergy' => 'w_d', 'TotalEnergy' => 'w_t', 'TruePowerLimitPoint' => 'in_lp', 'TruePowerLimitPointRelease' => 'in_lr', 'CosPhiSetPointRelease' => 'cs_sp', 'diesel_ready' => 'bms_pr', 'I_diesel' => 'bms_u2m', 'P_diesel' => 'bms_i2m', 'BMS_Power_ref' => 'b_ref', 'BMS_U2_meas' => 'u2_m', 'BMS_I2_meas' => 'i2_m', 'BMS_E_charge' => 'e_ch', 'BMS_status' => 'b_st', 'P_fix' => 'p_fx', 'P_ac_10' => 'p_ac_10', 'F_ac_10' => 'f_ac_10', 'Udc2' => 'u_dc2', 'Udc1' => 'u_dc1', 'Idc2_L1' => 'i_dc_l1', 'Idc2_L2' => 'i_dc_l2', 'Idc2_L3' => 'i_dc_l3', 'Idc2' => 'i_dc2', 'T1' => 't1', 'status' => 'dc_st', 'protect_word' => 'pr_w', 'Idc2_max_charge' => 'idc2_mc', 'Idc2_max_discharge' => 'idc2_md', 'Edc_charge' => 'edc_c', 'Edc_discharge' => 'edc_d'];
  
function addArrayAssoc($log, $arrS){
   $i = 0;
   $arr = [];
   $lines = file($log);
   $firstLine = explode("\t", $lines[0]);
   foreach ($firstLine as $item) {
        $result = preg_match('/\w+\b/',$item,$found);
        if ( array_key_exists($found[0], $arrS) ){
            $arr += [$arrS[$found[0]] => $log=="logs/inv_log" ? $i:"$i"];
        }
        $i++;  
  }
  return $arr; 
}
$arrAssoc = addArrayAssoc("logs/inv_log", $arrSopost);
$arrAssoc = array_merge($arrAssoc, addArrayAssoc("logs/dcdc_log", $arrSopost));
if ($arrAssoc['st_st'] != ''){
    $arrAssoc += ['in_sm' => $arrAssoc['st_st'] ];
}

// if (isset($_GET["letarr"]) && $_GET["letarr"] == 1){
//     echo json_encode($arrAssoc);
// }
?>
