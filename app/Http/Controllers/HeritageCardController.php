<?php

namespace App\Http\Controllers;

use App\Models\Heritage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class HeritageCardController extends Controller
{
     public function view()
    {
        return view('dashboard.heritage.index');
    }
    public function getdata(Request $request)
    {
        $heritage = Heritage::query();

        return FacadesDataTables::of($heritage)
           
            ->addIndexColumn()

            // عرض الصورة
            ->addColumn('image', function ($heritage) {
                if ($heritage->image) {
                    return '<img src="' . asset('storage/' . $heritage->image) . '" width="60" class="rounded">';
                }
                return '-';
            })

            // العمليات
            ->addColumn('action', function ($heritage) {

                $btns = [];

                $data_attr  = 'data-id="' . $heritage->id . '" ';
                $data_attr .= 'data-title="' . e($heritage->title) . '" ';
                $data_attr .= 'data-status="' . e($heritage->status) . '" ';
                $data_attr .= 'data-order="' . e($heritage->order) . '" ';
                $data_attr .= 'data-description="' . e($heritage->description) . '" ';
                $data_attr .= 'data-image="' . ($heritage->image ? asset('storage/' . $heritage->image) : '') . '" ';


                // ✏️ تعديل
                $btns[] = '<a ' . $data_attr . '
        data-bs-toggle="modal"
        data-bs-target="#update-modal"
        class="text-warning update_btn"
        title="تعديل">
        <i class="bi bi-pencil-fill"></i>
    </a>';

                // 🔁 تعطيل
                if ($heritage->status === 'active') {
                    $btns[] = '<a data-id="' . $heritage->id . '"
            data-url="' . route('dash.heritage.inactive') . '"
            class="action-btn btn-inactive toggle-status-btn"
            data-status="active"
            title="تعطيل">
            <i class="bi bi-x-circle-fill"></i>
        </a>';
                }

                // ✅ تفعيل
                if ($heritage->status !== 'active') {
                    $btns[] = '<a data-id="' . $heritage->id . '"
            data-url="' . route('dash.heritage.active') . '"
            class="action-btn btn-active toggle-status-btn"
            data-status="inactive"
            title="تفعيل">
            <i class="bi bi-check-circle-fill"></i>
        </a>';
                }

                // 🗑 حذف
                $btns[] = '<a href="javascript:;"
        data-id="' . $heritage->id . '"
        data-url="' . route('dash.heritage.delete') . '"
        class="text-danger btn-delete"
        title="حذف">
        <i class="bi bi-trash-fill"></i>
    </a>';

                return '<div class="d-flex align-items-center gap-3 fs-6 justify-content-start">'
                    . implode('', $btns) .
                    '</div>';
            })

            ->rawColumns(['image', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'order' => ['required'],
            'description' => ['nullable', 'string'],
            'image' => ['required', 'image', 'mimetypes:image/jpeg,image/png,image/webp', 'max:2048'],
        ]);

        // رفع الصورة أولاً
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('heritage', 'public');
        }

        Heritage::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'active',
            'order' => $request->order,
            'image' => $path,
        ]);

        return response()->json([
            'success' => 'تمت إضافة التراث بنجاح'
        ]);
    }

    public function update(Request $request)
    {
        $heritage = Heritage::findOrFail($request->id);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'order' => ['required', 'integer'],
            'description' => ['nullable', 'string'],
            'image' => ['required', 'image', 'mimetypes:image/jpeg,image/png,image/webp', 'max:10240'],
        ]);

        // تجهيز مسار الصورة
        $path = $heritage->image;

        // إذا في صورة جديدة
        if ($request->hasFile('image')) {

            // حذف القديمة
            if ($heritage->image && Storage::disk('public')->exists($heritage->image)) {
                Storage::disk('public')->delete($heritage->image);
            }

            // رفع الجديدة
            $path = $request->file('image')->store('artisans', 'public');
        }

        // تحديث مباشر
        $heritage->update([
            'title' => $request->title,
            'description' => $request->description,
            'order' => $request->order,
             'status' => $request->status,
            'image' => $path,
        ]);

        return response()->json([
            'success' => 'تم تعديل التراث بنجاح'
        ]);
    }


    public function active(Request $request)
    {
        $heritage = Heritage::findOrFail($request->id);

        $heritage->update([
            'status' => 'active'
        ]);

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }

    public function inactive(Request $request)
    {
        $heritage = Heritage::findOrFail($request->id);

        $heritage->update([
            'status' => 'inactive'
        ]);

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }










    public function delete(Request $request)
    {
        $category = Heritage::findOrFail($request->id);

        // لو عندك صورة احذفها
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }
}
