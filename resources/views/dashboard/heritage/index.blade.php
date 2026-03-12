@extends('dashboard.master')
@section('title')
    @lang('general.Heritages')
@stop
@section('content')


    <main class="page-content">

        {{-- add modal --}}
        <div class="modal fade" id="add-modal" tabindex="-1" aria-labelledby="stagesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stagesModalLabel">@lang('general.add_new_heritage')</h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <form method="post" action="{{ route('dash.heritage.store') }}" id="add-form" class="add-form"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="edit-id">

                        <div class="modal-body">

                            <div class="container">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                {{-- title --}}
                                <div class="mb-4 form-group">
                                    <label>Title</label>
                                    <input name="title" class="form-control">
                                </div>

                                {{-- description --}}
                                <div class="mb-4 form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control"></textarea>
                                </div>

                                {{-- order --}}
                                <div class="mb-4 form-group">
                                    <label>Order</label>
                                    <input type="number" name="order" class="form-control">
                                </div>


                                {{-- image --}}
                                <div class="mb-4 form-group">
                                    <label>Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer mb-3">
                            <button class="btn btn-outline-success col-12" type="submit">@lang('general.add')</button>
                            <button type="button" class="btn btn-outline-secondary col-12 mb-3"
                                data-bs-dismiss="modal">@lang('general.close')</button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
        {{-- ///////////////////////////////////////// --}}


        {{-- update modal --}}
        <div class="modal fade" id="update-modal" tabindex="-1" aria-labelledby="stagesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stagesModalLabel">@lang('general.update_heritage') </h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <form method="post" action="{{ route('dash.heritage.update') }}" id="update-form" class="update-form"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">

                        <div class="modal-body">
                            <div class="container">



                                {{-- title --}}
                                <div class="mb-4 form-group">
                                    <label>Title</label>
                                    <input id="title" name="title" class="form-control">
                                </div>

                                {{-- description --}}
                                <div class="mb-4 form-group">
                                    <label>Description</label>
                                    <textarea id="description" name="description" class="form-control"></textarea>
                                </div>

                                {{-- order --}}
                                <div class="mb-4 form-group">
                                    <label>Order</label>
                                    <input type="number" name="order" id="order" class="form-control">
                                </div>

                                {{-- status --}}
                                <div class="mb-4 form-group">
                                    <label>Status</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>

                                {{-- image --}}
                                <div class="mb-4 form-group">
                                    <label>Image</label>
                                    <input type="file" name="image" class="form-control">
                                    <div class="mb-3">
                                        <img id="current-image" src="" style="max-width:120px; display:none;"
                                            class="img-thumbnail">
                                    </div>
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

                    <div class="card-body">



                        @can('user.store')
                            <button class="btn btn-outline-primary col-12 btn-add " data-bs-toggle="modal"
                                data-bs-target="#add-modal">
                                @lang('general.add_new_heritage')
                            </button>
                        @endcan
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
                                <h5 class="mb-0">@lang('general.all_heritages')</h5>
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
                                        <th>@lang('general.heritage_title')</th>
                                        <th>@lang('general.heritage_description')</th>
                                        <th>@lang('general.heritage_image')</th>
                                        <th>@lang('general.heritage_order')</th>
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
                url: "{{ route('dash.heritage.getdata') }}",

            },

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },

                {
                    data: 'title',
                    name: 'title',
                    title: "@lang('general.heritage_title')",
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'description',
                    name: 'description',
                    title: "@lang('general.heritage_description')",
                    orderable: false,
                    searchable: true,
                },
                {
                    data: 'image',
                    name: 'image',
                    title: "@lang('general.heritage_image')",
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'order',
                    name: 'order',
                    title: "@lang('general.heritage_order')",
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
            $('#title').val($(this).data('title'));
            $('#image').val($(this).data('image'));
            $('#description').val($(this).data('description'));
            $('#order').val($(this).data('order'));
            $('#status').val($(this).data('status'));
            let image = $(this).data('image');
            if (image) {
                $('#current-image').attr('src', image).show();
            } else {
                $('#current-image').hide();
            }
        });
    </script>





@stop
