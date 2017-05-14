<div class="form-group {{ $errors->has('category_name') ? 'has-error' : ''}}">
    {!! Form::label('category_name', 'Category Name', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('category_name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('category_name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('sensor_id') ? 'has-error' : ''}}">
    {!! Form::label('sensor_id', 'Sensor Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('sensor_id', \App\Sensor::pluck('comment', 'id'), null, ['class' => 'form-control']) !!}
        {!! $errors->first('sensor_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
