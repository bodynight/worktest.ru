
var timerId = setInterval(function(){}, 1000);
// var arrAssoc = [];

// $(document).ready(function(){
//    $.get('../dataAssociate.php',{letarr: 1},function(data){
//          arrAssoc = JSON.parse(data);
//       });
// });

function updateblock(obn){
   var arr_data = [];
   $.get('../dataIndex.php',{letarr: 'log'}, function(data) {
      arr_data = JSON.parse(data);
      $.each(arr_data, function(key, value){
         $(`#${key} .tb_tds`).html(value);
      });
   });
}

function setobn(val){
   clearInterval(timerId);
   if(val.value != 0){
      var obn = val.value;
      timerId = setInterval( updateblock, obn, obn);
   }
   
}

$(document).on('click', 'td', function () {
  if(this.id != 0){
      $.post('grafick.php',{id: this.id}, function(data){
                                                 $('#graf').empty();
                                                 $('#graf').append(data);
      });
   }
});


