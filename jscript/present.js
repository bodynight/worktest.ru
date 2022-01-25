var f_image = "url(../image/maket.jpg)";
function get_width(){
       if($(window).width() <576){
         $('#fon').css({"height": "310px"});
         $('#sol_pan').css({ "position":"relative", "top": "-4%", "left": "34%"});
         $('#dg_out').css({ "position":"relative", "top": "-38%", "left": "34%"});
         $('#d_ac_in').css({ "position":"relative", "top": "-106%", "left": "52%"});
         $('#d_ac_out').css({ "position":"relative", "top": "-174%", "left": "73%"});
         $('#batary').css({ "position":"relative", "top": "-205%", "left": "11%"});
         $('#dc_dc_out').css({ "position":"relative", "top": "-273%", "left": "34%"});
       }else if($(window).width() >=576 && $(window).width() < 768){
         $('#fon').css({"height": "288px"});
         $('#sol_pan').css({ "position":"relative", "top": "-5%", "left": "33%"});
         $('#dg_out').css({ "position":"relative", "top": "-44%", "left": "33%"});
         $('#d_ac_in').css({ "position":"relative", "top": "-117%", "left": "51%"});
         $('#d_ac_out').css({ "position":"relative", "top": "-190%", "left": "73%"});
         $('#batary').css({ "position":"relative", "top": "-226%", "left": "10%"});
         $('#dc_dc_out').css({ "position":"relative", "top": "-299%", "left": "33%"});
       }else if($(window).width() >=768 && $(window).width() < 992){
         $('#fon').css({"height": "320px"});
         $('#sol_pan').css({ "position":"relative", "top": "-3%", "left": "34%"});
         $('#dg_out').css({ "position":"relative", "top": "-35%", "left": "34%"});
         $('#d_ac_in').css({ "position":"relative", "top": "-101%", "left": "52%"});
         $('#d_ac_out').css({ "position":"relative", "top": "-166%", "left": "74%"});
         $('#batary').css({ "position":"relative", "top": "-194%", "left": "12%"});
         $('#dc_dc_out').css({ "position":"relative", "top": "-259.5%", "left": "34%"});
       }else if($(window).width() >= 992 && $(window).width() < 1200){
         $('#fon').css({"height": "345px"});
         $('#sol_pan').css({ "position":"relative", "top": "-2%", "left": "35%"});
         $('#dg_out').css({ "position":"relative", "top": "-29%", "left": "35%"});
         $('#d_ac_in').css({ "position":"relative", "top": "-90%", "left": "53%"});
         $('#d_ac_out').css({ "position":"relative", "top": "-151%", "left": "75%"});
         $('#batary').css({ "position":"relative", "top": "-175%", "left": "12%"});
         $('#dc_dc_out').css({ "position":"relative", "top": "-235%", "left": "35%"});
       }else if($(window).width() >= 1200 && $(window).width() < 1400){
         $('#fon').css({"height": "410px"});
         $('#sol_pan').css({ "position":"relative", "top": "1%", "left": "37%"});
         $('#dg_out').css({ "position":"relative", "top": "-16%", "left": "37%"});
         $('#d_ac_in').css({ "position":"relative", "top": "-67%", "left": "54%"});
         $('#d_ac_out').css({ "position":"relative", "top": "-118%", "left": "76%"});
         $('#batary').css({ "position":"relative", "top": "-133%", "left": "14%"});
         $('#dc_dc_out').css({ "position":"relative", "top": "-184%", "left": "36%"});
       }else if($(window).width() >= 1400){
         $('#fon').css({"height": "490px"});
         $('#sol_pan').css({ "position":"relative", "top": "3%", "left": "39%"});
         $('#dg_out').css({ "position":"relative", "top": "-7%", "left": "39%"});
         $('#d_ac_in').css({ "position":"relative", "top": "-50%", "left": "55%"});
         $('#d_ac_out').css({ "position":"relative", "top": "-93%", "left": "77%"});
         $('#batary').css({ "position":"relative", "top": "-99%", "left": "15%"});
         $('#dc_dc_out').css({ "position":"relative", "top": "-142%", "left": "37%"});
       }
}
$(document).ready(function(){
   $('#fon').css({"background-image": f_image,"background-size": "cover"});
   get_width();
});
$(window).resize(function() {
    get_width();
});

var gaugeOptions = {
    chart: {
        type: 'solidgauge',
        backgroundColor: 'transparent'
    },

    title: null,

    pane: {
         center: ['25%', '25%'], 
        size: '45%',
        startAngle: -90,
        endAngle: 90,
        background: {
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
            innerRadius: '60%',
            outerRadius: '100%',
            shape: 'arc'
        }
    },

    exporting: {
        enabled: false
    },

    tooltip: {
        enabled: false
    },

    // the value axis
    yAxis: {
        stops: [
            [0.1, '#55BF3B'], // green
            [0.5, '#DDDF0D'], // yellow
            [0.9, '#DF5353'] // red
        ],
        lineWidth: 0,
        tickWidth: 0,
        minorTickInterval: null,
        tickAmount: 1,
        title: {
            y: -23
        },
        labels: {
            y: 8
        }
    },

    plotOptions: {
        solidgauge: {
            dataLabels: {
                y: -13,
                borderWidth: 0,
                useHTML: true
            }
        }
    }
};

// The sol_pan
var sol_pan = Highcharts.chart('sol_pan', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 250,
        labels:{
                distance: -8,
                style: {
                    "fontSize": "6px",
                    opacity: 0.5
                }
        },
        // title: {
        //     text: 'Мощность',
        //     style: {
        //             "fontSize": "6px",
        //             opacity: 0.6
        //     }
        // }
    },

    credits: {
        enabled: false
    },

    series: [{
        name: 'Мощность',
        data: [0],
        dataLabels: {
            format:
                '<div style="text-align:center;line-height:7px">' +
                '<span style="font-size:14px">{y:.1f}</span><br/>' +
                '<span style="font-size:6px;opacity:0.7">P(кВт)</span>' +
                '</div>'
        },
        tooltip: {
            valueSuffix: 'кВт'
        }
    }]

}));

// The dg_out
var dg_out = Highcharts.chart('dg_out', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 125,
         labels:{
                distance: -8,
                style: {
                    "fontSize": "6px",
                    opacity: 0.5
                }
        },
        // title: {
        //     text: 'Мощность',
        //     style: {
        //             "fontSize": "6px",
        //             opacity: 0.6
        //     }
        // }
    },

    credits: {
        enabled: false
    },

    series: [{
        name: 'Мощность',
        data: [0],
        dataLabels: {
            format:
                '<div style="text-align:center;line-height:7px">' +
                '<span style="font-size:14px">{y}</span><br/>' +
                '<span style="font-size:6px;opacity:0.7">P(кВт)</span>' +
                '</div>'
        },
        tooltip: {
            valueSuffix: 'кВт'
        }
    }]

}));

// The d_ac_in
var d_ac_in = Highcharts.chart('d_ac_in', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 250,
        labels:{
                distance: -8,
                style: {
                    "fontSize": "6px",
                    opacity: 0.5
                }
        },
        // title: {
        //     text: 'Мощность',
        //     style: {
        //             "fontSize": "6px",
        //             opacity: 0.6
        //     }
        // }
    },

    credits: {
        enabled: false
    },

    series: [{
        name: 'Мощность',
        data: [0],
        dataLabels: {
            format:
                '<div style="text-align:center;line-height:7px">' +
                '<span style="font-size:14px">{y}</span><br/>' +
                '<span style="font-size:6px;opacity:0.7">P(кВт)</span>' +
                '</div>'
        },
        tooltip: {
            valueSuffix: 'кВт'
        }
    }]

}));

// The d_ac_out
var d_ac_out = Highcharts.chart('d_ac_out', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 250,
        labels:{
                distance: -8,
                style: {
                    "fontSize": "6px",
                    opacity: 0.5
                }
        },
        // title: {
        //     text: 'Мощность',
        //     style: {
        //             "fontSize": "6px",
        //             opacity: 0.6
        //     }
        // }
    },

    credits: {
        enabled: false
    },

    series: [{
        name: 'Мощность',
        data: [0],
        dataLabels: {
            format:
                '<div style="text-align:center;line-height:7px">' +
                '<span style="font-size:14px">{y}</span><br/>' +
                '<span style="font-size:6px;opacity:0.7">P(кВт)</span>' +
                '</div>'
        },
        tooltip: {
            valueSuffix: 'кВт'
        }
    }]

}));

// The batary
var batary = Highcharts.chart('batary', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 120,
        labels:{
                distance: -8,
                style: {
                    "fontSize": "6px",
                    opacity: 0.5
                }
        },
        // title: {
        //     text: 'Мощность',
        //     style: {
        //             "fontSize": "6px",
        //             opacity: 0.6
        //     }
        // }
    },

    credits: {
        enabled: false
    },

    series: [{
        name: 'Мощность',
        data: [0],
        dataLabels: {
            format:
                '<div style="text-align:center;line-height:7px">' +
                '<span style="font-size:14px">{y}</span><br/>' +
                '<span style="font-size:6px;opacity:0.7">P(кВт)</span>' +
                '</div>'
        },
        tooltip: {
            valueSuffix: 'кВт'
        }
    }]

}));

// The dc_dc_out
var dc_dc_out = Highcharts.chart('dc_dc_out', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 250,
        labels:{
                distance: -8,
                style: {
                    "fontSize": "6px",
                    opacity: 0.5
                }
        },
        // title: {
        //     text: 'Мощность',
        //     style: {
        //             "fontSize": "6px",
        //             opacity: 0.6
        //     }
        // }
    },

    credits: {
        enabled: false
    },

    series: [{
        name: 'Мощность',
        data: [0],
        dataLabels: {
            format:
                '<div style="text-align:center;line-height:7px">' +
                '<span style="font-size:14px">{y:.1f}</span><br/>' +
                '<span style="font-size:6px;opacity:0.7">P(кВт)</span>' +
                '</div>'
        },
        tooltip: {
            valueSuffix: 'кВт'
        }
    }]

}));

// Bring life to the dials
setInterval(function () {
     $.get('../dataIndex.php',{present: 'present'}, function(data) {
        data = JSON.parse(data);
   
        var point,
            newVal,
            inc;

         // sol_pan
        if (sol_pan) {
            point = sol_pan.series[0].points[0];
            point.update(Math.abs(data['fem']));
        }

        // dg_out
        if (dg_out) {
            point = dg_out.series[0].points[0];
            point.update(Math.abs(data['jd_p']));
        }

         // d_ac_in
        if (d_ac_in) {
            point = d_ac_in.series[0].points[0];
            point.update(Math.abs(data['pv_p']));
        }

         // d_ac_out
        if (d_ac_out) {
            point = d_ac_out.series[0].points[0];
            point.update(Math.abs(data['ac_p']));
        }
         // batary
        if (batary) {
            point = batary.series[0].points[0];
            point.update(Math.abs(data['pdc_dc_out']));
        }

         // batary
        if (dc_dc_out) {
            point = dc_dc_out.series[0].points[0];
            point.update(Math.abs(data['pdc_dc_out']));
        }
    });
}, 2000);
