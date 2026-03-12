<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{
    public function view()
    {
        $categories = Category::where('status', 'active')->get();
 
        return view('dashboard.products.index', compact('categories'));
    }

    public function getdata(Request $request)
    {
        $products = Product::with('category')->select('products.*');

        return DataTables::of($products)
            ->filter(function ($query) use ($request) {

                if ($request->get('name')) {
                    $query->where('name', 'like', '%' . $request->get('name') . '%');
                }

                if ($request->get('category')) {
                    $query->whereHas('category', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->get('category') . '%');
                    });
                }

                if ($request->get('description')) {
                    $query->where('description', 'like', '%' . $request->get('description') . '%');
                }
            })
            ->addIndexColumn()

            // عرض الصورة
            ->addColumn('image', function ($product) {
                if ($product->image) {
                    return '<img src="' . asset('storage/' . $product->image) . '" width="60" class="rounded">';
                }
                return '-';
            })
            ->addColumn('status', function ($product) {
                return $product->status === 'active'
                    ? '<span class="badge bg-success">مفعل</span>'
                    : '<span class="badge bg-danger">غير مفعل</span>';
            })
            // عرض اسم التصنيف
            ->addColumn('category', function ($product) {
                return $product->category ? $product->category->name : '-';
            })

            // عرض السعر
            ->addColumn('price', function ($product) {
                return number_format($product->price, 2);
            })



            // العمليات
            ->addColumn('action', function ($product) {

                $btns = [];

                $data_attr  = 'data-id="' . $product->id . '" ';
                $data_attr .= 'data-name="' . e($product->name) . '" ';
                $data_attr .= 'data-slug="' . e($product->slug) . '" ';
                $data_attr .= 'data-description="' . e($product->description) . '" ';
                $data_attr .= 'data-price="' . $product->price . '" ';
                $data_attr .= 'data-original_price="' . $product->original_price . '" ';
                $data_attr .= 'data-stock="' . $product->stock . '" ';
                $data_attr .= 'data-category_id="' . $product->category_id . '" ';
                $data_attr .= 'data-image="' . ($product->image ? asset('storage/' . $product->image) : '') . '" ';
                $data_attr .= 'data-status="' . $product->status . '" ';

                // ✏️ تعديل
                $btns[] = '<a ' . $data_attr . '
        data-bs-toggle="modal"
        data-bs-target="#update-modal"
        class="text-warning update_btn"
        title="تعديل">
        <i class="bi bi-pencil-fill"></i>
            </a>';

                // 🔁 تعطيل
                if ($product->status === 'active') {
                    $btns[] = '<a data-id="' . $product->id . '"
            data-url="' . route('dash.products.inactive') . '"
            class="action-btn btn-inactive toggle-status-btn"
            data-status="active"
            title="تعطيل">
            <i class="bi bi-x-circle-fill"></i>
               </a>';
                }

                // ✅ تفعيل
                if ($product->status === 'inactive') {
                    $btns[] = '<a data-id="' . $product->id . '"
            data-url="' . route('dash.products.active') . '"
            class="action-btn btn-active toggle-status-btn"
            data-status="inactive"
            title="تفعيل">
            <i class="bi bi-check-circle-fill"></i>
                </a>';
                }

                // 🗑 حذف
                $btns[] = '<a href="javascript:;"
                      data-id="' . $product->id . '"
                      data-url="' . route('dash.products.delete') . '"
                      class="text-danger btn-delete"
                      title="حذف">
                      <i class="bi bi-trash-fill"></i>
                      </a>';

                return '<div class="d-flex align-items-center gap-3 fs-6 justify-content-start">'
                    . implode('', $btns) .
                    '</div>';
            })
            ->rawColumns(['image', 'status', 'action', 'category'])
            ->make(true);
    }

    public function store(Request $request)
    {

        // 1️⃣ Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        // 2️⃣ رفع الصورة
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->storePublicly('products', 'public');
        }

        // 3️⃣ إنشاء المنتج
        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'description' => $request->description,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'original_price' => $request->original_price,
            'image' => $imagePath,
            'stock' => $request->stock,
            'status' => 'active',
        ]);

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }

    public function update(Request $request)
    {
        // 1️⃣ Validation
        $request->validate([
            'id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug,' . $request->id,
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        // 2️⃣ جلب المنتج
        $product = Product::findOrFail($request->id);

        // 3️⃣ معالجة الصورة
        if ($request->hasFile('image')) {

            // حذف الصورة القديمة لو موجودة
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            $imagePath = $product->image;
        }

        // 4️⃣ تحديث البيانات
        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'description' => $request->description,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'original_price' => $request->original_price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'status' => $request->status,

        ]);

        return response()->json([
            'success' => 'تم تحديث المنتج بنجاح'
        ]);
    }
    public function active(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $product->update([
            'status' => 'active'
        ]);

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }

    public function inactive(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $product->update([
            'status' => 'inactive'
        ]);

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }

    public function getProductsData()
    {
        return response()->json(
            Product::with('category')->get()
        );
    }

    public function delete(Request $request)
    {
        $product = Product::findOrFail($request->id);

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json([
            'success' => 'تم حذف المنتج بنجاح'
        ]);
    }
    public function products(Request $request)
    {
        $query = Product::with('category')
            ->withAvg(['reviews' => function ($q) {
                $q->where('status', 'approved');
            }], 'rating')
            ->withCount(['reviews' => function ($q) {
                $q->where('status', 'approved');
            }]);

        if ($request->category && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        // 🔥 الترتيب
        if ($request->sort === 'price-low') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'price-high') {
            $query->orderBy('price', 'desc');
        } else {
            // Featured (افتراضي)
            $query->latest();
        }
        $products = $query->get();

        $userId = auth()->id();

        $products = $products->map(function ($product) use ($userId) {

            $onSale = $product->original_price !== null &&
                floatval($product->price) != floatval($product->original_price);
            $isNew = $product->created_at->diffInMinutes(now()) <= 3;
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug, // 🔥🔥🔥 هذا هو السطر الناقص
                'price' => $product->price,
                'original_price' => $product->original_price,
                'image' => Storage::url($product->image),
                'category_name' => $product->category->name,
                'description' => $product->description,
                'on_sale' => $onSale,
                'is_new' => $isNew,
                'rating_avg' => round($product->reviews_avg_rating ?? 0, 1),
                'reviews_count' => $product->reviews_count ?? 0,
                'created_at' => $product->created_at, // 👈 أضف هذا السطر

                'in_wishlist' => $userId
                    ? $product->wishlists()
                    ->where('user_id', $userId)
                    ->exists()
                    : false,
            ];
        });

        return response()->json($products);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        // 🔥 أضف هذا السطر
        $categories = Category::where('status', 'active')->get();
        return view('ecommerce-project.product-detail', compact('product', 'relatedProducts', 'categories'));
    }
    public function search(Request $request)
    {
        $products = Product::where('name', 'like', '%' . $request->search . '%')
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($products);
    }
}
