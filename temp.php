<?php
$mystring = '10.02.21 21:00:07 3 4 5 0 6 7 9';
$find = '21:00:07';
$pos = strpos($mystring, $find);

if ($pos === false) {
    echo "Строка '$find' не найдена";
} else {
    echo "Строка '$find' найдена<br>";
    $myarr = explode(" ", $mystring);
     for($i = 2; $i <= 8; $i++)
    {
       echo($myarr[$i]."<br>");
    }
}



$myArray = [];
$lines = explode(PHP_EOL, $myText);
$l = 0;
foreach($lines as $line) {
    $myArray[$l] = explode("\t", $line);
    $l++;
}


?>
