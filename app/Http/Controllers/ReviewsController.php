<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Reviews;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function view()
    {
        $products = Product::all();
        return view('dashboard.review-rating.index', compact('products'));
    }
    public function getdata(Request $request)
    {
        $reviews = Reviews::query();

        return DataTables::of($reviews)
            ->filter(function ($query) use ($request) {

                if ($request->get('name')) {
                    $query->where('name', 'like', '%' . $request->get('name') . '%');
                }

                if ($request->get('email')) {
                    $query->where('email', 'like', '%' . $request->get('email') . '%');
                }

                if ($request->get('rating')) {
                    $query->where('rating', 'like', '%' . $request->get('rating') . '%');
                }
            })
            ->addIndexColumn()

            ->addColumn('product', function ($review) {
                return $review->product ? $review->product->name : '-';
            })
            ->editColumn('rating', function ($review) {

                return str_repeat('⭐', $review->rating);
            })
            ->addColumn('status', function ($row) {

    if($row->status == 'pending'){
        return __('general.pending');
    }

    if($row->status == 'approved'){
        return __('general.approved');
    }

    if($row->status == 'rejected'){
        return __('general.rejected');
    }

})

            // العمليات
            ->addColumn('action', function ($review) {

                $btns = [];

                $data_attr  = 'data-id="' . $review->id . '" ';
                $data_attr .= 'data-status="' . e($review->status) . '" ';


                // ✏️ تعديل
                $btns[] = '<a ' . $data_attr . '
        data-bs-toggle="modal"
        data-bs-target="#update-modal"
        class="text-warning update_btn"
        title="تعديل">
        <i class="bi bi-pencil-fill"></i>
    </a>';



                // 🗑 حذف
                $btns[] = '<a href="javascript:;"
        data-id="' . $review->id . '"
        data-url="' . route('dash.reviews.delete') . '"
        class="text-danger btn-delete"
        title="حذف">
        <i class="bi bi-trash-fill"></i>
    </a>';

                return '<div class="d-flex align-items-center gap-3 fs-6 justify-content-start">'
                    . implode('', $btns) .
                    '</div>';
            })

            ->rawColumns(['action', 'product', 'status'])
            ->make(true);
    }


    public function store(Request $request)
    {
        // dd($request);
        // 1️⃣ Validation
        // dd($request->all());
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'review' => 'required|string|max:1000',
        ]);

        // تحويل القيمة الفارغة إلى null
        $product_id = $request->product_id ?: null;

        // 3️⃣ إنشاء المنتج
        Reviews::create([
            'name' => $request->name,
            'email' => $request->email,
            'product_id' => $product_id,
            'rating' => $request->rating,
            'title' => $request->title,
            'review' => $request->review,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }
     public function update(Request $request)
    {
        $review = Reviews::findOrFail($request->id);

        $request->validate([
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);

     

        // تحديث مباشر
        $review->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => 'تم تعديل التصنيف بنجاح'
        ]);
    }

     public function delete(Request $request)
    {
        $review = Reviews::findOrFail($request->id);

       

        $review->delete();

        return response()->json([
            'success' => 'تم حذف المنتج بنجاح'
        ]);
    }
}
