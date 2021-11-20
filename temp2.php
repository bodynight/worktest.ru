<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="jscript/jquery.js"></script>
  <title>Document</title>
</head>
<body>


<!-- score data here -->

          <p>Зависимые переключатели (radio):</p>
        <p>
        <input onclick="setobn(this)" name="radiobutton" type="radio" value="1000">1c
        <input onclick="setobn(this)" name="radiobutton" type="radio" value="5000">5c
        <input onclick="setobn(this)" name="radiobutton" type="radio" value="10000">10c
        <input onclick="setobn(this)" name="radiobutton" type="radio" value="60000">60c
        </p>



         <div id="block">
          <?php
           date_default_timezone_set('Europe/Moscow');
              $date = date('Y-m-d H:i:s a', time()); ?>
              <p>Date time: <?php echo $date; ?> </p>

           <p>Зависимые переключатели (radio):</p>
        <p>
        <input  name="radiobutton2" type="radio" value="1000">1c
        <input  name="radiobutton2" type="radio" value="5000">5c
        <input  name="radiobutton2" type="radio" value="1000">10c
        <input  name="radiobutton2" type="radio" value="60000">60c
        </p>

        </div>

        <script>
          var timerId = setInterval(function(){}, 1000);
          function updateblock(obn){ $("#block").load("temp2.php #block"); console.log(obn); }

          function setobn(val){
            var obn = val.value;
            console.log(obn);
            clearInterval(timerId);
            timerId = setInterval( updateblock, obn, obn);}
        </script>

</body>
</html>


