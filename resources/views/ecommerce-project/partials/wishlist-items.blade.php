@if ($wishlist->count())

    @foreach ($wishlist as $item)
        <style>
            .btn-add-to-cart,
            .btn-remove-wishlist {
                padding: 5px 18px;
                font-size: 14px;
                font-weight: 600;
                border-radius: 6px;
                border: none;
                cursor: pointer;
                transition: 0.3s;
            }

            /* زر Add to cart */
            .btn-add-to-cart {
                background: #006341;
                color: #fff;
            }

            .btn-add-to-cart:hover {
                background: #004d33;
            }

            /* زر Remove */
            .btn-remove-wishlist {
                background: #dc3545;
                color: #fff;
            }

            .btn-remove-wishlist:hover {
                background: #c82333;
            }
        </style>

        <div class="wishlist-item">
            <img src="{{ asset('storage/' . $item->product->image) }}" width="60">

            <div>
                <h5>{{ $item->product->name }}</h5>
                <p>${{ $item->product->price }}</p>
                <div style="display:flex;gap:10px;margin-top:8px">

                    <!-- ADD TO CART -->
                    <button class="btn-add-to-cart" data-id="{{ $item->product->id }}">
                        Add to Cart
                    </button>

                    <!-- REMOVE -->
                    <button class="btn-remove-wishlist" data-id="{{ $item->id }}">
                        Remove
                    </button>

                </div>
            </div>
        </div>
    @endforeach
    {{-- 🔥 ADD ALL BUTTON --}}
    <div style="margin-top:20px;text-align:center;">
        <button type="button" class="btn-add-all-cart">
            Add All To Cart
        </button>
    </div>
@else
    <div class="wishlist-empty">
        <div class="wishlist-empty__icon">
            <i class="fas fa-heart"></i>
        </div>

        <p class="wishlist-empty__text">Your wishlist is empty</p>

        <a href="{{ route('ecommerce.shop') }}" class="wishlist-empty__btn" onclick="$('#wishlistModal').hide();">
            Continue Browsing
        </a>
    </div>

@endif
