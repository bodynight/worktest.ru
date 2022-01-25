function get_width(){
   if($(window).width() <576){
       $('#fon').css({"height": "300px"});
       }else if($(window).width() >=576 && $(window).width() < 768){
       $('#fon').css({"height": "310px"});
       }else if($(window).width() >=768 && $(window).width() < 992){
       $('#fon').css({"height": "350px"});
       }else if($(window).width() >= 992 && $(window).width() < 1200){
         $('#fon').css({"height": "380px"});
       }else if($(window).width() >= 1200 && $(window).width() < 1400){
         $('#fon').css({"height": "450px"});
       }else if($(window).width() >= 1400 ){
         $('#fon').css({"height": "580px"});
}
$(document).ready(function(){
   $('#fon').css({"background-image": "url(../image/макет.JPG)","background-size": "cover"});
   get_width();
});
$(window).resize(function() {
    get_width();
  });
