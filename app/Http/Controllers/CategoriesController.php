<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{

    public function view()
    {
        return view('dashboard.category.index');
    }
    public function getdata(Request $request)
    {
        $categories = Category::query();

        return DataTables::of($categories)
            ->filter(function ($query) use ($request) {

                if ($request->get('name')) {
                    $query->where('name', 'like', '%' . $request->get('name') . '%');
                }

                if ($request->get('slug')) {
                    $query->where('slug', 'like', '%' . $request->get('slug') . '%');
                }

                if ($request->get('description')) {
                    $query->where('description', 'like', '%' . $request->get('description') . '%');
                }
            })
            ->addIndexColumn()

            // عرض الصورة
            ->addColumn('image', function ($category) {
                if ($category->image) {
                    return '<img src="' . asset('storage/' . $category->image) . '" width="60" class="rounded">';
                }
                return '-';
            })

            // العمليات
            ->addColumn('action', function ($category) {

                $btns = [];

                $data_attr  = 'data-id="' . $category->id . '" ';
                $data_attr .= 'data-name="' . e($category->name) . '" ';
                $data_attr .= 'data-slug="' . e($category->slug) . '" ';
                $data_attr .= 'data-description="' . e($category->description) . '" ';
                $data_attr .= 'data-image="' . ($category->image ? asset('storage/' . $category->image) : '') . '" ';


                // ✏️ تعديل
                $btns[] = '<a ' . $data_attr . '
        data-bs-toggle="modal"
        data-bs-target="#update-modal"
        class="text-warning update_btn"
        title="تعديل">
        <i class="bi bi-pencil-fill"></i>
    </a>';

                // 🔁 تعطيل
                if ($category->status === 'active') {
                    $btns[] = '<a data-id="' . $category->id . '"
            data-url="' . route('dash.categories.inactive') . '"
            class="action-btn btn-inactive toggle-status-btn"
            data-status="active"
            title="تعطيل">
            <i class="bi bi-x-circle-fill"></i>
        </a>';
                }

                // ✅ تفعيل
                if ($category->status !== 'active') {
                    $btns[] = '<a data-id="' . $category->id . '"
            data-url="' . route('dash.categories.active') . '"
            class="action-btn btn-active toggle-status-btn"
            data-status="inactive"
            title="تفعيل">
            <i class="bi bi-check-circle-fill"></i>
        </a>';
                }

                // 🗑 حذف
                $btns[] = '<a href="javascript:;"
        data-id="' . $category->id . '"
        data-url="' . route('dash.categories.delete') . '"
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
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug'],
            'description' => ['nullable', 'string'],
            'image' => ['required', 'image', 'mimetypes:image/jpeg,image/png,image/webp', 'max:2048'],
        ]);

        // رفع الصورة أولاً
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
        }

        Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'status' => 'active',
            'image' => $path,
        ]);

        return response()->json([
            'success' => 'تمت إضافة التصنيف بنجاح'
        ]);
    }

    public function update(Request $request)
    {
        $category = Category::findOrFail($request->id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug,' . $category->id],
            'description' => ['nullable', 'string'],
            'image' => ['required', 'image', 'mimetypes:image/jpeg,image/png,image/webp', 'max:2048'],
        ]);

        // تجهيز مسار الصورة
        $path = $category->image;

        // إذا في صورة جديدة
        if ($request->hasFile('image')) {

            // حذف القديمة
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            // رفع الجديدة
            $path = $request->file('image')->store('categories', 'public');
        }

        // تحديث مباشر
        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'image' => $path,
        ]);

        return response()->json([
            'success' => 'تم تعديل التصنيف بنجاح'
        ]);
    }


    public function active(Request $request)
    {
        $category = Category::findOrFail($request->id);

        $category->update([
            'status' => 'active'
        ]);

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }

    public function inactive(Request $request)
    {
        $category = Category::findOrFail($request->id);

        $category->update([
            'status' => 'inactive'
        ]);

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }










    public function delete(Request $request)
    {
        $category = Category::findOrFail($request->id);

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
