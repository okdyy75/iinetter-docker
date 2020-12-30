<div class="table-responsive">
    <table class="table" id="tweets-table">
        <thead>
            <tr>
                <th>Id</th>
        <th>User Id</th>
        <th>Ref Tweet Id</th>
        <th>Tweet Type</th>
        <th>Tweet Text</th>
        <th>Reply Count</th>
        <th>Retweet Count</th>
        <th>Favorite Count</th>
        <th>Created At</th>
        <th>Updated At</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tweets as $tweet)
            <tr>
                <td>{{ $tweet->id }}</td>
            <td>{{ $tweet->user_id }}</td>
            <td>{{ $tweet->ref_tweet_id }}</td>
            <td>{{ $tweet->tweet_type }}</td>
            <td>{{ $tweet->tweet_text }}</td>
            <td>{{ $tweet->reply_count }}</td>
            <td>{{ $tweet->retweet_count }}</td>
            <td>{{ $tweet->favorite_count }}</td>
            <td>{{ $tweet->created_at }}</td>
            <td>{{ $tweet->updated_at }}</td>
                <td>
                    {!! Form::open(['route' => ['tweets.destroy', $tweet->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('tweets.show', [$tweet->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('tweets.edit', [$tweet->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
