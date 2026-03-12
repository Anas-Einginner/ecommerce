@extends('ecommerce-project.master')
@section('content')
    <style>
        .product-detail-page {
            padding-top: 120px;
            min-height: calc(100vh - 100px);
        }

        .breadcrumb {
            margin-bottom: 15px;
            font-size: 13px;
            color: #666;
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .product-main {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        @media (max-width: 992px) {
            .product-main {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }

        .product-image {
            border-radius: 8px;
            overflow: hidden;
            height: 650px;
            background: #f8f9fa;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 20px;
        }

        .image-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: var(--secondary);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }

        .product-info {
            padding: 0;
        }

        .product-category {
            color: var(--primary);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 8px;
            display: inline-block;
        }

        .product-title {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            margin-bottom: 10px;
            color: #222;
            line-height: 1.3;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .stars {
            color: #ffc107;
            font-size: 13px;
        }

        .product-price-container {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .product-price {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary);
        }

        .original-price {
            text-decoration: line-through;
            color: #888;
            font-size: 16px;
        }

        .discount-badge {
            background: var(--secondary);
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: 600;
        }

        .product-description {
            color: #555;
            margin-bottom: 15px;
            line-height: 1.5;
            font-size: 13px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            margin-bottom: 15px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #555;
        }

        .feature-item i {
            color: var(--primary);
            font-size: 13px;
            min-width: 14px;
        }

        .product-details {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
            font-size: 12px;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #444;
        }

        .detail-value {
            color: #666;
            text-align: right;
        }

        .purchase-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
        }

        .stock-status {
            color: #28a745;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .quantity-buttons {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .quantity-btn {
            width: 28px;
            height: 28px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-input {
            width: 40px;
            text-align: center;
            padding: 4px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-weight: 600;
            font-size: 13px;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            margin-bottom: 10px;
        }

        .btn-add-to-cart {
            flex: 1;
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-add-to-cart:hover {
            background: #004d33;
        }

        .btn-wishlist {
            width: 45px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
        }

        .btn-wishlist:hover {
            color: var(--secondary);
            border-color: var(--secondary);
        }

        .btn-wishlist.active {
            color: var(--secondary);
            border-color: var(--secondary);
        }

        .quick-info {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #666;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .info-item i {
            color: var(--primary);
            font-size: 11px;
        }

        .related-products {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-subtitle {
            font-family: 'Cairo', sans-serif;
            color: var(--primary);
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            display: block;
            margin-bottom: 15px;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            color: #2d2d2d;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--primary);
        }

        .section-description {
            font-family: 'Cairo', sans-serif;
            color: #666;
            font-size: 16px;
            max-width: 600px;
            margin: 30px auto 0;
            line-height: 1.6;
        }

        .related-products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-bottom: 50px;
        }

        @media (max-width: 1200px) {
            .related-products-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 992px) {
            .related-products-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
        }

        @media (max-width: 576px) {
            .related-products-grid {
                grid-template-columns: 1fr;
                gap: 25px;
            }
        }

        .related-product-card {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.4s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .related-product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
        }

        .related-product-img {
            position: relative;
            height: 280px;
            background-size: cover;
            background-position: center;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .related-product-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .related-product-card:hover .related-product-img img {
            transform: scale(1.08);
        }

        .related-product-badge {
            background: var(--primary);
            color: white;
            padding: 8px 15px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.5px;
            position: absolute;
            top: 15px;
            left: 15px;
            z-index: 2;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .related-product-badge.new {
            background: #28a745;
        }

        .related-product-badge.sale {
            background: #dc3545;
        }

        .related-product-info {
            padding: 25px;
            background: white;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .related-product-category {
            color: var(--primary);
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            font-family: 'Cairo', sans-serif;
        }

        .related-product-title {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            color: #2d2d2d;
            margin-bottom: 12px;
            line-height: 1.4;
            min-height: 56px;
        }

        .related-product-description {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
            font-family: 'Cairo', sans-serif;
            min-height: 68px;
            flex-grow: 1;
        }

        .related-product-rating {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 15px;
        }

        .related-product-rating .fas.fa-star {
            color: #ffc107;
        }

        .related-product-rating .fas.fa-star-half-alt {
            color: #ffc107;
        }

        .related-product-rating .far.fa-star {
            color: #ddd;
        }

        .related-product-rating span {
            color: #777;
            font-size: 13px;
            margin-left: 5px;
        }

        .related-product-price {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
        }

        .related-current-price {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
        }

        .related-original-price {
            font-size: 16px;
            color: #999;
            text-decoration: line-through;
        }

        .btn-add-to-cart-small {
            background: var(--primary);
            color: white;
            border: none;
            padding: 14px 20px;
            width: 100%;
            font-family: 'Cairo', sans-serif;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 6px;
            text-transform: uppercase;
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-add-to-cart-small:hover {
            background: #004d33;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 99, 65, 0.25);
        }

        .view-all-products {
            text-align: center;
            margin-top: 40px;
        }

        .newsletter-section {
            background: linear-gradient(135deg, var(--primary) 0%, #004d33 100%);
            color: white;
            padding: 60px 0;
            position: relative;
            overflow: hidden;
        }

        .newsletter-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .newsletter-section::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
        }

        .newsletter-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 40px;
            position: relative;
            z-index: 1;
        }

        @media (max-width: 768px) {
            .newsletter-container {
                flex-direction: column;
                text-align: center;
                gap: 30px;
            }
        }

        .newsletter-text {
            flex: 1;
        }

        .newsletter-title {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            margin-bottom: 15px;
        }

        .newsletter-description {
            color: rgba(255, 255, 255, 0.85);
            font-size: 16px;
            line-height: 1.6;
            max-width: 500px;
        }

        .newsletter-form {
            flex: 1;
            max-width: 500px;
            display: flex;
            gap: 10px;
            background: white;
            padding: 5px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 576px) {
            .newsletter-form {
                flex-direction: column;
                background: transparent;
                box-shadow: none;
                padding: 0;
            }
        }

        .newsletter-input {
            flex: 1;
            padding: 16px 20px;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            outline: none;
        }

        @media (max-width: 576px) {
            .newsletter-input {
                background: white;
                margin-bottom: 10px;
            }
        }

        .newsletter-btn {
            background: var(--secondary);
            color: white;
            border: none;
            padding: 16px 30px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Cairo', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .newsletter-btn:hover {
            background: #a50d1e;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(206, 17, 38, 0.3);
        }

        .footer {
            background: #1a1a1a;
            color: #ddd;
            padding: 70px 0 20px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 50px;
            margin-bottom: 40px;
        }

        @media (max-width: 992px) {
            .footer-content {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .footer-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }
        }

        .footer-logo img {
            max-width: 180px;
            margin-bottom: 20px;
        }

        .footer-about {
            line-height: 1.6;
            margin-bottom: 25px;
            font-size: 15px;
        }

        .footer-title {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            color: white;
            margin-bottom: 20px;
            position: relative;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 40px;
            height: 2px;
            background: var(--primary);
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #aaa;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-links a:hover {
            color: white;
            transform: translateX(5px);
        }

        .footer-contact {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-contact li {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
        }

        .footer-contact i {
            color: var(--primary);
            font-size: 18px;
            margin-top: 4px;
            flex-shrink: 0;
        }

        .footer-contact strong {
            display: block;
            color: white;
            margin-bottom: 4px;
        }

        .footer-contact p {
            color: #aaa;
            line-height: 1.5;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid #333;
        }

        .footer-copyright {
            color: #777;
            font-size: 15px;
            margin-bottom: 20px;
        }

        .footer-copyright a {
            color: var(--primary);
            text-decoration: none;
        }

        .footer-copyright a:hover {
            text-decoration: underline;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: #333;
            color: white;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 18px;
        }

        .social-icon:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

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
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            padding: 25px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8f9fa;
            border-radius: 12px 12px 0 0;
        }

        .modal-header h3 {
            margin: 0;
            font-family: 'Playfair Display', serif;
            color: #2d2d2d;
            font-size: 24px;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #666;
            transition: color 0.3s ease;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            background: #f0f0f0;
            color: #dc3545;
        }

        .modal-content {
            padding: 25px;
        }

        .cart-empty,
        .wishlist-empty {
            text-align: center;
            padding: 50px 20px;
        }

        .cart-empty i,
        .wishlist-empty i {
            font-size: 64px;
            color: var(--primary);
            margin-bottom: 25px;
            opacity: 0.7;
        }

        .cart-empty h4,
        .wishlist-empty h4 {
            margin-bottom: 25px;
            color: #666;
            font-family: 'Playfair Display', serif;
            font-size: 22px;
        }

        .cart-empty .btn,
        .wishlist-empty .btn {
            margin-top: 25px;
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
            margin-bottom: 25px;
        }

        .cart-item,
        .wishlist-item {
            display: flex;
            gap: 15px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            align-items: center;
            transition: all 0.3s ease;
        }

        .cart-item:hover,
        .wishlist-item:hover {
            background: #f0f0f0;
        }

        .cart-item-img,
        .wishlist-item-img {
            width: 90px;
            height: 90px;
            border-radius: 6px;
            overflow: hidden;
            flex-shrink: 0;
            border: 1px solid #e0e0e0;
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
            margin-bottom: 8px;
            font-size: 16px;
            font-family: 'Inter', sans-serif;
            color: #2d2d2d;
            line-height: 1.4;
        }

        .cart-item-price,
        .wishlist-item-price {
            color: var(--primary);
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 12px;
        }

        .cart-item-qty {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 5px;
        }

        .qty-btn {
            width: 32px;
            height: 32px;
            border: 1px solid #e0e0e0;
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
            color: #666;
            border-color: #e0e0e0;
        }

        .qty-display {
            min-width: 40px;
            text-align: center;
            font-weight: 600;
            font-size: 16px;
        }

        .remove-item,
        .remove-wishlist-item {
            color: #dc3545;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .remove-item:hover,
        .remove-wishlist-item:hover {
            background: #f8d7da;
        }

        .cart-summary {
            padding: 25px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-top: 25px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
            font-family: 'Inter', sans-serif;
            font-size: 15px;
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .summary-row.total {
            font-weight: 700;
            font-size: 20px;
            color: var(--primary);
            border-top: 2px solid #e0e0e0;
            margin-top: 15px;
            padding-top: 18px;
        }

        .cart-total-amount {
            color: var(--primary);
            font-weight: 700;
        }

        .btn-block {
            width: 100%;
            padding: 16px;
            font-size: 16px;
            margin-top: 20px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
        }

        .wishlist-modal {
            max-width: 600px;
        }

        .wishlist-item-actions {
            display: flex;
            gap: 10px;
            margin-top: 12px;
        }

        .wishlist-item-actions button {
            padding: 10px 18px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border-radius: 6px;
            border: none;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .wishlist-item-actions .btn-add {
            background: var(--primary);
            color: white;
            flex: 1;
        }

        .wishlist-item-actions .btn-add:hover {
            background: #004d33;
            transform: translateY(-2px);
        }

        .wishlist-item-actions .btn-remove {
            background: #dc3545;
            color: white;
        }

        .wishlist-item-actions .btn-remove:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .wishlist-actions {
            text-align: center;
            margin-top: 25px;
        }

        .btn {
            display: inline-block;
            padding: 14px 32px;
            border-radius: 8px;
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
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .notification {
            position: fixed;
            top: 100px;
            right: 20px;
            background: white;
            padding: 16px 20px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            z-index: 10000;
            transform: translateX(400px);
            transition: transform 0.3s ease;
            border-left: 4px solid var(--primary);
            max-width: 300px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification i {
            color: var(--primary);
            font-size: 20px;
        }

        /* RESPONSIVE STYLES - UPDATED FROM ARTISANS.HTML */
        @media(max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }

            .main-nav {
                display: none;
            }

            .mobile-search-btn {
                display: block !important;
            }

            .search-container {
                display: none;
            }

            .action-icons {
                display: none;
            }

            .search-box {
                position: fixed;
                top: 100px;
                left: 50%;
                transform: translateX(-50%) translateY(-20px);
                width: 90%;
                max-width: 400px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            }

            .search-box.active {
                transform: translateX(-50%) translateY(0);
            }

            .mobile-nav {
                display: flex;
                flex-direction: column;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(10px);
                z-index: 999;
                padding: 100px 20px 20px;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                overflow-y: auto;
            }

            .mobile-nav.active {
                transform: translateX(0);
            }

            .product-detail-page {
                padding-top: 100px;
            }

            .product-main {
                padding: 15px;
                gap: 15px;
            }

            .product-image {
                height: 400px;
            }

            .product-title {
                font-size: 20px;
            }

            .product-price {
                font-size: 20px;
            }

            .original-price {
                font-size: 15px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-wishlist {
                width: 100%;
            }

            .quick-info {
                flex-wrap: wrap;
                gap: 8px;
            }

            .info-item {
                flex: 1;
                min-width: 120px;
            }

            .related-products {
                padding: 60px 0;
            }

            .related-product-img {
                height: 220px;
            }

            .related-product-title {
                font-size: 18px;
                min-height: 50px;
            }

            .related-current-price {
                font-size: 22px;
            }

            .newsletter-title {
                font-size: 28px;
            }

            .newsletter-description {
                font-size: 15px;
            }

            .header-actions {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                gap: 10px;
            }

            .mobile-menu-btn {
                order: 2;
            }
        }

        @media(max-width: 576px) {
            .logo-img {
                height: 60px;
            }

            .header-main {
                padding: 12px 0;
            }

            .product-image {
                height: 300px;
            }

            .product-title {
                font-size: 18px;
            }

            .product-price {
                font-size: 18px;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .related-products-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .related-product-img {
                height: 250px;
            }

            .related-product-info {
                padding: 20px;
            }

            .newsletter-section {
                padding: 50px 0;
            }

            .newsletter-title {
                font-size: 24px;
            }

            .footer {
                padding-top: 50px;
            }

            .footer-content {
                gap: 30px;
            }

            .footer-title {
                font-size: 18px;
            }

            .footer-about,
            .footer-links a,
            .footer-contact li,
            .footer-copyright {
                font-size: 14px;
            }
        }

        @media(max-width: 375px) {
            .logo-img {
                height: 55px;
            }

            .product-image {
                height: 250px;
            }

            .related-product-img {
                height: 200px;
            }

            .related-product-title {
                font-size: 16px;
                min-height: 44px;
            }

            .related-product-description {
                font-size: 13px;
                min-height: 60px;
            }
        }

        @media(min-width: 769px) {
            .mobile-search-btn {
                display: none !important;
            }

            .mobile-search-box {
                display: none !important;
            }
        }

        .product-details {
            background-color: #f7f7f7;
            border-radius: 10px;
            padding: 10px 15px;
            margin-top: 20px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e5e5e5;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #333;
        }

        .detail-value {
            color: #666;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-add-to-cart {
            flex: 1;
        }

        .btn-wishlist {
            width: 50px;
            min-width: 50px;
        }

        .btn-wishlist {
            transition: all 0.3s ease;
        }

        .btn-wishlist.active {
            background: rgba(0, 99, 65, 0.08);
            color: var(--primary);
            border-color: var(--primary);
            transform: scale(1.05);
        }
    </style>



    <div class="product-detail-page">
        <div class="container">

            {{-- Breadcrumb --}}
            <div class="breadcrumb">
                <a href="{{ url('/') }}">Home</a> /
                <a href="{{ route('ecommerce.shop.products') }}">Shop</a> /

                @if ($product->category)
                    <span>{{ $product->category->name }}</span> /
                @endif

                <span>{{ $product->name }}</span>
            </div>


            <div class="product-main">

                {{-- Image --}}
                <div class="product-image">
                 @if ($product->original_price && $product->original_price > $product->price)
    <div class="image-badge">SALE</div>
@endif

                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                </div>


                {{-- Info --}}
                <div class="product-info">

                    <div class="product-category">
                        {{ $product->category->name ?? 'Category' }}
                    </div>

                    <h1 class="product-title">
                        {{ $product->name }}
                    </h1>


                    {{-- Price --}}
                    <div class="product-price-container">
                        <span class="product-price">
                            ${{ number_format($product->price, 2) }}
                        </span>

@if ($product->original_price && $product->original_price > $product->price)                            <span class="original-price">
                                ${{ number_format($product->original_price, 2) }}
                            </span>

                            <span class="discount-badge">
                                Save
                                {{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%
                            </span>
                        @endif
                    </div>


                    {{-- Description --}}
                    <p class="product-description">
                        {{ $product->description }}
                    </p>
                    <div class="key-features">
                        <div class="features-grid" id="featuresGrid">
                            <div class="feature-item">
                                <i class="fas fa-check"></i>
                                <span>100% Hand-embroidered</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check"></i>
                                <span>Natural cotton &amp; silk</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check"></i>
                                <span>Traditional Palestinian motifs</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check"></i>
                                <span>One size fits all</span>
                            </div>
                        </div>
                    </div>
                    <div class="product-details">
                        <div class="detail-row">
                            <span class="detail-label">Material:</span>
                            <span class="detail-value">Natural cotton &amp; silk</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Care:</span>
                            <span class="detail-value">Hand wash cold, dry flat</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Origin:</span>
                            <span class="detail-value">Gaza, Palestine</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Size:</span>
                            <span class="detail-value">One size (adjustable)</span>
                        </div>
                    </div>
                    {{-- {{ $product->status }} --}}
                    <div class="purchase-section">

                        {{-- Stock Status --}}
                        @if ($product->stock > 0 && $product->status === 'active')
                            <div class="stock-status" id="stockStatus">
                                <i class="fas fa-check-circle"></i>
                                In stock - Only {{ $product->stock }} left
                            </div>
                        @else
                            <div class="stock-status text-danger">
                                <i class="fas fa-times-circle"></i>
                                Out of stock
                            </div>
                        @endif

                        @if ($product->stock > 0)
                            {{-- Quantity --}}
                            <div class="quantity-control">
                                <span>Quantity:</span>

                                <div class="quantity-buttons">
                                    <button type="button" class="quantity-btn minus">-</button>

                                    <input type="number" class="quantity-input" value="1" min="1"
                                        max="{{ $product->stock }}">

                                    <button type="button" class="quantity-btn plus">+</button>
                                </div>
                            </div>


                            {{-- Buttons --}}
                            <div class="action-buttons">

                                <button type="button" class="btn-add-to-cart" data-id="{{ $product->id }}">
                                    <i class="fas fa-shopping-cart"></i>
                                    Add to Cart
                                </button>

                                <button class="btn-wishlist" data-id="{{ $product->id }}">
                                    <i class="far fa-heart"></i>
                                </button>

                            </div>


                            {{-- Quick Info --}}
                            <div class="quick-info">

                                <div class="info-item">
                                    <i class="fas fa-truck"></i>
                                    <span>Free shipping over $100</span>
                                </div>

                                <div class="info-item">
                                    <i class="fas fa-undo"></i>
                                    <span>30-day returns</span>
                                </div>

                                <div class="info-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>Secure payment</span>
                                </div>

                            </div>
                        @endif

                    </div>

                </div>
            </div>


            {{-- Related Products --}}
            @if ($relatedProducts->count())
                <section class="related-products">
                    <div class="section-header">
                        <h2 class="section-title">You May Also Like</h2>
                    </div>

                    <div class="related-products-grid">

                        @foreach ($relatedProducts as $related)
                            <div class="related-product-card">

                                <div class="related-product-img">
                                    <a href="{{ route('ecommerce.product.show', $related->slug) }}">
                                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}"
                                            onerror="this.src='https://via.placeholder.com/400x400?text=Product+Image'">
                                    </a>

                                    {{-- Badge مثال --}}
                                    @if ($related->original_price)
                                        <span class="related-product-badge sale">Sale</span>
                                    @else
                                        <span class="related-product-badge bestseller">New</span>
                                    @endif
                                </div>

                                <div class="related-product-info">

                                    {{-- Category --}}
                                    <div class="related-product-category">
                                        {{ $related->category->name ?? 'Category' }}
                                    </div>

                                    {{-- Title --}}
                                    <h3 class="related-product-title">
                                        {{ $related->name }}
                                    </h3>

                                    {{-- Description --}}
                                    <p class="related-product-description">
                                        {{ \Illuminate\Support\Str::limit($related->description, 80) }}
                                    </p>

                                    {{-- Rating (ثابت حالياً) --}}
                                    <div class="related-product-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <span>(12 reviews)</span>
                                    </div>

                                    {{-- Price --}}
                                    <div class="related-product-price">
                                        <span class="related-current-price">
                                            ${{ number_format($related->price, 2) }}
                                        </span>

                                        @if ($related->original_price)
                                            <span class="related-original-price">
                                                ${{ number_format($related->original_price, 2) }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Add To Cart Button --}}
                                    <button class="btn-add-to-cart-small btn-add-to-cart" data-id="{{ $related->id }}">
                                        <i class="fas fa-shopping-cart"></i> Add to Cart
                                    </button>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif


        </div>
    </div>
    <script>
        $(document).on('click', '.quantity-btn.plus', function() {
            let input = $(this).siblings('.quantity-input');
            let max = parseInt(input.attr('max'));
            let value = parseInt(input.val());

            if (value < max) {
                input.val(value + 1);
            }
        });

        $(document).on('click', '.quantity-btn.minus', function() {
            let input = $(this).siblings('.quantity-input');
            let value = parseInt(input.val());

            if (value > 1) {
                input.val(value - 1);
            }
        });
    </script>
@endsection
