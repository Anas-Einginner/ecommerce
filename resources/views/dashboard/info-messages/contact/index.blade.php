@extends('dashboard.master')
@section('title')
    لوحة التحكم | صفحة الرئيسية للمدراء
@stop
@section('content')


    <main class="page-content">

        {{-- update modal --}}
        <div class="modal fade" id="update-modal" tabindex="-1" aria-labelledby="stagesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('general.update')</h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>

                    <form method="post" action="{{ route('dash.messages.update') }}" id="update-form" class="update-form">
                        @csrf
                        <input type="hidden" name="id" id="id">

                        <div class="modal-body">
                            <div class="container">

                                {{-- الاسم الكامل --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.full_name')</label>
                                    <input name="full_name" id="full_name" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- البريد الإلكتروني --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.email')</label>
                                    <input name="email" id="email" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- الموضوع --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.subject')</label>
                                    <input name="subject" id="subject" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- الرسالة --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.message')</label>
                                    <textarea name="message" id="message" class="form-control" rows="4"></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- الحالة --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.status')</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="new">@lang('general.new')</option>
                                        <option value="read">@lang('general.read')</option>
                                        <option value="replied">@lang('general.replied')</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
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
                                <h5 class="mb-0">@lang('general.Filter')</h5>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">

                            {{-- الاسم الكامل --}}
                            <div class="col-md-4 mb-3">
                                <input type="text" id="search-full_name" class="form-control search-input"
                                    placeholder="@lang('general.full_name')">
                            </div>

                            {{-- البريد الإلكتروني --}}
                            <div class="col-md-4 mb-3">
                                <input type="text" id="search-email" class="form-control"
                                    placeholder="@lang('general.email')">
                            </div>


                            {{-- الحالة --}}
                            <div class="col-md-4 mb-3">
                                <select id="search-status" class="form-control">
                                    <option value="">@lang('general.status')</option>
                                    <option value="new">@lang('general.new')</option>
                                    <option value="read">@lang('general.read')</option>
                                    <option value="replied">@lang('general.replied')</option>
                                </select>
                            </div>

                        </div>

                        <div class="d-flex justify-content-end gap-2 mb-3">
                            <button type="button" id="search-btn" class="btn btn-outline-success col-6">
                                @lang('general.search')
                            </button>

                            <button type="button" id="clear-btn" class="btn btn-outline-secondary col-6">
                                @lang('general.clean')
                            </button>
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
                                <h5 class="mb-0">@lang('general.all_messages')</h5>
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
                                        <th>@lang('general.full_name')</th>
                                        <th>@lang('general.email')</th>
                                        <th>@lang('general.subject')</th>
                                        <th>@lang('general.message')</th>
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
                url: "{{ route('dash.messages.getdata') }}",
                data: function(d) {
                    d.full_name = $('#search-full_name').val();
                    d.email = $('#search-email').val();
                    d.status = $('#search-status').val();
                }
            },

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'full_name',
                    name: 'full_name',
                    title: "@lang('general.full_name')",
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
                    data: 'subject',
                    name: 'subject',
                    title: "@lang('general.subject')",
                    orderable: false,
                    searchable: true,
                },
                {
                    data: 'message',
                    name: 'message',
                    title: "@lang('general.message')",
                    orderable: false,
                    searchable: true,
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

            $('#id').val($(this).data('id'));
            $('#full_name').val($(this).data('full_name'));
            $('#email').val($(this).data('email'));
            $('#subject').val($(this).data('subject'));
            $('#message').val($(this).data('message'));
            $('#status').val($(this).data('status'));


        });
    </script>





@stop
