

 var timerId = setInterval(function(){}, 1000);
function updateblock(obn){ $("#block").load("index.php #block"); console.log(obn); }

function setobn(val){
var obn = val.value;
console.log(obn);
clearInterval(timerId);
timerId = setInterval( updateblock, obn, obn);}

$('td').click(function(){
  if(this.id != 0){

  $.post('grafick.php',{id: this.id}, function(data){ $('#graf').empty();
                                                       $('#graf').append(data);
                                                       console.log('est!');});
                    }
});
