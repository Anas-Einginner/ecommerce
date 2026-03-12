@extends('auth.master')

@section('title','Register')

@section('content')

    <p style="color:#888;font-size:14px;margin-bottom:5px">
        Create your account
    </p>

    <h2 style="font-size:24px;font-weight:600;margin-bottom:20px">
        Sign up
    </h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Name --}}
        <div style="text-align:left;margin-bottom:15px">
            <label>Name</label>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="form-control"
                placeholder="Full name"
                required
            >
            @error('name')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

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
            >
            @error('email')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        {{-- Phone --}}
        <div style="text-align:left;margin-bottom:15px">
            <label>Phone</label>
            <input
                type="text"
                name="phone"
                value="{{ old('phone') }}"
                class="form-control"
                placeholder="Phone number"
            >
            @error('phone')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        {{-- Date of Birth --}}
        <div style="text-align:left;margin-bottom:15px">
            <label>Date of Birth</label>
            <input
                type="date"
                name="date_of_birth"
                value="{{ old('date_of_birth') }}"
                class="form-control"
            >
        </div>

        {{-- Gender --}}
        <div style="text-align:left;margin-bottom:15px">
            <label>Gender</label>
            <select name="gender" class="form-control">
                <option value="">Select</option>
                <option value="m" {{ old('gender')=='m' ? 'selected' : '' }}>Male</option>
                <option value="fm" {{ old('gender')=='fm' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        {{-- Password --}}
        <div style="text-align:left;margin-bottom:15px">
            <label>Password</label>
            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Create password"
                required
            >
            @error('password')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div style="text-align:left;margin-bottom:20px">
            <label>Confirm Password</label>
            <input
                type="password"
                name="password_confirmation"
                class="form-control"
                placeholder="Confirm password"
                required
            >
            @error('password_confirmation')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        <button class="btn-primary">
            Create Account
        </button>
    </form>

    <p style="margin-top:15px;font-size:14px;color:#888">
        Already registered?
        <a href="{{ route('login') }}" style="color:#006341;font-weight:600">
            Sign in
        </a>
    </p>

@endsection
