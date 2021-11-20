<?php

$ar_file = file("logs/inv_log");//из файла получаем массив строк
array_push($ar_file, array_shift($ar_file));// первый эл-т масива переносим в конец

$lastLine = $ar_file[count($ar_file) - 1];//получаем последнюю строку
$ar_string = explode("\t", $lastLine);//создание массива из строки
$ar_string[0] = date("Y-m-d H:i:s"); //заменяем нулевой элемент на текущюю дату
$ar_file[count($ar_file) - 1] = implode("\t", $ar_string);//из массива в строку
$fp=fopen("logs/inv_log","w");
if (flock($fp, LOCK_EX)) // установка исключительной блокировки на запись
{
fputs($fp,implode("",$ar_file)) or die("Ошибка записи"); // из массива в текст и записываем
flock($fp, LOCK_UN); // снятие блокировки
}
fclose($fp);
echo $ar_file;

 ?>

 <script>
  var i = 0;
   window.setInterval(function(){location.reload();console.log(i);i++;},1000);//запуск самообновления лога
 </script>
