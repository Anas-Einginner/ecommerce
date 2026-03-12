<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- 🔐 CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>HAWIYA | Handcrafted Palestine</title>
    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('website/css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/css/responsive.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&family=Cairo:wght@400;500;600&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

</head>

<body>
    <header class="header">
        <div class="container">
            <div class="header-main">
                <div class="logo-container">
                    <a href="../html/index.html" class="logo">
                        <img src="{{ asset('website/img/MainLogo (2).png') }}" alt="HAWIYA Logo" class="logo-img" />
                    </a>
                </div>

                <nav class="main-nav">
                    <ul class="nav-list">
                        <li><a href="{{ route('ecommerce.home') }}" class="nav-link active">Home</a></li>
                        <li><a href="{{ route('ecommerce.shop') }}" class="nav-link">Shop</a></li>
                        <li class="dropdown">
                            <div class="nav-link-wrapper">
                                <a href="#" class="nav-link">
                                    Our Categories <i class="fas fa-chevron-down"></i>
                                </a>

                                <div class="dropdown-menu">

                                    @foreach ($categories as $category)
                                        <a href="{{ route('ecommerce.shop', ['category' => $category->slug]) }}"
                                            class="dropdown-item">
                                            {{ $category->name }}
                                        </a>
                                    @endforeach

                                </div>
                            </div>
                        </li>
                        <li><a href="{{ route('ecommerce.artisan') }}" class="nav-link">Our Artisans</a></li>
                        <li><a href="{{ route('ecommerce.contact') }}" class="nav-link">Contact Us</a></li>
                    </ul>
                </nav>

                <div class="header-actions">
                    <div class="search-container">
                        <button class="search-btn" id="searchToggle"><i class="fas fa-search"></i></button>
                        <div class="search-box" id="searchBox">
                            <input type="text" placeholder="Search products..." class="search-input" />
                            <button class="search-submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <button class="mobile-search-btn" id="mobileSearchToggle">
                        <i class="fas fa-search"></i>
                    </button>
                    <div class="action-icons">
                        <a href="{{ route('ecommerce.account') }}" class="action-icon" id="accountBtn" title="Account">
                            <i class="far fa-user"></i>
                        </a>
                        <a href="#" class="action-icon" id="wishlistBtn" title="Wishlist">
                            <i class="far fa-heart"></i>
                            <span class="badge wishlist-count">0</span>
                        </a>
                        <a href="#" class="action-icon cart-icon" id="cartBtn" title="Cart">
                            <i class="fas fa-shopping-bag"></i>
                            <span class="badge cart-count">0</span>
                        </a>
                    </div>
                    <button class="mobile-menu-btn" id="mobileMenuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="mobile-search-box" id="mobileSearchBox">
            <div class="container">
                <input type="text" placeholder="Search products..." class="search-input" id="mobileSearchInput" />
            </div>
        </div>
    </header>

    <nav class="mobile-nav" id="mobileNav">
        <ul class="mobile-nav-list">
            <li class="mobile-nav-item">
                <a href="{{ route('ecommerce.home') }}" class="mobile-nav-link active">
                    <i class="fas fa-home"></i> Home
                </a>
            </li>
            <li class="mobile-nav-item">
                <a href="{{ route('ecommerce.shop') }}" class="mobile-nav-link">
                    <i class="fas fa-shopping-bag"></i> Shop
                </a>
            </li>
            <li class="mobile-nav-item">
                <div class="mobile-nav-link mobile-dropdown-toggle" id="mobileCategoriesToggle">
                    <div style="display: flex; align-items: center;">
                        <i class="fas fa-th-large"></i> Our Categories
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="mobile-dropdown-content" id="mobileCategories">
                    <a href="../html/shop.html?category=thobe" class="mobile-dropdown-item">
                        <i class="fas fa-tshirt"></i> Palestinian Thobe
                    </a>
                    <a href="../html/shop.html?category=modern" class="mobile-dropdown-item">
                        <i class="fas fa-tshirt"></i> Modern Clothing
                    </a>
                    <a href="../html/shop.html?category=wood" class="mobile-dropdown-item">
                        <i class="fas fa-tree"></i> Olive Wood Crafts
                    </a>
                    <a href="../html/shop.html?category=ceramics" class="mobile-dropdown-item">
                        <i class="fas fa-mug-hot"></i> Ceramics & Pottery
                    </a>
                    <a href="../html/shop.html?category=jewelry" class="mobile-dropdown-item">
                        <i class="fas fa-gem"></i> Traditional Jewelry
                    </a>
                    <a href="../html/shop.html?category=home" class="mobile-dropdown-item">
                        <i class="fas fa-home"></i> Home Decor
                    </a>
                    <a href="../html/shop.html?category=care" class="mobile-dropdown-item">
                        <i class="fas fa-spa"></i> Body Care
                    </a>
                    <a href="../html/shop.html?category=food" class="mobile-dropdown-item">
                        <i class="fas fa-utensils"></i> Food Products
                    </a>
                </div>
            </li>
            <li class="mobile-nav-item">
                <a href="{{ route('ecommerce.artisan') }}" class="mobile-nav-link">
                    <i class="fas fa-hands-helping"></i> Our Artisans
                </a>
            </li>
            <li class="mobile-nav-item">
                <a href="{{ route('ecommerce.contact') }}" class="mobile-nav-link">
                    <i class="fas fa-envelope"></i> Contact Us
                </a>
            </li>
            <li class="mobile-nav-item">
                <a href="#" class="mobile-nav-link" id="mobileWishlistBtn">
                    <i class="far fa-heart"></i> Wishlist
                    <span class="mobile-badge wishlist-count">0</span>
                </a>
            </li>
            <li class="mobile-nav-item">
                <a href="#" class="mobile-nav-link" id="mobileCartBtn">
                    <i class="fas fa-shopping-bag"></i> Cart
                    <span class="mobile-badge cart-count">0</span>
                </a>
            </li>
            <li class="mobile-nav-item">
                <a href="../html/account.html" class="mobile-nav-link">
                    <i class="far fa-user"></i> Account
                </a>
            </li>
        </ul>
    </nav>

    @yield('content')

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-col footer-col-main">
                    <div class="footer-logo">
                        <img src="{{ asset('website/img/Hawiya.png') }}" alt="Handcrafted Palestine Logo">
                    </div>
                    <p class="footer-about">We bridge traditional Palestinian craftsmanship with the global market,
                        ensuring fair wages for artisans while preserving cultural heritage for future generations.</p>

                </div>

                <div class="footer-col">
                    <h4 class="footer-title">Shop Categories</h4>
                    <ul class="footer-links">
                        @foreach ($categories as $category)
                            <li>
                                <a href="{{ route('ecommerce.shop', ['category' => $category->slug]) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>


                <div class="footer-col">
                    <h4 class="footer-title">Contact Us</h4>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-envelope"></i>
                            <div>
                                <strong>Email Us</strong>
                                <p>info@handcraftedpalestine.com</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>



            <div class="footer-copyright">
                <p>&copy; 2025 Handcrafted Palestine. All rights reserved. | <a href="#">Privacy Policy</a> | <a
                        href="#">Terms of Service</a> | <a href="#">Cookie Policy</a></p>
            </div>
        </div>
        </div>
    </footer>

    <!-- ===== CART MODAL ===== -->
    <div class="custom-modal" id="cartModal">
        <div class="custom-modal-box">
            <div class="custom-modal-header">
                <h3>Shopping Cart</h3>
                <button class="modal-close" data-close="cartModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="custom-modal-body">
                <div id="cartContent"></div>
            </div>
        </div>
    </div>

    <!-- ===== WISHLIST MODAL ===== -->
    <div class="custom-modal" id="wishlistModal">
        <div class="custom-modal-box">
            <div class="custom-modal-header">
                <h3>Wishlist</h3>
                <button class="modal-close" data-close="wishlistModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="custom-modal-body">
                <div id="wishlistContent"></div>
            </div>
        </div>
    </div>

    <button class="back-to-top"><i class="fas fa-chevron-up"></i></button>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        function showAppNotification(message, type = 'info') {

            const existing = $('.wishlist-notification');
            if (existing.length) existing.remove();

            const icons = {
                success: 'fa-check-circle',
                info: 'fa-info-circle',
                warning: 'fa-exclamation-triangle',
                error: 'fa-times-circle'
            };

            const notification = $(`
        <div class="wishlist-notification ${type}">
            <i class="fas ${icons[type] || icons.info}"></i>
            <span>${message}</span>
        </div>
    `);

            $('body').append(notification);

            setTimeout(() => notification.addClass('show'), 50);

            setTimeout(() => {
                notification.removeClass('show');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
        const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};

        $(document).ajaxError(function(event, xhr) {

            if (xhr.status === 401) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Login Required',
                    text: 'You must login first to continue.',
                    confirmButtonColor: '#006341',
                    confirmButtonText: 'Go to Login'
                }).then(() => {
                    window.location.href = "{{ route('login') }}";
                });

            }

        });
        // $(document).on('click', '#cartBtn, #mobileCartBtn', function(e) {

        //     e.preventDefault();

        //     if (!isLoggedIn) {

        //         Swal.fire({
        //             icon: 'warning',
        //             title: 'Login Required',
        //             text: 'You must login first to access your cart.',
        //             confirmButtonColor: '#006341',
        //             confirmButtonText: 'Go to Login'
        //         }).then(() => {
        //             window.location.href = "{{ route('login') }}";
        //         });

        //         return;
        //     }

        //     // إذا كان مسجل دخول
        //     $('#cartModal').addClass('active');
        //     $('body').css('overflow', 'hidden');

        //     $('#cartContent').html('<p style="text-align:center">Loading...</p>');

        //     $.get("{{ route('cart.index') }}")
        //         .done(function(res) {
        //             // ✅ أهم سطر (هنا كان الخطأ عندك)
        //             $('#cartContent').html(res.html);
        //         })
        //         .fail(function(xhr) {
        //           console.log(xhr.responseText);
        //             $('#cartContent').html('<p style="text-align:center; color:red;">Failed to load cart. Please try again.</p>');
        //         });
        // });
        $(document).on('click', '#cartBtn,#mobileCartBtn', function(e) {

            e.preventDefault();


            if (!isLoggedIn) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Login Required',
                    text: 'You must login first to access your cart.',
                    confirmButtonColor: '#006341',
                    confirmButtonText: 'Go to Login'
                }).then(() => {
                    window.location.href = "{{ route('login') }}";
                });

                return;
            }


            $('#cartModal').addClass('active');

            $('#cartContent').html('<p style="text-align:center">Loading...</p>');

            $.get("{{ route('cart.index') }}", function(res) {

                $('#cartContent').html(res.html);

            });

        });

        $(document).on('click', '.qty-plus, .qty-minus', function() {

            let row = $(this).closest('.cart-row');
            let cartId = row.data('id');
            let type = $(this).hasClass('qty-plus') ? 'plus' : 'minus';

            $.ajax({
                url: "{{ route('cart.update') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cart_id: cartId,
                    type: type
                },
                success: function(res) {
                    row.find('.qty-number').text(res.quantity);
                    row.find('.item-total').text(res.itemTotal);
                    $('#cart-total').text(res.total);

                }
            });

        });
        $(document).on('click', '.remove-item', function() {

            let row = $(this).closest('.cart-row');
            let cartId = row.data('id');

            $.ajax({
                url: "/cart/remove",
                type: "POST",
                data: {
                    cart_id: cartId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {

                    row.fadeOut(300, function() {
                        $(this).remove();

                        // بعد الحذف افحص عدد العناصر المتبقية
                        if ($('.cart-row').length == 0) {

                            $('.cart-content').html(`
                <div class="cart-empty">
                    <i class="fas fa-heart"></i>
                    <p>Cart is empty</p>
                </div>
            `);
                        }

                    });

                    $('#cart-subtotal').text(res.subtotal);
                    $('#cart-total').text(res.total);
                    $('.cart-count').text(res.count);

                    showAppNotification('Product removed', 'success');
                }
            });

        });

        function loadWishlist() {
            $.get("{{ route('wishlist.index') }}", function(res) {
                $('#wishlistContent').html(res.html);
            });
        }

        function loadHeaderCounts() {

            if (!isLoggedIn) return;

            $.get("{{ route('cart.count') }}", res => {
                $('.cart-count').text(res.count);
            });

            $.get("{{ route('wishlist.count') }}", res => {
                $('.wishlist-count').text(res.count);
            });
        }
        $(document).ready(function() {


            /* ===============================
               HEADER COUNTS
            ================================*/


            loadHeaderCounts();

            /* ===============================
               WISHLIST MODAL
            ================================*/

            $('#wishlistBtn, #mobileWishlistBtn').on('click', function(e) {

                e.preventDefault();

                if (!isLoggedIn) {

                    Swal.fire({
                        icon: 'warning',
                        title: 'Login Required',
                        text: 'You must login first to access your wishlist.',
                        confirmButtonColor: '#006341',
                        confirmButtonText: 'Go to Login'
                    }).then(() => {
                        window.location.href = "{{ route('login') }}";
                    });

                    return;
                }

                $('#wishlistModal').addClass('active');
                $('body').css('overflow', 'hidden');

                $('#wishlistContent').html('<p style="text-align:center">Loading...</p>');

                $.get("{{ route('wishlist.index') }}", function(res) {
                    $('#wishlistContent').html(res.html);
                });

            });

            // Close when clicking X
            $(document).on('click', '.modal-close', function() {
                const modalId = $(this).data('close');
                $('#' + modalId).removeClass('active');
                $('body').css('overflow', '');
            });

            // Close when clicking outside
            $('#wishlistModal').on('click', function(e) {
                if (e.target.id === 'wishlistModal') {
                    $(this).removeClass('active');
                    $('body').css('overflow', '');
                }
            });

        });

        $(document).on('click', '.btn-remove-wishlist', function() {

            let wishlistId = $(this).data('id');
            let card = $(this).closest('.wishlist-item');

            $.ajax({
                url: "/wishlist/remove/" + wishlistId,
                type: "DELETE",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {

                    // حذف من المودال
                    card.remove();

                    // إذا ما ضل عناصر Wishlist بالمودال -> اعرض empty state
                    if ($('#wishlistContent .wishlist-item').length === 0) {
                        $('#wishlistContent').html(`
            <div class="wishlist-empty">
                <div class="wishlist-empty__icon">
                    <i class="fas fa-heart"></i>
                </div>

                <p class="wishlist-empty__text">Your wishlist is empty</p>

                <a href="{{ route('ecommerce.shop') }}"
                   class="wishlist-empty__btn"
                   onclick="$('#wishlistModal').removeClass('active'); $('body').css('overflow','');">
                    Continue Browsing
                </a>
            </div>
        `);
                    }

                    // 🔥 إزالة التفعيل من كل القلوب بنفس الصفحة (اختياري خليها أدق تحت)
                    $('.wishlist-icon[data-id]').each(function() {
                        $(this).removeClass('active');
                        $(this).find('i').removeClass('fas').addClass('far');
                    });

                    loadHeaderCounts();
                    showWishlistNotification('Removed from wishlist', 'info');
                }
            });

        });


        $(document).on('click', '.btn-add-to-cart', function() {

            if (!isLoggedIn) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Login Required',
                    text: 'You must login first to add items to cart.',
                    confirmButtonColor: '#006341'
                }).then(() => {
                    window.location.href = "{{ route('login') }}";
                });

                return;
            }

            let btn = $(this);
            let id = btn.data('id');

            // ✅ جيب الكمية من الانبوت
            // ✅ خذ الكمية من نفس المنتج
            let qtyInput = btn.closest('div').find('.quantity-input');
            let quantity = qtyInput.length ? parseInt(qtyInput.val()) : 1;

            $.post("{{ route('cart.add') }}", {
                product_id: id,
                quantity: quantity, // 👈 أضفناها
                _token: $('meta[name="csrf-token"]').attr('content')
            }, function() {

                // ✅ رجع العدد لـ 1
                qtyInput.val(1);

                loadHeaderCounts();

                showAppNotification('Added to cart', 'success');

            });

        });

        function showWishlistNotification(message, type = 'info') {

            const existing = $('.wishlist-notification');
            if (existing.length) existing.remove();

            const icon = type === 'success' ? 'fa-heart' : 'fa-info-circle';

            const notification = $(`
        <div class="wishlist-notification ${type}">
            <i class="fas ${icon}"></i>
            <span>${message}</span>
        </div>
    `);

            $('body').append(notification);

            setTimeout(() => notification.addClass('show'), 50);

            setTimeout(() => {
                notification.removeClass('show');
                setTimeout(() => notification.remove(), 300);
            }, 2500);
        }

        $(document).on('click', '.wishlist-icon, .btn-wishlist', function() {
            if (!isLoggedIn) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Login Required',
                    text: 'You must login first to add items to wishlist.',
                    confirmButtonColor: '#006341'
                }).then(() => {
                    window.location.href = "{{ route('login') }}";
                });

                return;
            }
            let btn = $(this);
            let id = btn.data('id');

            $.ajax({
                url: "{{ route('wishlist.toggle') }}",
                type: "POST",
                data: {
                    product_id: id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {

                    if (res.status === 'added') {

                        btn.addClass('active');
                        btn.find('i').removeClass('far').addClass('fas');

                        showWishlistNotification(res.name + ' added to wishlist!', 'success');

                    } else {

                        btn.removeClass('active');
                        btn.find('i').removeClass('fas').addClass('far');

                        showWishlistNotification(res.name + ' removed from wishlist!', 'info');
                    }

                    loadHeaderCounts();
                }
            });

        });

        function loadWishlistCount() {

            $.ajax({
                url: "{{ route('wishlist.count') }}",
                type: "GET",
                success: function(res) {
                    $('.wishlist-count').text(res.count);
                }
            });

        }

        $(document).on('click', '.btn-add-all-cart', function(e) {
            e.preventDefault();

            if (!isLoggedIn) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Login Required',
                    text: 'You must login first.',
                    confirmButtonColor: '#006341'
                }).then(() => {
                    window.location.href = "{{ route('login') }}";
                });
                return;
            }

            const btn = $(this);
            btn.prop('disabled', true).text('Adding...');

            $.post("{{ route('cart.addAll') }}", {
                    _token: $('meta[name="csrf-token"]').attr('content')
                })
                .done(function(res) {
                    loadHeaderCounts();

                    showAppNotification('All items added to cart!', 'success');
                })
                .fail(function(xhr) {
                    console.log(xhr.responseText);
                    showAppNotification('Something went wrong', 'error');
                })
                .always(function() {
                    btn.prop('disabled', false).text('Add All To Cart');
                });
        });
    </script>
</body>

</html>
