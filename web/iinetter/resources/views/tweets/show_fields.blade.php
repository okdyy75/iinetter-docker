<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $tweet->id }}</p>
</div>

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $tweet->user_id }}</p>
</div>

<!-- Ref Tweet Id Field -->
<div class="form-group">
    {!! Form::label('ref_tweet_id', 'Ref Tweet Id:') !!}
    <p>{{ $tweet->ref_tweet_id }}</p>
</div>

<!-- Tweet Type Field -->
<div class="form-group">
    {!! Form::label('tweet_type', 'Tweet Type:') !!}
    <p>{{ $tweet->tweet_type }}</p>
</div>

<!-- Tweet Text Field -->
<div class="form-group">
    {!! Form::label('tweet_text', 'Tweet Text:') !!}
    <p>{{ $tweet->tweet_text }}</p>
</div>

<!-- Reply Count Field -->
<div class="form-group">
    {!! Form::label('reply_count', 'Reply Count:') !!}
    <p>{{ $tweet->reply_count }}</p>
</div>

<!-- Retweet Count Field -->
<div class="form-group">
    {!! Form::label('retweet_count', 'Retweet Count:') !!}
    <p>{{ $tweet->retweet_count }}</p>
</div>

<!-- Favorite Count Field -->
<div class="form-group">
    {!! Form::label('favorite_count', 'Favorite Count:') !!}
    <p>{{ $tweet->favorite_count }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $tweet->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $tweet->updated_at }}</p>
</div>

