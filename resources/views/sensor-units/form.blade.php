<div class="form-group {{ $errors->has('serial') ? 'has-error' : ''}}">
    {!! Form::label('serial', 'Serial', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('serial', null, ['class' => 'form-control']) !!}
        {!! $errors->first('serial', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'Description', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('description', null, ['class' => 'form-control']) !!}
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('last_seen') ? 'has-error' : ''}}">
    {!! Form::label('last_seen', 'Last Seen', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::input('datetime-local', 'last_seen', null, ['class' => 'form-control']) !!}
        {!! $errors->first('last_seen', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
