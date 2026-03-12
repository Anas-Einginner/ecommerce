<?php

namespace App\Http\Controllers;

use App\Models\Artisan;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ArtisanController extends Controller
{
    public function view()
    {
        $categories = Category::where('status', 'active')->get();
        return view('dashboard.artisan.index', compact('categories'));
    }
    public function getdata(Request $request)
    {
        $artisan = Artisan::with('category')->select('artisans.*');

        return DataTables::of($artisan)

            ->addIndexColumn()
             ->addColumn('category', function ($artisan) {
            return $artisan->category->name ?? '-';
        })
            // عرض الصورة
            ->addColumn('image', function ($artisan) {
                if ($artisan->image) {
                    return '<img src="' . asset('storage/' . $artisan->image) . '" width="60" class="rounded">';
                }
                return '-';
            })

            // العمليات
            ->addColumn('action', function ($artisan) {

                $btns = [];

                $data_attr  = 'data-id="' . $artisan->id . '" ';
                $data_attr .= 'data-name="' . e($artisan->name) . '" ';
                $data_attr .= 'data-status="' . e($artisan->status) . '" ';
                $data_attr .= 'data-category_id="' . e($artisan->category_id) . '" ';
                $data_attr .= 'data-location="' . e($artisan->location) . '" ';
                $data_attr .= 'data-bio="' . e($artisan->bio) . '" ';
                $data_attr .= 'data-image="' . ($artisan->image ? asset('storage/' . $artisan->image) : '') . '" ';


                // ✏️ تعديل
                $btns[] = '<a ' . $data_attr . '
        data-bs-toggle="modal"
        data-bs-target="#update-modal"
        class="text-warning update_btn"
        title="تعديل">
        <i class="bi bi-pencil-fill"></i>
    </a>';

                // 🔁 تعطيل
                if ($artisan->status === 'active') {
                    $btns[] = '<a data-id="' . $artisan->id . '"
            data-url="' . route('dash.artisans.inactive') . '"
            class="action-btn btn-inactive toggle-status-btn"
            data-status="active"
            title="تعطيل">
            <i class="bi bi-x-circle-fill"></i>
        </a>';
                }

                // ✅ تفعيل
                if ($artisan->status !== 'active') {
                    $btns[] = '<a data-id="' . $artisan->id . '"
            data-url="' . route('dash.artisans.active') . '"
            class="action-btn btn-active toggle-status-btn"
            data-status="inactive"
            title="تفعيل">
            <i class="bi bi-check-circle-fill"></i>
        </a>';
                }

                // 🗑 حذف
                $btns[] = '<a href="javascript:;"
        data-id="' . $artisan->id . '"
        data-url="' . route('dash.artisans.delete') . '"
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
            'category_id' => ['required', 'exists:categories,id'],
            'location' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'image' => ['required', 'image', 'mimetypes:image/jpeg,image/png,image/webp', 'max:10240'],
        ]);

        // رفع الصورة أولاً
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('artisans', 'public');
        }

        Artisan::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'location' => $request->location,
            'status' => 'active',
            'bio' => $request->bio,
            'image' => $path,
        ]);

        return response()->json([
            'success' => 'تمت إضافة التراث بنجاح'
        ]);
    }

    public function update(Request $request)
    {
        $artisan = Artisan::findOrFail($request->id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'location' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
            'bio' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
            'image' => ['required', 'image', 'mimetypes:image/jpeg,image/png,image/webp', 'max:10240'],
        ]);

        // تجهيز مسار الصورة
        $path = $artisan->image;

        // إذا في صورة جديدة
        if ($request->hasFile('image')) {

            // حذف القديمة
            if ($artisan->image && Storage::disk('public')->exists($artisan->image)) {
                Storage::disk('public')->delete($artisan->image);
            }

            // رفع الجديدة
            $path = $request->file('image')->store('artisans', 'public');
        }

        // تحديث مباشر
        $artisan->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'location' => $request->location,
            'status' => $request->status,
            'bio' => $request->bio,
            'image' => $path,
        ]);

        return response()->json([
            'success' => 'تم تعديل التراث بنجاح'
        ]);
    }


    public function active(Request $request)
    {
        $artisan = Artisan::findOrFail($request->id);

        $artisan->update([
            'status' => 'active'
        ]);

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }

    public function inactive(Request $request)
    {
        $artisan = Artisan::findOrFail($request->id);

        $artisan->update([
            'status' => 'inactive'
        ]);

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }










    public function delete(Request $request)
    {
        $artisan = Artisan::findOrFail($request->id);

        // لو عندك صورة احذفها
        if ($artisan->image && Storage::disk('public')->exists($artisan->image)) {
            Storage::disk('public')->delete($artisan->image);
        }

        $artisan->delete();

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }
}
