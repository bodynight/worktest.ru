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
            <td class="fw-bold text-center" colspan="3">Фактические значения мощности и частоты от анализатора качества </td>
          </tr>
          <tr class="tb_tr_t">
            <td class="tb_th_fs_t">Мощность (p_ac_10)</td>
            
              <td class="text-end">
                <div id="p_ac_10">
                  <?php echo $myarr[$arrAssoc['p_ac_10']]; ?>
                </div>
              </td>
            <td>кВт</td>
            
          </tr>
          <tr class="tb_tr_t">
            <td>Частота (f_ac_10)</td>
              <td class="text-end">
                <div id="f_ac_10">
                  <?php echo $myarr[$arrAssoc['f_ac_10']]; ?>
                </div>
              </td>
            <td>Гц</td>
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
  include "./graphik/chart_off.php";
 ?>
