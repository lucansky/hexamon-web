@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($sensors as $sensor)
            <div class="row">
                <div class="col-md-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Sensor <b>{{ $sensor->index }}</b> ({{ $sensor->sensor_unit_serial }})
                            <a href="{{ url('/sensors/' . $sensor->id) }}" title="View Sensor">
                                <button class="btn btn-info btn-xs"><i class="fa fa-eye"
                                                                       aria-hidden="true"></i> View
                                </button>
                            </a>
                            <a href="{{ url('/sensors/' . $sensor->id . '/edit') }}" title="Edit Sensor">
                                <button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o"
                                                                          aria-hidden="true"></i> Edit
                                </button>
                            </a>
                        </div>
                        <div class="panel-body">
                            @php
                                $last_measurement = $sensor->measurements()->orderBy('id','desc')->first()
                            @endphp
                            <p>
                                {{ ($last_measurement) ? ($last_measurement->value) : ("N/A") }} g
                            </p>
                            <p>
                                {{ $sensor->comment }}
                            </p>
                            <p>
                                <span class="small">{{ ($last_measurement) ? ($last_measurement->raw_value) : ("N/A") }}</span><br>
                                {{ ($last_measurement) ? ($last_measurement->at) : ("N/A") }}
                            </p>

                            @if ($last_measurement)
                                <hr>
                                <b>Calibration</b>
                                <p>
                                    {!! Form::open([
                                       'method'=>'POST',
                                       'url' => ['/sensors', $sensor->id, 'calibrate'],
                                       'style' => 'display:inline'
                                    ]) !!}

                                    {!! Form::number('known_weight', null, ['style' => 'width:90%;', 'placeholder' => 'Known weight']) !!} in grams
                                    {!! Form::button('<i class="fa fa-cube" aria-hidden="true"></i> Calibrate', array(
                                            'type' => 'submit',
                                            'class' => 'btn btn-success btn-xs',
                                            'title' => 'Calibrate',
                                            'onclick'=>'return confirm("Really overwrite calibrating factor?")'
                                    )) !!}
                                    {!! Form::close() !!}



                                </p>
                                <p>
                                    <a href="{{ url('/sensors/' . $sensor->id . '/tare') }}" title="Tare">
                                        <button class="btn btn-warning btn-xs"><i class="fa fa-anchor"
                                                                                  aria-hidden="true"></i> Tare
                                        </button>
                                    </a>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-10 col-md-offset-0">
                    <div class="panel panel-default">
                        <!--<div class="panel-heading">
                        </div>-->
                        <div class="panel-body">
                            <!--<div class="pull-right">

                            </div>
                            <br>-->
                            <div id="{{ $sensor->id }}" style="height: 400px; min-width: 200px;background-color: gray;"></div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highstock/5.0.9/highstock.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highstock/5.0.9/js/modules/exporting.js"></script>

    <script>
        @foreach(\App\Sensor::all() as $sensor)
            $.getJSON('/sensors/{{ $sensor->id }}/data.json?callback=?', function (data) {
            // Create the chart
            Highcharts.stockChart('{{ $sensor->id }}', {
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

                title: {
                 text: '{{ $sensor->comment }}'
                 },

                plotOptions: {
                    line: {
                        connectNulls: false
                    }
                },

                navigator: {
                    enabled: true
                },

                series: [{
                    name: '{{ $sensor->comment }}',
                    data: data,
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.y} g</b> <br/>',
                        valueDecimals: 0
                    }
                }]
            });
        });
        @endforeach
    </script>

@endsection

