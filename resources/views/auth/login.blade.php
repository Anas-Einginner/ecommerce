@extends('auth.master')

@section('title', 'Login')

@section('content')


    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Not Logged In',
                text: "{{ session('error') }}"
            });
        </script>
    @endif
    <p style="color:#888;font-size:14px">Please enter your details</p>
    <h2 style="font-size:24px;font-weight:600;margin-bottom:20px">Welcome back</h2>

    {{-- Session Status --}}
    @if (session('status'))
        <div style="color:green;margin-bottom:15px">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div style="text-align:left;margin-bottom:15px">
            <label>Email address</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control">
            @error('email')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        <div style="text-align:left;margin-bottom:15px">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
            @error('password')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        <div style="display:flex;justify-content:space-between;font-size:14px;margin-bottom:15px">
            <label>
                <input type="checkbox" name="remember"> Remember for 30 days
            </label>

            <a href="{{ route('password.request') }}" style="color:#006341">
                Forgot password?
            </a>
        </div>

        <button class="btn-primary">Sign in</button>

    </form>

    <p style="margin-top:15px;font-size:14px;color:#888">
        Don’t have an account?
        <a href="{{ route('register') }}" style="color:#006341;font-weight:600">Sign up</a>
    </p>




@endsection
