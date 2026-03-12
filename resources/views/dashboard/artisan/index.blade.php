@extends('dashboard.master')
@section('title')
    @lang('general.Artisan')
@stop
@section('content')


    <main class="page-content">

        {{-- add modal --}}
        <div class="modal fade" id="add-modal" tabindex="-1" aria-labelledby="stagesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stagesModalLabel">@lang('general.add_new_artisan')</h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <form method="post" action="{{ route('dash.artisans.store') }}" id="add-form" class="add-form"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="edit-id">

                        <div class="modal-body">

                            <div class="container">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                {{-- Name --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.artisan_name')</label>
                                    <input name="name" class="form-control">
                                </div>
                                <!-- category -->
                                <div class="mb-4 form-group">
                                    <label>@lang('general.category')</label>
                                    <select name="category_id" class="form-control">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- location --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.artisan_location')</label>
                                    <input name="location" class="form-control">
                                </div>
                                {{-- bio --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.artisan_bio')</label>
                                    <textarea name="bio" class="form-control"></textarea>
                                </div>


                                {{-- image --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.artisan_image')</label>
                                    <input type="file" name="image" class="form-control">
                                    <div class="mb-3">
                                        <img id="current-image" src="" style="max-width:120px; display:none;"
                                            class="img-thumbnail">
                                    </div>
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
                        <h5 class="modal-title" id="stagesModalLabel">@lang('general.update_artisan') </h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <form method="post" action="{{ route('dash.artisans.update') }}" id="update-form" class="update-form"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">

                        <div class="modal-body">
                            <div class="container">



                                {{-- Name --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.artisan_name')</label>
                                    <input id="name" name="name" class="form-control">
                                </div>
                                <!-- category -->
                                <div class="mb-4 form-group">
                                    <label>@lang('general.category')</label>
                                    <select id="category_id" name="category_id" class="form-control">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- location --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.artisan_location')</label>
                                    <input id="location" name="location" class="form-control">
                                </div>
                                {{-- bio --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.artisan_bio')</label>
                                    <textarea id="bio" name="bio" class="form-control"></textarea>
                                </div>


                                {{-- status --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.status')</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="active">@lang('general.active')</option>
                                        <option value="inactive">@lang('general.inactive')</option>
                                    </select>
                                </div>

                                {{-- image --}}
                                <div class="mb-4 form-group">
                                    <label>@lang('general.artisan_image')</label>
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

                        <button class="btn btn-outline-primary col-12 btn-add " data-bs-toggle="modal"
                            data-bs-target="#add-modal">
                            @lang('general.add_new_artisan')
                        </button>

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
                                <h5 class="mb-0">@lang('general.all_artisans')</h5>
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
                                        <th>@lang('general.artisan_name')</th>
                                        <th>@lang('general.artisan_category')</th>
                                        <th>@lang('general.artisan_bio')</th>
                                        <th>@lang('general.artisan_location')</th>
                                        <th>@lang('general.artisan_image')</th>
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
                url: "{{ route('dash.artisans.getdata') }}",

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
                    title: "@lang('general.artisan_name')",
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'category',
                    name: 'category_id',
                    title: "@lang('general.category_name')",
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'bio',
                    name: 'bio',
                    title: "@lang('general.artisan_bio')",
                    orderable: false,
                    searchable: true,
                },
                {
                    data: 'location',
                    name: 'location',
                    title: "@lang('general.artisan_location')",
                    orderable: false,
                    searchable: true,
                },

                {
                    data: 'image',
                    name: 'image',
                    title: "@lang('general.artisan_image')",
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
            $('#name').val($(this).data('name'));
            $('#image').val($(this).data('image'));
            $('#category_id').val($(this).data('category_id'));
            $('#location').val($(this).data('location'));
            $('#status').val($(this).data('status'));
            $('#bio').val($(this).data('bio'));



         let image = $(this).data('image');

if (image) {
    $('#update-modal #current-image')
        .attr('src', image)
        .show();
} else {
    $('#update-modal #current-image').hide();
}
        });
    </script>





@stop
