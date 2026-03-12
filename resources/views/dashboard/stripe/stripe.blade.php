@extends('dashboard.master')

@section('title', 'إعدادات Stripe')

@section('content')

    <h3 class="mb-4 text-center">إعدادات Stripe</h3>

    @if (session('success'))
        <div class="alert alert-success d-flex justify-content-between align-items-center">
            <span>{{ session('success') }}</span>
            <span class="badge bg-success">✔</span>
        </div>
    @endif
    <main class="page-content">

        <div class="card shadow-sm">
            <div class="card-body">

                <form method="POST" action="{{ route('dash.stripe.settings.store') }}" id="add-form" class="add-form">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Stripe Public Key</label>
                        <input type="text" name="stripe_public_key" class="form-control" value="{{ $publicKey ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stripe Secret Key</label>
                        <input type="password" name="stripe_secret_key" class="form-control" placeholder="••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••">

                    </div>
                    @can('stripe_settings.update')
                        <button class="btn btn-primary px-4">
                            حفظ الإعدادات
                        </button>
                    @endcan

                </form>

            </div>
        </div>
    </main>

@endsection
