<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentSetting;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {

        try {
            $key = PaymentSetting::where('key', 'stripe_secret_key')->value('value');

            // $key = Crypt::decryptString($key);

            Stripe::setApiKey($key);

            $items = Cart::where('user_id', auth()->id())->get();

            if ($items->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty'
                ]);
            }

            $total = $items->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            $paymentIntent = PaymentIntent::create([
                'amount' => $total * 100,
                'currency' => 'usd',
                'payment_method' => $request->payment_method,
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
            ]);
            $shipping = $request->shipping ?? 0;

            $total = $items->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            $total = $total + $shipping;
            $status = 'pending';

            if ($paymentIntent->status === 'succeeded') {
                $status = 'paid';
            } elseif ($paymentIntent->status === 'processing') {
                $status = 'processing';
            }
            $order = Order::create([
                'user_id' => auth()->id(),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'address1' => $request->address1,
                'address2' => $request->address2,
                'payment_intent_id' => $paymentIntent->id,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'country' => $request->country,
                'shipping_cost' => $shipping,
                'total' => $total,
                'status' => $status
            ]);

            foreach ($items as $item) {

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                ]);

                // خصم الكمية من المخزون
                $product = Product::find($item->product_id);

                if ($product) {
                    $product->decrement('stock', $item->quantity);
                }
            }

            Cart::where('user_id', auth()->id())->delete();

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'total' => $total
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function paymentIntent(Request $request)
    {

        $key = PaymentSetting::where('key', 'stripe_secret_key')->value('value');

        // $key = Crypt::decryptString($key);

        Stripe::setApiKey($key);

        $items = Cart::where('user_id', auth()->id())->get();

        $total = $items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $amount = $total * 100;

        $intent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'usd',
        ]);

        return response()->json([
            'clientSecret' => $intent->client_secret
        ]);
    }
    public function refund($orderId)
    {
        try {

            $key = PaymentSetting::where('key', 'stripe_secret_key')->value('value');

            $stripe = new \Stripe\StripeClient($key);

            $order = Order::findOrFail($orderId);

            if (!$order->payment_intent_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment intent not found'
                ], 422);
            }

            $paymentIntent = $stripe->paymentIntents->retrieve(
                $order->payment_intent_id
            );

            if (!$paymentIntent->latest_charge) {
                return response()->json([
                    'success' => false,
                    'message' => 'Charge not found'
                ]);
            }

            $refund = $stripe->refunds->create([
                'charge' => $paymentIntent->latest_charge,
            ]);

            $order->update([
                'status' => 'refunded'
            ]);

            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {

            Log::error($e);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function view()
    {
        return view('dashboard.order.index');
    }
    public function getdata(Request $request)
    {
        $order = Order::query();

        return DataTables::of($order)
            ->filter(function ($query) use ($request) {

                if ($request->get('first_name')) {
                    $query->where('first_name', 'like', '%' . $request->get('first_name') . '%');
                }

                if ($request->get('email')) {
                    $query->where('email', 'like', '%' . $request->get('email') . '%');
                }

                if (!empty($request->status)) {
                    $query->where('status', $request->status);
                }
            })
            ->addIndexColumn()

            ->addColumn('refund', function ($order) {

                if ($order->status === 'refunded') {

                    return '<span class="badge bg-success">
                    ' . __('general.refund') . '
                </span>';
                }

                if ($order->status === 'paid') {

                    return '<button
                    class="btn btn-sm btn-danger refund-btn"
                    data-url="' . route('ecommerce.refund', $order->id) . '">
                    ' . __('general.refund') . '
                </button>';
                }

                return '-';
            })


            // العمليات
            ->addColumn('action', function ($order) {

                $btns = [];

                $data_attr  = 'data-id="' . $order->id . '" ';
                $data_attr .= 'data-first_name="' . e($order->first_name) . '" ';
                $data_attr .= 'data-last_name="' . e($order->last_name) . '" ';
                $data_attr .= 'data-address1="' . e($order->address1) . '" ';
                $data_attr .= 'data-address2="' . e($order->address2) . '" ';
                $data_attr .= 'data-city="' . e($order->city) . '" ';
                $data_attr .= 'data-state="' . e($order->state) . '" ';
                $data_attr .= 'data-zip="' . e($order->zip) . '" ';
                $data_attr .= 'data-country="' . e($order->country) . '" ';
                $data_attr .= 'data-status="' . e($order->status) . '" ';

                $btns[] = '<a href="' . route('ecommerce.dash.order-items-user.view', $order->id) . '"
        class="text-primary"
        title="عرض الطلب">
        <i class="bi bi-eye-fill"></i>
    </a>';




                // 🗑 حذف
                $btns[] = '<a href="javascript:;"
        data-id="' . $order->id . '"
        data-url="' . route('dash.Order.delete') . '"
        class="text-danger btn-delete"
        title="حذف">
        <i class="bi bi-trash-fill"></i>
    </a>';

                return '<div class="d-flex align-items-center gap-3 fs-6 justify-content-start">'
                    . implode('', $btns) .
                    '</div>';
            })

            ->rawColumns(['action', 'refund'])
            ->make(true);
    }
    public function delete(Request $request)
    {
        $order = Order::findOrFail($request->id);
        $order->delete();
        return response()->json(['success' => 'تمت العملية بنجاح']);
    }
}
