<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>@yield('title', 'My Blog')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @if(auth()->check() && !in_array(Route::currentRouteName(), ['login', 'register']))
        <nav>
            <ul>
                @if(auth()->user()->isAdmin())
                    <li><a href="{{ route('admin.users') }}">User Management</a></li>
                @endif
                <li><a href="{{ route('posts.index') }}">Posts</a></li>
                <li style="margin-left: auto;">
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                </li>
            </ul>
        </nav>
    @endif

    <div class="container">
        <div class="form-container">
            @yield('content')
        </div>
    </div>
</body>
</html>
