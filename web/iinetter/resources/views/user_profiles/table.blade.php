<div class="table-responsive">
    <table class="table" id="userProfiles-table">
        <thead>
            <tr>
                <th>Id</th>
        <th>User Id</th>
        <th>Screen Name</th>
        <th>Created At</th>
        <th>Updated At</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($userProfiles as $userProfile)
            <tr>
                <td>{{ $userProfile->id }}</td>
            <td>{{ $userProfile->user_id }}</td>
            <td>{{ $userProfile->screen_name }}</td>
            <td>{{ $userProfile->created_at }}</td>
            <td>{{ $userProfile->updated_at }}</td>
                <td>
                    {!! Form::open(['route' => ['userProfiles.destroy', $userProfile->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('userProfiles.show', [$userProfile->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('userProfiles.edit', [$userProfile->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
