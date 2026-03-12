    @extends('ecommerce-project.master')

    @section('content')
        <style>
            .product-rating {
                display: flex;
                align-items: center;
                gap: 6px;
                margin: 6px 0;
                font-size: 14px;
            }

            .product-rating i {
                color: #ffc107;
            }

            .rating-number {
                font-weight: 600;
                color: #333;
            }

            .reviews-count {
                color: #777;
                font-size: 13px;
            }

            .new-badge {
                position: absolute;
                top: 10px;
                left: 10px;
                background: #28a745;
                color: white;
                font-size: 12px;
                font-weight: 600;
                padding: 4px 8px;
                border-radius: 4px;
            }
            .product-image{
position:relative;
}
        </style>
        @php
            $activeCategory = request('category', 'all');
        @endphp

        <section class="category-filter">
            <div class="container">
                <div class="category-container">

                    <button class="category-btn {{ $activeCategory === 'all' ? 'active' : '' }}" data-category="all">
                        All Products
                    </button>

                    @foreach ($categories as $category)
                        <button class="category-btn {{ $activeCategory === $category->slug ? 'active' : '' }}"
                            data-category="{{ $category->slug }}" data-name="{{ $category->name }}">

                            {{ $category->slug }}
                        </button>
                    @endforeach

                </div>
            </div>
        </section>

        <section class="shop-content">
            <div class="container">

                <div class="shop-header">
                    <h2 class="shop-title" id="shopTitle">

                        @if ($activeCategory === 'all')
                            All Products
                        @else
                            {{ $categories->firstWhere('slug', $activeCategory)?->name }}
                        @endif

                    </h2>
                    <div class="shop-controls">

                        <select id="sortSelect" class="sort-select">
                            <option value="featured">Featured</option>
                            <option value="price-low">Price Low → High</option>
                            <option value="price-high">Price High → Low</option>
                        </select>

                        <div class="view-options">
                            <button class="view-btn active" data-view="grid">
                                <i class="fas fa-th"></i>
                            </button>
                            <button class="view-btn" data-view="list">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>

                    </div>
                </div>

                <div id="productsGrid" class="products-grid"></div>

            </div>
        </section>


        <script>
            $(document).ready(function() {

                let currentCategory = "{{ request('category', 'all') }}";
                let currentSort = 'featured';

                function loadProducts(category = 'all', sort = 'featured') {

                    $('#productsGrid').html('');

                    $.ajax({
                        url: "{{ route('ecommerce.shop.products') }}",
                        type: "GET",
                        data: {
                            category: category,
                            sort: sort
                        },

                        success: function(products) {

                            if (!products.length) {
                                $('#productsGrid').html(`
                                <div class="empty-products" style="text-align:center; padding:50px 0;">
                                    <i class="fas fa-box-open" style="font-size:45px; color:#ccc;"></i>
                                    <h3 style="margin-top:15px; color:#666;">No products available</h3>
                                    <p style="color:#999;">Please check back later.</p>
                                </div>
                            `);
                                return;
                            }

                            let html = '';

                            // ✅ template للرابط (من Laravel)
                            let productUrlTemplate = "{{ route('ecommerce.product.show', 'SLUG') }}";

                            products.forEach(function(product) {
                                let isNew = product.is_new;
                                let rating = product.rating_avg ?? 0;
                                let reviews = product.reviews_count ?? 0;

                                let stars = '';

                                for (let i = 1; i <= 5; i++) {

                                    if (i <= Math.round(rating)) {
                                        stars += '<i class="fas fa-star text-warning"></i>';
                                    } else {
                                        stars += '<i class="far fa-star text-warning"></i>';
                                    }

                                }

                                // ✅ رابط المنتج بناءً على slug
                                let productUrl = productUrlTemplate.replace('SLUG', product.slug);

                                html += `
                                <div class="product-card">
                                    <div class="product-image">

                                        ${product.on_sale ? `<span class="sale-badge">SALE</span>` : ''}
                                        ${isNew ? `<span class="new-badge">NEW</span>` : ''}
                                        <a href="${productUrl}">
                                            <img src="${product.image}" alt="${product.name}">
                                        </a>

                                        <button class="wishlist-icon ${product.in_wishlist ? 'active' : ''}"
                                                data-id="${product.id}">
                                            <i class="${product.in_wishlist ? 'fas' : 'far'} fa-heart"></i>
                                        </button>

                                    </div>

                                    <div class="product-info">

                                        <div class="product-category">
                                            ${product.category_name ?? ''}
                                        </div>

                                        <h3 class="product-title">
                                            ${product.name ?? ''}
                                        </h3>

                                        <p class="product-description">
                                            ${product.description ?? ''}
                                        </p>
                                        <div class="product-rating">
        ${stars}
        <span class="rating-number">${rating} / 5</span>
        <span class="reviews-count">(${reviews} reviews)</span>
    </div>
                                        <div class="product-price">
                                            <span class="current-price">
                                                $${product.price ?? ''}
                                            </span>

                                            ${product.on_sale ? `
                                                        <span class="original-price">
                                                            $${product.original_price ?? ''}
                                                        </span>
                                                    ` : ''}
                                        </div>

                                        <button class="btn-add-to-cart" data-id="${product.id}">
                                            <i class="fas fa-shopping-cart"></i>
                                            Add to Cart
                                        </button>

                                    </div>
                                </div>
                            `;
                            });

                            $('#productsGrid').html(html);
                        },

                        error: function(xhr) {
                            console.error(xhr.responseText);
                            $('#productsGrid').html(`
                            <div class="empty-products" style="text-align:center; padding:50px 0;">
                                <i class="fas fa-exclamation-triangle" style="font-size:45px; color:#ccc;"></i>
                                <h3 style="margin-top:15px; color:#666;">Error loading products</h3>
                                <p style="color:#999;">Please try again.</p>
                            </div>
                        `);
                        }
                    });
                }

                $('#sortSelect').change(function() {
                    currentSort = $(this).val();
                    loadProducts(currentCategory, currentSort);
                });

                $('.category-btn').click(function() {

                    $('.category-btn').removeClass('active');
                    $(this).addClass('active');

                    let category = $(this).data('category');
                    currentCategory = category;

                    updateTitle(category);
                    loadProducts(category, currentSort);

                    const url = new URL(window.location);
                    url.searchParams.set('category', category);
                    window.history.pushState({}, '', url);
                });

                function updateTitle(slug) {
                    if (slug === 'all') {
                        $('#shopTitle').text('All Products');
                        return;
                    }

                    let name = $('.category-btn[data-category="' + slug + '"]').data('name');
                    $('#shopTitle').text(name ?? slug);
                }

                // ✅ أول تحميل
                loadProducts(currentCategory, currentSort);
                updateTitle(currentCategory);

                // ✅ تغيير شكل العرض Grid/List
                $('.view-btn').click(function() {
                    $('.view-btn').removeClass('active');
                    $(this).addClass('active');

                    let view = $(this).data('view');

                    if (view === 'grid') {
                        $('#productsGrid').removeClass('products-list').addClass('products-grid');
                    }

                    if (view === 'list') {
                        $('#productsGrid').removeClass('products-grid').addClass('products-list');
                    }
                });

            });
        </script>
    @endsection
