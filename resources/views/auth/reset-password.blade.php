@extends('auth.master')

@section('title','Reset Password')

@section('content')

    <p style="color:#888;font-size:14px;margin-bottom:5px">
        Reset your password
    </p>

    <h2 style="font-size:24px;font-weight:600;margin-bottom:20px">
        Create new password
    </h2>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        {{-- Token --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- Email --}}
        <div style="text-align:left;margin-bottom:15px">
            <label>Email address</label>
            <input
                type="email"
                name="email"
                value="{{ old('email', $request->email) }}"
                class="form-control"
                required
                autofocus
            >
            @error('email')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        {{-- Password --}}
        <div style="text-align:left;margin-bottom:15px">
            <label>New password</label>
            <input
                type="password"
                name="password"
                class="form-control"
                required
                autocomplete="new-password"
            >
            @error('password')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div style="text-align:left;margin-bottom:20px">
            <label>Confirm password</label>
            <input
                type="password"
                name="password_confirmation"
                class="form-control"
                required
                autocomplete="new-password"
            >
            @error('password_confirmation')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        <button class="btn-primary">
            Reset Password
        </button>
    </form>

@endsection
