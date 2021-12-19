<div class="col-sm-12 col-md-10 col-lg-8">
      <div class="table-responsive-sm">

      <table class="table table-bordered">
        <thead>
          <tr class="tb_tr_t table-warning">
            
            <th class="text-center" scope="row" >Режим работы ОПРЧ</th>
            <th  scope="col">

              <form action="oprch.php" method="post">
                <select name="sel_oprh" class="form-select form-select-lg fw-bold fs-4">
                  <option <?php echo $_SESSION['sel_oprh'] == 'Выкл.' ?  "selected" : '' ; ?>  class="sel_" value="Выкл.">Выкл.</option>
                  <option <?php echo $_SESSION['sel_oprh'] == 'P,F - инвертор' ?  'selected' : '' ; ?> class="sel_" value="P,F - инвертор">P,F - инвертор</option>
                  <option <?php echo $_SESSION['sel_oprh'] == 'P,F - анализатор' ?  "selected" : '' ; ?> class="sel_" value="P,F - анализатор">P,F - анализатор</option>
                  <option <?php echo $_SESSION['sel_oprh'] == 'Отладка P, F - инвертор' ?  "selected" : '' ; ?> class="sel_" value="Отладка P, F - инвертор">Отладка P, F - инвертор</option>
                  <option <?php echo $_SESSION['sel_oprh'] == 'Отладка P,F - анализатор' ?  "selected" : '' ; ?>class="sel_" value="Отладка P,F - анализатор">Отладка P,F - анализатор</option>
                </select>

            </th>
            <th scope="col">
              <button name="do_select" type="submit" class="btn btn-secondary btn-lg text-center" id="do_sel">Применить</button>
            </form>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr class="tb_tr_t table-warning">
            <td class="fw-bold text-center" colspan="3">Фактические значения мощности и частоты инвертора </td>
          </tr>
          <tr class="tb_tr_t">
            <td class="tb_th_fs_t">Мощность (InvTotalTruePower)</td>
            <td class="text-end">
              <div id="ac_p">
                <?php echo $myarr[$arrAssoc['ac_p']]; ?>
              </div>    
            </td>
            <td>кВт</td>
            
          </tr>
          <tr class="tb_tr_t">
            <td>Частота (InvFrequency)</td>
            <td class="text-end">
              <div id="in_f">
                <?php echo $myarr[$arrAssoc['in_f']]; ?>
              </div>    
            </td>
            <td>Гц</td>
            
          </tr>
          <tr class="tb_tr_t table-warning">
            <td class="fw-bold text-center" colspan="7">Расчетные значения режима при ОПРЧ </td>
          </tr>
          <tr class="tb_tr_t">
            <td>Зафиксированная мощность (P_fix)</td>
            <td class="text-end">
              <div id="p_fx">
                <?php echo $myarr[$arrAssoc['p_fx']]; ?>
              </div>    
            </td>
            <td>кВт</td>
          </tr>
          <tr class="tb_tr_t">
            <td>Расчетная мощность (TruePowerLimitPoint)</td>
            <td class="text-end">
              <div id="in_lp">
                <?php echo $myarr[$arrAssoc['in_lp']]; ?>
              </div>    
            </td>
            <td >кВт</td>
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
  include "./graphik/chart_pf_in.php";
 ?>    
