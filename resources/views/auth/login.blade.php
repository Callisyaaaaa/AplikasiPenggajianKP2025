@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="login-container">
            <h2 class="text-center mb-4">Login</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                    <label for="remember" class="form-check-label">Remember Me</label>
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>

                <div class="mt-3 text-center">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot Your Password?</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
