<html>
<head>
<?php
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);
    // Разбор GET
    if(isset($_GET['a'])){
        if (stripos($_GET['a'], '.')){
            $Device = 'INV.'.$_GET['a'] ;
        }
        else{
            $Device = 'InS.'.$_GET['a'];
        }
    }
    else{exit(); echo '<script>window.close()</script>';}
    // Разбор POST
    if (isset($_POST['datetime_select'])){
        if ($_POST['datetime_select'] == ''){
            $Date = 'Last';
        }
        else{
            $Date = $_POST['datetime_select'];
        }
    }
    else{
        $Date = 'Last';
    }
    if (isset($_POST['reload'])){
        $Date = 'Last';
    }
    include 'function_site/con_DB.php';  		// подключение к БД
    include 'function_site/SaMaE.php';          // статусы сообщения ошибки
    include 'inv_db.php';                       // функция INV_TABLE($Date, $Device) получения данных инвертора из БД
    include 'pvlog_db.php';                     // функция PVLOG_TABLE($Date, $Device) получения данных шкафа связи из БД
    // Загрука данных подключения БД
    $SES = defsite($site);
    // Загрука данных инвертора
    $INV_db = INV_TABLE($Date, $Device);
    // Загрука данных шкафа связи
    $IPC_db = PVLOG_TABLE($Date, $Device);

?>
<title><?php
    echo ($SES[0]->name).' '.$Device;
    ?></title>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
    <link href="INV.css" rel="stylesheet" type="text/css" />
	<link href="GCB.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="style_css/jquery.datetimepicker.css"/>
    <script src="jscript/jquery.js"></script>
    <script src="jscript/jquery.datetimepicker.js"></script>
</head>
<body>
    <div class="main">
        <table class="datetime">
            <form method="post">
                <tr>
                    <th class="datetime_inv">
                        <input
                            type="text"
                            autocomplete="off"
                            name="datetime_select"
                            id="datetimepicker_select"
                            style="text-align:center"
                            value="<?php if(isset($_POST['datetime_select']) & !isset($_POST['reload'])){echo $_POST['datetime_select'];} else {echo date("Y-m-d H:i:00");} ?>"
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
                    </th>
                </tr>
            </form>
        </table>
    </div>
    <div class="datetime">
        Состояние инвертора
        <table class="SaMaEr">
            <tr>
                <th class="inv">Инв.</th>
                <th class="in_st">Состояние инвертора</th>
                <th class="in_in">Информ. сообщения</th>
                <th class="in_wr">Предупрежд. инв.</th>
                <th class="in_fl">Ошибки. инв.</th>
                <th class="in_fs">Ошибки. инв. самоподтв.</th>
                <th class="dc_in">Информ. DC</th>
                <th class="dc_wr">Предупрежд. DC</th>
                <th class="ac_in">Информ. AC</th>
                <th class="ac_wr">Предупрежд. AC</th>
                <th class="ac_fl">Ошибки. AC</th>
                <th class="ac_fs">Ошибки. AC самоподтв.</th>
                <th class="ac_fs">Статус связи</th>
            </tr>
            <?php
            for ($j=0; $j<count($INV_db); $j++){?>
                <tr>
                    <th class="inv">
                        <?php
                            list($st_n, $in_n) = explode(".",array_keys($INV_db)[$j]);
                            echo array_keys($INV_db)[$j];
                        ?>
                    </th>
                    <?php
                    $arrey_div1 = array("in_st", "in_in", "in_wr", "in_fl", "in_fs", "dc_in", "dc_wr", "ac_in", "ac_wr", "ac_fl", "ac_fs", "st_st");
                    foreach ($arrey_div1 as $value) {?>
                        <th class = <?php  echo $value; ?>>
                            <?php echo INV_PARAM($value, $arr_key_name, $site, $INV_db, $j); ?>
                        </th>
                    <?php } ?>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
    <div class="datetime">
        Рабочие параметры инвертора
        <table class="data_header">
            <tr>
                <th class="inv" rowspan="2">Инв.</th>
                <th class="dc" colspan="4">Постоянный ток</th>
                <th class="in" colspan="4">Инвертор</th>
                <th class="ac" colspan="2">Переменный ток</th>
                <th class="ac" colspan="2">Доп. данные</th>
            </tr>
            <tr>
                <th class="u_dc_header" >U dc</th>
                <th class="i_ac_header" >I dc</th>
                <th class="p_dc_header" >P dc</th>
                <th class="r_dc_header" >R изол.</th>
                <th class="u_ac_header" >U inv <br> L1 L2 L3 </th>
                <th class="i_ac_header" >I inv <br> L1 L2 L3 </th>
                <th class="i_f_header"  >F inv </th>
                <th class="t_header"    >T в шкафу</th>
                <th class="u_ac_header" >U ac <br> L1 L2 L3 </th>
                <th class="ac_f_header"  >F ac </th>
                <th class="in_sm_header" >StartMode </th>
                <th class="in_of_header" >InvOFF </th>
            </tr>
            <?php
                for ($j=0; $j<count($INV_db); $j++){
            ?>
            <tr>
                <th class="inv">
                    <?php
                        list($st_n, $in_n) = explode(".",array_keys($INV_db)[$j]);
                        echo array_keys($INV_db)[$j];
                    ?>
                </th>
                <?php
                $arrey_div1 = array("pv_v", "pv_i", "pv_p", "pv_r", "in_v1", "in_i1", "in_f", "in_t",  "ac_v1", "ac_f", "in_sm", "in_of");
                foreach ($arrey_div1 as $value) {?>
                    <th class = <?php  echo $value; ?>>
                        <?php echo INV_PARAM($value, $arr_key_name, $site, $INV_db, $j);?>

                    </th>
                <?php } ?>
            </tr>
            <?php
                }
            ?>
        </table>
    </div>
    <div class="datetime">
        Производительность инвертора
        <table class="data_header">
            <tr>
                <th class="inv" rowspan="2">Инв.</th>
                <th class="ac" colspan="4">Мощность</th>
                <th class="ac" colspan="2">Выработка</th>
                <th class="ac" colspan="3">Ограничения</th>
            </tr>
            <tr>
                <th class="ac_cs_header" >cos(ф) </th>
                <th class="ac_s_header" >S ac </th>
                <th class="ac_p_header" >P ac </th>
                <th class="ac_q_header" >Q ac </th>
                <th class="w_d_header" >W </th>
                <th class="w_t_header" >W all </th>
                <th class="in_lp_header" >P lim </th>
                <th class="in_lr_header" >Point lim </th>
                <th class="cs_sp_header" >cos(ф) lim </th>
            </tr>
            <?php  for ($j=0; $j<count($INV_db); $j++){ ?>
                <tr>
                    <th class="inv">
                        <?php
                            list($st_n, $in_n) = explode(".",array_keys($INV_db)[$j]);
                            echo array_keys($INV_db)[$j];
                        ?>
                    </th>
                    <?php
                    $arrey_div1 = array("ac_cs", "ac_s", "ac_p", "ac_q", "w_d", "w_t", "in_lp", "in_lr",  "cs_sp");
                    foreach ($arrey_div1 as $value) {?>
                        <th class = <?php  echo $value; ?>>
                            <?php echo INV_PARAM($value, $arr_key_name, $site, $INV_db, $j); ?>
                        </th>
                    <?php } ?>
                </tr>
            <?php  }  ?>
        </table>
    </div>
    <div class="datetime">
        Шкаф связи
        <table class="data_header">
            <tr>
                <th class="ups_st" colspan="5">ИБП</th>
                <th class="cv_t" colspan="2">Температура</th>
                <th class="cv_in" colspan="2">Датчики</th>
                <th class="rdc" colspan="6">Сервер (RDC)</th>
            </tr>
            <tr>
                <th class="ibp_v_header" >Udc</th>
                <th class="ibp_i_header" >Idc</th>
                <th class="ibp_r_header" >R АКБ</th>
                <th class="ibp_t_header" >Темп. возле АКБ</th>
                <th class="ibp_e_header" >Ошибки</th>
                <th class="cvm_st_header" >T в ИС</th>
                <th class="cvm_it_header" >T в шкафу</th>
                <th class="cvm_al_header" >Авар. откл.</th>
                <th class="cvm_ol_header" >Уровень масла в тр-ре</th>
                <th class="ipc_st_header" >Статус</th>
                <th class="ipc_sc_header" >Загруз. CPU сист.</th>
                <th class="ipc_rc_header" >Загруз. CPU RDC</th>
                <th class="ipc_rt_header" >Время проц. RDC</th>
                <th class="ipc_it_header" >Время работы IPC</th>
                <th class="ipc_m_header" >Объем flash</th>
            </tr>
            <tr>
                <?php
                    $key = array_keys($IPC_db); // Массив ключей
                    for ($i=0; $i<count($key); $i++){

                ?>
                <td>
                        <?php $Uvid = explode("_",$IPC_db[$key[$i]]['ibp_v_g']); ?>
                        <A  HREF="#nul" ONCLICK="window.open('<?php echo 'Meteostation_one.php?ud='.$site.'&i='.(hexdec($Uvid[1])*3).'&d='.(hexdec($Uvid[2])*3).'&a= Напряжение ИБП ИС'.$key[$i]; ?>','','Width=1000,Height=700');">
                            <?php echo $IPC_db[$key[$i]]['ibp_v'];?>
                        </A>
                </td>
                <td>
                        <?php $Uvid = explode("_",$IPC_db[$key[$i]]['ibp_i_g']); ?>
                        <A  HREF="#nul" ONCLICK="window.open('<?php echo 'Meteostation_one.php?ud='.$site.'&i='.(hexdec($Uvid[1])*3).'&d='.(hexdec($Uvid[2])*3).'&a= Ток ИБП ИС'.$key[$i]; ?>','','Width=1000,Height=700');">
                            <?php echo $IPC_db[$key[$i]]['ibp_i'];?>
                        </A>
                </td>
                <td>
                        <?php $Uvid = explode("_",$IPC_db[$key[$i]]['ibp_r_g']); ?>
                        <A  HREF="#nul" ONCLICK="window.open('<?php echo 'Meteostation_one.php?ud='.$site.'&i='.(hexdec($Uvid[1])*3).'&d='.(hexdec($Uvid[2])*3).'&a= Сопротивление АКБ ИС'.$key[$i]; ?>','','Width=1000,Height=700');">
                            <?php echo $IPC_db[$key[$i]]['ibp_r'];?>
                        </A>
                </td>
                <td>
                        <?php $Uvid = explode("_",$IPC_db[$key[$i]]['ibp_t_g']); ?>
                        <A  HREF="#nul" ONCLICK="window.open('<?php echo 'Meteostation_one.php?ud='.$site.'&i='.(hexdec($Uvid[1])*3).'&d='.(hexdec($Uvid[2])*3).'&a= Температура возле АКБ ИС'.$key[$i]; ?>','','Width=1000,Height=700');">
                            <?php echo $IPC_db[$key[$i]]['ibp_t'];?>
                        </A>
                </td>
                <td>
                        <?php $Uvid = explode("_",$IPC_db[$key[$i]]['ibp_e_g']); ?>
                        <A  HREF="#nul" ONCLICK="window.open('<?php echo 'Meteostation_one.php?ud='.$site.'&i='.(hexdec($Uvid[1])*3).'&d='.(hexdec($Uvid[2])*3).'&a= Ошибки ИБП ИС'.$key[$i]; ?>','','Width=1000,Height=700');">
                            <?php
                                $mes_st = MESSAGE($IPC_db[$key[$i]]['ibp_e'], $arr_state_ibp);
                                foreach($mes_st as  $key_st => $value_st){
                                    echo $arr_state_ibp[$value_st].'<br>';
                                }
                            ?>
                        </A>
                </td>
                <td>
                        <?php $Uvid = explode("_",$IPC_db[$key[$i]]['cvm_st_g']); ?>
                        <A  HREF="#nul" ONCLICK="window.open('<?php echo 'Meteostation_one.php?ud='.$site.'&i='.(hexdec($Uvid[1])*3).'&d='.(hexdec($Uvid[2])*3).'&a= Температура в помещ. ИС'.$key[$i]; ?>','','Width=1000,Height=700');">
                            <?php echo $IPC_db[$key[$i]]['cvm_st'];?>
                        </A>
                </td>
                <td>
                        <?php $Uvid = explode("_",$IPC_db[$key[$i]]['cvm_it_g']); ?>
                        <A  HREF="#nul" ONCLICK="window.open('<?php echo 'Meteostation_one.php?ud='.$site.'&i='.(hexdec($Uvid[1])*3).'&d='.(hexdec($Uvid[2])*3).'&a= Температура в шкафу связи ИС'.$key[$i]; ?>','','Width=1000,Height=700');">
                            <?php echo $IPC_db[$key[$i]]['cvm_it'];?>
                        </A>
                </td>
                <td>
                        <?php $Uvid = explode("_",$IPC_db[$key[$i]]['cvm_al_g']); ?>
                        <A  HREF="#nul" ONCLICK="window.open('<?php echo 'Meteostation_one.php?ud='.$site.'&i='.(hexdec($Uvid[1])*3).'&d='.(hexdec($Uvid[2])*3).'&a= Аварийное отключение ИС'.$key[$i]; ?>','','Width=1000,Height=700');">
                            <?php if ($IPC_db[$key[$i]]['cvm_al'] == 1) {echo "Норм.";} else {echo "Авария";} ?>
                        </A>
                </td>
                <td>
                        <?php $Uvid = explode("_",$IPC_db[$key[$i]]['cvm_ol_g']); ?>
                        <A  HREF="#nul" ONCLICK="window.open('<?php echo 'Meteostation_one.php?ud='.$site.'&i='.(hexdec($Uvid[1])*3).'&d='.(hexdec($Uvid[2])*3).'&a= Индикация уровня масла тр-ра ИС'.$key[$i]; ?>','','Width=1000,Height=700');">
                            <?php if ($IPC_db[$key[$i]]['cvm_ol'] == 0) {echo "Норм.";} else {echo "Низкий";} ?>
                        </A>
                </td>
                <td>
                        <?php $Uvid = explode("_",$IPC_db[$key[$i]]['ipc_st_g']); ?>
                        <A  HREF="#nul" ONCLICK="window.open('<?php echo 'Meteostation_one.php?ud='.$site.'&i='.(hexdec($Uvid[1])*3).'&d='.(hexdec($Uvid[2])*3).'&a= Состояние IPC ИС'.$key[$i]; ?>','','Width=1000,Height=700');">
                            <?php
                                $mes_st = MESSAGE($IPC_db[$key[$i]]['ipc_st'], $arr_state_ipc);
                                foreach($mes_st as  $key_st => $value_st){
                                    echo $arr_state_ipc[$value_st].'<br>';
                                }
                            ?>
                        </A>
                </td>
                <td>
                        <?php $Uvid = explode("_",$IPC_db[$key[$i]]['ipc_sc_g']); ?>
                        <A  HREF="#nul" ONCLICK="window.open('<?php echo 'Meteostation_one.php?ud='.$site.'&i='.(hexdec($Uvid[1])*3).'&d='.(hexdec($Uvid[2])*3).'&a= Нагрузка процессора IPC ИС'.$key[$i]; ?>','','Width=1000,Height=700');">
                            <?php echo $IPC_db[$key[$i]]['ipc_sc'];?>
                        </A>
                </td>
                <td>
                        <?php $Uvid = explode("_",$IPC_db[$key[$i]]['ipc_rc_g']); ?>
                        <A  HREF="#nul" ONCLICK="window.open('<?php echo 'Meteostation_one.php?ud='.$site.'&i='.(hexdec($Uvid[1])*3).'&d='.(hexdec($Uvid[2])*3).'&a= Нагрузка на CPU процесса RDC ИС'.$key[$i]; ?>','','Width=1000,Height=700');">
                            <?php echo $IPC_db[$key[$i]]['ipc_rc'];?>
                        </A>
                </td>
                <td>
                        <?php $Uvid = explode("_",$IPC_db[$key[$i]]['ipc_rt_g']); ?>
                        <A  HREF="#nul" ONCLICK="window.open('<?php echo 'Meteostation_one.php?ud='.$site.'&i='.(hexdec($Uvid[1])*3).'&d='.(hexdec($Uvid[2])*3).'&a= Время работы RDC ИС'.$key[$i]; ?>','','Width=1000,Height=700');">
                            <?php echo round($IPC_db[$key[$i]]['ipc_rt']/3600 , 2).' ч.' ;?>
                        </A>
                </td>
                <td>
                        <?php $Uvid = explode("_",$IPC_db[$key[$i]]['ipc_it_g']); ?>
                        <A  HREF="#nul" ONCLICK="window.open('<?php echo 'Meteostation_one.php?ud='.$site.'&i='.(hexdec($Uvid[1])*3).'&d='.(hexdec($Uvid[2])*3).'&a= Время работы IPC ИС'.$key[$i]; ?>','','Width=1000,Height=700');">
                            <?php echo round($IPC_db[$key[$i]]['ipc_it']/3600 , 2).' ч.';?>
                        </A>
                </td>
                <td>
                        <?php $Uvid = explode("_",$IPC_db[$key[$i]]['ipc_m_g']); ?>
                        <A  HREF="#nul" ONCLICK="window.open('<?php echo 'Meteostation_one.php?ud='.$site.'&i='.(hexdec($Uvid[1])*3).'&d='.(hexdec($Uvid[2])*3).'&a= Объем flash памяти IPC ИС'.$key[$i]; ?>','','Width=1000,Height=700');">
                            <?php echo $IPC_db[$key[$i]]['ipc_m'];?>
                        </A>
                </td>
                <?php  }  ?>
            </tr>

        </table>
    </div>
    <script>
        $('#datetimepicker_select').datetimepicker({
            lang:'ru',
            dayOfWeekStart: 1,
            step:30,
            format:'Y-m-d H:i:00'
        });
    </script>

</body>
</html>
