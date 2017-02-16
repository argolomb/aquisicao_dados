<?php
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<div class="site-index">
    <div class="jumbotron">
        <h1>Gráfico</h1>
    </div>
    <div class="body-content">
        <div id="container" style="height: 400px; min-width: 310px"></div>
    </div>
</div>
<script>
    var ws = new WebSocket('ws://localhost:8080/');
    ws.onopen = function() {
        document.body.style.backgroundColor = '#cfc';
    };
    ws.onclose = function() {
        document.body.style.backgroundColor = null;
    };
    ws.onmessage = function(event) {
        var data = event.data;
    };
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });
    Highcharts.stockChart('container', {
        chart: {
            events: {
                load: function () {
                    // set up the updating of the chart each second
                    var series = this.series[0];
                    setInterval(function () {
                        var x = (new Date()).getTime(), // current time
                            y = Math.round(Math.random() * 10);
                        series.addPoint([x, y], true, true);
                    }, 1000);
                }
            }
        },
        rangeSelector: {
            buttons: [{
                count: 1,
                type: 'minute',
                text: '1M'
            }, {
                count: 5,
                type: 'minute',
                text: '5M'
            }, {
                type: 'all',
                text: 'All'
            }],
            inputEnabled: false,
            selected: 0
        },
        title: {
            text: 'Live random data'
        },
        exporting: {
            enabled: false
        },
        series: [{
            name: 'Random data',
            data: (function () {
                // generate an array of random data
                var data = [],
                    time = (new Date()).getTime(),
                    i;

                for (i = -999; i <= 0; i += 1) {
                    data.push([
                        time + i * 1000,
                        Math.round(Math.random() * 10)
                    ]);
                }
                return data;
            }())
        }]
    });
</script>