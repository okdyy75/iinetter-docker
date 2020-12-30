<!-- Screen Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('screen_name', 'Screen Name:') !!}
    {!! Form::text('screen_name', null, ['class' => 'form-control','maxlength' => 255]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control','maxlength' => 255]) !!}
</div>

<!-- Location Field -->
<div class="form-group col-sm-6">
    {!! Form::label('location', 'Location:') !!}
    {!! Form::text('location', null, ['class' => 'form-control','maxlength' => 255]) !!}
</div>

<!-- Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('url', 'Url:') !!}
    {!! Form::text('url', null, ['class' => 'form-control']) !!}
</div>

<!-- Icon Field -->
<div class="form-group col-sm-6">
    {!! Form::label('icon', 'Icon:') !!}
    {!! Form::file('icon') !!}
</div>
<div class="clearfix"></div>

<!-- Header Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('header_image', 'Header Image:') !!}
    {!! Form::file('header_image') !!}
</div>
<div class="clearfix"></div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('userProfiles.index') }}" class="btn btn-default">Cancel</a>
</div>
