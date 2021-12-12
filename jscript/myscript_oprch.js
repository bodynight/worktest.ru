var timerIdo = setInterval(function(){}, 1000);

function updateblock_oprch(obno)
{
   $("#block").load("../oprch.php #block");
   console.log(obno); 
}

function setobn_oprch(){
var obno = 1000;
console.log(obno);
clearInterval(timerIdo);
timerIdo = setInterval( updateblock_oprch, obno, obno);}

function setobnoff()
{
  clearInterval(timerIdo);
  // Перезагрузить текущую страницу
  document.location.reload(); 
}
