
  <?php 
  $lines = file("logs/inv_log");
  $i = 0;
  $arrAssoc = [];
  $firstLine = explode("\t", $lines[0]);
  foreach ($firstLine as $item) {
  $result = preg_match('/\w+\b/',$item,$found);
  if ($found[0] == 'Inverter_Operation_State'){
      $arrAssoc += ['in_st' => $i];
  }
  if ($found[0] == 'PV_Inverter_Information'){
      $arrAssoc += ['in_in' => $i];
  }
  if ($found[0] == 'PV_Inverter_Warning'){
      $arrAssoc += ['in_wr' => $i];
  }
  if ($found[0] == 'PV_Inverter_Fault'){
      $arrAssoc += ['in_fl' => $i];
  }
  if ($found[0] == 'PV_Inverter_Fault_SACK'){
      $arrAssoc += ['in_fs' => $i];
  }
  if ($found[0] == 'PV_Input_DC_Information'){
      $arrAssoc += ['dc_in' => $i];
  }
  if ($found[0] == 'PV_Input_DC_Warning'){
      $arrAssoc += ['dc_wr' => $i];
  }
    if ($found[0] == 'PV_Output_AC_Information'){
      $arrAssoc += ['ac_in' => $i];
  }
  if ($found[0] == 'PV_Output_AC_Warning'){
      $arrAssoc += ['ac_wr' => $i];
  }
  if ($found[0] == 'PV_Output_AC_Fault'){
      $arrAssoc += ['ac_fl' => $i];
  }
  if ($found[0] == 'PV_Output_AC_Fault_SACK'){
      $arrAssoc += ['ac_fs' => $i];
  }
  if ($found[0] == 'StartMode'){
      $arrAssoc += ['st_st' => $i];
  }
  if ($found[0] == 'PV_Voltage'){
      $arrAssoc += ['pv_v' => $i];
  }
  if ($found[0] == 'PV_Current'){
      $arrAssoc += ['pv_i' => $i];
  }
  if ($found[0] == 'PV_Power'){
      $arrAssoc += ['pv_p' => $i];
  }
  if ($found[0] == 'DC_Isolation_Resistor'){
      $arrAssoc += ['pv_r' => $i];
  }
  if ($found[0] == 'InvVoltL1_L2'){
      $arrAssoc += ['in_v1' => $i];
  }
  if ($found[0] == 'InvVoltL2_L3'){
      $arrAssoc += ['in_v2' => $i];
  }
  if ($found[0] == 'InvVoltL3_L1'){
      $arrAssoc += ['in_v3' => $i];
  }
  if ($found[0] == 'InvCurrentL1'){
      $arrAssoc += ['in_i1' => $i];
  }
  if ($found[0] == 'InvCurrentL2'){
      $arrAssoc += ['in_i2' => $i];
  }
  if ($found[0] == 'InvCurrentL3'){
      $arrAssoc += ['in_i3' => $i];
  }
  if ($found[0] == 'InvFrequency'){
      $arrAssoc += ['in_f' => $i];
  }
  if ($found[0] == 'AmbientAirTemp'){
      $arrAssoc += ['in_t' => $i];
  }
  if ($found[0] == 'GridVoltL1_L2'){
      $arrAssoc += ['ac_v1' => $i];
  }
  if ($found[0] == 'GridVoltL2_L3'){
      $arrAssoc += ['ac_v2' => $i];
  }
  if ($found[0] == 'GridVoltL3_L1'){
      $arrAssoc += ['ac_v3' => $i];
  }
  if ($found[0] == 'GridFrequency'){
      $arrAssoc += ['ac_f' => $i];
  }
  if ($found[0] == 'StartMode'){
      $arrAssoc += ['in_sm' => $i];
  }
  if ($found[0] == 'InverterOFF'){
      $arrAssoc += ['in_of' => $i];
  }
  if ($found[0] == 'CosPhi'){
      $arrAssoc += ['ac_cs' => $i];
  }
  if ($found[0] == 'InvTotalApparentPower'){
      $arrAssoc += ['ac_s' => $i];
  }
  if ($found[0] == 'InvTotalTruePower'){
      $arrAssoc += ['ac_p' => $i];
  }
  if ($found[0] == 'InvTotalReactivePower'){
      $arrAssoc += ['ac_q' => $i];
  }
  if ($found[0] == 'DayEnergy'){
      $arrAssoc += ['w_d' => $i];
  }
  if ($found[0] == 'TotalEnergy'){
      $arrAssoc += ['w_t' => $i];
  }
  if ($found[0] == 'TruePowerLimitPoint'){
      $arrAssoc += ['in_lp' => $i];
  }
  if ($found[0] == 'TruePowerLimitPointRelease'){
      $arrAssoc += ['in_lr' => $i];
  }
  if ($found[0] == 'CosPhiSetPointRelease'){
      $arrAssoc += ['cs_sp' => $i];
  }
  if ($found[0] == 'diesel_ready'){
      $arrAssoc += ['bms_pr' => $i];
  }
  if ($found[0] == 'I_diesel'){
      $arrAssoc += ['bms_u2m' => $i];
  }
  if ($found[0] == 'P_diesel'){
      $arrAssoc += ['bms_i2m' => $i];
  }
  if ($found[0] == 'BMS_Power_ref'){
      $arrAssoc += ['b_ref' => $i];
  }
  if ($found[0] == 'BMS_U2_meas'){
      $arrAssoc += ['u2_m' => $i];
  }
  if ($found[0] == 'BMS_I2_meas'){
      $arrAssoc += ['i2_m' => $i];
  }
  if ($found[0] == 'BMS_E_charge'){
      $arrAssoc += ['e_ch' => $i];
  }
  if ($found[0] == 'BMS_status'){
      $arrAssoc += ['b_st' => $i];
  }
    $i++;  
  }

  $lines = file("logs/dcdc_log");
  $i = 0;
  $firstLine = explode("\t", $lines[0]);
  foreach ($firstLine as $item){
    $result = preg_match('/\w+\b/',$item,$found);
    if ($found[0] == 'Udc2'){
      $arrAssoc += ['u_dc2' => "$i"];
    }
    if ($found[0] == 'Udc1'){
      $arrAssoc += ['u_dc1' => "$i"];
    }
    if ($found[0] == 'Idc2_L1'){
      $arrAssoc += ['i_dc_l1' => "$i"];
    }
    if ($found[0] == 'Idc2_L2'){
      $arrAssoc += ['i_dc_l2' => "$i"];
    }
    if ($found[0] == 'Idc2_L3'){
      $arrAssoc += ['i_dc_l3' => "$i"];
    }
    if ($found[0] == 'Idc2'){
      $arrAssoc += ['i_dc2' => "$i"];
    }
    if ($found[0] == 'T1'){
      $arrAssoc += ['t1' => "$i"];
    }
    if ($found[0] == 'status'){
      $arrAssoc += ['dc_st' => "$i"];
    }
    if ($found[0] == 'protect_word'){
      $arrAssoc += ['pr_w' => "$i"];
    }
    if ($found[0] == 'Idc2_max_charge'){
      $arrAssoc += ['idc2_mc' => "$i"];
    }
    if ($found[0] == 'Idc2_max_discharge'){
      $arrAssoc += ['idc2_md' => "$i"];
    }
    if ($found[0] == 'Edc_charge'){
      $arrAssoc += ['edc_c' => "$i"];
    }
    if ($found[0] == 'Edc_discharge'){
      $arrAssoc += ['edc_d' => "$i"];
    }
    $i++;
    }
   ?>



