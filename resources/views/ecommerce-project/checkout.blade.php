@extends('ecommerce-project.master')
@section('content')
    <style>
        :root {
            --primary-green: #006341;
            --secondary-green: #004d33;
            --success-green: #28a745;
            --light-green: #e8f5e9;
            --dark-green: #1b5e20;
            --primary-red: #dc3545;
            --accent-red: #e74c3c;
            --light-red: #fff5f5;
            --dark-red: #c82333;
            --primary-black: #1a1a1a;
            --dark-grey: #333333;
            --medium-grey: #666666;
            --light-grey: #e0e0e0;
            --extra-light-grey: #f8f9fa;
            --border-grey: #cccccc;
            --divider-grey: #e9ecef;
            --transition: all 0.3s ease;
            --font-primary: 'Poppins', sans-serif;
            --font-secondary: 'Playfair Display', serif;
        }

        .checkout-page {
            padding-top: 80px;
            min-height: 100vh;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding-bottom: 80px;
            position: relative;
        }

        .checkout-page::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                radial-gradient(circle at 10% 20%, rgba(0, 99, 65, 0.03) 0%, transparent 25%),
                radial-gradient(circle at 90% 80%, rgba(220, 53, 69, 0.03) 0%, transparent 25%);
            pointer-events: none;
            z-index: -1;
        }

        .checkout-container {
            max-width: 850px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
        }

        .checkout-header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .checkout-header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-green), var(--primary-red));
            border-radius: 2px;
        }

        .checkout-header h1 {
            font-family: var(--font-secondary);
            font-size: 28px;
            color: var(--primary-black);
            margin-bottom: 5px;
            font-weight: 700;
        }

        .order-summary-header {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .order-summary-header h3 {
            font-size: 16px;
            color: var(--dark-grey);
            margin-bottom: 8px;
            font-weight: 600;
        }

        .order-summary-header p {
            font-size: 15px;
            font-weight: 600;
            color: var(--primary-green);
        }

        .green-stepper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            position: relative;
            padding: 15px 0;
        }

        .green-stepper::before {
            content: '';
            position: absolute;
            top: 25px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--light-grey);
            z-index: 1;
            border-radius: 2px;
        }

        .step {
            position: relative;
            z-index: 2;
            text-align: center;
            flex: 1;
        }

        .step-circle {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            font-weight: 600;
            color: var(--dark-grey);
            transition: all 0.3s ease;
            font-size: 14px;
            border: 2px solid var(--light-grey);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .step.active .step-circle {
            background: var(--primary-green);
            color: white;
            border-color: var(--primary-green);
            box-shadow: 0 3px 10px rgba(0, 99, 65, 0.3);
        }

        .step.completed .step-circle {
            background: var(--success-green);
            color: white;
            border-color: var(--success-green);
        }

        .step.completed .step-circle::after {
            content: '✓';
            font-weight: 700;
            font-size: 16px;
        }

        .step-label {
            font-size: 12px;
            font-weight: 500;
            color: var(--medium-grey);
            white-space: nowrap;
            transition: all 0.3s ease;
        }

        .step.active .step-label {
            color: var(--primary-green);
            font-weight: 600;
        }

        .checkout-form-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
            display: none;
            border: 1px solid rgba(0, 0, 0, 0.06);
        }

        .checkout-form-section.active {
            display: block;
            animation: fadeInUp 0.3s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-section-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        }

        .form-section-header h2 {
            font-size: 20px;
            color: var(--primary-black);
            font-weight: 600;
            font-family: var(--font-secondary);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-grey);
            font-size: 13px;
            text-transform: uppercase;
        }

        .form-label.required::after {
            content: '*';
            color: var(--primary-red);
            margin-left: 3px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid rgba(224, 224, 224, 0.8);
            border-radius: 8px;
            font-size: 14px;
            font-family: var(--font-primary);
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            color: var(--primary-black);
        }

        .form-control::placeholder {
            color: #999;
            font-weight: 400;
            font-size: 14px;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-green);
            box-shadow: 0 0 0 3px rgba(0, 99, 65, 0.1);
        }

        .form-hint {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            color: var(--medium-grey);
        }

        .shipping-methods {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }

        .shipping-method {
            border: 1px solid rgba(224, 224, 224, 0.8);
            border-radius: 10px;
            padding: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            position: relative;
        }

        .shipping-method.selected {
            border-color: var(--primary-green);
            background: rgba(232, 245, 233, 0.3);
        }

        .shipping-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 8px;
        }

        .shipping-icon {
            width: 40px;
            height: 40px;
            background: var(--light-grey);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--medium-grey);
            font-size: 18px;
        }

        .shipping-name {
            font-weight: 600;
            color: var(--dark-grey);
            font-size: 16px;
        }

        .shipping-description {
            font-size: 13px;
            color: var(--medium-grey);
        }

        .shipping-price {
            position: absolute;
            top: 18px;
            right: 18px;
            font-weight: 600;
            color: var(--primary-green);
            font-size: 16px;
        }

        .payment-methods {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }

        .payment-method {
            border: 1px solid rgba(224, 224, 224, 0.8);
            border-radius: 10px;
            padding: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            position: relative;
        }

        .payment-method.selected {
            border-color: var(--primary-green);
            background: rgba(232, 245, 233, 0.3);
        }

        .credit-card-form {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid rgba(0, 99, 65, 0.1);
            border-radius: 10px;
            background: rgba(248, 249, 250, 0.5);
            display: none;
        }

        .payment-method.selected .credit-card-form {
            display: block;
        }

        .card-preview {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            position: relative;
        }

        .card-chip {
            width: 40px;
            height: 30px;
            background: #FFD700;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .card-number {
            font-family: 'Courier New', monospace;
            font-size: 18px;
            letter-spacing: 2px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .card-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-holder,
        .card-expiry {
            font-size: 12px;
            opacity: 0.9;
        }

        .card-fields {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        /* REVIEW PAGE STYLES */
        .review-section {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--divider-grey);
        }

        .review-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .review-section h3 {
            font-size: 18px;
            margin-bottom: 15px;
            color: var(--dark-grey);
            font-weight: 600;
            font-family: var(--font-secondary);
        }

        .review-items {
            background: var(--extra-light-grey);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .review-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--divider-grey);
        }

        .review-item:last-child {
            border-bottom: none;
        }

        .review-item-image {
            width: 60px;
            height: 60px;
            background: var(--light-grey);
            border-radius: 4px;
            margin-right: 15px;
            flex-shrink: 0;
            background-size: cover;
            background-position: center;
        }

        .review-item-details {
            flex: 1;
        }

        .review-item-name {
            font-weight: 600;
            color: var(--dark-grey);
            margin-bottom: 3px;
        }

        .review-item-variant {
            font-size: 13px;
            color: var(--medium-grey);
        }

        .review-item-price {
            font-weight: 600;
            color: var(--primary-green);
            min-width: 80px;
            text-align: right;
        }

        .review-totals {
            margin-top: 15px;
        }

        .review-total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 15px;
        }

        .review-total-row.total {
            font-weight: 700;
            font-size: 18px;
            color: var(--primary-green);
            border-top: 2px solid var(--primary-green);
            padding-top: 12px;
            margin-top: 8px;
        }

        .review-address {
            line-height: 1.6;
        }

        .review-shipping-method {
            font-weight: 600;
            color: var(--dark-grey);
            margin-bottom: 5px;
        }

        .review-shipping-description {
            color: var(--medium-grey);
            font-size: 14px;
        }

        .review-payment-method {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .review-payment-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--light-grey);
            color: var(--medium-grey);
            font-size: 18px;
        }

        .review-payment-details {
            flex: 1;
        }

        .review-payment-type {
            font-weight: 600;
            color: var(--dark-grey);
        }

        .review-payment-info {
            font-size: 14px;
            color: var(--medium-grey);
        }

        .checkout-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.06);
        }

        .btn-back {
            padding: 12px 24px;
            background: white;
            border: 1px solid rgba(224, 224, 224, 0.8);
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--dark-grey);
            font-size: 14px;
        }

        .btn-back:hover {
            border-color: var(--primary-red);
            color: var(--primary-red);
            background: rgba(220, 53, 69, 0.05);
        }

        .btn-continue,
        .btn-place-order {
            padding: 12px 30px;
            background: var(--primary-green);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .btn-continue:hover,
        .btn-place-order:hover {
            background: var(--secondary-green);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 99, 65, 0.2);
        }

        /* COMPACT SUCCESS POPUP - FITS ON ONE PAGE */
        .success-popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 10000;
            padding: 15px;
        }

        .success-popup.active {
            display: flex;
        }

        .success-popup-content {
            background: white;
            border-radius: 12px;
            padding: 30px;
            max-width: 450px;
            width: 100%;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .success-icon {
            width: 60px;
            height: 60px;
            background: var(--success-green);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 24px;
        }

        .success-popup h2 {
            font-size: 22px;
            color: var(--primary-green);
            margin-bottom: 10px;
            font-weight: 600;
            font-family: var(--font-secondary);
        }

        .success-popup p {
            color: var(--medium-grey);
            margin-bottom: 20px;
            line-height: 1.5;
            font-size: 14px;
        }

        .order-details {
            background: rgba(248, 249, 250, 0.8);
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
            text-align: left;
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .order-details h4 {
            font-size: 14px;
            color: var(--dark-grey);
            margin-bottom: 10px;
            font-weight: 600;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .order-details-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding: 6px 0;
            font-size: 13px;
        }

        .order-details-label {
            color: var(--medium-grey);
        }

        .order-details-value {
            font-weight: 600;
            color: var(--dark-grey);
        }

        .delivery-info {
            background: rgba(232, 245, 233, 0.5);
            border: 1px solid rgba(40, 167, 69, 0.3);
            border-radius: 8px;
            padding: 12px;
            margin-top: 15px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 13px;
        }

        .delivery-info i {
            color: var(--success-green);
            font-size: 16px;
            margin-top: 2px;
        }

        .delivery-info p {
            margin: 0;
            color: var(--dark-green);
        }

        .popup-buttons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 10px;
        }

        .btn-popup-primary {
            padding: 10px 25px;
            background: var(--primary-green);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-popup-primary:hover {
            background: var(--secondary-green);
        }

        .btn-view-order {
            background: var(--dark-grey);
        }

        .btn-view-order:hover {
            background: var(--primary-black);
        }

        .error-message {
            color: var(--primary-red);
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--primary-red);
            color: white;
            padding: 12px 16px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 8px;
            opacity: 0;
            transform: translateX(100px);
            transition: all 0.3s ease;
            max-width: 300px;
        }

        .notification.show {
            opacity: 1;
            transform: translateX(0);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .checkout-page {
                padding-top: 70px;
                padding-bottom: 40px;
            }

            .checkout-header h1 {
                font-size: 24px;
            }

            .checkout-form-section {
                padding: 20px;
            }

            .form-section-header h2 {
                font-size: 18px;
            }

            .checkout-buttons {
                flex-direction: column;
                gap: 10px;
            }

            .btn-back,
            .btn-continue,
            .btn-place-order {
                width: 100%;
                justify-content: center;
            }

            .success-popup-content {
                padding: 20px;
                margin: 10px;
            }

            .success-icon {
                width: 50px;
                height: 50px;
                font-size: 20px;
                margin-bottom: 12px;
            }

            .success-popup h2 {
                font-size: 20px;
            }

            .success-popup p {
                font-size: 13px;
                margin-bottom: 15px;
            }

            .popup-buttons {
                flex-direction: column;
            }

            .btn-popup-primary {
                width: 100%;
                justify-content: center;
            }

            .review-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .review-item-image {
                margin-bottom: 10px;
            }
        }

        @media (max-width: 480px) {
            .checkout-header h1 {
                font-size: 22px;
            }

            .step-circle {
                width: 30px;
                height: 30px;
                font-size: 12px;
            }

            .form-row {
                gap: 15px;
            }

            .shipping-method,
            .payment-method {
                padding: 15px;
            }

            .shipping-price {
                position: static;
                margin-top: 5px;
                font-size: 14px;
            }

            .review-total-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .review-total-row span:last-child {
                align-self: flex-end;
            }
        }
    </style>
    <main class="checkout-page">
        <div class="checkout-container">
            <div class="checkout-header">
                <h1>Checkout</h1>
            </div>
            <div class="order-summary-header">

                <h3>Order Summary</h3>

                @foreach ($items as $item)
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">

                        <img src="{{ asset('storage/' . $item->product->image) }}"
                            style="width:50px; height:50px; object-fit:cover; border-radius:6px;">

                        <div style="flex:1;">

                            <div style="font-weight:600;">
                                {{ $item->product->name }}
                            </div>

                            <div style="font-size:13px; color:#666;">
                                Qty: {{ $item->quantity }}
                            </div>

                        </div>

                        <div style="font-weight:600;">
                            ${{ number_format($item->price * $item->quantity, 2) }}
                        </div>

                    </div>
                @endforeach


                <hr>

                <div style="display:flex; justify-content:space-between; font-weight:700;">

                    <span>Total</span>

                    <span>
                        ${{ number_format($subtotal, 2) }}
                    </span>

                </div>

            </div>
            <div class="green-stepper">
                <div class="step active" id="step1">
                    <div class="step-circle">1</div>
                    <div class="step-label">Shipping Address</div>
                </div>
                <div class="step" id="step2">
                    <div class="step-circle">2</div>
                    <div class="step-label">Shipping Method</div>
                </div>
                <div class="step" id="step3">
                    <div class="step-circle">3</div>
                    <div class="step-label">Payment Details</div>
                </div>
                <div class="step" id="step4">
                    <div class="step-circle">4</div>
                    <div class="step-label">Review Order</div>
                </div>
            </div>
            <section class="checkout-form-section active" id="shippingForm">
                <div class="form-section-header">
                    <h2>Shipping Address</h2>
                </div>
                <div class="form-hint" style="margin-bottom: 20px;">
                    Address lookup powered by Google, view <a href="#" style="color: var(--primary-green);">Privacy
                        policy</a>. To opt out change cookie preferences.
                    <br><br>
                    <span style="color: var(--primary-red);">*</span> Indicates required field
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label required">FIRST NAME</label>
                        <input type="text" class="form-control" id="firstName" placeholder="First name"
                            autocomplete="off" />
                        <div class="error-message" id="firstNameError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">LAST NAME</label>
                        <input type="text" class="form-control" id="lastName" placeholder="Last name"
                            autocomplete="off" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label required">ADDRESS 1 - STREET OR P.O. BOX</label>
                    <input type="text" class="form-control" id="address1" placeholder="Street address or P.O. Box"
                        autocomplete="off" />
                    <div class="error-message" id="address1Error"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">ADDRESS 2 - APT, SUITE, FLOOR</label>
                    <input type="text" class="form-control" id="address2" placeholder="Apartment, suite, floor, etc."
                        autocomplete="off" />
                    <div class="form-hint">Leave blank if P.O. Box in Address 1</div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label required">ZIP/POSTAL CODE</label>
                        <input type="text" class="form-control" id="zipCode" placeholder="Postal/ZIP code"
                            autocomplete="off" />
                        <div class="error-message" id="zipCodeError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label required">CITY</label>
                        <input type="text" class="form-control" id="city" placeholder="City" autocomplete="off" />
                        <div class="error-message" id="cityError"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label required">COUNTRY</label>
                    <select class="form-control" id="country">
                        <option value="">Select Country...</option>
                        <option value="PS" selected>Palestine</option>
                        <option value="US">United States</option>
                        <option value="CA">Canada</option>
                        <option value="GB">United Kingdom</option>
                        <option value="AU">Australia</option>
                        <option value="DE">Germany</option>
                        <option value="FR">France</option>
                        <option value="IT">Italy</option>
                        <option value="ES">Spain</option>
                        <option value="NL">Netherlands</option>
                        <option value="BE">Belgium</option>
                        <option value="SE">Sweden</option>
                        <option value="NO">Norway</option>
                        <option value="DK">Denmark</option>
                        <option value="FI">Finland</option>
                        <option value="IE">Ireland</option>
                        <option value="PT">Portugal</option>
                        <option value="GR">Greece</option>
                        <option value="AT">Austria</option>
                        <option value="CH">Switzerland</option>
                        <option value="PL">Poland</option>
                        <option value="CZ">Czech Republic</option>
                        <option value="HU">Hungary</option>
                        <option value="RO">Romania</option>
                        <option value="BG">Bulgaria</option>
                        <option value="HR">Croatia</option>
                        <option value="SI">Slovenia</option>
                        <option value="SK">Slovakia</option>
                        <option value="LT">Lithuania</option>
                        <option value="LV">Latvia</option>
                        <option value="EE">Estonia</option>
                        <option value="IS">Iceland</option>
                        <option value="MT">Malta</option>
                        <option value="CY">Cyprus</option>
                        <option value="LU">Luxembourg</option>
                        <option value="JP">Japan</option>
                        <option value="CN">China</option>
                        <option value="IN">India</option>
                        <option value="KR">South Korea</option>
                        <option value="SG">Singapore</option>
                        <option value="MY">Malaysia</option>
                        <option value="TH">Thailand</option>
                        <option value="VN">Vietnam</option>
                        <option value="PH">Philippines</option>
                        <option value="ID">Indonesia</option>
                        <option value="PK">Pakistan</option>
                        <option value="BD">Bangladesh</option>
                        <option value="LK">Sri Lanka</option>
                        <option value="NP">Nepal</option>
                        <option value="AE">United Arab Emirates</option>
                        <option value="SA">Saudi Arabia</option>
                        <option value="QA">Qatar</option>
                        <option value="KW">Kuwait</option>
                        <option value="OM">Oman</option>
                        <option value="BH">Bahrain</option>
                        <option value="JO">Jordan</option>
                        <option value="LB">Lebanon</option>
                        <option value="EG">Egypt</option>
                        <option value="MA">Morocco</option>
                        <option value="TN">Tunisia</option>
                        <option value="DZ">Algeria</option>
                        <option value="ZA">South Africa</option>
                        <option value="NG">Nigeria</option>
                        <option value="KE">Kenya</option>
                        <option value="GH">Ghana</option>
                        <option value="UG">Uganda</option>
                        <option value="TZ">Tanzania</option>
                        <option value="MX">Mexico</option>
                        <option value="BR">Brazil</option>
                        <option value="AR">Argentina</option>
                        <option value="CL">Chile</option>
                        <option value="CO">Colombia</option>
                        <option value="PE">Peru</option>
                        <option value="VE">Venezuela</option>
                        <option value="EC">Ecuador</option>
                        <option value="BO">Bolivia</option>
                        <option value="PY">Paraguay</option>
                        <option value="UY">Uruguay</option>
                        <option value="CR">Costa Rica</option>
                        <option value="PA">Panama</option>
                        <option value="GT">Guatemala</option>
                        <option value="SV">El Salvador</option>
                        <option value="HN">Honduras</option>
                        <option value="NI">Nicaragua</option>
                        <option value="DO">Dominican Republic</option>
                        <option value="CU">Cuba</option>
                        <option value="JM">Jamaica</option>
                        <option value="NZ">New Zealand</option>
                        <option value="RU">Russia</option>
                        <option value="TR">Turkey</option>
                        <option value="IR">Iran</option>
                        <option value="UA">Ukraine</option>
                        <option value="BY">Belarus</option>
                        <option value="KZ">Kazakhstan</option>
                        <option value="UZ">Uzbekistan</option>
                        <option value="AZ">Azerbaijan</option>
                        <option value="GE">Georgia</option>
                        <option value="AM">Armenia</option>
                        <option value="MD">Moldova</option>
                    </select>
                    <div class="error-message" id="countryError"></div>
                </div>
                <div class="form-group">
                    <label class="form-label required">STATE/PROVINCE/REGION</label>
                    <input type="text" class="form-control" id="state" placeholder="State, Province, or Region"
                        autocomplete="off" />
                    <div class="error-message" id="stateError"></div>
                </div>
                <div class="checkout-buttons">
                    <button class="btn-back" onclick="window.location.href='#'">
                        <i class="fas fa-arrow-left"></i> Back to Cart
                    </button>
                    <button type="button" class="btn-continue" id="continueToShippingMethod">
                        Continue to shipping method <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </section>
            <section class="checkout-form-section" id="shippingMethodForm">
                <div class="form-section-header">
                    <h2>Shipping Method</h2>
                </div>
                <div class="shipping-methods">
                    <div class="shipping-method selected" data-shipping="0">
                        <div class="shipping-header">
                            <div class="shipping-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div>
                                <div class="shipping-name">Standard Shipping</div>
                                <div class="shipping-description">7-14 business days</div>
                            </div>
                        </div>
                        <div class="shipping-price">FREE</div>
                    </div>
                    <div class="shipping-method" data-shipping="15">
                        <div class="shipping-header">
                            <div class="shipping-icon">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div>
                                <div class="shipping-name">Express Shipping</div>
                                <div class="shipping-description">3-5 business days</div>
                            </div>
                        </div>
                        <div class="shipping-price">$15.00</div>
                    </div>
                    <div class="shipping-method" data-shipping="30">
                        <div class="shipping-header">
                            <div class="shipping-icon">
                                <i class="fas fa-rocket"></i>
                            </div>
                            <div>
                                <div class="shipping-name">Next Day Shipping</div>
                                <div class="shipping-description">1-2 business days</div>
                            </div>
                        </div>
                        <div class="shipping-price">$30.00</div>
                    </div>
                </div>
                <div class="checkout-buttons">
                    <button class="btn-back" id="backToShippingAddress">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                    <button type="button" class="btn-continue" id="continueToPayment">
                        Continue to Payment <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </section>
            <section class="checkout-form-section" id="paymentForm">
                <div class="form-section-header">
                    <h2>Payment</h2>
                </div>
                <div class="payment-methods">
                    <div class="payment-method selected" data-method="credit-card">
                        <div class="shipping-header">
                            <div class="shipping-icon">
                                <i class="far fa-credit-card"></i>
                            </div>
                            <div>
                                <div class="shipping-name">Credit/Debit Card</div>
                                <div class="shipping-description">Visa, MasterCard, American Express</div>
                            </div>
                        </div>
                        <div class="credit-card-form">
                            <div class="card-preview">
                                <div class="card-chip"></div>
                                <div class="card-number" id="cardPreview">•••• •••• •••• ••••</div>
                                <div class="card-details">
                                    <div class="card-holder" id="cardHolderPreview">CARD HOLDER</div>
                                    <div class="card-expiry" id="cardExpiryPreview">MM/YY</div>
                                </div>
                            </div>



                            <div class="form-group">
                                <label class="form-label required">Card Details</label>
                                <div id="card-element" class="form-control"></div>
                                <div id="card-errors" style="color:red; margin-top:8px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="checkout-buttons">
                    <button type="button" class="btn-back" id="backToShippingMethod">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                    <button type="button" class="btn-continue" id="continueToReview">
                        Continue to Review <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </section>
            <section class="checkout-form-section" id="reviewForm">
                <div class="form-section-header">
                    <h2>Review Your Order</h2>
                </div>
                <div class="review-content" id="reviewContent">
                    <!-- Content will be populated by JavaScript -->
                </div>
                <div class="checkout-buttons">
                    <button type="button" class="btn-back" id="backToPayment">
                        <i class="fas fa-arrow-left"></i> Back to Payment
                    </button>
                    <button type="button" class="btn-place-order" id="placeOrderBtn">
                        <i class="fas fa-lock"></i> Place Order
                    </button>
                </div>
            </section>
        </div>
    </main>
    <div class="success-popup" id="successPopup">
        <div class="success-popup-content">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            <h2>Payment Successful!</h2>
            <p>Thank you for your order. Your payment has been processed successfully.</p>
            <div class="order-details">
                <h4>Order Details</h4>
                <div class="order-details-row">
                    <span class="order-details-label">Order Number:</span>
                    <span class="order-details-value" id="popupOrderNumber">HAW-2024-00123</span>
                </div>
                <div class="order-details-row">
                    <span class="order-details-label">Total Amount:</span>
                    <span class="order-details-value" id="popupOrderTotal">$300.00</span>
                </div>
                <div class="order-details-row">
                    <span class="order-details-label">Payment Method:</span>
                    <span class="order-details-value" id="popupPaymentMethod">Credit Card</span>
                </div>
            </div>
            <div class="delivery-info">
                <i class="fas fa-truck"></i>
                <p>Your order will be delivered in 7-14 business days. You will receive tracking information via email.
                </p>
            </div>
            <div class="popup-buttons">
                <button class="btn-popup-primary" id="continueShopping">
                    <a href="{{ route('ecommerce.home') }}" class="btn-popup-primary">
                        Continue Shopping
                    </a>
                </button>
            </div>
        </div>
    </div>
    {{-- <script src="https://js.stripe.com/v3/"></script> --}}

    <script>
        let stripe;
        let card;
        document.addEventListener("DOMContentLoaded", function() {

            stripe = Stripe("{{ $stripeKey }}");

            const elements = stripe.elements();

            card = elements.create("card", {
                hidePostalCode: true,
                style: {
                    base: {
                        fontSize: '16px',
                        color: '#32325d',
                        '::placeholder': {
                            color: '#aab7c4'
                        }
                    }
                }
            });

            card.mount("#card-element");



            card.on('change', function(event) {

                const displayError = document.getElementById('card-errors');

                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }

            });
        });
        document.addEventListener("DOMContentLoaded", function() {

            const shippingForm = document.getElementById("shippingForm");
            const shippingMethodForm = document.getElementById("shippingMethodForm");
            const paymentForm = document.getElementById("paymentForm");
            const reviewForm = document.getElementById("reviewForm");

            const step1 = document.getElementById("step1");
            const step2 = document.getElementById("step2");
            const step3 = document.getElementById("step3");
            const step4 = document.getElementById("step4");


            // 1 -> 2
            document.getElementById("continueToShippingMethod").addEventListener("click", function() {

                shippingForm.classList.remove("active");
                shippingMethodForm.classList.add("active");

                step1.classList.remove("active");
                step1.classList.add("completed");

                step2.classList.add("active");

            });


            // 2 -> 3
            document.getElementById("continueToPayment").addEventListener("click", function() {

                shippingMethodForm.classList.remove("active");
                paymentForm.classList.add("active");

                step2.classList.remove("active");
                step2.classList.add("completed");

                step3.classList.add("active");

            });


            // 3 -> 4
            document.getElementById("continueToReview").addEventListener("click", function() {

                paymentForm.classList.remove("active");
                reviewForm.classList.add("active");

                step3.classList.remove("active");
                step3.classList.add("completed");

                step4.classList.add("active");

            });


            // back 2 -> 1
            document.getElementById("backToShippingAddress").addEventListener("click", function() {

                shippingMethodForm.classList.remove("active");
                shippingForm.classList.add("active");

                step2.classList.remove("active");
                step1.classList.remove("completed");
                step1.classList.add("active");

            });


            // back 3 -> 2
            document.getElementById("backToShippingMethod").addEventListener("click", function() {

                paymentForm.classList.remove("active");
                shippingMethodForm.classList.add("active");

                step3.classList.remove("active");
                step2.classList.remove("completed");
                step2.classList.add("active");

            });


            // back 4 -> 3
            document.getElementById("backToPayment").addEventListener("click", function() {

                reviewForm.classList.remove("active");
                paymentForm.classList.add("active");

                step4.classList.remove("active");
                step3.classList.remove("completed");
                step3.classList.add("active");

            });

        });
        let selectedShipping = 0;

        $(".shipping-method").click(function() {

            $(".shipping-method").removeClass("selected");

            $(this).addClass("selected");

            selectedShipping = $(this).data("shipping");

        });
        $("#placeOrderBtn").click(async function() {
            // console.log("Stripe key:", "{{ $stripeKey }}");
            if (!stripe || !card) {

                Swal.fire({
                    icon: 'error',
                    title: 'Payment Error',
                    text: 'Stripe not initialized',
                    confirmButtonColor: '#006341'
                });

                return;
            }

            const {
                paymentMethod,
                error
            } = await stripe.createPaymentMethod({
                type: "card",
                card: card
            });

            if (error) {
                $("#card-errors").text(error.message);
                return;
            }

            let data = {
                payment_method: paymentMethod.id,
                first_name: $("#firstName").val(),
                last_name: $("#lastName").val(),
                address1: $("#address1").val(),
                address2: $("#address2").val(),
                city: $("#city").val(),
                state: $("#state").val(),
                zip: $("#zipCode").val(),
                country: $("#country").val(),
                total: {{ $subtotal }},
                shipping: selectedShipping
            };

            $.ajax({
                url: "{{ route('ecommerce.checkout.placeOrder') }}",
                type: "POST",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {

                    if (result.success) {

            let stockElement = document.getElementById("stockStatus");

            if(stockElement){
                stockElement.innerHTML =
                '<i class="fas fa-check-circle"></i> Order placed successfully';
            }

                        $("#popupOrderTotal").text("$" + result.total);

                        $("#successPopup").addClass("active");

                    } else {
                        alert(result.message);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Failed',
                        text: 'Something went wrong during payment',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });

        });
    </script>
@endsection
