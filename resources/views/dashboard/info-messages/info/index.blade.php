@extends('dashboard.master')
@section('title')
    لوحة التحكم | صفحة الرئيسية للمدراء
@stop
@section('content')
    <style>
        /* ===============================
           CONTACT INFO SETTINGS STYLE
        =================================*/

        .account-card {
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
            padding: 25px;
        }

        .form-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .form-title i {
            color: #006341;
            font-size: 1.1rem;
        }

        .form-subtitle {
            font-size: .85rem;
            color: #6c757d;
            margin-bottom: 20px;
        }

        /* Grid Layout */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        /* Form Group */
        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: .85rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        /* Inputs */
        .form-group input {
            padding: 10px 14px;
            border: 1px solid #e2e5e8;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            transition: 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #006341;
            box-shadow: 0 0 0 2px rgba(0, 99, 65, .1);
        }

        /* Button Section */
        .actions {
            margin-top: 20px;
            display: flex;
            gap: 12px;
        }

        .btn {
            flex: 1;
            padding: 12px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s ease;
            font-size: .9rem;
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: #006341;
            color: #fff;
        }

        .btn-primary:hover {
            background: #004d33;
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .account-card {
                padding: 20px;
            }
        }
    </style>

    <main class="page-content">





        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-header bg-transparent">

                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <section class="account-card">
                                <div>

                                    <div class="form-title">
                                        <i class="fas fa-address-book"></i> @lang('general.Contact Information')
                                    </div>

                                    <div class="form-subtitle">
                                        @lang('general.Update website contact details & social media links')
                                    </div>

                                    <form method="POST" action="{{ route('dash.info.update') }}" id="update-form"
                                        class="update-form">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $contact->id ?? 1 }}">
                                        <div class="form-grid">

                                            <div class="form-group">
                                                <label>@lang('general.phone')</label>
                                                <input name="phone" type="text" value="{{ $contact->phone ?? '' }}">
                                            </div>

                                            <div class="form-group">
                                                <label>@lang('general.Main Email')</label>
                                                <input name="email" type="email" value="{{ $contact->email ?? '' }}">
                                            </div>

                                            <div class="form-group">
                                                <label>@lang('general.Support Email')</label>
                                                <input name="support_email" type="email"
                                                    value="{{ $contact->support_email ?? '' }}">
                                            </div>

                                            <div class="form-group">
                                                <label>@lang('general.Facebook')</label>
                                                <input name="facebook" type="text" placeholder="https://facebook.com/..."
                                                    value="{{ $contact->facebook ?? '' }}">
                                            </div>

                                            <div class="form-group">
                                                <label>@lang('general.Instagram')</label>
                                                <input name="instagram" type="text"
                                                    placeholder="https://instagram.com/..."
                                                    value="{{ $contact->instagram ?? '' }}">
                                            </div>

                                            <div class="form-group">
                                                <label>@lang('general.Twitter')</label>
                                                <input name="twitter" type="text" placeholder="https://twitter.com/..."
                                                    value="{{ $contact->twitter ?? '' }}">
                                            </div>

                                            <div class="form-group">
                                                <label>@lang('general.Pinterest')</label>
                                                <input name="pinterest" type="text"
                                                    placeholder="https://pinterest.com/..."
                                                    value="{{ $contact->pinterest ?? '' }}">
                                            </div>

                                        </div>

                                        <div class="actions">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-save"></i> @lang('general.Save Contact Info')
                                            </button>
                                        </div>

                                    </form>

                                </div>
                            </section>
                        </div>
                    </div>
                </div>

            </div>


    </main>
@stop
