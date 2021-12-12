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
  <link rel="stylesheet" href="style_css/my_style.css">

  <title>ОПРЧ</title>
</head>

<body>

   <?php
   require 'db.php';
 if( isset($_SESSION['logged_user']) )
{ 
  if( $_SESSION['logged_user']->role == 'admin')
  {
    
    include 'dataAssociate.php';

    $lines = file("./logs/inv_log");
    $myarr = explode("\t", $lines[count($lines)-1]);

    include 'function.php';

    ?>

  <div class="container">
      <?php require "navbar.php";
      if( isset( $_POST['do_select']) )
      {
        if( isset($_POST['sel_oprh']) )
        {
          $_SESSION['sel_oprh'] = $_POST['sel_oprh'];
        }
      }
       ?>
  <br>

  <div class="row">
        <div class="col-sm-12 col-md-10 col-lg-8">
            <table class="table table-bordered">
               <tbody>
                  <tr class="tb_tr_t table-warning">
                    <td class="fw-bold text-center">
                      Авто обновление
                      <button type="button" onclick="setobn_oprch()" class="btn btn-outline-primary fw-bold">Включить</button>
                      <button type="button" onclick="setobnoff()"class="btn btn-outline-secondary fw-bold">Выключить</button> 
                    </td>
                  </tr>
               </tbody>  
            </table>
        </div>
  </div> 

   <?php 
      if( isset($sel_oprh) )
      { ?>
        <div class="row">
          <div class="col-sm-12 col-md-10 col-lg-8">
            <div class="alert alert-info sel_" role="alert">
             Выбранный режим работы:<br> <?php echo $sel_oprh; ?>
            </div>
          </div>
        </div>
<?php } ?>


    <?php 
      if( isset($_POST['do_input']) )
      {
        $err_input = [];

        if( isset($_POST['F']) && !is_numeric($_POST['F']) && $_POST['F'] != "" )
          {
            $err_input[] = 'Вееденное значение для Частоты не является числом';
          }

          if( isset($_POST['P']) && !is_numeric($_POST['P']) && $_POST['P'] != "" )
          {
            $err_input[] = 'Вееденное значение для Мощности не является числом';
          }


        if( isset($_POST['P']) && $_POST['P'] > 0 )
        {
          if( $_POST['P'] > 0 && $_POST['P'] <=255 && is_numeric($_POST['P']) )
          {
            $p = $_POST['P'];
            
          }else
          {
            $err_input[] = 'Неверное значение для вводимой Мощности(P) (Допустимый диапазон 0-255)';
          }
        }

        if( isset($_POST['F']) && $_POST['F'] > 0 )
        {
          if( $_POST['F'] >= 47.5 && $_POST['F'] <= 51.5 && is_numeric($_POST['F']) )
          {
            
            $f =preg_replace( "/,/", ".", $_POST['F'] );
            
          }else
          {
            $err_input[] = "Неверный диапазон для Частоты(F) (допустимый диапазон 47.5-51.5)";
          }
        }

        if( $err_input > 0 )
        { 

           foreach ($err_input as $error)
            { ?>
              <div class="row">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <div class="alert alert-danger sel_" role="alert">
                    
                  <?php    echo $error . '<br>' ;   ?>
                   
                  </div>
                </div>
              </div>
      <?php } 
        }
  }
     ?>
<div id="block">  
  <?php

    if( $_SESSION['sel_oprh'] ==  'Выкл.' )
    {
      require "tables/off.php";
      save_oprch( "" );
    }

    if( $_SESSION['sel_oprh'] ==  'P,F - инвертор' )
    {
      require "tables/pf_in.php";
      save_oprch( "regular" );
    }

    if( $_SESSION['sel_oprh'] ==  'P,F - анализатор' )
    {
      require "tables/pf_an.php";
      save_oprch( "regular_ac_10" );
    }

    if( $_SESSION['sel_oprh'] ==  'Отладка P, F - инвертор' )
    {
      
      if( !isset($err_input) )
      {
        if( isset($f) || isset($p) )
          {
            $inp = "debug";
            if ( isset($f) )
            {
              $inp .= " F=" . $f;
            }

            if ( isset($p) )
            {
              $inp .= " P=" . $p;
            }
            
            save_oprch($inp);
          }
      }else
      {
        if(sizeof($err_input) == 0)
        {
          if( isset($f) || isset($p) )
          {
            $inp = "debug";
            if ( isset($f) )
            {
              $inp .= " F=" . $f;
            }

            if ( isset($p) )
            {
              $inp .= " P=" . $p;
            }
            
            save_oprch($inp);
          }
        }
      } 

      if( !isset($_POST['do_input']) && !preg_match('/<m>.(debug [fp]=)/isU', f_read_oprch(), $matches))
      {
        save_oprch( "debug F=50" );
      }
    // require "tables/opf_in.php";  
    require "tables/opf_in.php";      
    }

    if( $_SESSION['sel_oprh'] ==  'Отладка P,F - анализатор' )
    {
      if( !isset($err_input) )
      {
        if( isset($f) || isset($p) )
          {
            $inp = "debug_ac_10";
            if ( isset($f) )
            {
              $inp .= " F=" . $f;
            }

            if ( isset($p) )
            {
              $inp .= " P=" . $p;
            }
            
            save_oprch($inp);
          }
      }else
      {
        if(sizeof($err_input) == 0)
        {
          if( isset($f) || isset($p) )
          {
            $inp = "debug_ac_10";
            if ( isset($f) )
            {
              $inp .= " F=" . $f;
            }

            if ( isset($p) )
            {
              $inp .= " P=" . $p;
            }
            
            save_oprch($inp);
          }
        }
      }
            
      if( !isset($_POST['do_input']) && !preg_match('/<m>.(debug_ac_10 [fp]=)/isU', f_read_oprch(), $matches) )
      {
        save_oprch( "debug_ac_10 F=50" );
      }
      // require "tables/opf_an.php";    
      require "tables/opf_an.php";    
    } ?>

    <?php
    if( !isset($_SESSION['sel_oprh']) )
    {
      preg_match('/<m>(.*)<\/m>/isU', f_read_oprch(), $matches);
      $status_oprch = trim($matches[1]);
      
      if( $status_oprch == "" )
      { 
        $_SESSION['sel_oprh'] = 'Выкл.';
        require "tables/off.php";
      }

      if( $status_oprch == "regular" )
      {
        $_SESSION['sel_oprh'] = 'P,F - инвертор';
        require "tables/pf_in.php";
      }

      if( $status_oprch == "regular_ac_10" )
      {
        $_SESSION['sel_oprh'] = 'P,F - анализатор';
        require "tables/pf_an.php";
      }

      if( preg_match('/<m>.(debug [fp]=)/isU', f_read_oprch(), $matches) )
      {
        $_SESSION['sel_oprh'] = 'Отладка P, F - инвертор';
        require "tables/opf_in.php";
      }

      if( preg_match('/<m>.(debug_ac_10 [fp]=)/isU', f_read_oprch(), $matches) )
      {
        $_SESSION['sel_oprh'] = 'Отладка P,F - анализатор';
        require "tables/opf_an.php";
      }
    }
   ?>
</div>
 <?php }else
      { ?>
        <div class="row">
          <div class="col-sm-12 col-md-10 col-lg-8">
            <div class="alert alert-danger sel_" role="alert">
             У вас не достаточно прав для просмотра данной страницы!
            </div>
          </div>
        </div>
     <?php } ?>

<?php }else
    { ?>
      <div class="row">
          <div class="col-sm-12 col-md-10 col-lg-8">
            <div class="alert alert-danger sel_" role="alert">
             Войдите под своей учетной записью!
            </div>
          </div>
        </div>
<?php } ?>
</div>
  <script src="jscript/myscript_oprch.js"></script>
  <script src="jscript/bootstrap.bundle.min.js"></script>
    
</body>
</html>

