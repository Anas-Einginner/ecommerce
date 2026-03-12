document.addEventListener('DOMContentLoaded', function() {
    initializeSite();
});

let currentUser = null;

function initializeSite() {
    const header = document.querySelector('.header');
    if (header) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
                const logoImg = document.querySelector('.logo-img');
                if (logoImg) logoImg.style.height = '60px';
            } else {
                header.classList.remove('scrolled');
                const logoImg = document.querySelector('.logo-img');
                if (logoImg) logoImg.style.height = '80px';
            }
        });
    }

    initializeSearchToggle();
    initializeHeroSlider();
    initializeMobileMenu();
    initializeProductFilter();
    initializeCart();
    initializeWishlist();
    initializeAuth();
    initializeNewsletterForm();
    initializeBackToTop();
}

function initializeSearchToggle() {
    const searchToggle = document.getElementById('searchToggle');
    const searchBox = document.getElementById('searchBox');
    if (!searchToggle || !searchBox) return;

    searchToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        searchBox.classList.toggle('active');
        const input = searchBox.querySelector('.search-input');
        if (input && searchBox.classList.contains('active')) {
            input.focus();
        }
    });

    document.addEventListener('click', (e) => {
        if (!searchBox.contains(e.target) && !searchToggle.contains(e.target)) {
            searchBox.classList.remove('active');
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && searchBox.classList.contains('active')) {
            searchBox.classList.remove('active');
        }
    });
}

function initializeHeroSlider() {
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.querySelector('.slider-prev');
    const nextBtn = document.querySelector('.slider-next');
    if (!slides.length) return;

    let currentSlide = 0;
    slides[currentSlide].classList.add('active');
    if (dots[currentSlide]) dots[currentSlide].classList.add('active');

    function nextSlide() {
        slides[currentSlide].classList.remove('active');
        if (dots[currentSlide]) dots[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
        if (dots[currentSlide]) dots[currentSlide].classList.add('active');
    }

    function prevSlide() {
        slides[currentSlide].classList.remove('active');
        if (dots[currentSlide]) dots[currentSlide].classList.remove('active');
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        slides[currentSlide].classList.add('active');
        if (dots[currentSlide]) dots[currentSlide].classList.add('active');
    }

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            slides[currentSlide].classList.remove('active');
            if (dots[currentSlide]) dots[currentSlide].classList.remove('active');
            currentSlide = index;
            slides[currentSlide].classList.add('active');
            if (dots[currentSlide]) dots[currentSlide].classList.add('active');
        });
    });

    if (prevBtn) prevBtn.addEventListener('click', prevSlide);
    if (nextBtn) nextBtn.addEventListener('click', nextSlide);

    let slideInterval = setInterval(nextSlide, 5000);
    const slider = document.querySelector('.hero-slider');
    if (slider) {
        slider.addEventListener('mouseenter', () => clearInterval(slideInterval));
        slider.addEventListener('mouseleave', () => {
            slideInterval = setInterval(nextSlide, 5000);
        });
    }
}

function initializeMobileMenu() {
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const closeMobileMenuBtn = document.querySelector('.close-mobile-menu');
    const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');

    if (mobileMenuBtn && mobileMenuOverlay) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenuOverlay.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
    }

    if (closeMobileMenuBtn && mobileMenuOverlay) {
        closeMobileMenuBtn.addEventListener('click', () => {
            mobileMenuOverlay.style.display = 'none';
            document.body.style.overflow = '';
        });
    }

    if (mobileMenuOverlay) {
        mobileMenuOverlay.addEventListener('click', (e) => {
            if (e.target === mobileMenuOverlay) {
                mobileMenuOverlay.style.display = 'none';
                document.body.style.overflow = '';
            }
        });
    }
}

function initializeProductFilter() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const productCards = document.querySelectorAll('.product-card');
    if (!filterBtns.length) return;

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const filter = btn.getAttribute('data-filter');

            productCards.forEach(card => {
                if (filter === 'all' || card.getAttribute('data-category') === filter) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 10);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
}

function initializeCart() {
    const addToCartBtns = document.querySelectorAll('.btn-add-to-cart, .btn-quick-add');
    const cartCount = document.querySelector('.cart-count');
    const cartBtn = document.getElementById('cartBtn');
    const cartModal = document.getElementById('cartModal');
    if (!cartModal) return;

    const modalClose = cartModal.querySelector('.modal-close');
    let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    let cartItemCount = cartItems.reduce((sum, item) => sum + item.quantity, 0);
    let totalAmount = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);

    function updateCartDisplay() {
        if (cartCount) cartCount.textContent = cartItemCount;
        const cartEmpty = document.getElementById('cartEmpty');
        const cartItemsContainer = document.getElementById('cartItems');
        const cartItemsList = cartItemsContainer.querySelector('.cart-items-list');
        const cartSubtotal = cartItemsContainer.querySelector('.cart-subtotal');
        const cartTotalAmount = cartItemsContainer.querySelector('.cart-total-amount');

        if (cartItemCount === 0) {
            if (cartEmpty) cartEmpty.style.display = 'block';
            if (cartItemsContainer) cartItemsContainer.style.display = 'none';
        } else {
            if (cartEmpty) cartEmpty.style.display = 'none';
            if (cartItemsContainer) cartItemsContainer.style.display = 'block';
            if (cartItemsList) cartItemsList.innerHTML = '';

            cartItems.forEach(item => {
                const cartItem = document.createElement('div');
                cartItem.className = 'cart-item';
                cartItem.innerHTML = `
                    <div class="cart-item-image">
                        <img src="${item.image}" alt="${item.name}">
                    </div>
                    <div class="cart-item-info">
                        <h4 class="cart-item-title">${item.name}</h4>
                        <div class="cart-item-price">$${item.price.toFixed(2)}</div>
                        <div class="cart-item-quantity">
                            <button class="decrease-qty" data-id="${item.id}">-</button>
                            <input type="number" value="${item.quantity}" min="1" max="10" data-id="${item.id}">
                            <button class="increase-qty" data-id="${item.id}">+</button>
                        </div>
                    </div>
                    <button class="cart-item-remove" data-id="${item.id}">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                if (cartItemsList) cartItemsList.appendChild(cartItem);
            });

            document.querySelectorAll('.decrease-qty').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    updateCartItemQuantity(id, -1);
                });
            });

            document.querySelectorAll('.increase-qty').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    updateCartItemQuantity(id, 1);
                });
            });

            document.querySelectorAll('.cart-item-remove').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    removeCartItem(id);
                });
            });

            if (cartSubtotal) cartSubtotal.textContent = `$${totalAmount.toFixed(2)}`;
            if (cartTotalAmount) cartTotalAmount.textContent = `$${totalAmount.toFixed(2)}`;
        }

        const cartEmptyBtn = document.querySelector('#cartEmpty .btn');
        if (cartEmptyBtn) {
            cartEmptyBtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = 'html/shop.html';
            });
        }

        localStorage.setItem('cartItems', JSON.stringify(cartItems));
    }

    function addToCart(productId, productName, productPrice, productImage) {
        const existingItemIndex = cartItems.findIndex(item => item.id === productId);
        if (existingItemIndex > -1) {
            cartItems[existingItemIndex].quantity += 1;
        } else {
            cartItems.push({
                id: productId,
                name: productName,
                price: productPrice,
                image: productImage,
                quantity: 1
            });
        }
        cartItemCount += 1;
        totalAmount += productPrice;
        updateCartDisplay();
        showNotification(`${productName} added to cart!`);
        createFlyingItemAnimation(productImage);
        return true;
    }

    function updateCartItemQuantity(itemId, change) {
        const itemIndex = cartItems.findIndex(item => item.id === itemId);
        if (itemIndex > -1) {
            const item = cartItems[itemIndex];
            const newQty = item.quantity + change;
            if (newQty < 1) {
                removeCartItem(itemId);
                return;
            }
            const qtyChange = change;
            const priceChange = item.price * change;
            cartItems[itemIndex].quantity = newQty;
            cartItemCount += qtyChange;
            totalAmount += priceChange;
            updateCartDisplay();
        }
    }

    function removeCartItem(itemId) {
        const itemIndex = cartItems.findIndex(item => item.id === itemId);
        if (itemIndex > -1) {
            const item = cartItems[itemIndex];
            cartItemCount -= item.quantity;
            totalAmount -= item.price * item.quantity;
            cartItems.splice(itemIndex, 1);
            updateCartDisplay();
            showNotification(`${item.name} removed from cart`, 'info');
        }
    }

    if (cartBtn) {
        cartBtn.addEventListener('click', (e) => {
            e.preventDefault();
            cartModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
    }

    if (modalClose) {
        modalClose.addEventListener('click', () => {
            cartModal.style.display = 'none';
            document.body.style.overflow = '';
        });
    }

    cartModal.addEventListener('click', (e) => {
        if (e.target === cartModal) {
            cartModal.style.display = 'none';
            document.body.style.overflow = '';
        }
    });

    addToCartBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const productCard = this.closest('.product-card');
            const productId = productCard.getAttribute('data-id') || `prod-${Date.now()}`;
            const productName = productCard.querySelector('.product-title')?.textContent || 'Product';
            const priceText = productCard.querySelector('.current-price')?.textContent.replace('$', '');
            const productPrice = parseFloat(priceText) || 0;
            const bgImage = getComputedStyle(productCard.querySelector('.product-img')).backgroundImage;
            const productImage = bgImage.slice(5, -2) || 'img/placeholder.jpg';

            addToCart(productId, productName, productPrice, productImage);
        });
    });

    updateCartDisplay();
}

function createFlyingItemAnimation(imageUrl) {
    const flyingItem = document.createElement('div');
    flyingItem.className = 'flying-item';
    flyingItem.style.cssText = `
        position: fixed;
        width: 40px;
        height: 40px;
        background-image: url(${JSON.stringify(imageUrl)});
        background-size: cover;
        border-radius: 50%;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        z-index: 9999;
        left: ${window.innerWidth / 2}px;
        top: ${window.innerHeight / 2}px;
        pointer-events: none;
    `;
    document.body.appendChild(flyingItem);

    const cartIcon = document.querySelector('.cart-icon') || document.querySelector('.cart');
    if (cartIcon) {
        const rect = cartIcon.getBoundingClientRect();
        setTimeout(() => {
            flyingItem.style.transition = 'all 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55)';
            flyingItem.style.left = `${rect.left + rect.width / 2 - 20}px`;
            flyingItem.style.top = `${rect.top + rect.height / 2 - 20}px`;
            flyingItem.style.transform = 'scale(0.1)';
            flyingItem.style.opacity = '0';
        }, 10);
    }

    setTimeout(() => {
        if (flyingItem.parentNode) document.body.removeChild(flyingItem);
    }, 1000);
}

function initializeWishlist() {
    let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
    updateWishlistUI(wishlist.length);
    
    const wishlistIcon = document.querySelector('.action-icon[title="Wishlist"]');
    if (wishlistIcon) {
        wishlistIcon.addEventListener('click', function(e) {
            e.preventDefault();
            showWishlistPage();
        });
    }
    
    document.addEventListener('click', function(e) {
        if (e.target.closest('.add-wishlist')) {
            const btn = e.target.closest('.add-wishlist');
            const productCard = btn.closest('.product-card');
            toggleWishlistItem(productCard, btn);
        }
    });
}

function toggleWishlistItem(productCard, button) {
    const productId = productCard.getAttribute('data-id') || `prod-${Date.now()}`;
    const productName = productCard.querySelector('.product-title')?.textContent || 'Product';
    const priceText = productCard.querySelector('.current-price')?.textContent.replace('$', '');
    const productPrice = parseFloat(priceText) || 0;
    const bgImage = getComputedStyle(productCard.querySelector('.product-img')).backgroundImage;
    const productImage = bgImage.slice(5, -2) || 'img/placeholder.jpg';
    
    let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
    const existingIndex = wishlist.findIndex(item => item.id === productId);
    
    if (existingIndex > -1) {
        wishlist.splice(existingIndex, 1);
        button.classList.remove('active');
        button.querySelector('i').className = 'far fa-heart';
        showNotification('Removed from wishlist', 'info');
    } else {
        wishlist.push({
            id: productId,
            name: productName,
            price: productPrice,
            image: productImage,
            addedAt: new Date().toISOString()
        });
        button.classList.add('active');
        button.querySelector('i').className = 'fas fa-heart';
        showNotification('Added to wishlist!', 'success');
        
        button.style.transform = 'scale(1.3)';
        setTimeout(() => {
            button.style.transform = '';
        }, 300);
    }
    
    localStorage.setItem('wishlist', JSON.stringify(wishlist));
    updateWishlistUI(wishlist.length);
}

function updateWishlistUI(count) {
    const wishlistCount = document.querySelector('.wishlist-count');
    if (wishlistCount) {
        wishlistCount.textContent = count;
    }
    
    document.querySelectorAll('.add-wishlist').forEach(btn => {
        const productCard = btn.closest('.product-card');
        const productId = productCard.getAttribute('data-id');
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        const inWishlist = wishlist.some(item => item.id === productId);
        
        if (inWishlist) {
            btn.classList.add('active');
            btn.querySelector('i').className = 'fas fa-heart';
        } else {
            btn.classList.remove('active');
            btn.querySelector('i').className = 'far fa-heart';
        }
    });
}

function showWishlistPage() {
    const wishlistModal = document.createElement('div');
    wishlistModal.className = 'modal-overlay';
    wishlistModal.id = 'wishlistModal';
    
    let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
    
    wishlistModal.innerHTML = `
        <div class="modal-container wishlist-modal">
            <div class="modal-header">
                <h3><i class="fas fa-heart"></i> My Wishlist</h3>
                <button class="modal-close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-content">
                ${wishlist.length === 0 ? `
                    <div class="wishlist-empty">
                        <i class="fas fa-heart"></i>
                        <h4>Your wishlist is empty</h4>
                        <p>Save items you love to your wishlist</p>
                        <a href="html/shop.html" class="btn btn-primary">Start Shopping</a>
                    </div>
                ` : `
                    <div class="wishlist-items">
                        ${wishlist.map(item => `
                            <div class="wishlist-item" data-id="${item.id}">
                                <div class="wishlist-item-img">
                                    <img src="${item.image}" alt="${item.name}">
                                </div>
                                <div class="wishlist-item-info">
                                    <h4>${item.name}</h4>
                                    <div class="wishlist-item-price">$${item.price.toFixed(2)}</div>
                                </div>
                                <div class="wishlist-item-actions">
                                    <button class="btn btn-primary btn-small add-to-cart-from-wishlist">
                                        <i class="fas fa-shopping-cart"></i> Add to Cart
                                    </button>
                                    <button class="btn btn-outline btn-small remove-from-wishlist">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                    <div class="wishlist-actions">
                        <button class="btn btn-primary" id="clearWishlistBtn">
                            <i class="fas fa-trash"></i> Clear All
                        </button>
                        <a href="#" class="btn btn-outline continue-shopping-btn">
                            Continue Shopping
                        </a>
                    </div>
                `}
            </div>
        </div>
    `;
    
    document.body.appendChild(wishlistModal);
    wishlistModal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    initializeWishlistModal(wishlistModal);
}

function initializeWishlistModal(modal) {
    const closeBtn = modal.querySelector('.modal-close');
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            modal.remove();
            document.body.style.overflow = '';
        });
    }
    
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.remove();
            document.body.style.overflow = '';
        }
    });
    
    const continueShoppingBtn = modal.querySelector('.continue-shopping-btn');
    if (continueShoppingBtn) {
        continueShoppingBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = 'html/shop.html';
        });
    }
    
    modal.querySelectorAll('.remove-from-wishlist').forEach(btn => {
        btn.addEventListener('click', function() {
            const item = this.closest('.wishlist-item');
            const itemId = item.getAttribute('data-id');
            
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            wishlist = wishlist.filter(item => item.id !== itemId);
            
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            updateWishlistUI(wishlist.length);
            
            item.remove();
            
            if (wishlist.length === 0) {
                modal.querySelector('.wishlist-items').innerHTML = `
                    <div class="wishlist-empty">
                        <i class="fas fa-heart"></i>
                        <h4>Your wishlist is empty</h4>
                        <p>Save items you love to your wishlist</p>
                        <a href="html/shop.html" class="btn btn-primary">Start Shopping</a>
                    </div>
                `;
                modal.querySelector('.wishlist-actions').style.display = 'none';
            }
            
            showNotification('Removed from wishlist', 'info');
        });
    });
    
    modal.querySelectorAll('.add-to-cart-from-wishlist').forEach(btn => {
        btn.addEventListener('click', function() {
            const item = this.closest('.wishlist-item');
            const itemId = item.getAttribute('data-id');
            
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            const wishlistItem = wishlist.find(item => item.id === itemId);
            
            if (wishlistItem) {
                addToCart(
                    wishlistItem.id,
                    wishlistItem.name,
                    wishlistItem.price,
                    wishlistItem.image
                );
                
                wishlist = wishlist.filter(item => item.id !== itemId);
                localStorage.setItem('wishlist', JSON.stringify(wishlist));
                updateWishlistUI(wishlist.length);
                item.remove();
                
                showNotification('Added to cart and removed from wishlist!', 'success');
            }
        });
    });
    
    const clearBtn = modal.querySelector('#clearWishlistBtn');
    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            localStorage.removeItem('wishlist');
            updateWishlistUI(0);
            
            modal.querySelector('.wishlist-items').innerHTML = `
                <div class="wishlist-empty">
                    <i class="fas fa-heart"></i>
                    <h4>Your wishlist is empty</h4>
                    <p>Save items you love to your wishlist</p>
                    <a href="html/shop.html" class="btn btn-primary">Start Shopping</a>
                </div>
            `;
            modal.querySelector('.wishlist-actions').style.display = 'none';
            
            showNotification('Wishlist cleared', 'info');
        });
    }
}

function initializeAuth() {
    updateAccountButton();
    updateCartUIForUser();
    
    const accountBtn = document.getElementById('accountBtn');
    if (accountBtn) {
        accountBtn.addEventListener('click', function(e) {
            const currentUser = localStorage.getItem('currentUser') || sessionStorage.getItem('currentUser');
            if (!currentUser) {
                e.preventDefault();
                const currentPath = window.location.pathname;
                window.location.href = `html/login.html?redirect=${encodeURIComponent(currentPath)}`;
            }
        });
    }
    
   // Checkout buttons redirect directly to checkout page
const checkoutLinks = document.querySelectorAll('[href*="checkout"], .btn-primary[href*="checkout"]');
checkoutLinks.forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        window.location.href = 'html/checkout.html';
    });
});

const cartCheckoutBtn = document.querySelector('.cart-items .btn-primary');
if (cartCheckoutBtn) {
    cartCheckoutBtn.addEventListener('click', function(e) {
        e.preventDefault();
        window.location.href = 'html/checkout.html';
    });
}
}

// function updateAccountButton() {
//     const accountBtn = document.getElementById('accountBtn');
//     if (accountBtn) {
//         const currentUser = localStorage.getItem('currentUser') || sessionStorage.getItem('currentUser');
//         const icon = accountBtn.querySelector('i');
        
//         if (currentUser) {
//             const user = JSON.parse(currentUser);
//             // accountBtn.href = 'html/account.html';
//             accountBtn.title = `Logged in as ${user.name}`;
//             if (icon) icon.className = 'fas fa-user-circle';
//         } else {
//             accountBtn.href = 'html/login.html';
//             accountBtn.title = 'Login / Register';
//             if (icon) icon.className = 'far fa-user';
//         }
//     }
// }

function updateCartUIForUser() {
    const currentUser = localStorage.getItem('currentUser') || sessionStorage.getItem('currentUser');
    if (currentUser) {
        const user = JSON.parse(currentUser);
        const users = JSON.parse(localStorage.getItem('hawiyaUsers') || '[]');
        const userData = users.find(u => u.id === user.id);
        
        if (userData && userData.cart && userData.cart.length > 0) {
            const cartCount = document.querySelector('.cart-count');
            if (cartCount) {
                const itemCount = userData.cart.reduce((sum, item) => sum + item.quantity, 0);
                cartCount.textContent = itemCount;
            }
        }
    }
}

function initializeNewsletterForm() {
    const newsletterForm = document.getElementById('communityForm');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const name = this.name.value.trim();
            const email = this.email.value.trim();
            
            if (!name || !email) {
                showNotification('Please fill in all fields.', 'error');
                return;
            }
            
            setTimeout(() => {
                showNotification(`Welcome, ${name}! You're now part of our community.`, 'success');
                this.reset();
                document.querySelectorAll('.input-group label').forEach(l => l.classList.remove('active'));
            }, 600);
        });
    }
    
    document.querySelectorAll('.input-group input').forEach(input => {
        const label = input.nextElementSibling;
        if (input.value) label.classList.add('active');
        
        input.addEventListener('focus', () => label.classList.add('active'));
        input.addEventListener('blur', () => {
            if (!input.value) label.classList.remove('active');
        });
    });
}

function initializeBackToTop() {
    const backToTopBtn = document.querySelector('.back-to-top');
    if (!backToTopBtn) return;

    window.addEventListener('scroll', () => {
        backToTopBtn.style.display = window.scrollY > 500 ? 'flex' : 'none';
    });

    backToTopBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
    `;

    if (!document.querySelector('#notification-styles')) {
        const style = document.createElement('style');
        style.id = 'notification-styles';
        style.textContent = `
            .notification {
                position: fixed;
                top: 100px;
                right: 30px;
                background: white;
                border-radius: 8px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.15);
                padding: 20px;
                z-index: 9999;
                max-width: 350px;
                transform: translateX(100%);
                opacity: 0;
                transition: all 0.3s cubic-bezier(0.68, -0.55, 0.27, 1.55);
                border-left: 4px solid #006341;
            }
            .notification.success { border-left-color: #006341; }
            .notification.error { border-left-color: #ce1126; }
            .notification.info { border-left-color: #17a2b8; }
            .notification-content { display: flex; align-items: center; gap: 15px; }
            .notification-content i { font-size: 1.5rem; color: #006341; }
            .notification.error .notification-content i { color: #ce1126; }
            .notification.info .notification-content i { color: #17a2b8; }
            .notification-content span { font-weight: 500; color: #212529; }
            .notification.show {
                transform: translateX(0);
                opacity: 1;
            }
        `;
        document.head.appendChild(style);
    }

    document.body.appendChild(notification);
    setTimeout(() => notification.classList.add('show'), 10);
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            if (notification.parentNode) document.body.removeChild(notification);
        }, 300);
    }, 3000);



}



