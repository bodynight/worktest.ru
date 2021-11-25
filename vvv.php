<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
  <title>Document</title>
</head>
<body>
  <h1>Hello</h1>
<script>

  let value_num = "6";

 function get_values(value_num){

                        var data2 = [];

                        if (typeof value_num == "number") {
                            $.get("logs/inv_log", function(data){
                            let  arr = data.split('\n');
                            console.log('number');
                           for(let lines of arr){
                            var items = lines.split('\t');
                            // console.log(Date.parse(items[0]));
                            // console.log(Number(items[Number(value_num)]));
                            data2.push([
                                Date.parse(items[0]) ,
                                Number(items[value_num])
                            ]);
                           }
                           });
                        } else {
                            $.get("logs/dcdc_log", function(data){
                            let arr = data.split('\n');
                            console.log('text');
                            for(let lines of arr){
                                var items = lines.split('\t');
                                // console.log(items);
                                // console.log(value_num);
                                // console.log(Date.parse(items[0]));
                                // console.log(Number(items[Number(value_num)]));
                                data2.push([
                                    Date.parse(items[0]) ,
                                    Number(items[Number(value_num)])
                                ]);
                               }
                               });
                          }

                          return data2;

};

 console.log(get_values(value_num));
</script>
</body>
</html>
// function get_values(value_num){

    //                     var data2 = [];

    //                     if (typeof value_num == "number") {
    //                         $.get("logs/inv_log", function(data){
    //                         let  arr = data.split('\n');
    //                         console.log('number');
    //                        for(let lines of arr){
    //                         var items = lines.split('\t');

    //                         data2.push([
    //                             Date.parse(items[0]) ,
    //                             Number(items[value_num])
    //                         ]);
    //                        }
    //                        });
    //                     } else {
    //                         $.get("logs/dcdc_log", function(data){
    //                         let arr = data.split('\n');
    //                         console.log('text');
    //                         for(let lines of arr){
    //                             var items = lines.split('\t');

    //                             data2.push([
    //                                 Date.parse(items[0]) ,
    //                                 Number(items[Number(value_num)])
    //                             ]);
    //                            }
    //                            });
    //                       }

    //                       return data2;}
    // var data2 = get_values(value_num);
    // console.log(data2);
