

<!DOCTYPE html>
<html lang="en">

<head>
        <title>Chart</title>
</head>

<body>
    
    <?php
    if(isset($_POST['id'])){$value_var = $_POST['id'];}//получаем переменную через ajax post
    ?>

    <div class="container">
                <div class="row">
                    <div id="viewSelectWrap">
                        View Select:

                                <input class="form-check-input" id="rdb1" type="radio" name="toggler" value="divID-1" style="cursor:pointer;" checked/>
                                <label class="form-check-label" for="flexRadioDefault1">Static</label>


                                <input class="form-check-input" id="rdb2" type="radio" name="toggler" value="divID-2" style="cursor:pointer;" />
                                <label class="form-check-label" for="flexRadioDefault1">Dinamically</label>

                    </div>
                </div>
                </div>
                <div class="row">
                   <div class="col-sm-12 col-md-10 col-lg-8">
                    <div id="divID-1" class="toHide" style="height: 400px; min-width: 310px"></div>
                   </div>
                   <div class="col-sm-12 col-md-2 col-lg-4"></div>
                </div>
    </div>



<script>

    var name_title = <?php echo json_encode($value_var);?>;
    console.log(name_title);
    var data = [];
    var value_num = 0;
    var timerId_chart = setInterval(function(){}, 1000);
    

    function static(){
        $.get('dataIndex.php',{chart_arg: name_title}, function(dat){
            clearInterval(timerId_chart);
            dat = JSON.parse(dat);
            data = dat['array'];
            value_num = dat['get_num_val'];
            // Create the chart
            $('#divID-1').highcharts('StockChart',{
            // Highcharts.stockChart('container1', {

                plotOptions: {
                series: {
                   turboThreshold: 0,
                    }
                },

                time: {
                        useUTC: false
                        },

                rangeSelector: {
                    inputDateFormat: '%Y-%m-%d %H:%M:%S',
                    inputEditDateFormat:'%Y-%m-%d %H:%M:%S',
                    inputBoxWidth: 150,
                    buttonTheme: {
                        width: 40
                    },
                    buttons: [{
                    count: 10,
                    type: 'second',
                    text: '10c'
                    },{
                    count: 20,
                    type: 'second',
                    text: '20c'
                    },{
                    count: 1,
                    type: 'minute',
                    text: '1M'
                    },{
                    count: 2,
                    type: 'minute',
                    text: '2M'
                    },{
                    count: 5,
                    type: 'minute',
                    text: '5M'
                    },{
                    count: 10,
                    type: 'minute',
                    text: '10M'
                    },{
                    count: 20,
                    type: 'minute',
                    text: '20M'
                    }, {
                    type: 'all',
                    text: 'All'
                    }],

                    inputEnabled: true,
                    selected: 7


                    },

                    title: {
                        text: "Charts for " + name_title
                    },

                    series: [{
                    name: name_title,
                    data: data,
                    tooltip: {
                        valueDecimals: 2
                             }
                        }]
                    });
                });
            }
            
    function dinamic(){        
        $.get('dataIndex.php',{chart_arg: name_title}, function(dat){
            clearInterval(timerId_chart);
            dat = JSON.parse(dat);
            data = dat['array'];
            value_num = dat['get_num_val'];
            // Create the chart
            $('#divID-1').highcharts('StockChart',{
                // Highcharts.stockChart('container2', {
                chart: {
                    events: {
                        load: function () {
                            // set up the updating of the chart each second
                            var series = this.series[0];
                            var lines = 0;
                            var lastline = 0;
                            timerId_chart = setInterval(function () {
                                function get_data_v(){
                                    $.get('dataIndex.php',{arg: name_title, val_arg: value_num}, function(data){
                                        data = JSON.parse(data);
                                        var x = Date.parse(data["time"]),
                                        y = Number(data["value"]);
                                        series.addPoint([x, y], true, true);
                                    });
                                }
                                get_data_v();
                            }, 1000);
                        }
                    }
                },

                plotOptions: {
                    series: {
                       turboThreshold: 0,
                        }
                    },

                time: {
                    useUTC: false
                },

                rangeSelector: {
                     inputDateFormat: '%Y-%m-%d %H:%M:%S',
                        inputEditDateFormat:'%Y-%m-%d %H:%M:%S',
                        inputBoxWidth: 150,
                        buttonTheme: {
                            width: 40
                        },
                        buttons: [{
                        count: 10,
                        type: 'second',
                        text: '10c'
                        },{
                        count: 20,
                        type: 'second',
                        text: '20c'
                        },{
                        count: 1,
                        type: 'minute',
                        text: '1M'
                        },{
                        count: 2,
                        type: 'minute',
                        text: '2M'
                        },{
                        count: 5,
                        type: 'minute',
                        text: '5M'
                        },{
                        count: 10,
                        type: 'minute',
                        text: '10M'
                        },{
                        count: 20,
                        type: 'minute',
                        text: '20M'
                        }, {
                        type: 'all',
                        text: 'All'
                        }],

                        inputEnabled: true,
                        selected: 7
                },

                title: {
                    text: "Dynamically updated data " + name_title
                },

                exporting: {
                    enabled: true
                },

                series: [{
                    name: name_title,
                    data: data,
                    tooltip: {
                            valueDecimals: 2
                                 }
                }]
            });
        });
    }
    $(document).ready(function(){
    static();
    });
    $(document).on('click', '#rdb1', function(){
        // clearInterval(timerId_chart);
        $("#divID-1").empty();
        static();
    });
    $(document).on('click', '#rdb2', function(){
        // clearInterval(timerId_chart);
        $("#divID-1").empty();
        dinamic();
    });
</script>

</body>
</html>
