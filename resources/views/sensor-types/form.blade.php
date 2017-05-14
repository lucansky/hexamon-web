<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('unit_name') ? 'has-error' : ''}}">
    {!! Form::label('unit_name', 'Názov jednotky (kg, g, ...)', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('unit_name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('unit_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('fa_icon') ? 'has-error' : ''}}">
    {!! Form::label('unit_name', 'Font-awesome ikona (fa-....)', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('fa_icon', null, ['class' => 'form-control']) !!}
        {!! $errors->first('fa_icon', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('default_offset') ? 'has-error' : ''}}">
    {!! Form::label('default_offset', 'Default Offset', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('default_offset', null, ['class' => 'form-control']) !!}
        {!! $errors->first('default_offset', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('default_factor') ? 'has-error' : ''}}">
    {!! Form::label('default_factor', 'Default Factor', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('default_factor', null, ['class' => 'form-control']) !!}
        {!! $errors->first('default_factor', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
