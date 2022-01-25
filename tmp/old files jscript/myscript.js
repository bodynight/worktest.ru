
var timerId = setInterval(function(){}, 1000);
var date_time = 0;
function updateblock(date){
  if(date == undefined){
    date = 0;
  }
  console.log(date);
   $.get('../dataIndex.php',{letarr: 'log', date: date}, function(data) {
      data = JSON.parse(data);
      var arr_data = data['arr_data'];
      var ar_error = data['ar_error'];
      $.each(arr_data, function(key, value){
         $(`#${key} .tb_tds`).html(value);
      });
      $('#error_mes').empty();
      if(ar_error != 0){
          $.each(ar_error, function(key, value){
             $("#error_mes").append(`<div class="col-sm-12 col-md-10 col-lg-8"><div class="alert alert-danger dalert" role="alert">${key}: ${value}</div></div>`);
          });
      }
   });
}

function setobn(val){
   clearInterval(timerId);
   if(val.value != 0){
      var obn = val.value;
      timerId = setInterval( updateblock, obn);
   }
   
}

$('#datetimepicker_select').datetimepicker({
            lang:'ru',
            dayOfWeekStart: 1,
            step:1,
            format:'Y-m-d H:i:s',
            onChangeDateTime:function(dp,$input){
              date_time = $input.val();
            }
        });

$(document).ready(function(){
   updateblock();
});

$(document).on('click', '#btn-submit1', function(){
  if(date_time != 0){
    clearInterval(timerId);
    $("#radio_off").prop("checked", true);
    updateblock(date_time);
  }

});

$(document).on('click', 'td', function () {
  if(this.id != 0){
      $.post('grafick.php',{id: this.id}, function(data){
                                                 $('#graf').empty();
                                                 $('#graf').append(data);
      });
   }
});


