@extends('auth.master')

@section('title','Forgot Password')

@section('content')

    <p style="color:#888;font-size:14px;margin-bottom:10px">
        Forgot your password?
    </p>

    <h2 style="font-size:22px;font-weight:600;margin-bottom:20px">
        Reset Password
    </h2>

    <p style="font-size:14px;color:#666;margin-bottom:20px">
        No problem. Just let us know your email address and we will email you a password reset link.
    </p>

    {{-- Session Status --}}
    @if (session('status'))
        <div style="color:green;font-size:14px;margin-bottom:15px">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        {{-- Email --}}
        <div style="text-align:left;margin-bottom:15px">
            <label>Email address</label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="form-control"
                placeholder="Enter your email"
                required
                autofocus
            >

            @error('email')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        <button class="btn-primary">
            Email Password Reset Link
        </button>
    </form>

    <p style="margin-top:15px;font-size:14px;color:#888">
        Remember your password?
        <a href="{{ route('login') }}" style="color:#006341;font-weight:600">
            Sign in
        </a>
    </p>

@endsection
