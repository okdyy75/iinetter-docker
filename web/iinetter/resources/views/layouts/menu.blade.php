<li class="{{ Request::is('users*') ? 'active' : '' }}">
    <a href="{{ route('users.index') }}"><i class="fa fa-edit"></i><span>Users</span></a>
</li>

<li class="{{ Request::is('tweets*') ? 'active' : '' }}">
    <a href="{{ route('tweets.index') }}"><i class="fa fa-edit"></i><span>Tweets</span></a>
</li>

