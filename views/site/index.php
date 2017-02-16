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
        <form>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="exampleSelect1">Example select</label>
                <select class="form-control" id="exampleSelect1">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
            <button type="button" class="btn btn-primary">Conectar</button>
        </form>
        <div id="container" style="height: 400px; min-width: 310px"></div>
    </div>
</div>
<script>
    var series = {
        name: 'Random data',
            data: (function () {
            // generate an array of random data
            var data = [],
                time = (new Date()).getTime(),
                i;
            for (i = -999; i <= 0; i += 1) {
                data.push([time + i * 1000,0]);
            }
            return data;
        }())
    };
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });
    var hc = Highcharts.stockChart('container', {
        /*chart: {
            events: {
                load: function (x, y) {
                    // set up the updating of the chart each second
                    //this.series[0].addPoint([x, y], true, true);
                    /*setInterval(function () {
                        var x = (new Date()).getTime(), // current time
                            y = Math.round(Math.random() * 10);
                        series.addPoint([x, y], true, true);
                    }, 1000);*-/
                }
            }
        },*/
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
            enabled: true
        },
        series: [series]
    });
    var addPointIntoSerie = function(x, y) {
        hc.series[0].addPoint([x, y], true, true);
    };
    var ws = new WebSocket('ws://localhost:8080/');
    ws.onopen = function() {
        document.body.style.backgroundColor = '#cfc';
    };
    ws.onclose = function() {
        document.body.style.backgroundColor = '#ff8982';
    };
    ws.onmessage = function(event) {
        var data = JSON.parse(event.data);
        switch (data.action) {
            case 'serialRead':
                addPointIntoSerie(data.data[0].timestamp, data.data[0].value);
                break;
            case 'serialAvailable':
//                alert(data.data);
                break;
        }
    };
</script>