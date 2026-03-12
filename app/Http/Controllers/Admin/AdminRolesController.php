<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class AdminRolesController extends Controller
{
    /**
     * الأدوار المقفولة
     */
    private array $lockedRoles = ['super_admin'];

    /**
     * صفحة تعيين الأدوار للمستخدمين
     */
    public function view()
    {
        $roles = Role::query()
            ->whereNotIn('name', $this->lockedRoles)
            ->when(
                Schema::hasColumn('roles', 'status'),
                fn($q) => $q->where('status', 'active')
            )
            ->orderBy('name')
            ->get();

        return view('dashboard.admins.role-admin', compact('roles'));
    }

    /**
     * DataTable للمستخدمين
     */
    public function getdata(Request $request)
    {
        $users = User::query()->with('roles:id,name');

        return DataTables::of($users)
            ->filter(function ($q) use ($request) {
                if ($request->get('name')) {
                    $q->where('name', 'like', '%' . $request->name . '%');
                }

                if ($request->get('email')) {
                    $q->where('email', 'like', '%' . $request->email . '%');
                }
            })
            ->addIndexColumn()

            ->addColumn('email', fn($u) => e($u->email))

            ->addColumn('roles', function ($u) {
                $roles = $u->roles
                    ->pluck('name')
                    ->reject(fn($r) => $r === 'super_admin')
                    ->values();

                if ($roles->isEmpty()) {
                    return '<span class="badge bg-secondary">بدون دور</span>';
                }

                return $roles->map(
                    fn($r) =>
                    '<span class="badge bg-info me-1">' . e($r) . '</span>'
                )->implode(' ');
            })

            ->addColumn('action', function ($u) {

                /** @var \App\Models\User|null $auth */
                $auth = auth()->user();
                if (!$auth) return '-';

                // ❌ لا تعدّل نفسك
                if ($u->id === $auth->id) {
                    return '<span class="text-muted">لا يمكن تعديل نفسك</span>';
                }

                // ❌ لا يعبث بـ super_admin إلا super_admin
                if ($u->hasRole('super_admin') && !$auth->hasRole('super_admin')) {
                    return '-';
                }

                $btns = [];

                // attributes مشتركة
                $dataAttr  = 'data-id="' . $u->id . '" ';
                $dataAttr .= 'data-name="' . e($u->name) . '" ';
                $dataAttr .= 'data-email="' . e($u->email) . '" ';



                /* ======================
                * ✏️ تعديل الأدوار للمستخدم )
                * ====================== */
                if ($auth->can('user_roles.update')) {
                    $btns[] = '<a href="javascript:;"
                    class="text-warning update_btn"
                    ' . $dataAttr . '
                    data-checked-url="' . route('dash.admin-role.rolesChecked', $u->id) . '"
                    data-bs-toggle="modal"
                    data-bs-target="#update-modal"
                    title="تعديل">
                    <i class="bi bi-pencil-fill"></i>
                    </a>';
                }
                /* ======================
                 * 🔁 تفعيل / تعطيل المستخدم
                 * ====================== */
                $status = $u->status ?? 'active';

                if ($status === 'active') {
                    if ($auth->can('user_roles.active')) {
                        $btns[] = '<a href="javascript:;"
                            class="action-btn btn-inactive toggle-status-btn"
                            data-id="' . $u->id . '"
                            data-url="' . route('dash.admin-role.inactive') . '"
                            title="تعطيل">
                            <i class="bi bi-x-circle-fill"></i>
                        </a>';
                    }
                } else {
                    if ($auth->can('user_roles.active')) {
                        $btns[] = '<a href="javascript:;"
                            class="action-btn btn-active toggle-status-btn"
                            data-id="' . $u->id . '"
                            data-url="' . route('dash.admin-role.active') . '"
                            title="تفعيل">
                            <i class="bi bi-check-circle-fill"></i>
                        </a>';
                    }
                }

                /* ======================
                 * 🗑 حذف المستخدم
                   * ====================== */
                if ($auth->can('user_roles.delete')) {
                    $btns[] = '<a href="javascript:;"
                            data-id="' . $u->id . '"
                            data-url="' . route('dash.admin-role.delete') . '"
                            class="text-danger btn-delete"
                            title="حذف">
                            <i class="bi bi-trash-fill"></i></a>';
                }

                if (empty($btns)) return '-';

                return '<div class="d-flex align-items-center gap-3 fs-6">'
                    . implode('', $btns) .
                    '</div>';
            })
            ->rawColumns(['roles', 'action'])
            ->make(true);
    }

    /**
     * جلب أدوار مستخدم (لـ checkbox checked)
     */


    /**
     * إضافة / تعيين أدوار لمستخدم (Ajax)
     */
    public function store(Request $request)
    {
        /** @var \App\Models\User|null $auth */
        $auth = auth()->user();

        $validated = $request->validate([
            'email' => ['required', 'email'],
            'name'  => ['nullable', 'string', 'max:255'], // لو بدك تنشئي مستخدم جديد
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
        ]);

        // (اختياري) منع تعديل نفسك
        if ($validated['email'] === $auth->email) {
            return response()->json(['error' => 'لا يمكنك تعديل نفسك'], 403);
        }

        $rolesRequested = $validated['roles'] ?? [];

        // حماية super_admin
        if (collect($rolesRequested)->contains('super_admin') && !$auth->hasRole('super_admin')) {
            return response()->json(['error' => 'غير مسموح إعطاء super_admin'], 403);
        }

        // منع أدوار غير مفعّلة
        if (Schema::hasColumn('roles', 'status')) {
            $active = Role::whereIn('name', $rolesRequested)
                ->where('status', 'active')
                ->pluck('name')
                ->toArray();

            if (count($active) !== count($rolesRequested)) {
                return response()->json(['error' => 'يوجد دور غير مفعّل'], 422);
            }
        }

        // ✅ updateOrCreate على USER نفسه
        $user = User::updateOrCreate(
            ['email' => $validated['email']],
            array_filter([
                'name' => $validated['name'] ?? null, // لو فاضي ما يحدثه (بفضل array_filter)
            ])
        );

        // (اختياري) منع العبث بـ super_admin user
        if ($user->hasRole('super_admin') && !$auth->hasRole('super_admin')) {
            return response()->json(['error' => 'غير مسموح تعديل super_admin'], 403);
        }

        // ✅ هذا هو “update/create” الحقيقي للربط (pivot) بدون ما تلمسيه يدويًا
        $user->syncRoles($rolesRequested);

        return response()->json(['success' => 'تم حفظ الأدوار بنجاح']);
    }

    /**
     * تحديث أدوار مستخدم (Ajax)
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User|null $auth */
        $auth = auth()->user();



        $validated = $request->validate([
            'id'      => ['required', 'integer', 'exists:users,id'],
            'roles'   => ['nullable', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
        ]);

        $user = User::with('roles')->findOrFail($validated['id']);

        // ❌ لا تعدّل نفسك
        if ((int)$user->id === (int)$auth->id) {
            return response()->json(['error' => 'لا يمكنك تعديل نفسك'], 403);
        }

        // ❌ لا يعبث بـ super_admin إلا super_admin
        if ($user->hasRole('super_admin') && !$auth->hasRole('super_admin')) {
            return response()->json(['error' => 'غير مسموح تعديل super_admin'], 403);
        }

        $rolesRequested = $validated['roles'] ?? [];

        // ❌ منع إعطاء super_admin لغير super_admin
        if (collect($rolesRequested)->contains('super_admin') && !$auth->hasRole('super_admin')) {
            return response()->json(['error' => 'غير مسموح إعطاء super_admin'], 403);
        }

        // ✅ منع اختيار أدوار غير مفعّلة (لو عندك عمود status بالroles)
        if (Schema::hasColumn('roles', 'status') && !empty($rolesRequested)) {
            $active = Role::whereIn('name', $rolesRequested)
                ->where('status', 'active')
                ->pluck('name')
                ->toArray();

            if (count($active) !== count($rolesRequested)) {
                return response()->json(['error' => 'يوجد دور غير مفعّل'], 422);
            }
        }

        // ✅ التحديث الحقيقي للـ pivot model_has_roles
        $user->syncRoles($rolesRequested);

        return response()->json([
            'success' => 'تم تحديث الأدوار بنجاح'
        ]);
    }

    public function inactive(Request $request)
    {
        $user = User::findOrFail($request->id);

        if ((int)$user->id === (int)auth()->id()) {
            return response()->json(['error' => 'لا يمكنك تعطيل نفسك'], 403);
        }
        if ($user->hasRole('super_admin')) {
            return response()->json(['error' => 'لا يمكنك تعطيل super_admin'], 403);
        }

        $user->update(['status' => 'inactive']);

        return response()->json(['success' => 'تم التعطيل']);
    }

    public function active(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->update(['status' => 'active']);

        return response()->json(['success' => 'تم التفعيل']);
    }
    public function delete(Request $request)
    {
        $auth = auth()->user();

        $request->validate([
            'id' => ['required', 'exists:users,id'],
        ]);

        $user = User::findOrFail($request->id);

        if ($user->id === $auth->id) {
            return response()->json(['error' => 'لا يمكنك تعديل نفسك'], 403);
        }

        if ($user->hasRole('super_admin')) {
            return response()->json(['error' => 'غير مسموح تعديل super_admin'], 403);
        }

        $user->syncRoles([]); // ✅ يحذف كل روابط model_has_roles

        return response()->json(['success' => 'تم حذف أدوار المستخدم']);
    }

    public function rolesChecked(User $user)
    {
        $roles = $user->roles()
            ->pluck('name')
            ->reject(fn($r) => $r === 'super_admin')
            ->values()
            ->toArray();

        return response()->json([
            'roles' => $roles
        ]);
    }
}
