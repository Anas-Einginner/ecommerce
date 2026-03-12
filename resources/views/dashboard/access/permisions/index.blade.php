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
                        <h5 class="modal-title" id="stagesModalLabel">@lang('general.add_new_permission')</h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <form method="post" action="{{ route('dash.permissions.store') }}" id="add-form" class="add-form">
                        @csrf
                        <div class="modal-body">

                            <div class="container">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="mb-2 form-group">
                                    <label class="form-label">@lang('general.permission_name')</label>
                                    <input placeholder="@lang('general.permission_name')" name="name" class="form-control"
                                        type="text">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-2 form-group">
                                    <label class="form-label">@lang('general.permission_description ')</label>
                                    <input id="add-description" name="description" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">@lang('general.permissions_group')
                                    </label>
                                    <select name="model" class="form-select">
                                        <option value="">@lang('general.select_group')</option>

                                        @foreach ($modules as $label => $module)
                                            @php $key = $module['key'] ?? null; @endphp
                                            @if ($key)
                                                <option value="{{ $key }}">{{ $label }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                    @error('model')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer mb-3">
                            @can('permission.store')
                                <button class="btn btn-outline-success col-12" type="submit">@lang('general.add')</button>
                                <button type="button" class="btn btn-outline-secondary col-12 mb-3"
                                    data-bs-dismiss="modal">@lang('general.close')</button>
                            @endcan
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
                        <h5 class="modal-title" id="stagesModalLabel">@lang('general.update')</h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <form method="post" action="{{ route('dash.permissions.update') }}" id="update-form"
                        class="update-form">
                        <div class="modal-body">

                            <div class="container">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" id="id">
                                <div class="mb-2 form-group">
                                    <label class="form-label">@lang('general.permission_name')</label>
                                    <input placeholder="@lang('general.permission_name')" name="name" id="name"
                                        class="form-control" type="text">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-2 form-group">
                                    <label class="form-label">@lang('general.permission_description')</label>
                                    <input id="update-description" placeholder="@lang('general.permission_description')" name="description"
                                        class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-4">
                                    <select name="model" id="model" class="form-select">
                                        <option value="">@lang('general.select_group')</option>

                                        @foreach ($modules as $label => $module)
                                            @php $key = $module['key'] ?? null; @endphp
                                            @if ($key)
                                                <option value="{{ $key }}">{{ $label }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('model')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer mb-3">
                            <button class="btn btn-outline-info col-12" type="submit">تعديل</button>
                            <button type="button" class="btn btn-outline-secondary col-12 mb-3"
                                data-bs-dismiss="modal">إغلاق</button>
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
                            <div class="col">
                                <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12 mb-3">
                                <input type="text" id="search-name" class="form-control search-input"
                                    placeholder="@lang('general.permission_name')"> ">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mb-3">
                            <button type="submit" id="search-btn"
                                class="btn btn-outline-success col-6">@lang('general.search')</button>
                            <button type="reset" id="clear-btn"
                                class="btn btn-outline-secondary col-6 ">@lang('general.clean')</button>
                        </div>
                        {{-- @can('Permission.store') --}}
                        <button class="btn btn-outline-primary col-12 btn-add " data-bs-toggle="modal"
                            data-bs-target="#add-modal">
                            @lang('general.add_new_permission')
                        </button>
                        {{-- @endcan --}}

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
                                <h5 class="mb-0">@lang('general.all_permission')</h5>
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
                                        <th>@lang('general.permission_name')</th>
                                        <th>@lang('general.permission_description')</th>
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
                url: "{{ route('dash.permissions.getdata') }}",
                data: function(n) {
                    n.name = $('#search-name').val();
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
                    title: '@lang('general.permission_name')',
                    orderable: true,
                    searchable: true,
                },

                {
                    name: 'desc',
                    data: 'desc',
                    title: '@lang('general.permission_description')',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'action',
                    name: 'action',
                    title: '@lang('general.actions')',
                    orderable: false,
                    searchable: false,
                },

            ],

            language: {
                url: "{{ asset('datatable_custom/i18n/ar.json') }}",
            }
        });



        $(document).ready(function() {
            $(document).on('click', '.update_btn', function(e) {
                e.preventDefault();
                var button = $(this);
                var name = button.data('name');
                var model = button.data('model');
                var description = button.data('description');
                var id = button.data('id');

                $('#update-modal #id').val($(this).data('id'));
                $('#update-modal #name').val($(this).data('name'));
                $('#update-modal #update-description').val($(this).data('description'));
                $('#update-modal #model').val($(this).data('model'));

            });
        });
    </script>




@stop
