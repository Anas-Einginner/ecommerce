<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionsController extends Controller
{
    public function view()
    {
        $permissionsGrouped = Permission::orderBy('model')
            ->orderBy('name')
            ->get()
            ->groupBy('model');

        // modules للعرض (ترجمة فقط)
        $modules = config('app.modules');
        return view('dashboard.access.permisions.index', compact('modules'));
    }
    function getdata(Request $request)
    {
        $users = Permission::query();

        return DataTables::of($users)
            ->filter(function ($qur) use ($request) {
                if ($request->get('name')) {
                    // like %...% , %.. , ..%
                    $qur->where('name', 'like', '%' .  $request->get('name') . '%');
                }
            })
            ->addIndexColumn()
            ->addColumn('desc', function ($qur) {
                return  $qur->description;
            })
            ->addColumn('status', function ($qur) {
                return $qur->status === 'active'
                    ? '<span class="badge bg-success">مفعل</span>'
                    : '<span class="badge bg-secondary">معطل</span>';
            })
            ->addColumn('action', function ($qur) {

                /** @var \App\Models\User $auth */
                $auth = auth()->user();
                $data_attr = ' ';
              $data_attr  = 'data-id="' . $qur->id . '" ';
$data_attr .= 'data-name="' . e($qur->name) . '" ';
$data_attr .= 'data-description="' . e($qur->description) . '" ';
$data_attr .= 'data-model="' . e($qur->model) . '" ';


                $action = '';
                $action .= '<div class="d-flex align-items-center gap-3 fs-6 justify-content-start">';

                // زر التعديل

                $action .= '<a ' . $data_attr . ' data-bs-toggle="modal" data-bs-target="#update-modal" class="text-warning update_btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill "></i></a>';

                if (!$auth) {
                    return '-';
                }

                $btns = [];
                $data_attr  = 'data-id="' . $qur->id . '" ';
                $data_attr .= 'data-name="' . ($qur->name) . '" ';

                // ✏️ تعديل
                if ($auth->can('permission.update')) {
                    $btns[] = '<a ' . $data_attr . '
                            data-bs-toggle="modal"
                            data-bs-target="#update-modal"
                            class="text-warning update_btn"
                            title="تعديل">
                            <i class="bi bi-pencil-fill"></i></a>';
                }

                // 🔁 تفعيل / تعطيل
                if ($qur->status === 'active') {
                    if ($auth->can('permission.active')) {
                        $btns[] = '<a data-id="' . $qur->id . '"
                                data-url="' . route('dash.permissions.inactive') . '"
                                class="action-btn btn-inactive toggle-status-btn"
                                title="تعطيل">
                                <i class="bi bi-x-circle-fill"></i></a>';
                    }
                } else {
                    if ($auth->can('permission.active')) {
                        $btns[] = '<a data-id="' . $qur->id . '"
                                data-url="' . route('dash.permissions.active') . '"
                                class="action-btn btn-active toggle-status-btn"
                                title="تفعيل">
                                <i class="bi bi-check-circle-fill"></i></a>';
                    }
                }

                // 🗑 حذف
                if ($auth->can('permission.delete')) {
                    $btns[] = '<a href="javascript:;"
                            data-id="' . $qur->id . '"
                            data-url="' . route('dash.permissions.delete') . '"
                            class="text-danger btn-delete"
                            title="حذف">
                            <i class="bi bi-trash-fill"></i></a>';
                }

                // لو ما في ولا زر
                if (empty($btns)) {
                    return '-';
                }

                return '<div class="d-flex align-items-center gap-3 fs-6 justify-content-start">'
                    . implode('', $btns) .
                    '</div>';
            })
            ->rawColumns(['action', 'desc', 'status'])
            ->make(true);
    }

    function store(Request $request)
    {
        $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'description'   => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
        ], [
            'name.required'     => 'الاسم مطلوب.',
            'name.string'       => 'الاسم يجب أن يكون نصاً.',
            'name.max'          => 'الاسم لا يجب أن يتجاوز 255 حرفاً.',
            'model.required'     => 'النموذج مطلوب.',
            'model.string'       => 'النموذج يجب أن يكون نصاً.',
            'model.max'          => 'النموذج لا يجب أن يتجاوز 255 حرفاً.',
            'description.required'     => 'الوصف مطلوب.',
            'description.string'       => 'الوصف يجب أن يكون نصاً.',
            'description.max'          => 'الوصف لا يجب أن يتجاوز 255 حرفاً  '




        ]);

        $modelKey = strtolower($request->model); // مثال: user / user_roles

        $action = strtolower(trim($request->name)); // المستخدم كتب delete أو user.delete
        $action = str_contains($action, '.') ? explode('.', $action)[1] : $action;

        Permission::create([
            'name'        => $modelKey . '.' . $action,  // ✅ user.delete
            'model'       => $modelKey,
            'description' => $request->description,
            'guard_name'  => 'web',
        ]);

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }

    public function update(Request $request)
    {
        $user = Permission::findOrFail($request->id);

        $validated = $request->validate([
            'id'          => ['required', 'exists:permissions,id'],
            'model' => ['required', 'string', 'max:255'],
            'description'   => ['required', 'string', 'max:255'],
            'name'  => ['required', 'string', 'max:255'],

        ]);


        $modelKey = strtolower($validated['model']);

        $action = strtolower($validated['name']);
        $action = str_contains($action, '.') ? explode('.', $action)[1] : $action;

        $user->update([
            'name'        => $modelKey . '.' . $action,
            'model'       => $modelKey,
            'description' => $validated['description'],
        ]);
        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }

    function inactive(Request $request)
    {

        $user = Permission::findOrFail($request->id);



        $user->update([
            'status' => 'inactive',
        ]);

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }


    function active(Request $request)
    {
        $user = Permission::query()->findOrFail($request->id);
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
        $user = Permission::findOrFail($request->id);
        $user->delete();
        return response()->json(['success' => 'تم الحذف']);
    }
}
