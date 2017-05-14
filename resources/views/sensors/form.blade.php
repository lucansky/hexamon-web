<div class="form-group {{ $errors->has('sensor_unit_serial') ? 'has-error' : ''}}">
    {!! Form::label('sensor_unit_serial', 'Sensor Unit Serial', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('sensor_unit_serial', null, ['class' => 'form-control']) !!}
        {!! $errors->first('sensor_unit_serial', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('index') ? 'has-error' : ''}}">
    {!! Form::label('index', 'Index', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('index', null, ['class' => 'form-control']) !!}
        {!! $errors->first('index', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('sensor_type_id') ? 'has-error' : ''}}">
    {!! Form::label('sensor_type_id', 'Sensor Type Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('sensor_type_id', null, ['class' => 'form-control']) !!}
        {!! $errors->first('sensor_type_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('offset') ? 'has-error' : ''}}">
    {!! Form::label('offset', 'Offset', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('offset', null, ['class' => 'form-control']) !!}
        {!! $errors->first('offset', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('factor') ? 'has-error' : ''}}">
    {!! Form::label('factor', 'Factor', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('factor', null, ['class' => 'form-control']) !!}
        {!! $errors->first('factor', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
