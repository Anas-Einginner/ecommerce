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

                    <form method="post" action="{{ route('dash.Order.update') }}" id="update-form" class="update-form">
                        @csrf
                        <input type="hidden" name="id" id="id">

                        <div class="modal-body">
                            <div class="container">

                                {{-- First Name --}}
                                <div class="mb-4 col-md-6 form-group">
                                    <label>@lang('general.first_name')</label>
                                    <input name="first_name" id="first_name" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- Last Name --}}
                                <div class="mb-4 col-md-6 form-group">
                                    <label>@lang('general.last_name')</label>
                                    <input name="last_name" id="last_name" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- Address 1 --}}
                                <div class="mb-4 col-md-12 form-group">
                                    <label>@lang('general.address1')</label>
                                    <input name="address1" id="address1" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- Address 2 --}}
                                <div class="mb-4 col-md-12 form-group">
                                    <label>@lang('general.address2')</label>
                                    <input name="address2" id="address2" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- City --}}
                                <div class="mb-4 col-md-4 form-group">
                                    <label>@lang('general.city')</label>
                                    <input name="city" id="city" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- State --}}
                                <div class="mb-4 col-md-4 form-group">
                                    <label>@lang('general.state')</label>
                                    <input name="state" id="state" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- Zip --}}
                                <div class="mb-4 col-md-4 form-group">
                                    <label>@lang('general.zip')</label>
                                    <input name="zip" id="zip" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- Country --}}
                                <div class="mb-4 col-md-6 form-group">
                                    <label>@lang('general.country')</label>
                                    <input name="country" id="country" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- Status --}}
                                <div class="mb-4 col-md-6 form-group">
                                    <label>@lang('general.status')</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="pending">@lang('general.pending')</option>
                                        <option value="paid">@lang('general.paid')</option>
                                        <option value="processing">@lang('general.processing')</option>
                                        <option value="shipped">@lang('general.shipped')</option>
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
                                <input type="text" id="search-first_name" class="form-control search-input"
                                    placeholder="@lang('general.full_name')">
                            </div>

                            {{-- البريد الإلكتروني --}}
                            <div class="col-md-4 mb-3">
                                <input name="city" id="search-city" class="form-control"
                                    placeholder="@lang('general.city')">
                                <div class="invalid-feedback"></div>
                            </div>


                            {{-- الحالة --}}
                            {{-- الحالة --}}
                            <div class="col-md-4 mb-3">
                                <select name="status" id="search-status" class="form-control">

                                    <option value="">@lang('general.status')</option>

                                    <option value="pending">@lang('general.pending')</option>
                                    <option value="paid">@lang('general.paid')</option>
                                    <option value="processing">@lang('general.processing')</option>
                                    <option value="shipped">@lang('general.shipped')</option>

                                </select>

                                <div class="invalid-feedback"></div>
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
                                        <th>@lang('general.first_name')</th>
                                        <th>@lang('general.last_name')</th>
                                        <th>@lang('general.address1')</th>
                                        <th>@lang('general.address2')</th>
                                        <th>@lang('general.city')</th>
                                        <th>@lang('general.state')</th>
                                        <th>@lang('general.zip')</th>
                                        <th>@lang('general.country')</th>
                                        <th>@lang('general.total')</th>
                                        <th>@lang('general.shipping_cost')</th>
                                        <th>@lang('general.status')</th>
                                        <th>@lang('general.refund')</th>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,

            ajax: {
                url: "{{ route('dash.Order.getdata') }}",
                data: function(d) {
                    d.first_name = $('#search-first_name').val();
                    d.city = $('#search-city').val();
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
                    data: 'first_name',
                    name: 'first_name',
                    title: "@lang('general.first_name')",
                    orderable: true,
                    searchable: true,
                },

                {
                    data: 'last_name',
                    name: 'last_name',
                    title: "@lang('general.last_name')",
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'address1',
                    name: 'address1',
                    title: "@lang('general.address1')",
                    orderable: false,
                    searchable: true,
                },
                {
                    data: 'address2',
                    name: 'address2',
                    title: "@lang('general.address2')",
                    orderable: false,
                    searchable: true,
                },
                {
                    data: 'city',
                    name: 'city',
                    title: "@lang('general.city')",
                    orderable: true,
                    searchable: true,
                },

                {
                    data: 'state',
                    name: 'state',
                    title: "@lang('general.state')",
                    orderable: true,
                    searchable: true,
                },

                {
                    data: 'zip',
                    name: 'zip',
                    title: "@lang('general.zip')",
                    orderable: true,
                    searchable: true,
                },

                {
                    data: 'country',
                    name: 'country',
                    title: "@lang('general.country')",
                    orderable: true,
                    searchable: true,
                },

                {
                    data: 'total',
                    name: 'total',
                    title: "@lang('general.total')",
                    orderable: true,
                    searchable: false,
                },

                {
                    data: 'shipping_cost',
                    name: 'shipping_cost',
                    title: "@lang('general.shipping_cost')",
                    orderable: true,
                    searchable: false,
                },

                {
                    data: 'status',
                    name: 'status',
                    title: "@lang('general.status')",
                    orderable: true,
                    searchable: false,
                },
                {
                    data: 'refund',
                    name: 'refund',
                    title: "@lang('general.refund')",
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
            $('#first_name').val($(this).data('first_name'));
            $('#last_name').val($(this).data('last_name'));
            $('#address1').val($(this).data('address1'));
            $('#address2').val($(this).data('address2'));
            $('#city').val($(this).data('city'));
            $('#state').val($(this).data('state'));
            $('#zip').val($(this).data('zip'));
            $('#country').val($(this).data('country'));
            $('#total').val($(this).data('total'));
            $('#shipping_cost').val($(this).data('shipping_cost'));
            $('#status').val($(this).data('status'));


        });

        $(document).on('click', '.refund-btn', function() {

            let url = $(this).data('url');

            Swal.fire({
                title: "@lang('general.are_you_sure')",
                text: "@lang('general.refund_order')",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "@lang('general.yes_refund')",
                cancelButtonText: "@lang('general.cancel')"
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },

                        success: function(res) {

                            if (!res || res.success !== true) {
                                Swal.fire("Error!", res?.message ?? "Refund failed", "error");
                                return;
                            }

                            Swal.fire("Refunded!", "The order has been refunded.", "success");

                            table.ajax.reload(null, false);
                        },


                   error: function(xhr) {

                    Swal.fire(
                        "@lang('general.error')",
                        "@lang('general.something_wrong')",
                        "error"
                    );

                }
            });

        }

        // إذا ضغط Cancel
        else if (result.dismiss === Swal.DismissReason.cancel) {

            Swal.fire(
                "@lang('general.cancelled')",
                "@lang('general.refund_cancelled')",
                "info"
            );

        }

    });

});
    </script>





@stop
