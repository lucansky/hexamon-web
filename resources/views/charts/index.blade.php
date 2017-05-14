@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                @foreach(\App\Chart::all()->groupBy('category_name') as $category_name => $chart_list)
                    <div class="panel panel-default">
                        <div class="panel-heading">{{ $category_name }}</div>
                        <div class="panel-body">
                            <div id="{{ md5($category_name) }}" style="height: 400px; min-width: 310px"></div>
                        </div>
                    </div>
                    <!-- {{ $category_name }} -->
                @endforeach
                {{-- @endforeach --}}

                <hr>
                <div class="panel panel-default">
                    <div class="panel-heading">Charts</div>
                    <div class="panel-body">
                        <a href="{{ url('/charts/create') }}" class="btn btn-success btn-sm" title="Add New Chart">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category Name</th>
                                        <th>Sensor Id</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($charts as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->category_name }}</td>
                                        <td>{{ $item->sensor->sensor_unit_serial }} # {{ $item->sensor->index }} ({{ $item->sensor->comment }}) </td>
                                        <td>
                                            <a href="{{ url('/charts/' . $item->id) }}" title="View Chart"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/charts/' . $item->id . '/edit') }}" title="Edit Chart"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/charts', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete Chart',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

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
        var sensor_data = {!! $sensor_categories !!};

        @foreach($sensor_categories as $sensor_category_name => $sensors)
            @php $hashed_name = md5($sensor_category_name) @endphp

            var seriesOptions{{ $hashed_name }} = [];
            var seriesCounter{{ $hashed_name }} = 0;

            function createChart{{ $hashed_name }}() {
                Highcharts.stockChart('{{ $hashed_name }}', {
                    rangeSelector: {
                        buttons: [{
                            type: 'hour',
                            count: 1,
                            text: '1H'
                        }, {
                            type: 'day',
                            count: 1,
                            text: '1D'
                        }, {
                            type: 'day',
                            count: 3,
                            text: '3D'
                        }, {
                            type: 'day',
                            count: 7,
                            text: '7D'
                        }, {
                            type: 'month',
                            count: 1,
                            text: '1M'
                        }, {
                            type: 'month',
                            count: 6,
                            text: '6M'
                        }, {
                            type: 'year',
                            count: 1,
                            text: '1Y'
                        }, {
                            type: 'all',
                            text: 'All'
                        }],
                        inputEnabled: true,
                        selected: 1
                    },

                    /*yAxis: {
                        plotLines: [{
                            value: 0,
                            width: 2,
                            color: 'silver'
                        }],
                        min: 0
                    },*/
                    yAxis: [{
                        lineWidth: 1,
                        title: {
                            text: 'Váha'
                        },
                        min: 0
                    }],
                    legend: {
                        enabled: true
                    },
                    plotOptions: {
                        series: {
                            showInNavigator: true
                        },
                        line: {
                            connectNulls: false
                        }
                    },
                    tooltip: {
                        pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y} g</b> <br/>',
                        valueDecimals: 2,
                        split: true
                    },

                    series: seriesOptions{{ $hashed_name }}
                });
            }

            $.each(sensor_data['{!! $sensor_category_name !!}'], function (i, sensor) {
                //$.getJSON('https://www.highcharts.com/samples/data/jsonp.php?filename=' + name.toLowerCase() + '-c.json&callback=?', function (data) {
                $.getJSON('/sensors/'+ sensor['sensor_id'].toString().toLowerCase() +'/data.json?callback=?', function (data) {

                    seriesOptions{{ $hashed_name }}[i] = {
                        name: sensor['sensor_comment'],
                        data: data
                    };

                    // As we're loading the data asynchronously, we don't know what order it will arrive. So
                    // we keep a counter and create the chart when all the data is loaded.
                    seriesCounter{{ $hashed_name }} += 1;

                    if (seriesCounter{{ $hashed_name }} === sensor_data['{!! $sensor_category_name !!}'].length) {
                        createChart{{ $hashed_name }}();
                    }
                });
            });
        @endforeach
    </script>

@endsection
