@if ($items->count() > 0)
    @foreach ($items as $item)
        <div class="cart-row" data-id="{{ $item->id }}">

            <div class="cart-thumb">
                <img src="{{ asset('storage/' . $item->product->image) }}">
            </div>

            <div class="cart-meta">

                <div class="cart-title">
                    {{ $item->product->name }}
                </div>

                <!-- سعر القطعة فقط -->
                <div class="cart-price">
                    ${{ number_format($item->price, 2) }}
                </div>

                <div class="cart-qty">
                    <button class="qty-minus">-</button>
                    <span class="qty-number">{{ $item->quantity }}</span>
                    <button class="qty-plus">+</button>
                    <button class="remove-item ">Remove</button>
                </div>
                <!-- زر الحذف -->
            </div>

        </div>
    @endforeach
    <div class="cart-summary">
        <style>
            .btn-checkout {
                display: block;
                width: 100%;
                background: #006341;
                color: #fff;
                text-align: center;
                padding: 12px;
                border-radius: 6px;
                margin-top: 15px;
                font-weight: 600;
                text-decoration: none;
                transition: .3s;
            }

            .btn-checkout:hover {
                background: #004d33;
                color: #fff;
            }
        </style>
        <div class="total-row">
            Total:
            $<span id="cart-total">
                {{ number_format($subtotal, 2) }}
            </span>
        </div>

        <div class="checkout-btn-wrapper">
            <a href="{{ route('ecommerce.checkout') }}" class="btn-checkout">
                <i class="fas fa-credit-card"></i>
                Checkout
            </a>
        </div>

    </div>
@else
    <div class="cart-empty">
        <div class="cart-empty__icon">
            <i class="fas fa-heart"></i>
        </div>

        <p class="cart-empty__text">Your cart is empty</p>

        <a href="{{ route('ecommerce.shop') }}" class="cart-empty__btn">
            Continue Shopping
        </a>
    </div>
@endif
