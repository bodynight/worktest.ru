    <?php 
      $f_read = read_oprch('F');
      $p_read = read_oprch('P');
     ?>

    <div class="col-sm-12 col-md-10 col-lg-8">
      <div class="table-responsive-sm">

      <table class="table table-bordered">
        <thead>
          <tr class="tb_tr_t table-warning">
            
            <th class="text-center" scope="row" >Режим работы ОПРЧ</th>
            <th  scope="col" colspan="3">
              
              <form action="oprch.php" method="post">
                <select name="sel_oprh" class="form-select form-select-lg fw-bold fs-4">
                  <option <?php echo $_SESSION['sel_oprh'] == 'Выкл.' ?  "selected" : '' ; ?>  class="sel_" value="Выкл.">Выкл.</option>
                  <option <?php echo $_SESSION['sel_oprh'] == 'P,F - инвертор' ?  "selected" : '' ; ?> class="sel_" value="P,F - инвертор">P,F - инвертор</option>
                  <option <?php echo $_SESSION['sel_oprh'] == 'P,F - анализатор' ?  "selected" : '' ; ?> class="sel_" value="P,F - анализатор">P,F - анализатор</option>
                  <option <?php echo $_SESSION['sel_oprh'] == 'Отладка P, F - инвертор' ?  "selected" : '' ; ?> class="sel_" value="Отладка P, F - инвертор">Отладка P, F - инвертор</option>
                  <option <?php echo $_SESSION['sel_oprh'] == 'Отладка P,F - анализатор' ?  "selected" : '' ; ?> class="sel_" value="Отладка P,F - анализатор">Отладка P,F - анализатор</option>
                </select>

            </th>
            <th scope="col" colspan="3">

              <button name="do_select" type="submit" class="btn btn-secondary btn-lg text-center" id="do_sel">Применить</button>

            </th>
            </form>
          </tr>
        </thead>
        <tbody>
          <tr class="tb_tr_t table-warning">
            
            <td class="fw-bold text-center" colspan="3">Фактические значения частоты и мощности от анализатора </td>
            <td class="fw-bold text-center" colspan="4">Параметры отладки режима ОПРЧ</td>
            
          </tr>
          <tr class="tb_tr_t">
            <td class="tb_th_fs_t">Мощность (P_ac_10)</td>
            <td class="cs_z">
              <div id="p_ac_10">
                <?php echo $myarr[$arrAssoc['p_ac_10']]; ?>
              </div>    
            </td>
            <td class="cs_z">кВт</td>
            <form action="oprch.php" method="post">
            <td class="tb_th_fs_t">Задаваемая мощность</td>
            <td>
              <input class="form-control form-control-lg cs_zi" name="P" type="text" value=<?php echo $p_read; ?> >
            </td>
            <td>кВт</td>
            <td>
              <button type="submit" class="btn btn-secondary btn-lg text-center" name="do_input">Применить</button>
            </td>
          </tr>
          <tr class="tb_tr_t">
            <td>Частота (F_ac_10)</td>
            <td class="cs_z">
              <div id="f_ac_10">
                <?php echo $myarr[$arrAssoc['f_ac_10']]; ?>
              </div>    
            </td>
            <td class="cs_z">Гц</td>
            <td>Задаваемая частота</td>
            <td>
              <input class="form-control form-control-lg cs_zi" type="text" name="F" placeholder="50" value=<?php echo $f_read; ?> >
            </td>
            <td>Гц</td>
            <td>
              <button type="submit" class="btn btn-secondary btn-lg text-center" name="do_input">Применить</button>
            </td>
          </form>
          </tr>
          <tr class="tb_tr_t table-warning">
            <td class="fw-bold text-center" colspan="7">Расчетные значения режима при ОПРЧ </td>
          </tr>
          <tr class="tb_tr_t">
            <td>Зафиксированная мощность (P_fix)</td>
            <td>
              <div id="p_fx">
                <?php echo $myarr[$arrAssoc['p_fx']]; ?>
              </div>    
            </td>
            <td colspan="5">кВт</td>
          </tr>
          <tr class="tb_tr_t">
            <td>Расчетная мощность (True_Power_Limit)</td>
            <td>
              <div id="in_lp">
                <?php echo $myarr[$arrAssoc['in_lp']]; ?>
              </div>    
            </td>
            <td colspan="5">кВт</td>
          </tr>
        </tbody>
      </table>

      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-8">
        <div id="container" style="height: 400px; min-width: 310px"></div>
      </div>
    </div>

    <?php 
      include "./graphik/chart_pf_an.php";
    ?>    

