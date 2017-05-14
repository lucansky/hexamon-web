<div class="form-group {{ $errors->has('sensor_id') ? 'has-error' : ''}}">
    {!! Form::label('sensor_id', 'Sensor Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('sensor_id', null, ['class' => 'form-control']) !!}
        {!! $errors->first('sensor_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('at') ? 'has-error' : ''}}">
    {!! Form::label('at', 'At', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::input('datetime-local', 'at', null, ['class' => 'form-control']) !!}
        {!! $errors->first('at', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('value') ? 'has-error' : ''}}">
    {!! Form::label('value', 'Value', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('value', null, ['class' => 'form-control']) !!}
        {!! $errors->first('value', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('raw_value') ? 'has-error' : ''}}">
    {!! Form::label('raw_value', 'Raw Value', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('raw_value', null, ['class' => 'form-control']) !!}
        {!! $errors->first('raw_value', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
