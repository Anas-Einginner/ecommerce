@extends('ecommerce-project.master')
@section('content')
    <style>
        .contact-hero {
            padding: 160px 0 40px;
            background: linear-gradient(rgba(0, 99, 65, 0.03), rgba(0, 99, 65, 0.01));
            text-align: center;
        }

        .contact-hero h1 {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .contact-hero p {
            font-size: 1.1rem;
            color: var(--gray);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .contact-form-container {
            background: white;
            border-radius: var(--radius);
            padding: 30px;
            box-shadow: var(--shadow);
        }

        .contact-info-container {
            background: white;
            border-radius: var(--radius);
            padding: 30px;
            box-shadow: var(--shadow);
        }

        .section-title {
            font-size: 1.6rem;
            color: var(--primary);
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--primary);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text);
            font-size: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:hover {
            border-color: #bbb;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 99, 65, 0.1);
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }

        .contact-info-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid var(--border);
        }

        .contact-info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            background: rgba(0, 99, 65, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .contact-details h4 {
            font-size: 1.2rem;
            color: var(--primary);
            margin-bottom: 5px;
        }

        .contact-details p {
            color: var(--gray);
            line-height: 1.6;
            font-size: 1rem;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(0, 99, 65, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .social-link:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
        }

        .review-form-section {
            padding: 60px 0;
            background: rgba(0, 99, 65, 0.02);
        }

        .review-form-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .review-form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .review-form-header h2 {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .review-form-header p {
            color: var(--gray);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .review-form-wrapper {
            background: white;
            border-radius: var(--radius);
            padding: 40px;
            box-shadow: var(--shadow);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 25px;
        }

        .rating-group {
            margin-bottom: 25px;
        }

        .rating-label {
            display: block;
            margin-bottom: 12px;
            font-weight: 600;
            color: var(--text);
            font-size: 1rem;
        }

        .rating-input {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .stars-container {
            display: flex;
            gap: 8px;
        }

        .star {
            font-size: 1.8rem;
            color: #e0e0e0;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .star:hover,
        .star.active {
            color: #ffc107;
        }

        .rating-text {
            font-size: 1rem;
            color: var(--primary);
            font-weight: 600;
            min-width: 100px;
        }

        .review-submit-btn {
            width: 100%;
            padding: 16px;
            font-size: 1.1rem;
            margin-top: 20px;
        }

        .review-message {
            text-align: center;
            padding: 20px;
            background: rgba(0, 99, 65, 0.05);
            border-radius: var(--radius);
            margin-top: 25px;
            display: none;
            border-left: 4px solid var(--primary);
            animation: fadeIn 0.3s ease;
            font-size: 1rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .review-message.show {
            display: block;
        }

        .review-message i {
            color: var(--primary);
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .form-hint {
            font-size: 0.9rem;
            color: var(--gray);
            margin-top: 5px;
            display: block;
        }

        .faq-section {
            padding: 60px 0;
        }

        .faq-item {
            background: white;
            border-radius: var(--radius);
            margin-bottom: 15px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .faq-question {
            padding: 20px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            color: var(--primary);
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .faq-question:hover {
            background: rgba(0, 99, 65, 0.05);
        }

        .faq-question i {
            font-size: 1rem;
            transition: transform 0.3s ease;
        }

        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }

        .faq-answer {
            padding: 0 20px;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item.active .faq-answer {
            padding: 0 20px 20px;
            max-height: 500px;
        }

        .faq-answer p {
            font-size: 1rem;
            color: var(--gray);
            line-height: 1.6;
        }

        .cta {
            background: var(--primary);
            color: white;
            text-align: center;
            padding: 60px 20px;
            margin-top: 40px;
        }

        .cta h2 {
            font-size: 2.2rem;
            margin-bottom: 15px;
        }

        .cta p {
            max-width: 600px;
            margin: 0 auto;
            opacity: 0.9;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .modal-container {
            background: white;
            border-radius: var(--radius);
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            margin: 0;
            font-family: 'Playfair Display', serif;
            color: var(--text);
            font-size: 1.4rem;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--gray);
            transition: color 0.3s ease;
        }

        .modal-close:hover {
            color: #dc3545;
        }

        .modal-content {
            padding: 20px;
        }

        .cart-empty,
        .wishlist-empty {
            text-align: center;
            padding: 40px 20px;
        }

        .cart-empty i,
        .wishlist-empty i {
            font-size: 48px;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .cart-empty h4,
        .wishlist-empty h4 {
            margin-bottom: 20px;
            color: var(--gray);
            font-family: 'Inter', sans-serif;
            font-size: 18px;
        }

        .cart-empty .btn,
        .wishlist-empty .btn {
            margin-top: 20px;
        }

        .cart-items,
        .wishlist-items {
            display: none;
        }

        .cart-items-list,
        .wishlist-items-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 20px;
        }

        .cart-item,
        .wishlist-item {
            display: flex;
            gap: 15px;
            padding: 15px;
            background: var(--light-gray);
            border-radius: var(--radius);
            align-items: center;
        }

        .cart-item-img,
        .wishlist-item-img {
            width: 80px;
            height: 80px;
            border-radius: 4px;
            overflow: hidden;
            flex-shrink: 0;
            border: 1px solid var(--border);
        }

        .cart-item-img img,
        .wishlist-item-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart-item-details,
        .wishlist-item-details {
            flex-grow: 1;
        }

        .cart-item-title,
        .wishlist-item-title {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            color: var(--text);
        }

        .cart-item-price,
        .wishlist-item-price {
            color: var(--primary);
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .cart-item-qty {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 5px;
        }

        .qty-btn {
            width: 30px;
            height: 30px;
            border: 1px solid var(--border);
            background: white;
            cursor: pointer;
            border-radius: 4px;
            font-weight: 600;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .qty-btn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .qty-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .qty-btn:disabled:hover {
            background: white;
            color: var(--gray);
            border-color: var(--border);
        }

        .qty-display {
            min-width: 40px;
            text-align: center;
            font-weight: 600;
            font-size: 16px;
        }

        .remove-item {
            color: #dc3545;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 4px;
            transition: background 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .remove-item:hover {
            background: #f8d7da;
        }

        .cart-summary {
            padding: 20px;
            background: var(--light-gray);
            border-radius: var(--radius);
            margin-top: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
            font-family: 'Inter', sans-serif;
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .summary-row.total {
            font-weight: 700;
            font-size: 18px;
            color: var(--primary);
            border-top: 2px solid var(--border);
            margin-top: 10px;
            padding-top: 15px;
        }

        .cart-total-amount {
            color: var(--primary);
            font-weight: 700;
        }

        .btn {
            display: inline-block;
            padding: 12px 28px;
            border-radius: var(--radius);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            border: none;
            font-size: 16px;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: 2px solid var(--primary);
        }

        .btn-primary:hover {
            background-color: #004d33;
            border-color: #004d33;
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .btn-block {
            width: 100%;
            padding: 14px;
            font-size: 16px;
            margin-top: 15px;
        }

        .wishlist-modal {
            max-width: 600px;
        }

        .wishlist-item-actions {
            display: flex;
            gap: 10px;
        }

        .wishlist-item-actions button {
            padding: 8px 15px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border-radius: 4px;
            border: none;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .wishlist-item-actions .btn-add {
            background: var(--primary);
            color: white;
        }

        .wishlist-item-actions .btn-add:hover {
            background: #004d33;
        }

        .wishlist-item-actions .btn-remove {
            background: #dc3545;
            color: white;
        }

        .wishlist-item-actions .btn-remove:hover {
            background: #c82333;
        }

        .remove-wishlist-item {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #dc3545;
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .remove-wishlist-item:hover {
            background: #c82333;
            transform: scale(1.1);
        }

        .wishlist-actions {
            text-align: center;
            margin-top: 20px;
        }

        .notification {
            position: fixed;
            top: 100px;
            right: 20px;
            background: white;
            padding: 15px 25px;
            border-radius: var(--radius);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            z-index: 10000;
            transform: translateX(300px);
            transition: transform 0.3s ease;
            border-left: 4px solid var(--primary);
            max-width: 300px;
            font-weight: 600;
            font-family: 'Cairo', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 14px;
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification i {
            color: var(--primary);
            margin-right: 10px;
            font-size: 18px;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        /* Responsive adjustments for contact page */
        @media(max-width: 992px) {
            .contact-hero {
                padding: 140px 0 30px;
            }

            .contact-hero h1 {
                font-size: 2.2rem;
            }

            .review-form-header h2 {
                font-size: 1.8rem;
            }
        }

        @media(max-width: 768px) {
            .contact-hero {
                padding: 120px 0 20px;
            }

            .contact-hero h1 {
                font-size: 1.8rem;
            }

            .contact-hero p {
                font-size: 1rem;
            }

            .contact-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .contact-form-container,
            .contact-info-container {
                padding: 25px;
            }

            .cart-item,
            .wishlist-item {
                flex-direction: column;
                text-align: center;
            }

            .cart-item-img,
            .wishlist-item-img {
                margin-right: 0;
                margin-bottom: 10px;
            }

            .cart-item-qty {
                justify-content: center;
            }

            .wishlist-item-actions {
                justify-content: center;
            }

            .review-form-wrapper {
                padding: 25px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }

        @media(max-width: 576px) {
            .contact-hero {
                padding: 110px 0 15px;
            }

            .contact-hero h1 {
                font-size: 1.6rem;
            }

            .contact-hero p {
                font-size: 0.95rem;
            }

            .contact-form-container,
            .contact-info-container {
                padding: 20px;
            }

            .section-title {
                font-size: 1.4rem;
            }

            .review-form-wrapper {
                padding: 20px;
            }

            .review-form-header h2 {
                font-size: 1.5rem;
            }

            .star {
                font-size: 1.5rem;
            }

            .cta {
                padding: 40px 15px;
            }

            .cta h2 {
                font-size: 1.8rem;
            }

            .cta p {
                font-size: 1rem;
            }
        }

        .product-search {
            position: relative;
        }

        .product-search input {
            width: 100%;
            padding: 12px 40px 12px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .product-search input:focus {
            border-color: #006341;
            box-shadow: 0 0 0 3px rgba(0, 99, 65, 0.1);
            outline: none;
        }

        .product-search::after {
            content: "\f002";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            right: 15px;
            top: 38px;
            color: #888;
            font-size: 14px;
        }

        .product-search input::placeholder {
            color: #999;
        }
    </style>




    <main>
        <section class="contact-hero">
            <div class="container">
                <h1>Get in Touch</h1>
                <p>Have questions about our products or artisans? We're here to help preserve and share Palestinian heritage
                    with you.</p>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="contact-grid">
                    <div class="contact-form-container">
                        <h2 class="section-title">Send Us a Message</h2>
                        <form method="POST" action="{{ route('dash.messages.store') }}" id="add-form" class="add-form">
                            @csrf

                            <div class="form-group">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="full_name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Email Address *</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Subject</label>
                                <input type="text" name="subject" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Message *</label>
                                <textarea name="message" class="form-control" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Send Message
                            </button>
                        </form>
                    </div>

                    <div class="contact-info-container">
                        <h2 class="section-title">Contact Information</h2>

                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Our Location</h4>
                                <p>HAWIYA is an online platform<br>WORLDWIDE</p>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Phone Number</h4>
                                <p>
                                    {{ $contact?->phone }} <br>
                                    Monday - Friday, 9AM - 6PM
                                </p>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Email Address</h4>
                                <p>
                                    {{ $contact?->email }} <br>
                                    {{ $contact?->support_email }}
                                </p>
                            </div>
                        </div>

                        <div class="social-links">

                            @if ($contact?->facebook)
                                <a href="{{ $contact->facebook }}" class="social-link" title="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            @endif

                            @if ($contact?->instagram)
                                <a href="{{ $contact->instagram }}" class="social-link" title="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            @endif

                            @if ($contact?->twitter)
                                <a href="{{ $contact->twitter }}" class="social-link" title="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            @endif

                            @if ($contact?->pinterest)
                                <a href="{{ $contact->pinterest }}" class="social-link" title="Pinterest">
                                    <i class="fab fa-pinterest-p"></i>
                                </a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="review-form-section">
            <div class="container">
                <div class="review-form-container">
                    <div class="review-form-header">
                        <h2>Share Your Experience</h2>
                        <p>Your feedback helps us support Palestinian artisans and improve our community</p>
                    </div>

                    <div class="review-form-wrapper">
                        <form method="POST" action="{{ route('ecommerce.store.review') }}" id="review-form">
                            @csrf
                            <input type="hidden" name="product_id" id="product_id">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="reviewName" class="form-label">Your Name *</label>
                                    <input type="text" name="name" id="reviewName" class="form-control">
                                    <span class="form-hint">We'll use this to personalize your review</span>
                                </div>
                                <div class="form-group">
                                    <label for="reviewEmail" class="form-label">Email Address *</label>
                                    <input type="email" name="email" id="reviewEmail" class="form-control">
                                    <span class="form-hint">We won't share your email with anyone</span>
                                </div>
                            </div>

                            <div class="form-group product-search">
                                <label for="reviewProduct" class="form-label">
                                    Product You Purchased (Optional)
                                </label>

                                <input type="text" id="reviewProduct" class="form-control"
                                    placeholder="Search product..." list="productsList" >

                                <datalist id="productsList"></datalist>


                            </div>
                            <div class="rating-group">
                                <label class="rating-label">Your Rating *</label>
                                <div class="rating-input">
                                    <div class="stars-container" id="ratingStars">
                                        <i class="far fa-star star" data-rating="1"></i>
                                        <i class="far fa-star star" data-rating="2"></i>
                                        <i class="far fa-star star" data-rating="3"></i>
                                        <i class="far fa-star star" data-rating="4"></i>
                                        <i class="far fa-star star" data-rating="5"></i>
                                    </div>
                                    <span class="rating-text" id="ratingText">Select your rating</span>
                                    <input type="hidden" name="rating" id="ratingValue" value="0">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="reviewTitle" class="form-label">Review Title *</label>
                                <input type="text" name="title" id="reviewTitle" class="form-control"
                                    placeholder="Summarize your experience">
                            </div>

                            <div class="form-group">
                                <label for="reviewText" class="form-label">Your Review *</label>
                                <textarea id="reviewText" name="review" class="form-control" rows="5"
                                    placeholder="Tell us about your experience with our products and artisans..."></textarea>
                                <span class="form-hint">Share details about the quality, craftsmanship, and your overall
                                    experience</span>
                            </div>

                            <button type="submit" class="btn btn-primary review-submit-btn">
                                <i class="fas fa-paper-plane"></i> Submit Review
                            </button>
                        </form>

                        <div class="review-message" id="reviewMessage"></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="faq-section">
            <div class="container">
                <h2 class="section-title" style="text-align: left;">Frequently Asked Questions</h2>
                <p style="text-align:left; color: var(--gray); margin-bottom: 24px; font-size: 0.95rem;">Find quick answers
                    to common questions</p>

                <div class="faq-item">
                    <div class="faq-question">
                        How can I support Palestinian artisans?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Every purchase from HAWIYA directly supports Palestinian artisans and their families. You can
                            also help by sharing our story, following us on social media, and spreading awareness about
                            Palestinian traditional crafts.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        What is your shipping policy?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>We offer free worldwide shipping on orders over $100. Standard shipping takes 10-15 business
                            days, while express shipping (available for an additional fee) takes 5-7 business days. All
                            packages are carefully wrapped to protect your traditional crafts.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        How do I track my order?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Once your order ships, you'll receive a confirmation email with a tracking number. You can use
                            this number on our website or the carrier's website to track your package's journey from
                            Palestine to your doorstep.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        Can I request custom embroidery or designs?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Yes! We work closely with our artisans to create custom pieces. Please contact us with your
                            requirements, and we'll connect you with the appropriate artisan to discuss your vision,
                            timeline, and pricing.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="cta">
            <h2>Connect With Heritage</h2>
            <p>Join our community in preserving Palestinian culture through authentic crafts and meaningful connections.</p>
        </section>
    </main>



    <script>
        $('#add-form').on('submit', function(e) {

            e.preventDefault();

            let form = $(this);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),

                success: function(response) {

                    Swal.fire({
                        icon: 'success',
                        title: '📩 Message Sent!',
                        text: 'Thank you for contacting us. We will reply soon.',
                        confirmButtonColor: '#198754'
                    });

                    form[0].reset();
                },

                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong!',
                        text: 'Please try again later.'
                    });
                }
            });
        });

        $(document).ready(function() {

            $('#reviewProduct').on('keyup', function() {

                let search = $(this).val();

                if (search.length < 1) return;

                $.ajax({
                    url: "{{ route('ecommerce.products.search') }}",
                    type: "GET",
                    data: {
                        search: search
                    },

                    success: function(products) {

                        let html = '';

                        products.forEach(function(product) {

                            // html +=
                            //     `<option value="${product.id}">${product.name}</option>`;
                            html += `<option value="${product.name}" data-id="${product.id}"></option>`;
                        });

                        $('#productsList').html(html);

                    }

                });

            });

        });

        $(document).ready(function() {

            $('#ratingStars .star').click(function() {

                let rating = $(this).data('rating');

                // حفظ القيمة
                $('#ratingValue').val(rating);

                // إعادة تعيين النجوم
                $('#ratingStars .star').removeClass('fas').addClass('far');

                // تعبئة النجوم
                $('#ratingStars .star').each(function() {

                    if ($(this).data('rating') <= rating) {
                        $(this).removeClass('far').addClass('fas');
                    }

                });

                $('#ratingText').text(rating + " Star Rating");

            });

        });


        $('#review-form').on('submit', function(e) {

            e.preventDefault();

            if ($('#product_id').val() == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Select Product',
                    text: 'Please select product from list'
                });
                return;
            }

            let form = $(this);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),

                success: function(response) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Review Sent!',
                        text: 'Thank you for your feedback.',
                        confirmButtonColor: '#198754'
                    });

                    form[0].reset();

                    $('#ratingStars .star').removeClass('fas').addClass('far');
                    $('#ratingText').text('Select your rating');

                },

                error: function(xhr) {

                    console.log(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong'
                    });

                }

            });

        });
        // document.getElementById("reviewProduct").addEventListener("change", function() {

        //     let selected = this.value;
        //     let options = document.querySelectorAll("#productsList option");

        //     options.forEach(option => {

        //         if (option.value === selected) {
        //             document.getElementById("product_id").value = option.dataset.id;
        //         }

        //     });

        // });
        $('#reviewProduct').on('input', function(){

    let val = $(this).val();

    $('#productsList option').each(function(){

        if($(this).val() === val){
            $('#product_id').val($(this).data('id'));
        }

    });

});
    </script>
@endsection
