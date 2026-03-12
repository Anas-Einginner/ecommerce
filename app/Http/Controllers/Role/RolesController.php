<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission; // ✅ Spatie Permission
use Yajra\DataTables\Facades\DataTables;

class RolesController extends Controller
{
    public function view()
    {
        $modules = config('app.modules'); // ✅ لازم

        $modulesLabels = $modules;

        $permissionsGrouped = Permission::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get()
            ->groupBy('model');

        return view(
            'dashboard.access.roles.index',
            compact('modulesLabels', 'permissionsGrouped', 'modules')
        );
    }
    private function moduleClassFromLabel(string $label): ?string
    {
        $module = config("app.modules.$label");

        if (is_array($module)) {
            return $module['model'] ?? null;
        }

        return is_string($module) ? $module : null;
    }
    public function getdata(Request $request)
    {
        $auth = auth()->user();
        $roles = Role::query();

        return DataTables::of($roles)
            ->filter(function ($qur) use ($request) {
                if ($request->get('name')) {
                    $qur->where('name', 'like', '%' . $request->get('name') . '%');
                }
            })
            ->addIndexColumn()
            ->addColumn('action', function ($qur) {
                /** @var \App\Models\User|null $auth */

                $auth = auth()->user();
                if (!$auth) return '-';

                if (in_array($qur->name, ['super_admin'], true)) {
                    return '-';
                }

                $btns = [];
                $data_attr  = 'data-id="' . $qur->id . '" ';
                $data_attr .= 'data-name="' . e($qur->name) . '" ';

                if ($auth->can('role.update')) {
                    $btns[] = '<a ' . $data_attr . '
                        data-bs-toggle="modal"
                        data-bs-target="#update-modal"
                        class="text-warning update_btn"
                        title="تعديل">
                        <i class="bi bi-pencil-fill"></i></a>';
                }

                $status = $qur->status ?? 'active';

                if ($status === 'active') {
                    if ($auth->can('role.inactive')) {
                        $btns[] = '<a data-id="' . $qur->id . '"
                            data-url="' . route('dash.roles.inactive') . '"
                            class="action-btn btn-inactive toggle-status-btn"
                            title="تعطيل">
                            <i class="bi bi-x-circle-fill"></i>
                        </a>';
                    }
                } else {
                    if ($auth->can('role.active')) {
                        $btns[] = '<a data-id="' . $qur->id . '"
                            data-url="' . route('dash.roles.active') . '"
                            class="action-btn btn-active toggle-status-btn"
                            title="تفعيل">
                            <i class="bi bi-check-circle-fill"></i>
                        </a>';
                    }
                }

                if ($auth->can('role.delete') && !in_array($qur->name, ['customer'], true)) {
                    $btns[] = '<a href="javascript:;"
                        data-id="' . $qur->id . '"
                        data-url="' . route('dash.roles.delete') . '"
                        class="text-danger btn-delete"
                        title="حذف">
                        <i class="bi bi-trash-fill"></i></a>';
                }

                if (empty($btns)) return '-';

                return '<div class="d-flex align-items-center gap-3 fs-6">'
                    . implode('', $btns) .
                    '</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $role = Role::updateOrCreate([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        $role->syncPermissions($validated['permissions'] ?? []);

        return response()->json(['success' => 'تمت العملية بنجاح']);
    }

    private array $lockedRoles = ['super_admin'];

    public function update(Request $request)
    {
        $role = Role::findOrFail($request->id);

        if (in_array($role->name, $this->lockedRoles, true)) {
            return response()->json([
                'error' => "غير مسموح تعديل دور {$role->name}"
            ], 403);
        }

        $validated = $request->validate([
            'id' => ['required', 'exists:roles,id'],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($role->id),
            ],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $role->update([
            'name' => $validated['name'],
        ]);

        $role->syncPermissions($validated['permissions'] ?? []);

        return response()->json(['success' => 'تمت العملية بنجاح']);
    }

    public function permissionsChecked(Role $role)
    {
        return response()->json([
            'success' => 'تم تحميل صلاحيات الدور',
            'permissions' => $role->permissions->pluck('name')->toArray(),
        ]);
    }
    public function delete(Request $request)
    {
        $role = Role::findOrFail($request->id);

        if (in_array($role->name, ['super_admin'], true)) {
            return response()->json([
                'error' => 'لا يمكن حذف هذا الدور'
            ], 403);
        }

        $role->delete();

        return response()->json([
            'success' => 'تم حذف الدور بنجاح'
        ]);
    }
}
