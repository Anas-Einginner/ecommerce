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

                                {{-- الطلب --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.order')</label>
                                    <select name="order_id" id="order_id" class="form-control">
                                        {{-- orders --}}
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- المنتج --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.product')</label>
                                    <select name="product_id" id="product_id" class="form-control">
                                        {{-- products --}}
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- الكمية --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.quantity')</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control"
                                        value="1">
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- السعر --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.price')</label>
                                    <input type="number" step="0.01" name="price" id="price" class="form-control">
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

                    
                               <div class="col-md-4 mb-3">
                                    <input name="product_id" id="search-product_id" class="form-control"   placeholder="@lang('general.product_name')">
                                    </input>
                                    <div class="invalid-feedback"></div>
                                </div>
                                
                             {{-- الكمية --}}
                                <div class="col-md-4 mb-3">
                                    <input type="number" name="quantity" id="search-quantity" class="form-control"
                                        value="1"   placeholder="@lang('general.quantity')">
                                    <div class="invalid-feedback"></div>
                                </div>
                              {{-- السعر --}}

                            <div class="col-md-4 mb-3">
                                    <input type="number" step="0.01" name="price" id="search-price" class="form-control" placeholder="@lang('general.price')">
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
                                        <th>@lang('general.order')</th>
                                        <th>@lang('general.product')</th>
                                        <th>@lang('general.quantity')</th>
                                        <th>@lang('general.price')</th>
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
                url: "{{ route('dash.Order-item.getdata') }}",
                data: function(d) {
                    d.product_id = $('#search-product_id').val();
                    d.quantity = $('#search-quantity').val();
                    d.price = $('#search-price').val();
                }
            },

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },

                {
                    data: 'order_id',
                    name: 'order_id',
                    title: "@lang('general.order')",
                    orderable: true,
                    searchable: true,
                },

                {
                    data: 'product_name',
                    name: 'product.name',
                    title: "@lang('general.product')",
                    orderable: true,
                    searchable: true,
                },

                {
                    data: 'quantity',
                    name: 'quantity',
                    title: "@lang('general.quantity')",
                    orderable: true,
                    searchable: false,
                },

                {
                    data: 'price',
                    name: 'price',
                    title: "@lang('general.price')",
                    orderable: true,
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
    $('#order_id').val($(this).data('order_id'));
    $('#product_id').val($(this).data('product_id'));
    $('#quantity').val($(this).data('quantity'));
    $('#price').val($(this).data('price'));


        });
    </script>





@stop
