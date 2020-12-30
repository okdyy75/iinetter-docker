<!-- Ref Tweet Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ref_tweet_id', 'Ref Tweet Id:') !!}
    {!! Form::number('ref_tweet_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Tweet Type Field -->
<div class="form-group col-sm-12">
    {!! Form::label('tweet_type', 'Tweet Type:') !!}
    <label class="radio-inline">
        {!! Form::radio('tweet_type', "tweet", null) !!} tweet
    </label>

    <label class="radio-inline">
        {!! Form::radio('tweet_type', "retweet", null) !!} retweet
    </label>

    <label class="radio-inline">
        {!! Form::radio('tweet_type', "reply", null) !!} reply
    </label>

</div>

<!-- Tweet Text Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('tweet_text', 'Tweet Text:') !!}
    {!! Form::textarea('tweet_text', null, ['class' => 'form-control','maxlength' => 255]) !!}
</div>

<!-- Reply Count Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reply_count', 'Reply Count:') !!}
    {!! Form::number('reply_count', 0, ['class' => 'form-control','min' => 0]) !!}
</div>

<!-- Retweet Count Field -->
<div class="form-group col-sm-6">
    {!! Form::label('retweet_count', 'Retweet Count:') !!}
    {!! Form::number('retweet_count', 0, ['class' => 'form-control','min' => 0]) !!}
</div>

<!-- Favorite Count Field -->
<div class="form-group col-sm-6">
    {!! Form::label('favorite_count', 'Favorite Count:') !!}
    {!! Form::number('favorite_count', 0, ['class' => 'form-control','min' => 0]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('tweets.index') }}" class="btn btn-default">Cancel</a>
</div>
