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
                        <h5 class="modal-title" id="stagesModalLabel">@lang('general.Add New Admin')</h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <form method="post" action="{{ route('dash.admin.store') }}" id="add-form" class="add-form">
                        @csrf
                        <input type="hidden" name="id" id="edit-id">

                        <div class="modal-body">

                            <div class="container">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="mb-4 form-group">
                                    <label>@lang('general.name')</label>
                                    <input name="name" class="form-control" placeholder="@lang('general.name')">
                                    <div class="invalid-feedback"></div>

                                </div>
                                <div class="mb-4 form-group">
                                    <label>@lang('general.email')</label>
                                    <input name="email" type="email" class="form-control"
                                        placeholder="@lang('general.email')">
                                    <div class="invalid-feedback"></div>


                                </div>
                                <div class="mb-4 form-group">
                                    <label>@lang('general.phone')</label>
                                    <input name="phone" class="form-control" placeholder="@lang('general.phone')">
                                    <div class="invalid-feedback"></div>

                                </div>
                                <div class="mb-4 form-group">
                                    <label>@lang('general.gender')</label>
                                    <select name="gender" class="form-control">
                                        <option selected disabled>@lang('general.choose gender')</option>
                                        <option value="m">@lang('general.male')</option>
                                        <option value="f">@lang('general.female')</option>
                                    </select>
                                    <div class="invalid-feedback"></div>

                                </div>

                                <div class="mb-4 form-group">
                                    <label>@lang('general.date_of_birth')</label>
                                    <input name="date_of_birth" type="date" class="form-control">
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
                        <h5 class="modal-title" id="stagesModalLabel">@lang('general.Update Admin') </h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <form method="post" action="{{ route('dash.admin.update') }}" id="update-form" class="update-form">
                        <div class="modal-body">

                            <div class="container">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" id="id">
                                <div class="mb-4 form-group">
                                    <label>@lang('general.name')</label>
                                    <input name="name" id="name" class="form-control"
                                        placeholder="@lang('general.name')">
                                </div>
                                <div class="mb-4 form-group">
                                    <label>@lang('general.email')</label>
                                    <input name="email" id="email" type="email" class="form-control"
                                        placeholder="@lang('general.email')">
                                    <div class="invalid-feedback"></div>

                                </div>
                                <div class="mb-4 form-group">
                                    <label>@lang('general.phone')</label>
                                    <input name="phone" id="phone" class="form-control"
                                        placeholder="@lang('general.phone')">
                                    <div class="invalid-feedback"></div>

                                </div>

                                <div class="mb-4 form-group">
                                    <label>@lang('general.gender')</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option selected disabled>@lang('general.gender')</option>
                                        <option value="m">@lang('general.male')</option>
                                        <option value="f">@lang('general.female')</option>
                                    </select>
                                    <div class="invalid-feedback"></div>

                                </div>

                                <div class="mb-4 form-group">
                                    <label>@lang('general.date_of_birth')</label>
                                    <input name="date_of_birth" id="date_of_birth" type="date" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer mb-3">
                            <button class="btn btn-outline-info col-12" type="submit">@lang('general.update')</button>
                            <button type="button" class="btn btn-outline-secondary col-12 mb-3"
                                data-bs-dismiss="modal">@lang('general.close')</button>
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
                            <div class="col-md-4 mb-3">
                                <input type="text" id="search-name" class="form-control search-input"
                                    placeholder="@lang('general.name admin')">
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="email" id="search-email" class="form-control search-input"
                                    placeholder="@lang('general.email')">
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="text" id="search-phone" class="form-control  search-input"
                                    placeholder="@lang('general.phone')">
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
                                @lang('general.Add New Admin')
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
                                <h5 class="mb-0">@lang('general.all admins')</h5>
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
                                        <th>@lang('general.phone')</th>
                                        <th>@lang('general.date_of_birth')</th>
                                        <th>@lang('general.gender')</th>
                                        <th>@lang('general.status')</th>
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
                url: "{{ route('dash.admin.getdata') }}",
                data: function(n) {
                    n.name = $('#search-name').val();
                    n.email = $('#search-email').val();
                    n.phone = $('#search-phone').val();
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
                    title: '@lang('general.name')',
                    orderable: true,
                    searchable: true,
                },

                {
                    data: 'email',
                    name: 'email',
                    title: '@lang('general.email')',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'phone',
                    name: 'phone',
                    title: '@lang('general.phone')',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'date_of_birth',
                    name: 'date_of_birth',
                    title: '@lang('general.date_of_birth')',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'gender',
                    name: 'gender',
                    title: '@lang('general.gender')',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'status',
                    name: 'status',
                    title: '@lang('general.status')',
                    orderable: true,
                    searchable: true,
                },


                {
                    data: 'action',
                    name: 'action',
                    title: '@lang('general.operations')',

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



        $(document).ready(function() {
            $(document).on('click', '.update_btn', function(e) {
                e.preventDefault();
                var button = $(this);

                var name = button.data('name');
                var email = button.data('email');
                var phone = button.data('phone');
                var gender = button.data('gender');
                var date_of_birth = button.data('date_of_birth');
                var id = button.data('id');

                $('#name').val(name);
                $('#email').val(email);
                $('#phone').val(phone);
                $('#gender').val(gender);
                $('#date_of_birth').val(date_of_birth);
                $('#id').val(id);
            });
        });
    </script>




@stop
