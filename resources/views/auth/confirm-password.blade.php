@extends('auth.master')

@section('title','Confirm Password')

@section('content')

    <p style="color:#888;font-size:14px;margin-bottom:10px">
        Security check
    </p>

    <h2 style="font-size:22px;font-weight:600;margin-bottom:15px">
        Confirm your password
    </h2>

    <p style="font-size:14px;color:#666;margin-bottom:20px">
        This is a secure area of the application. Please confirm your password before continuing.
    </p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        {{-- Password --}}
        <div style="text-align:left;margin-bottom:15px">
            <label>Password</label>
            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Enter your password"
                required
                autocomplete="current-password"
            >

            @error('password')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        <button class="btn-primary">
            Confirm
        </button>
    </form>

@endsection
