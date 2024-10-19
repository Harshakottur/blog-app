@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card fade-in" style="max-width: 500px; margin: 2rem auto; padding: 20px;"> <!-- Added padding -->
        <h2 class="text-center mb-3">Login</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email address</label>
                <input id="email" type="email" 
                    class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" 
                    required autocomplete="email" autofocus>
               
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" >{{ $message }}</span>
                @enderror
            </div>
            <div>
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </div>

            <p class="text-center mt-3">
                Don't have an account? 
                <a href="{{ route('register') }}">Sign Up</a>
            </p>
        </form>
    </div>
</div>
@endsection
