<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $userProfile->id }}</p>
</div>

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $userProfile->user_id }}</p>
</div>

<!-- Screen Name Field -->
<div class="form-group">
    {!! Form::label('screen_name', 'Screen Name:') !!}
    <p>{{ $userProfile->screen_name }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $userProfile->description }}</p>
</div>

<!-- Location Field -->
<div class="form-group">
    {!! Form::label('location', 'Location:') !!}
    <p>{{ $userProfile->location }}</p>
</div>

<!-- Url Field -->
<div class="form-group">
    {!! Form::label('url', 'Url:') !!}
    <p>{{ $userProfile->url }}</p>
</div>

<!-- Icon Field -->
<div class="form-group">
    {!! Form::label('icon', 'Icon:') !!}
    <p><img src="{{ $userProfile->icon_url }}"></p>
</div>

<!-- Header Image Field -->
<div class="form-group">
    {!! Form::label('header_image', 'Header Image:') !!}
    <p><img src="{{ $userProfile->header_image_url }}"></p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $userProfile->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $userProfile->updated_at }}</p>
</div>
