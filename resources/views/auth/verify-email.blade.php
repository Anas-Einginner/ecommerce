@extends('auth.master')

@section('title','Verify Email')

@section('content')

    <p style="color:#888;font-size:14px;margin-bottom:10px">
        Verify your email
    </p>

    <h2 style="font-size:22px;font-weight:600;margin-bottom:15px">
        Email verification required
    </h2>

    <p style="font-size:14px;color:#666;margin-bottom:20px;line-height:1.6">
        Thanks for signing up! Before getting started, could you verify your email address
        by clicking on the link we just emailed to you?
        <br><br>
        If you didn’t receive the email, we will gladly send you another.
    </p>

    {{-- Success message --}}
    @if (session('status') === 'verification-link-sent')
        <div style="color:#28a745;font-size:14px;margin-bottom:15px">
            A new verification link has been sent to your email address.
        </div>
    @endif

    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:20px">

        {{-- Resend --}}
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button class="btn-primary" style="width:auto;padding:10px 18px">
                Resend Verification Email
            </button>
        </form>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background:none;border:none;color:#666;font-size:14px">
                Log out
            </button>
        </form>

    </div>

@endsection
