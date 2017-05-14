<div class="col-md-3">
    <!--<div class="panel panel-default panel-flush">
        <div class="panel-heading">
            Sidebar
        </div>

        <div class="panel-body">
            <ul class="nav" role="tablist">
                <li role="presentation">
                    <a href="{{ url('/sensor-types') }}">
                        Typy senzorov
                    </a>
                </li>
                <hr>
                <li role="presentation">
                    <a href="{{ url('/gateways') }}">
                        Zberné jednotky
                    </a>
                </li>
                <li role="presentation">
                    <a href="{{ url('/sensor-units') }}">
                        Senzoricke jednotky
                    </a>
                </li>
                <li role="presentation">
                    <a href="{{ url('/sensors') }}">
                        Senzory
                    </a>
                </li>
                <li role="presentation">
                    <a href="{{ url('/measurements') }}">
                        Merania
                    </a>
                </li>
            </ul>
        </div>
    </div>-->

    @foreach(\App\Chart::all()->groupBy('category_name') as $category_name => $charts)
        <div class="panel panel-default panel-flush">
            <div class="panel-heading">
                {{ $category_name }} <span class="small" style="color: green;"></span>
            </div>

            <div class="panel-body">
                <ul class="nav" role="tablist">
                    @foreach($charts as $chart)
                        <li role="presentation">
                            <a href="{{ url('/sensors/'.$chart->sensor_id) }}">
                                @php
                                    $last_measurement = $chart->sensor->measurements()->orderBy('id','desc')->first()
                                @endphp
                                {{ $chart->sensor->comment }} ({{ $chart->sensor->sensor_unit_serial }}#{{ $chart->sensor->index }})
                                @if($last_measurement)
                                    <b>{{ round($last_measurement->value) }} g</b>
                                @endif
                                <br>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>
