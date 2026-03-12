<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    function view()
    {
        $roles = ['admin', 'super_admin', 'customer'];
        return view('dashboard.admins.index', compact('roles'));
    }

    function getdata(Request $request)
    {
        /** @var \App\Models\User|null $auth */
        $auth = auth()->user();
        $authId = $auth->id;
        $isMeSuperAdmin = $auth->hasRole('super_admin');

        $users = User::query()
            ->where(function ($q) use ($authId) {

                // المستخدم الحالي دائمًا
                $q->where('id', $authId)

                    // أو باقي المستخدمين حسب الأدوار
                    ->orWhere(function ($q2) {

                        $q2->where(function ($q3) {

                            // ✅ ما إله أي دور
                            $q3->whereDoesntHave('roles')

                                // ✅ أو إله أدوار لكن ولا واحد منهم customer
                                ->orWhereDoesntHave('roles', function ($r) {
                                    $r->where('name', 'customer');
                                });
                        });
                    });
            })

            // ✅ إذا أنا مش super_admin: اخفي كل اللي عليهم دور super_admin
            ->when(!$isMeSuperAdmin, function ($q) {
                $q->whereDoesntHave('roles', function ($r) {
                    $r->where('name', 'super_admin');
                });
            });
        return DataTables::of($users)
            ->filter(function ($qur) use ($request) {
                if ($request->get('name')) {
                    // like %...% , %.. , ..%
                    $qur->where('name', 'like', '%' .  $request->get('name') . '%');
                }

                if ($request->get('phone')) {
                    $qur->where('phone', 'like', '%' .  $request->get('phone') . '%');
                }


                if ($request->get('email')) {
                    $qur->where('email', 'like', '%' . $request->get('email') . '%');
                }
            })
            ->addIndexColumn()
            ->addColumn('email', function ($qur) {
                return $qur->email;
            })
            ->addColumn('gender', function ($qur) {

                if (!$qur->gender) {
                    return '-';
                }

                $gender = strtolower($qur->gender);

                // ذكر
                if (in_array($gender, ['m', 'ذكر'])) {
                    return '<span class="badge bg-primary text-white">'
                        . __('general.male')
                        . '</span>';
                }

                // أنثى
                if (in_array($gender, ['f', 'أنثى'])) {
                    return '<span class="badge bg-pink text-white">'
                        . __('general.female')
                        . '</span>';
                }

                return '-';
            })
            ->addColumn('status', function ($qur) {

                if ($qur->status == 'active') {
                    return '<span class="badge bg-success text-white">'
                        . __('general.active') .
                        '</span>';
                }

                return '<span class="badge bg-secondary text-white">'
                    . __('general.inactive') .
                    '</span>';
            })


            ->addColumn('action', function ($qur) {

                /** @var \App\Models\User|null $auth */
                $auth = auth()->user();
                if (!$auth) return '-';

                // ✅ Spatie checks
                $isMeSuperAdmin     = $auth->hasRole('super_admin');
                $isTargetSuperAdmin = $qur->hasRole('super_admin');
                $isSelf             = ($qur->id === $auth->id);

                // إذا أنا مش سوبر أدمن والهدف سوبر أدمن: امنع كل الأزرار
                if (!$isMeSuperAdmin && $isTargetSuperAdmin) {
                    return '-';
                }

                $data_attr  = 'data-id="' . $qur->id . '" ';
                $data_attr .= 'data-name="' . e($qur->name) . '" ';
                $data_attr .= 'data-email="' . e($qur->email) . '" ';
                $data_attr .= 'data-phone="' . e($qur->phone) . '" ';
                $data_attr .= 'data-gender="' . e($qur->gender) . '" ';
                $data_attr .= 'data-status="' . e($qur->status) . '" ';
                $data_attr .= 'data-date_of_birth="' . e($qur->date_of_birth) . '" ';

                $btns = [];

                // ✏️ تعديل
                if (!$isSelf && $auth->can('user.update')) {
                    $btns[] = '<a ' . $data_attr . ' data-bs-toggle="modal" data-bs-target="#update-modal"
            class="text-warning update_btn" title="تعديل">
            <i class="bi bi-pencil-fill"></i></a>';
                }

                // 🔁 تعطيل
                if (!$isSelf && $qur->status === 'active' && $auth->can('user.active')) {
                    $btns[] = '<a data-id="' . $qur->id . '"
            data-url="' . route('dash.admin.inactive') . '"
            class="action-btn btn-inactive toggle-status-btn"
            data-status="active" title="تعطيل">
            <i class="bi bi-x-circle-fill"></i></a>';
                }

                // ✅ تفعيل
                if (!$isSelf && $qur->status !== 'active' && $auth->can('user.active')) {
                    $btns[] = '<a data-id="' . $qur->id . '"
            data-url="' . route('dash.admin.active') . '"
            class="action-btn btn-active toggle-status-btn"
            data-status="inactive" title="تفعيل">
            <i class="bi bi-check-circle-fill"></i></a>';
                }

                // 🗑 حذف (امنع حذف super_admin + امنع حذف customer)
                if (!$isSelf && $auth->can('user.delete')) {
                    if (!$isTargetSuperAdmin && !$qur->hasRole('customer')) {
                        $btns[] = '<a href="javascript:;"
                data-id="' . $qur->id . '"
                data-url="' . route('dash.admin.delete') . '"
                class="text-danger btn-delete" title="حذف">
                <i class="bi bi-trash-fill"></i></a>';
                    }
                }

                return empty($btns)
                    ? '-'
                    : '<div class="d-flex align-items-center gap-3 fs-6 justify-content-start">' . implode('', $btns) . '</div>';
            })


            ->rawColumns(['status', 'gender', 'action'])
            ->make(true);
    }

    function store(Request $request)
    {
        $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone'  => ['required', 'unique:users,phone'],
            'gender' => ['required', 'in:m,f'],
            'date_of_birth' => ['required', 'date'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('12345678'),
            'gender' => $request->gender,
            'status' => 'active',
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }

    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);

        $validated = $request->validate([
            'id' => ['required', 'exists:users,id'],

            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', Rule::unique('users', 'phone')->ignore($user->id)],
            'gender' => ['required', 'in:m,f'],
            'date_of_birth' => ['required', 'date'],

        ]);

        if ($user->id === auth()->id() && $validated['status'] === 'inactive') {

            unset($validated['status']);

            $user->update($validated);

            return response()->json([
                'error' => 'لا يمكنك تعطيل حسابك بنفسك، تم حفظ باقي التعديلات'
            ], 403);
        }

        $user->update($validated);

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }

    function inactive(Request $request)
    {

        $user = User::findOrFail($request->id);

        if ($user->id === auth()->id()) {
            return response()->json([
                'error' => 'لا يمكنك تعطيل حسابك بنفسك'
            ], 403);
        }


        $user->update([
            'status' => 'inactive',
        ]);

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }


    function active(Request $request)
    {
        $user = User::query()->findOrFail($request->id);
        if ($user) {
            $user->update([
                'status' => 'active',
            ]);
        }
        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }

    public function delete(Request $request)
    {
        $user = User::findOrFail($request->id);

        // ممنوع حذف customer فقط
        if ($user->hasRole('customer')) {
            return response()->json([
                'error' => 'لا يمكن حذف العميل، يمكنك فقط تعطيله.'
            ], 403);
        }

        // (اختياري) ممنوع تحذفي نفسك
        if ($user->id === auth()->id()) {
            return response()->json([
                'error' => 'لا يمكنك حذف حسابك.'
            ], 403);
        }
        if ($user->hasRole('super_admin')) {
            return response()->json(['error' => 'لا يمكن حذف السوبر أدمن'], 403);
        }
        $user->delete();
        return response()->json(['success' => 'تم الحذف']);
    }
}
