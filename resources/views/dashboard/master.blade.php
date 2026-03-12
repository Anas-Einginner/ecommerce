<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="rtl">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('dashboard/assets/images/favicon-32x32.png') }}" type="image/png" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--plugins-->
    <link href="{{ asset('dashboard/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="{{ asset('dashboard/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard/assets/css/bootstrap-extended.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard/assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard/assets/css/icons.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="{{ asset('datatable_custom/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('datatable_custom/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- loader-->
    <link href="{{ asset('dashboard/assets/css/pace.min.css') }}" rel="stylesheet" />

    <!--Theme Styles-->
    <link href="{{ asset('dashboard/assets/css/dark-theme.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard/assets/css/light-theme.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard/assets/css/semi-dark.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard/assets/css/header-colors.css') }}" rel="stylesheet" />

    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard/toastr/app-assets/vendors/css/extensions/toastr.min.css') }}">

    <style>
        .modal-dialog-scrollable .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }

        .swal-footer {
            display: flex !important;
            justify-content: center !important;
            gap: 10px;
        }

        .swal-button {
            min-width: 100px;
        }
    </style>
    <title>@yield('title')</title>
</head>

<body>


    <!--start wrapper-->
    <div class="wrapper">
        <!--start top header-->
        <header class="top-header">
            <nav class="navbar navbar-expand gap-3">
                <div class="mobile-toggle-icon fs-3">
                    <i class="bi bi-list"></i>
                </div>
                <form class="searchbar">
                    <div class="position-absolute top-50 translate-middle-y search-icon ms-3"><i
                            class="bi bi-search"></i></div>
                    <input class="form-control" type="text" placeholder="@lang('general.Type here to search')">
                    <div class="position-absolute top-50 translate-middle-y search-close-icon"><i
                            class="bi bi-x-lg"></i></div>
                </form>
                <div class="top-navbar-right ms-auto">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item search-toggle-icon">
                            <a class="nav-link" href="#">
                                <div class="">
                                    <i class="bi bi-search"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item dropdown dropdown-user-setting">
                            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                                data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                @php
                                    $user = auth()->user();
                                    $profile = $user?->profile;

                                    $avatar =
                                        $profile && $profile->image
                                            ? asset('storage/' . $profile->image)
                                            : asset('dashboard/assets/images/avatars/avatar-1.png');
                                @endphp

                                <div class="user-setting d-flex align-items-center">
                                    <img src="{{ $avatar }}" class="user-img" alt="">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        @php
                                            $user = auth()->user();
                                            $profile = $user?->profile;

                                            $avatar =
                                                $profile && $profile->image
                                                    ? asset('storage/' . $profile->image)
                                                    : asset('dashboard/assets/images/avatars/avatar-1.png');
                                        @endphp

                                        <div class="d-flex align-items-center dropdown-user">

                                            <div class="avatar-wrapper">
                                                <img src="{{ $avatar }}" alt="User Avatar" class="avatar-img"
                                                    onerror="this.onerror=null;this.src='{{ asset('dashboard/assets/images/avatars/avatar-1.png') }}';">
                                            </div>

                                            <div class="user-info">
                                                <div class="user-name">{{ $user->name }}</div>
                                                <div class="user-role">{{ $user->email }}</div>
                                            </div>

                                        </div>

                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('dash.profile.view') }}">
                                        <div class="d-flex align-items-center">
                                            <div class=""><i class="bi bi-person-fill"></i></div>
                                            <div class="ms-3"><span>@lang('general.profile')</span></div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2" data-bs-toggle="collapse"
                                        href="#langMenu" role="button" aria-expanded="false" aria-controls="langMenu">
                                        <i class="bi bi-translate"></i>
                                        <span>@lang('general.language')</span>
                                        <i class="bi bi-chevron-down ms-auto"></i>
                                    </a>

                                    <div class="collapse mt-1" id="langMenu">
                                        <div class="d-flex flex-column">

                                            {{-- English --}}
                                            @if (app()->getLocale() === 'en')
                                                <span class="dropdown-item d-flex align-items-center gap-2 text-muted">
                                                    <i class="bi bi-globe"></i>
                                                    <span>@lang('general.English')</span>
                                                    <span class="flex-grow-1"></span>
                                                    <i class="bi bi-check text-success"></i>
                                                </span>
                                            @else
                                                <a class="dropdown-item d-flex align-items-center gap-2 ps-4"
                                                    href="{{ route('lang.switch', 'en') }}">
                                                    <i class="bi bi-globe"></i>
                                                    <span>@lang('general.English')</span>
                                                </a>
                                            @endif

                                            {{-- Arabic --}}
                                            @if (app()->getLocale() === 'ar')
                                                <span class="dropdown-item d-flex align-items-center gap-2 text-muted">
                                                    <i class="bi bi-globe"></i>
                                                    <span>@lang('general.Arabic')</span>
                                                    <span class="flex-grow-1"></span>
                                                    <i class="bi bi-check text-success"></i>
                                                </span>
                                            @else
                                                <a class="dropdown-item d-flex align-items-center gap-2 ps-4"
                                                    href="{{ route('lang.switch', 'ar') }}">
                                                    <i class="bi bi-globe"></i>
                                                    <span>@lang('general.Arabic')</span>
                                                </a>
                                            @endif

                                        </div>
                                    </div>
                                </li>


                                <li>
                                    <form action="{{ route('logout') }}" method="POST"
                                        class="dropdown-item p-0 m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-lock-fill"></i>
                                            <span class="ms-3">@lang('general.logout')</span>
                                        </button>
                                    </form>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item dropdown dropdown-large">
                            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                                data-bs-toggle="dropdown">
                                <div class="projects">
                                    <i class="bi bi-grid-3x3-gap-fill"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="row row-cols-3 gx-2">
                                    <div class="col">
                                        <a href="ecommerce-orders.html">
                                            <div class="apps p-2 radius-10 text-center">
                                                <div class="apps-icon-box mb-1 text-white bg-gradient-purple">
                                                    <i class="bi bi-basket2-fill"></i>
                                                </div>
                                                <p class="mb-0 apps-name">Orders</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="javascript:;">
                                            <div class="apps p-2 radius-10 text-center">
                                                <div class="apps-icon-box mb-1 text-white bg-gradient-info">
                                                    <i class="bi bi-people-fill"></i>
                                                </div>
                                                <p class="mb-0 apps-name">Users</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="ecommerce-products-grid.html">
                                            <div class="apps p-2 radius-10 text-center">
                                                <div class="apps-icon-box mb-1 text-white bg-gradient-success">
                                                    <i class="bi bi-trophy-fill"></i>
                                                </div>
                                                <p class="mb-0 apps-name">Products</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="component-media-object.html">
                                            <div class="apps p-2 radius-10 text-center">
                                                <div class="apps-icon-box mb-1 text-white bg-gradient-danger">
                                                    <i class="bi bi-collection-play-fill"></i>
                                                </div>
                                                <p class="mb-0 apps-name">Media</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="pages-user-profile.html">
                                            <div class="apps p-2 radius-10 text-center">
                                                <div class="apps-icon-box mb-1 text-white bg-gradient-warning">
                                                    <i class="bi bi-person-circle"></i>
                                                </div>
                                                <p class="mb-0 apps-name">Account</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="javascript:;">
                                            <div class="apps p-2 radius-10 text-center">
                                                <div class="apps-icon-box mb-1 text-white bg-gradient-voilet">
                                                    <i class="bi bi-file-earmark-text-fill"></i>
                                                </div>
                                                <p class="mb-0 apps-name">Docs</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="ecommerce-orders-detail.html">
                                            <div class="apps p-2 radius-10 text-center">
                                                <div class="apps-icon-box mb-1 text-white bg-gradient-branding">
                                                    <i class="bi bi-credit-card-fill"></i>
                                                </div>
                                                <p class="mb-0 apps-name">Payment</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="javascript:;">
                                            <div class="apps p-2 radius-10 text-center">
                                                <div class="apps-icon-box mb-1 text-white bg-gradient-desert">
                                                    <i class="bi bi-calendar-check-fill"></i>
                                                </div>
                                                <p class="mb-0 apps-name">Events</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="javascript:;">
                                            <div class="apps p-2 radius-10 text-center">
                                                <div class="apps-icon-box mb-1 text-white bg-gradient-amour">
                                                    <i class="bi bi-book-half"></i>
                                                </div>
                                                <p class="mb-0 apps-name">Story</p>
                                            </div>
                                        </a>
                                    </div>
                                </div><!--end row-->
                            </div>
                        </li>
                        <li class="nav-item dropdown dropdown-large">
                            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                                data-bs-toggle="dropdown">

                                <div class="messages position-relative">

                                    <i class="bi bi-chat-right-fill"></i>

                                    @if ($messagesCount > 0)
                                        <span
                                            class="badge bg-danger position-absolute top-0 start-100 translate-middle"
                                            style="font-size: 10px ; border-radius: 50%">
                                            {{ $messagesCount }}
                                        </span>
                                    @endif

                                </div>

                            </a>
                            <div class="dropdown-menu dropdown-menu-end p-0">
                                <div class="p-2 border-bottom m-2">
                                    <h5 class="h5 mb-0">Messages</h5>
                                </div>
                                <div class="header-message-list p-2">

                                    @foreach ($recentMessages as $message)
                                        <a class="dropdown-item" href="{{ route('dash.messages.view') }}">
                                            <div class="d-flex align-items-center">

                                                <img src="{{ asset('dashboard/assets/images/avatars/avatar-1.png') }}"
                                                    class="rounded-circle" width="50" height="50">

                                                <div class="ms-3 flex-grow-1">

                                                    <h6 class="mb-0 dropdown-msg-user">
                                                        {{ $message->name }}

                                                        <span class="msg-time float-end text-secondary">
                                                            {{ $message->created_at->diffForHumans() }}
                                                        </span>

                                                    </h6>

                                                    <small
                                                        class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">
                                                        {{ Str::limit($message->message, 40) }}
                                                    </small>

                                                </div>
                                            </div>
                                        </a>
                                    @endforeach

                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown dropdown-large">
                            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                                data-bs-toggle="dropdown">
                                <div class="notifications">
                                    <span class="notify-badge">8</span>
                                    <i class="bi bi-bell-fill"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end p-0">
                                <div class="p-2 border-bottom m-2">
                                    <h5 class="h5 mb-0">Notifications</h5>
                                </div>
                                <div class="header-notifications-list p-2">
                                    <a class="dropdown-item" href="#">
                                        <div class="d-flex align-items-center">
                                            <div class="notification-box bg-light-primary text-primary">
                                                <i class="bi bi-clock-history"></i>
                                            </div>

                                            <div class="ms-3">
                                                <h6 class="mb-0">Last login</h6>
                                                <small class="text-muted">
                                                    {{ auth()->user()->last_login_at?->locale('en')->diffForHumans() }}
                                                </small>
                                            </div>

                                        </div>
                                    </a>
                                </div>
                                @if (isset($lowStockProducts) && $lowStockProducts->count())

                                    <div class="header-notifications-list p-2">

                                        @foreach ($lowStockProducts as $product)
                                            <a class="dropdown-item" href="#">
                                                <div class="d-flex align-items-center">

                                                    <div class="notification-box bg-light-warning text-warning">
                                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                                    </div>

                                                    <div class="ms-3">
                                                        <h6 class="mb-0">Low Stock</h6>
                                                        <small class="text-muted">
                                                            {{ $product->name }} ({{ $product->stock }} left)
                                                        </small>
                                                    </div>

                                                </div>
                                            </a>
                                        @endforeach

                                    </div>

                                @endif
                                <div class="p-2">
                                    <div>
                                        <hr class="dropdown-divider">
                                    </div>
                                    <a class="dropdown-item" href="#">
                                        <div class="text-center">View All Notifications</div>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!--end top header-->

        <!--start sidebar -->
        <aside class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <img src="{{ asset('dashboard/assets/images/logo-icon.png') }}" class="logo-icon"
                        alt="logo icon">
                </div>
                <div>
                    <h4 class="logo-text">@lang('general.store_dashboard')</h4>
                </div>
                <div class="toggle-icon {{ app()->getLocale() === 'ar' ? 'me-auto' : 'ms-auto' }}">
                    <i class="bi bi-list"></i>
                </div>
            </div>
            <!--navigation-->
            @include('dashboard.parts.sidebar')
            <!--end navigation-->
        </aside>
        <!--end sidebar -->


        @yield('content')

        <!--start overlay-->
        <div class="overlay nav-toggle-icon"></div>
        <!--end overlay-->

        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->

        <!--start switcher-->
        <div class="switcher-body">

            <div class="offcanvas offcanvas-end shadow border-start-0 p-2" data-bs-scroll="true"
                data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling">
                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Theme Customizer</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    <h6 class="mb-0">Theme Variation</h6>
                    <hr>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="LightTheme"
                            value="option1" checked>
                        <label class="form-check-label" for="LightTheme">Light</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="DarkTheme"
                            value="option2">
                        <label class="form-check-label" for="DarkTheme">Dark</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="SemiDarkTheme"
                            value="option3">
                        <label class="form-check-label" for="SemiDarkTheme">Semi Dark</label>
                    </div>
                    <hr>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="MinimalTheme"
                            value="option3">
                        <label class="form-check-label" for="MinimalTheme">Minimal Theme</label>
                    </div>
                    <hr />
                    <h6 class="mb-0">Header Colors</h6>
                    <hr />
                    <div class="header-colors-indigators">
                        <div class="row row-cols-auto g-3">
                            <div class="col">
                                <div class="indigator headercolor1" id="headercolor1"></div>
                            </div>
                            <div class="col">
                                <div class="indigator headercolor2" id="headercolor2"></div>
                            </div>
                            <div class="col">
                                <div class="indigator headercolor3" id="headercolor3"></div>
                            </div>
                            <div class="col">
                                <div class="indigator headercolor4" id="headercolor4"></div>
                            </div>
                            <div class="col">
                                <div class="indigator headercolor5" id="headercolor5"></div>
                            </div>
                            <div class="col">
                                <div class="indigator headercolor6" id="headercolor6"></div>
                            </div>
                            <div class="col">
                                <div class="indigator headercolor7" id="headercolor7"></div>
                            </div>
                            <div class="col">
                                <div class="indigator headercolor8" id="headercolor8"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end switcher-->

    </div>
    <!--end wrapper-->


    <!-- Bootstrap bundle JS -->
    <script src="{{ asset('dashboard/assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('dashboard/assets/js/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('dashboard/assets/js/index.js') }}"></script> --}}
    <script src="{{ asset('dashboard/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <!--app-->
    <script src="{{ asset('dashboard/assets/js/app.js') }}"></script>
    <script src="{{ asset('datatable_custom/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable_custom/js/vendor/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('datatable_custom/js/vendor/dataTables.responsive.min.js') }}"></script>

    <script src="{{ asset('dashboard/toastr/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>


    {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('.btn-add').on('click', function(e) {
            $('input').removeClass('is-invalid');
            $('select').removeClass('is-invalid');
            $('.invalid-feedback').text('');
        });



        $(document).ready(function() {
            $('#add-form').on('submit', function(event) {

                event.preventDefault();
                var data = new FormData(this);
                let url = $(this).attr('action');
                let method = $(this).attr('method');

                $('#add-form').find('input, select, textarea').removeClass('is-invalid');
                $('#add-form').find('.invalid-feedback').html('');

                $.ajax({
                    type: method,
                    cache: false,
                    contentType: false,
                    processData: false,
                    url: url,
                    data: data,

                    success: function(result) {
                        $("#add-modal").modal('hide');
                        $('#add-form').trigger("reset");
                        $('input[type="checkbox"]').prop('checked', false);

                        toastr.success("{{ __('general.success_operation') }}");
                        table.draw();
                    },

                    error: function(data) {
                        if (data.status === 422) {
                            var response = data.responseJSON;

                            $.each(response.errors, function(key, value) {

                                var str = key.split(".");
                                if (str[1] === '0') {
                                    key = str[0] + '[]';
                                }

                                var $field = $('#add-form').find('[name="' + key +
                                    '"], [name="' + key + '[]"]');

                                $field.addClass('is-invalid');

                                $field.closest('.mb-4, .mb-3, .form-group')
                                    .find('.invalid-feedback')
                                    .first()
                                    .html(value[0]);
                            });

                        } else {
                            console.log(data.responseText);
                            toastr.error('حدث خطأ غير متوقع');
                        }
                    }
                });
            });
        });
        $('.update-form').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var data = new FormData(this);
            var url = $(this).attr('action');
            var type = $(this).attr('method');
            $.ajax({
                url: url,
                type: type,
                processData: false,
                contentType: false,
                data: data,
                success: function(res) {
                    $('#update-modal').modal('hide');
                    toastr.success("{{ __('general.success_operation') }}");
                    table.draw();
                },
                error: function(xhr) {

                    // أخطاء validation
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(key, messages) {
                            let input = form.find('[name="' + key + '"]');
                            input.addClass('is-invalid');
                            input.closest('.form-group')
                                .find('.invalid-feedback')
                                .text(messages[0]);
                        });
                        console.log(xhr.responseJSON);

                        toastr.error('تحقق من الحقول');
                        return;
                    }

                    // ❌ منع تعطيل نفسك (403)
                    if (xhr.status === 403 && xhr.responseJSON?.error) {
                        toastr.warning(xhr.responseJSON.error);
                        return;
                    }

                    toastr.error('حدث خطأ غير متوقع');
                }


            });
        });

        // $(document).ready(function() {
        //     $(document).on('click', '.delete-btn', function(e) {
        //         e.preventDefault();
        //         var button = $(this);
        //         var id = button.data('id');
        //         var url = button.data('url');
        //         swal({
        //             title: "هل أنت متأكد من العملية ؟",
        //             text: "انتبه عند حذف العنصر لا يمكن التراجع عن العملية .",
        //             icon: "warning",
        //             buttons: {
        //                 cancel: {
        //                     text: "إلغاء",
        //                     value: null,
        //                     visible: true,
        //                     className: "custom-cancel-btn",
        //                     closeModal: true,
        //                 },
        //                 confirm: {
        //                     text: "احذف",
        //                     value: true,
        //                     visible: true,
        //                     className: "custom-confirm-btn",
        //                     closeModal: true,
        //                 },
        //             },
        //             dangerMode: true,
        //         }).then((willDelete) => {
        //             if (willDelete) {
        //                 $.ajax({
        //                     url: url,
        //                     type: "post",
        //                     data: {
        //                         id: id,
        //                         _token: "{{ csrf_token() }}"
        //                     },
        //                     success: function(res) {
        //                         toastr.success(res.success)
        //                         table.draw();
        //                     },
        //                 });
        //             } else {
        //                 toastr.error('تم الغاء عملية الحذف')
        //             }
        //         });
        //     })
        // });


        $('#search-btn').on('click', function(e) {
            e.preventDefault();
            table.draw();
        });

        // $('#clear-btn').on('click', function(e) {
        //     e.preventDefault();
        //     $('.search-input').val("").trigger('change')
        //     table.draw();
        // });
        $('#clear-btn').on('click', function(e) {
            e.preventDefault();
            $('[id^="search-"]').val('');
            table.draw();
        });

        $(document).ready(function() {

            $(document).on('click', '.toggle-status-btn', function(e) {
                e.preventDefault();

                let button = $(this);
                let id = button.data('id');
                let url = button.data('url');
                let status = button.data('status');

                let isActive = status === 'active';
                Swal.fire({
                    title: "{{ __('general.are_you_sure') }}",
                    text: isActive ?
                        "{{ __('general.will_be_inactive') }}" :
                        "{{ __('general.will_be_active') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: isActive ?
                        "{{ __('general.inactive') }}" : "{{ __('general.active') }}",
                    cancelButtonText: "{{ __('general.cancel') }}"
                }).then((result) => {

                    if (!result.isConfirmed) {
                        toastr.info("{{ __('general.operation_cancelled') }}");
                        return;
                    }

                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            toastr.success("{{ __('general.success_operation') }}");
                            table.draw(false);
                        },
                        error: function(xhr) {
                            toastr.error("{{ __('general.unexpected_error') }}");
                        }
                    });

                });
            });

        });

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();

            let button = $(this);
            let id = button.data('id');
            let url = button.data('url');

            Swal.fire({
                title: "{{ __('general.delete_title') }}",
                text: "{{ __('general.delete_text') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "{{ __('general.delete_confirm') }}",
                cancelButtonText: "{{ __('general.cancel') }}"
            }).then((result) => {

                if (!result.isConfirmed) {
                    toastr.info("{{ __('general.delete_cancelled_info') }}");
                    return;
                }

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        id: id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function(res) {
                        toastr.success("{{ __('general.success_operation') }}");
                        table.draw();
                    },

                    error: function(xhr) {

                        let msg = "{{ __('general.unexpected_error') }}";

                        if (xhr.status === 419)
                            msg = "{{ __('general.session_expired') }}";

                        if (xhr.status === 403)
                            msg = "{{ __('general.unauthorized_action') }}";

                        if (xhr.status === 404)
                            msg = "{{ __('general.route_not_found') }}";

                        if (xhr.status === 500)
                            msg = "{{ __('general.server_error') }}";

                        toastr.error(msg);
                    }
                });

            });
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('click', '.js-lang-switch', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');

            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'Accept': 'application/json'
                },
                success: function() {
                    location.reload();
                },
                error: function() {
                    window.location.href = url;
                }
            });
        });
    </script>

    @yield('js')

</body>

</html>
