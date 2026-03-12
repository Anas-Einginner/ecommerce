<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderItemController extends Controller
{
     public function view()
    {
        return view('dashboard.order.order-item');
    }

    public function getdata(Request $request)
    {
        $order_item = OrderItem::query();

        return DataTables::of($order_item)
            ->filter(function ($query) use ($request) {

                if ($request->get('product_id')) {
                    $query->where('product_id', 'like', '%' . $request->get('product_id') . '%');
                }  


                if ($request->get('')) {
                    $query->where('quantity', 'like', '%' . $request->get('quantity') . '%');
                }

                if ($request->get('price')) {
                    $query->where('price', 'like', '%' . $request->get('price') . '%');
                }
            })
            ->addIndexColumn()
            
    ->addColumn('product_name', function ($row) {
    return $row->product->name ?? '';
})
            // العمليات
            ->addColumn('action', function ($order_item) {

                $btns = [];

    $data_attr  = 'data-id="' . $order_item->id . '" ';
    $data_attr .= 'data-order_id="' . $order_item->order_id . '" ';
    $data_attr .= 'data-product_id="' . $order_item->product_id . '" ';
    $data_attr .= 'data-quantity="' . e($order_item->quantity) . '" ';
    $data_attr .= 'data-price="' . e($order_item->price) . '" ';


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
        data-id="' . $order_item->id . '"
        data-url="' . route('dash.Order-item.delete') . '"
        class="text-danger btn-delete"
        title="حذف">
        <i class="bi bi-trash-fill"></i>
    </a>';

                return '<div class="d-flex align-items-center gap-3 fs-6 justify-content-start">'
                    . implode('', $btns) .
                    '</div>';
            })

            ->rawColumns(['action','product_name'])
            ->make(true);
    }

}
