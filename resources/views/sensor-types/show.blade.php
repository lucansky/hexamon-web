@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">SensorType {{ $sensortype->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/sensor-types') }}" title="Back">
                            <button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                                Back
                            </button>
                        </a>
                        <a href="{{ url('/sensor-types/' . $sensortype->id . '/edit') }}" title="Edit SensorType">
                            <button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o"
                                                                      aria-hidden="true"></i> Edit
                            </button>
                        </a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['sensortypes', $sensortype->id],
                            'style' => 'display:inline'
                        ]) !!}
                        {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-xs',
                                'title' => 'Delete SensorType',
                                'onclick'=>'return confirm("Confirm delete?")'
                        ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $sensortype->id }}</td>
                                </tr>
                                <tr>
                                    <th> Name</th>
                                    <td> {{ $sensortype->name }} </td>
                                </tr>
                                <tr>
                                    <th> Font-awesome icon</th>
                                    <td> {{ $sensortype->fa_icon }} </td>
                                </tr>
                                <tr>
                                    <th> Default Offset</th>
                                    <td> {{ $sensortype->default_offset }} </td>
                                </tr>
                                <tr>
                                    <th> Default Factor</th>
                                    <td> {{ $sensortype->default_factor }} </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
