@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Sensor {{ $sensor->sensor_unit_serial }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/sensors') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/sensors/' . $sensor->sensor_unit_serial . '/edit') }}" title="Edit Sensor"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['sensors', $sensor->sensor_unit_serial],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Sensor',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $sensor->sensor_unit_serial }}</td>
                                    </tr>
                                    <tr><th> Sensor Unit Serial </th><td> {{ $sensor->sensor_unit_serial }} </td></tr><tr><th> Index </th><td> {{ $sensor->index }} </td></tr><tr><th> Sensor Type Id </th><td> {{ $sensor->sensor_type_id }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Sensor {{ $sensor->sensor_unit_serial }}</div>
                    <div class="panel-body">

                        <div id="container" style="height: 400px; min-width: 310px"></div>

{{--                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    @foreach($measurements as $measurement)
                                        <tr>
                                            <td>{{ $measurement->at }}</td>
                                            <td>{{ $measurement->value }}</td>
                                            <td>{{ $measurement->raw_value }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>--}}

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highstock/5.0.9/highstock.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highstock/5.0.9/js/modules/exporting.js"></script>

    <script>
        var seriesOptions = [],
                seriesCounter = 0,
                names = ['1'];

        /**
         * Create the chart when all data is loaded
         * @returns {undefined}
         */
        function createChart() {

            Highcharts.stockChart('container', {

                rangeSelector: {
                    selected: 4
                },

                yAxis: {
                    /*labels: {
                        formatter: function () {
                            return (this.value > 0 ? ' + ' : '') + this.value + '%';
                        }
                    },*/
                    plotLines: [{
                        value: 0,
                        width: 2,
                        color: 'silver'
                    }],
                    min: 0
                },

                plotOptions: {
                    series: {
                        //compare: 'percent',
                        showInNavigator: true
                    }
                },

                tooltip: {
                    pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.change}%)<br/>',
                    valueDecimals: 2,
                    split: true
                },

                series: seriesOptions
            });
        }

        $.each(names, function (i, name) {
            //$.getJSON('https://www.highcharts.com/samples/data/jsonp.php?filename=' + name.toLowerCase() + '-c.json&callback=?', function (data) {
            $.getJSON('/sensors/'+ name.toLowerCase() +'/data.json?callback=?', function (data) {

                seriesOptions[i] = {
                    name: name,
                    data: data
                };

                // As we're loading the data asynchronously, we don't know what order it will arrive. So
                // we keep a counter and create the chart when all the data is loaded.
                seriesCounter += 1;

                if (seriesCounter === names.length) {
                    createChart();
                }
            });
        });
    </script>

@endsection
