@extends('dashboard.master')

@section('title')
    لوحة التحكم | إدارة الأدوار
@stop

@section('content')
    <main class="page-content">

        {{-- ===================== UPDATE MODAL ===================== --}}
        <div class="modal fade" id="update-modal" tabindex="-1" aria-labelledby="updateRoleLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="updateRoleLabel">تعديل الدور</h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>

                    <form method="post" action="{{ route('dash.roles.update') }}" id="update-form-role"
                        class="update-form-role">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">

                            <div class="mb-3 form-group">
                                <label class="form-label">الاسم</label>
                                <input name="name" id="name" class="form-control" placeholder="الاسم">
                            </div>
                            <div class="mb-4 form-group">
                                <label class="form-label">الصلاحيات</label>

                                <div class="row g-3" id="update-permissions-wrap">
                                    @foreach ($modules as $label => $module)
                                        @php
                                            // key من config (user / role / permission / user_roles)
                                            $moduleKey = is_array($module)
                                                ? $module['key'] ?? strtolower(class_basename($module['model'] ?? ''))
                                                : strtolower(class_basename($module));

                                            $list = $permissionsGrouped[$moduleKey] ?? collect();
                                        @endphp

                                        <div class="col-12 col-md-4">
                                            <div class="border rounded p-3 h-100 module-box"
                                                data-module="{{ $moduleKey }}">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h6 class="mb-0">{{ $label }}</h6>
                                                    <button type="button" class="btn btn-sm btn-outline-primary select-all"
                                                        data-module="{{ $moduleKey }}">
                                                        تحديد الكل
                                                    </button>
                                                </div>

                                                @forelse($list as $perm)
                                                    <label class="d-flex align-items-center gap-2 m-0 mb-1">
                                                        <input type="checkbox" class="form-check-input perm-checkbox"
                                                            name="permissions[]" value="{{ $perm->name }}">
                                                        <span>{{ $perm->description }}</span>
                                                    </label>
                                                @empty
                                                    <small class="text-muted">لا توجد صلاحيات لهذه المجموعة</small>
                                                @endforelse
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="invalid-feedback"></div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-outline-info col-12" type="submit">تعديل</button>
                            <button type="button" class="btn btn-outline-secondary col-12"
                                data-bs-dismiss="modal">إغلاق</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        {{-- ========================================================= --}}


        {{-- ===================== FILTER + ADD FORM CARD ===================== --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card radius-10 w-100">

                    <div class="card-header bg-transparent">
                        <h5 class="mb-0">التصفية</h5>
                    </div>

                    <div class="card-body">

                        {{-- Filter --}}
                        <div class="row g-2 mb-4">
                            <div class="col-md-9">
                                <input type="text" id="search-name" class="form-control search-input"
                                    placeholder="اسم الدور">
                            </div>
                            <div class="col-md-3 d-flex gap-2">
                                <button type="button" id="search-btn" class="btn btn-outline-success w-50">بحث</button>
                                <button type="button" id="clear-btn" class="btn btn-outline-secondary w-50">تنظيف</button>
                            </div>
                        </div>

                        <hr>

                        {{-- Add Role Form --}}
                        <h6 class="mb-3">إضافة دور جديد</h6>

                        <form method="post" action="{{ route('dash.roles.store') }}" id="add-form">
                            @csrf

                            <div class="mb-5 form-group">
                                <label class="form-label">@lang('اسم الدور')</label>
                                <input name="name" class="form-control" placeholder="مثال: admin">
                                <div class="invalid-feedback"></div>
                            </div>

                            {{-- 2) هون حطي كود الموديلات + الصلاحيات --}}
                            @php
                                use Illuminate\Support\Str;
                            @endphp

                            <div class="row g-3">
                                @foreach ($modules as $label => $module)
                                    @php
                                        // key من config (user / role / permission / user_roles)
                                        $moduleKey = is_array($module)
                                            ? $module['key'] ?? strtolower(class_basename($module['model'] ?? ''))
                                            : strtolower(class_basename($module));

                                        $list = $permissionsGrouped[$moduleKey] ?? collect();
                                    @endphp

                                    <div class="col-12 col-md-4">
                                        <div class="border rounded p-3 h-100 module-box" data-module="{{ $moduleKey }}">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0">{{ $label }}</h6>
                                                <button type="button" class="btn btn-sm btn-outline-primary select-all"
                                                    data-module="{{ $moduleKey }}">
                                                    تحديد الكل
                                                </button>
                                            </div>

                                            @forelse($list as $perm)
                                                <label class="d-flex align-items-center gap-2 m-0 mb-1">
                                                    <input type="checkbox" class="form-check-input perm-checkbox"
                                                        name="permissions[]" value="{{ $perm->name }}">
                                                    <span>{{ $perm->description }}</span>
                                                </label>
                                            @empty
                                                <small class="text-muted">لا توجد صلاحيات لهذه المجموعة</small>
                                            @endforelse
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- 3) زر الحفظ --}}
                            <div class="mt-3">
                                <button class="btn btn-outline-primary w-100" type="submit">إضافة</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
        {{-- =============================================================== --}}


        {{-- ===================== TABLE CARD ===================== --}}
        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12 d-flex">
                <div class="card radius-10 w-100">

                    <div class="card-header bg-transparent">
                        <div class="row g-3 align-items-center">
                            <div class="col">
                                <h5 class="mb-0">جميع الأدوار</h5>
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
                                        <th>العمليات</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        {{-- ======================================================= --}}

    </main>
@stop


@section('js')
    <script>
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('dash.roles.getdata') }}",
                data: function(n) {
                    n.name = $('#search-name').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name',
                    title: 'الاسم',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'action',
                    name: 'action',
                    title: 'العمليات',
                    orderable: false,
                    searchable: false
                },
            ],
            language: {
                url: "{{ asset('datatable_custom/i18n/ar.json') }}",
            }
        });

        // بحث / تنظيف
        $('#search-btn').on('click', function() {
            table.ajax.reload();
        });
        $('#clear-btn').on('click', function() {
            $('#search-name').val('');
            table.ajax.reload();
        });

        // تعبئة مودال التعديل
        $(document).on('click', '.update_btn', function(e) {
            e.preventDefault();
            var button = $(this);
            $('#name').val(button.data('name'));
            $('#id').val(button.data('id'));
        });
        $(document).on('click', '.select-all', function(e) {
            e.preventDefault();

            // ✅ خذ نفس البوكس اللي جوّه الزر
            const box = $(this).closest('.module-box');

            // ✅ كل الصلاحيات داخل هذا البوكس فقط
            const cbs = box.find('input.perm-checkbox');

            // ✅ لو بدك تشوفي هل لقى فعلاً
            // console.log('checkboxes:', cbs.length);

            // toggle: إذا فيه واحد مش محدد -> حدد الكل، غير هيك فك الكل
            const anyUnchecked = cbs.is(':not(:checked)');
            cbs.prop('checked', anyUnchecked).trigger('change');
        });



        $(document).on('click', '.update_btn', function() {

            const roleId = $(this).data('id');
            const roleName = $(this).data('name');

            // عبّي البيانات الأساسية
            $('#update-form-role #id').val(roleId);
            $('#update-form-role #name').val(roleName);

            // امسحي تحديد قديم
            $('#update-form-role').find('input[name="permissions[]"]').prop('checked', false);

            // ✅ جيبي صلاحيات الدور وشيّكي عليها
            $.ajax({
                url: "{{ route('dash.roles.permissionsChecked', ['role' => '__ROLE__']) }}".replace(
                    '__ROLE__', roleId),
                type: "GET",
                success: function(res) {
                    const perms = res.permissions || [];

                    // (اختياري) نجاح صامت بدون توستر
                    // toastr.success(res.success);

                    $('#update-form-role').find('input[name="permissions[]"]').prop('checked', false);

                    perms.forEach(function(p) {
                        $('#update-form-role')
                            .find('input[name="permissions[]"][value="' + p + '"]')
                            .prop('checked', true);
                    });
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    toastr.error('فشل تحميل صلاحيات الدور');
                }
            });
        });

        $(document).on('submit', '#update-form-role', function(e) {
            e.preventDefault();

            const form = $(this);
            const data = new FormData(this);

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method') || 'POST',
                data: data,
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#update-modal').modal('hide');
                    toastr.success(res.success || 'تمت العملية بنجاح');
                    if (typeof table !== 'undefined') table.draw();
                },
                error: function(xhr) {
                    toastr.warning('لا يمكن تعديل الدور');
                    console.log('انس');
                }
            });
        });
    </script>
@stop
