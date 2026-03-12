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
                        <h5 class="modal-title" id="stagesModalLabel">اضافة مدير جديد</h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                        <form method="post" action="{{ route('dash.admin-role.store') }}" id="add-form" class="add-form">
            

                        @csrf
                        <input type="hidden" name="id" id="edit-id">

                        <div class="modal-body">

                            <div class="container">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="mb-4 form-group">
                                    <label>@lang('البريد الالكتروني')</label>
                                    <input name="email" type="email" class="form-control"
                                        placeholder="@lang('البريد الالكتروني')">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">الأدوار</label>
                                    <small class="text-muted">اكتبي البريد ليتم تحديد أدواره تلقائيًا إذا كان موجود.</small>

                                    <div class="row" id="add-roles-box">
                                        @foreach ($roles as $r)
                                            <div class="col-md-4 mb-2">
                                                <label class="d-flex align-items-center gap-2">
                                                    <input type="checkbox" class="form-check-input add-role-chk"
                                                        name="roles[]" value="{{ $r->name }}">
                                                    <span>{{ $r->name }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer mb-3">
                            <button class="btn btn-outline-success col-12" type="submit">@lang('اضافة')</button>
                            <button type="button" class="btn btn-outline-secondary col-12 mb-3"
                                data-bs-dismiss="modal">إغلاق</button>
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
                        <h5 class="modal-title" id="stagesModalLabel">تعديل دور المسوؤل </h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                     <form method="post" action="{{ route('dash.admin-role.update') }}" id="update-form" class="update-form">

                        {{-- @csrf --}}
                        <div class="modal-body">

                            <div class="container">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" id="id">
                                <input type="hidden" name="email" id="email">
                                <div class="mb-4 form-group">
                                    <label>@lang('البريد الالكتروني')</label>
                                    <input name="email" id="email" type="email" class="form-control"
                                        placeholder="@lang('البريد الالكتروني')" readonly>
                                    <div class="invalid-feedback"></div>

                                </div>
                                <div class="mb-3">
                                    <label class="form-label">الأدوار</label>

                                    <div class="row g-2" id="update-roles-box">
                                        @foreach ($roles as $role)
                                            <div class="col-12 col-md-4">
                                                <label class="d-flex align-items-center gap-2 m-0">
                                                    <input type="checkbox" class="form-check-input" name="roles[]"
                                                        value="{{ $role->name }}">
                                                    <span>{{ $role->name }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="text-danger small roles-error mt-2"></div>
                                </div>



                            </div>
                        </div>
                        <div class="modal-footer mb-3">
                            <button class="btn btn-outline-info col-12" type="submit">@lang('تعديل')</button>
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
                                <h5 class="mb-0"> التصفية</h5>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <input type="text" id="search-name" class="form-control search-input"
                                    placeholder="@lang('اسم المسؤول')">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="email" id="search-email" class="form-control search-input"
                                    placeholder="@lang('البريد الإلكتروني')">
                            </div>

                        </div>
                        <div class="d-flex justify-content-end gap-2 mb-3">
                            <button type="submit" id="search-btn" class="btn btn-outline-success col-6">بحث</button>
                            <button type="reset" id="clear-btn" class="btn btn-outline-secondary col-6 ">تنظيف</button>
                        </div>
                       @can('user_roles.store')
                           
                       <button class="btn btn-outline-primary col-12 btn-add " data-bs-toggle="modal"
                       data-bs-target="#add-modal">
                       اضافة دور جديد لمستخدم
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
                                <h5 class="mb-0">جميع المسؤولين مع الأدوار</h5>
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
                                        <th>الاسم</th>
                                        <th>البريد الالكتروني</th>
                                        <th>الدور</th>
                                        <th>العمليات</th>
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
                url: "{{ route('dash.admin-role.getdata') }}",
                data: function(n) {
                    n.name = $('#search-name').val();
                    n.email = $('#search-email').val();
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
                    title: 'الاسم',
                    orderable: true,
                    searchable: true,
                },

                {
                    data: 'email',
                    name: 'email',
                    title: 'البريد الالكتروني',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'roles',
                    name: 'roles',
                    title: 'الدور',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'action',
                    name: 'action',
                    title: 'العمليات',

                    orderable: false,
                    searchable: false,
                },

            ],

            language: {
                url: "{{ asset('datatable_custom/i18n/ar.json') }}",
            }
        });




        // $(document).on('submit', '#add-form', function(e) {
        //     e.preventDefault();

        //     const form = $(this);
        //     const url = form.data('url');
        //     const data = new FormData(this);

        //     $.ajax({
        //         url: url,
        //         type: 'POST',
        //         processData: false,
        //         contentType: false,
        //         data: data,
        //         success: function(res) {
        //             $('#add-modal').modal('hide');
        //             form[0].reset();
        //             $('#add-modal .add-role-chk').prop('checked', false);

        //             toastr.success(res.success || 'تمت الإضافة');
        //             table.draw(false);
        //         },
        //         error: function(xhr) {
        //             console.log(xhr.responseText);
        //             toastr.error('فشلت الإضافة');
        //         }
        //     });
        // });
       
        $(document).on('click', '.update_btn', function(e) {
            e.preventDefault();

            const btn = $(this);

            const form = $('#update-form'); 
            form.find('input[name="id"]').val(btn.data('id'));
            form.find('input[name="name"]').val(btn.data('name'));
            form.find('input[name="email"]').val(btn.data('email'));

            // ✅ امسحي القديم
            form.find('input[name="roles[]"]').prop('checked', false);

            // ✅ جيبي الأدوار وشيّكيها
            const checkedUrl = btn.data('checked-url');
            $.get(checkedUrl, function(res) {
                const roles = res.roles || [];
                roles.forEach(function(roleName) {
                    form.find('input[name="roles[]"][value="' + roleName + '"]').prop('checked',
                        true);
                });
            });
        });
        
    </script>




@stop
