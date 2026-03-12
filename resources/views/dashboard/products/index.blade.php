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
                        <h5 class="modal-title" id="stagesModalLabel">@lang('general.add_new_product')</h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <form method="post" action="{{ route('dash.products.store') }}" id="add-form" class="add-form"
                        enctype="multipart/form-data">

                        @csrf

                        <div class="modal-body">
                            <div class="container">

                                {{-- اسم المنتج --}}
                                <div class="mb-4">
                                    <label>@lang('general.product_name')</label>
                                    <input name="name" class="form-control">
                                    <div class="invalid-feedback"></div>

                                </div>

                                {{-- Slug --}}
                                <div class="mb-4">
                                    <label>@lang('general.product_slug')</label>
                                    <input name="slug" class="form-control" placeholder="@lang('general.example_slug')">
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- الوصف --}}
                                <div class="mb-4">
                                    <label>@lang('general.product_description')</label>
                                    <textarea name="description" class="form-control" rows="4"></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- التصنيف --}}
                                <div class="mb-4">
                                    <label>@lang('general.category_name')</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">@lang('general.choice_category')</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- السعر --}}
                                <div class="mb-4">
                                    <label>@lang('general.price')</label>
                                    <input type="number" step="0.01" name="price" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- السعر قبل الخصم --}}
                                <div class="mb-4">
                                    <label>@lang('general.original_price')</label>
                                    <input type="number" step="0.01" name="original_price" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- المخزون --}}
                                <div class="mb-4">
                                    <label>@lang('general.stock')</label>
                                    <input type="number" name="stock" class="form-control" value="0">
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- الصورة --}}
                                <div class="mb-4">
                                    <label>@lang('general.product_image')</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                    <div class="invalid-feedback"></div>
                                </div>





                            </div>
                        </div>

                        <div class="modal-footer mb-3">
                            <button class="btn btn-outline-success col-12" type="submit">
                                @lang('general.add')
                            </button>

                            <button type="button" class="btn btn-outline-secondary col-12 mb-3" data-bs-dismiss="modal">
                                @lang('general.close')
                            </button>
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
                        <h5 class="modal-title" id="stagesModalLabel">@lang('general.update_product') </h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <form method="post" action="{{ route('dash.products.update') }}" id="update-form" class="update-form"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">

                        <div class="modal-body">
                            <div class="container">

                                {{-- اسم المنتج --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.product_name')</label>
                                    <input name="name" id="name" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>
                                {{-- التصنيف --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.category_name')</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option value="">@lang('general.choice_category')</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                {{-- Slug --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.slug')</label>
                                    <input name="slug" id="slug" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- الوصف --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.product_description')</label>
                                    <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>



                                {{-- السعر --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.price')</label>
                                    <input type="number" step="0.01" name="price" id="price"
                                        class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- السعر قبل الخصم --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.original_price')</label>
                                    <input type="number" step="0.01" name="original_price" id="original_price"
                                        class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                {{-- المخزون --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.stock')</label>
                                    <input type="number" name="stock" id="stock" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>
                                {{-- الحالة --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.status')</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                {{-- الصورة --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.product_image')</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                </div>

                                {{-- صورة حالية --}}
                                <div class="mb-3">
                                    <img id="current-image" src="" style="max-width:120px; display:none;"
                                        class="img-thumbnail">
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
                                    placeholder="@lang('general.product_name')">
                            </div>

                            {{-- اسم المتجر --}}
                            <div class="col-md-4 mb-3">
                                <input type="text" id="search-category" class="form-control"
                                    placeholder="@lang('general.category_name')">
                            </div>

                            {{-- وصف التصنيف --}}
                            <div class="col-md-4 mb-3">
                                <input type="text" id="search-description" class="form-control search-input"
                                    placeholder="@lang('general.product_description')">
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
                                @lang('general.add_new_product')
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
                                <h5 class="mb-0">@lang('general.all_products')</h5>
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
                                        <th>@lang('general.product_name')</th>
                                        <th>@lang('general.category_name')</th>
                                        <th>@lang('general.product_description')</th>
                                        <th>@lang('general.slug')</th>
                                        <th>@lang('general.original_price')</th>
                                        <th>@lang('general.stock')</th>
                                        <th>@lang('general.price')</th>
                                        <th>@lang('general.status')</th>
                                        <th>@lang('general.product_image')</th>
                                        <th>@lang('general.operations')</th>
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
                url: "{{ route('dash.products.getdata') }}",
                data: function(d) {
                    d.name = $('#search-name').val();
                    d.category = $('#search-category').val();
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
                    title: "@lang('general.product_name')",
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'category',
                    name: 'category',
                    title: "@lang('general.category_name')",
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'description',
                    name: 'description',
                    title: "@lang('general.product_description')",
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'slug',
                    name: 'slug',
                    title: "@lang('general.slug')",
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'original_price',
                    name: 'original_price',
                    title: "@lang('general.original_price')",
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
                    data: 'stock',
                    name: 'stock',
                    title: "@lang('general.stock')",
                    orderable: true,
                    searchable: false,
                },

                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'image',
                    name: 'image',
                    title: "@lang('general.product_image')",
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'action',
                    name: 'action',
                    title: "@lang('general.operations')",
                    orderable: false,
                    searchable: false,
                },
            ],

            language: {
                url: "{{ asset('datatable_custom/i18n/ar.json') }}",
            }
        });

        // زر البحث
        $('#search-btn').on('click', function() {
            table.draw();
        });


        // تعبئة مودال التعديل
        $(document).on('click', '.update_btn', function(e) {
            e.preventDefault();

            $('#id').val($(this).data('id'));
            $('#name').val($(this).data('name'));
            $('#category_id').val($(this).data('category_id'));
            $('#original_price').val($(this).data('original_price'));
            $('#price').val($(this).data('price'));
            $('#stock').val($(this).data('stock'));
            $('#status').val($(this).data('status'));
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
