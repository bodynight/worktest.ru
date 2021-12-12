<?php 

      function f_read_oprch()
  {  
    $file = "data/oprch.conf";
    $fp = fopen($file, "r");
    $str_log = fread($fp, filesize($file));
    fclose($fp);
    return $str_log;
  }

    function save_oprch($comand)
       {   
           if( $comand != "")
           {
            $comand = "\n" . $comand . "\n";
           }

           $file = "data/oprch.conf";

           $fp = fopen($file, "r");
           $str_log = fread($fp, filesize("data/oprch.conf"));
           $strpreg = preg_replace( '/(<m>).*(<\/m>)/isU',"$1".$comand."$2", $str_log);
           fclose($fp);

           $fp = fopen($file, "w");
            fwrite($fp, $strpreg) or die("Ошибка записи");
           fclose($fp);
       }

    function read_oprch($value)
      {   
          //получаем значение  из файла  oprch.conf между тэгами <m></m>
          $preg_m = preg_match('/<m>.*'.$value.'=(.*)\s.*<\/m>/isU', f_read_oprch(), $match);
          if( isset($match[1]))
          {
            $read_oprch = $match[1];
          }
          return $read_oprch;
      }

 ?>
