<?php

  function update_log($log){

    $ar_file = file($log);//из файла получаем массив строк

    $fLine = array_shift($ar_file);  //извлекаем первую строку

    array_push($ar_file, array_shift($ar_file));// первый эл-т масива переносим в конец

    array_unshift($ar_file, $fLine);// возвращаем на место первую строку

    $lastLine = $ar_file[count($ar_file) - 1];//получаем последнюю строку

    $ar_string = explode("\t", $lastLine);//создание массива из строки

    $ar_string[0] = date("Y-m-d H:i:s"); //заменяем нулевой элемент на текущюю дату

    $ar_file[count($ar_file) - 1] = implode("\t", $ar_string);//из массива в строку

    $fp=fopen($log,"w");

      if (flock($fp, LOCK_EX)){ // установка исключительной блокировки на запись

        fputs($fp,implode("",$ar_file)) or die("Ошибка записи"); // из массива в текст и записываем

        flock($fp, LOCK_UN); // снятие блокировки
      }

    fclose($fp);
  }

  update_log("logs/inv_log");
  update_log("logs/dcdc_log");
  update_log("logs/janitza_diesel");
  echo 'Hello';

?>
  <script>
     window.setInterval(function(){location.reload();},800);//запуск самообновления лога
  </script>
