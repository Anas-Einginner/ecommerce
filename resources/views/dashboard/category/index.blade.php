@extends('dashboard.master')
@section('title')
    لوحة التحكم | صفحة الرئيسية للمدراء
@stop
@section('content')


    <main class="page-content">

        {{-- add modal --}}
        <div class="modal fade" id="add-modal" tabindex="-1" aria-labelledby="stagesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stagesModalLabel">@lang('general.add_new_category')</h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <form method="post" action="{{ route('dash.categories.store') }}" id="add-form" class="add-form"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="edit-id">

                        <div class="modal-body">

                            <div class="container">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                {{-- name --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.category_name')</label>
                                    <input name="name" class="form-control" placeholder="@lang('general.category_name')">
                                    <div class="invalid-feedback"></div>
                                </div>
                                {{-- slug --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.category_slug')</label>
                                    <input name="slug" class="form-control" placeholder="@lang('general.example_slug')">
                                    <div class="invalid-feedback"></div>
                                </div>
                                {{-- description --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.category_description')</label>
                                    <textarea name="description" class="form-control" rows="4" placeholder="@lang('general.optional_description')"></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- image --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.category_image')</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                    <div class="invalid-feedback"></div>
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
                        <h5 class="modal-title" id="stagesModalLabel">@lang('general.update_category') </h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <form method="post" action="{{ route('dash.categories.update') }}" id="update-form" class="update-form"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">

                        <div class="modal-body">
                            <div class="container">



                                {{-- اسم التصنيف --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.category_name')</label>
                                    <input name="name" id="name" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>
                                {{-- اسم المتجر --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.category_slug')</label>
                                    <input name="slug" id="slug" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>


                                {{-- الوصف --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.category_description')</label>
                                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="@lang('general.optional_description')"></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- الصورة --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.category_image')</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                </div>

                                {{-- صورة حالية (اختياري) --}}
                                <div class="mb-3">
                                    <img id="current-image" src="" style="max-width:120px; display:none;"
                                        class="img-thumbnail">
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer mb-3">
                            <button class="btn btn-outline-info col-12" type="submit">
                                @lang('general.update_category')
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
                                    placeholder="@lang('general.category_name')">
                            </div>

                            {{-- اسم المتجر --}}
                            <div class="col-md-4 mb-3">
                                <input type="text" id="search-slug" class="form-control" placeholder="@lang('general.slug')">
                            </div>

                            {{-- وصف التصنيف --}}
                            <div class="col-md-4 mb-3">
                                <input type="text" id="search-description" class="form-control search-input"
                                    placeholder="@lang('general.category_description')">
                            </div>

                        </div>

                        <div class="d-flex justify-content-end gap-2 mb-3">
                            <button type="submit" id="search-btn"
                                class="btn btn-outline-success col-6">@lang('general.search')</button>
                            <button type="reset" id="clear-btn"
                                class="btn btn-outline-secondary col-6">@lang('general.clean')</button>
                        </div>
                        @can('user.store')
                            <button class="btn btn-outline-primary col-12 btn-add " data-bs-toggle="modal"
                                data-bs-target="#add-modal">
                                @lang('general.add_new_category')
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
                                <h5 class="mb-0">@lang('general.all_categories')</h5>
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
                                        <th>@lang('general.category_name')</th>
                                        <th>@lang('general.category_slug')</th>
                                        <th>@lang('general.category_description')</th>
                                        <th>@lang('general.category_image')</th>
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
                url: "{{ route('dash.categories.getdata') }}",
                data: function(d) {
                    d.name = $('#search-name').val();
                    d.slug = $('#search-slug').val();
                    d.description = $('#search-description').val();
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
                    title: "@lang('general.category_name')",
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'slug',
                    name: 'slug',
                    title: "@lang('general.category_slug')",
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'description',
                    name: 'description',
                    title: "@lang('general.category_description')",
                    orderable: false,
                    searchable: true,
                },
                {
                    data: 'image',
                    name: 'image',
                    title: "@lang('general.category_image')",
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

        // زر البحث
        $('#search-btn').on('click', function() {
            table.draw();
        });

        // زر تنظيف الفلترة
        $('#clear-btn').on('click', function() {
            $('#search-name').val('');
            $('#search-slug').val('');
            $('#search-description').val('');
            table.draw();
        });

        // تعبئة مودال التعديل
        $(document).on('click', '.update_btn', function(e) {
            e.preventDefault();

            $('#id').val($(this).data('id'));
            $('#name').val($(this).data('name'));
            $('#slug').val($(this).data('slug'));
            $('#description').val($(this).data('description'));

            let image = $(this).data('image');
            if (image) {
                $('#current-image').attr('src', image).show();
            } else {
                $('#current-image').hide();
            }
        });
    </script>





@stop
