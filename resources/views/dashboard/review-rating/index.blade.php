@extends('dashboard.master')
@section('title')
    لوحة التحكم | صفحة الرئيسية للمدراء
@stop
@section('content')


    <main class="page-content">


        {{-- ///////////////////////////////////////// --}}


        {{-- update modal --}}
        <div class="modal fade" id="update-modal" tabindex="-1" aria-labelledby="stagesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stagesModalLabel">@lang('general.update') </h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <form method="post" action="{{ route('dash.reviews.update') }}" id="update-form" class="update-form"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">

                        <div class="modal-body">
                            <div class="container">


                           

                                {{-- الحالة --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.status')</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="pending">@lang('general.pending')</option>
                                        <option value="approved">@lang('general.approved')</option>
                                        <option value="rejected">@lang('general.rejected')</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer mb-3">
                            <button class="btn btn-outline-info col-12" type="submit">
                                @lang('general.update')
                            </button>
                            <button type="button" class="btn btn-outline-secondary col-12 mb-3" data-bs-dismiss="modal">
                                @lang('general.close')
                            </button>
                        </div>
                    </form>

                </div>


            </div>
        </div>



        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-header bg-transparent">
                        <div class="row g-3 align-items-center">
                            <div class="col">
                                <h5 class="mb-0"> @lang('general.Filter')</h5>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">

                            {{-- اسم التصنيف --}}
                            <div class="col-md-4 mb-3">
                                <input type="text" id="search-name" class="form-control search-input"
                                    placeholder="@lang('general.name')">
                            </div>

                            {{-- اسم المتجر --}}
                            <div class="col-md-4 mb-3">
                                <input type="text" id="search-email" class="form-control"
                                    placeholder="@lang('general.email')">
                            </div>

                            {{-- وصف التصنيف --}}
                            <div class="col-md-4 mb-3">
                                <select id="search-rating" class="form-control search-input">
                                    <option value="">@lang('general.Select Rating')</option>
                                    <option value="1">⭐</option>
                                    <option value="2">⭐⭐</option>
                                    <option value="3">⭐⭐⭐</option>
                                    <option value="4">⭐⭐⭐⭐</option>
                                    <option value="5">⭐⭐⭐⭐⭐</option>
                                </select>
                            </div>

                        </div>

                        <div class="d-flex justify-content-end gap-2 mb-3">
                            <button type="submit" id="search-btn"
                                class="btn btn-outline-success col-6">@lang('general.search')</button>
                            <button type="reset" id="clear-btn"
                                class="btn btn-outline-secondary col-6">@lang('general.clean')</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-header bg-transparent">
                        <div class="row g-3 align-items-center">
                            <div class="col">
                                <h5 class="mb-0">@lang('general.all_reviews')</h5>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('general.name')</th>
                                        <th>@lang('general.email')</th>
                                        <th>@lang('general.product')</th>
                                        <th>@lang('general.rating')</th>
                                        <th>@lang('general.review')</th>
                                        <th>@lang('general.title')</th>
                                        <th>@lang('general.status')</th>
                                        <th>@lang('general.actions')</th>
                                    </tr>

                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@stop
@section('js')
    <script>
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,

            ajax: {
                url: "{{ route('dash.reviews.getdata') }}",
                data: function(d) {
                    d.name = $('#search-name').val();
                    d.email = $('#search-email').val();
                    d.rating = $('#search-rating').val();
                }
            },

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'name',
                    name: 'name',
                    title: "@lang('general.name')",
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'email',
                    name: 'email',
                    title: "@lang('general.email')",
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'product',
                    name: 'product',
                    title: "@lang('general.product')",
                    orderable: false,
                    searchable: true,
                },
                {
                    data: 'rating',
                    name: 'rating',
                    title: "@lang('general.rating')",
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'title',
                    name: 'title',
                    title: "@lang('general.title')",
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'review',
                    name: 'review',
                    title: "@lang('general.review')",
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'status',
                    name: 'status',
                    title: "@lang('general.status')",
                    orderable: false,
                    searchable: false,
                },

                {
                    data: 'action',
                    name: 'action',
                    title: "@lang('general.actions')",
                    orderable: false,
                    searchable: false,
                },
            ]

            @if (app()->getLocale() === 'ar')
                , language: {
                    url: "{{ asset('datatable_custom/i18n/ar.json') }}"
                }
            @endif
        });

        // تعبئة مودال التعديل
        $(document).on('click', '.update_btn', function(e) {
            e.preventDefault();
            // ملئ الحقول بالبيانات
            //             name
            // email
            // product
            // rating
            // title
            // review
            // status
            $('#id').val($(this).data('id'));
            $('#name').val($(this).data('name'));
            $('#email').val($(this).data('email'));
    $('#product_id').val($(this).data('product_id'));
            $('#title').val($(this).data('title'));
            $('#review').val($(this).data('review'));
            $('#rating').val($(this).data('rating'));
            $('#status').val($(this).data('status'));


        });
    </script>





@stop
