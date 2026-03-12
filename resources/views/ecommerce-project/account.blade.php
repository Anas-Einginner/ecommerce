   @extends('ecommerce-project.master')
   @section('content')
       <style>
           :root {
               --primary: #006341;
               --primary-dark: #004d33;
               --secondary: #ce1126;
               --bg: #f4f6f5;
               --card: #ffffff;
               --text: #212529;
               --muted: #6c757d;
               --gray: #666;
               --light-gray: #f8f9fa;
               --border: #e0e0e0;
               --radius: 14px;
               --shadow: 0 10px 30px rgba(0, 0, 0, .08);
           }

           * {
               margin: 0;
               padding: 0;
               box-sizing: border-box
           }

           body {
               font-family: 'Poppins', sans-serif;
               background: var(--bg);
               color: var(--text);
               min-height: 100vh;
               overflow-x: hidden;
               line-height: 1.7;
           }

           h1,
           h2,
           h3 {
               font-family: 'Playfair Display', serif;
           }

           .container {
               width: 90%;
               max-width: 1200px;
               margin: auto;
               padding: 0 20px;
           }

           /* Header & Navigation - Updated to match contact.html */
           .header {
               background-color: white;
               position: fixed;
               top: 0;
               left: 0;
               width: 100%;
               z-index: 1000;
               box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
               transition: all 0.3s ease;
           }

           .header.scrolled {
               padding: 10px 0;
               background-color: white;
           }

           .logo-img {
               height: 80px;
               transition: all 0.3s ease;
           }

           .header-main {
               display: flex;
               justify-content: space-between;
               align-items: center;
               padding: 15px 0;
           }

           .nav-list {
               display: flex;
               align-items: center;
               gap: 24px;
               list-style: none;
               margin: 0;
               padding: 0;
           }

           .nav-link {
               font-weight: 600;
               color: var(--text);
               text-decoration: none;
               padding: 8px 0;
               transition: all 0.3s ease;
               display: flex;
               align-items: center;
               gap: 6px;
               position: relative;
               font-family: 'Inter', sans-serif;
           }

           .nav-link:hover,
           .nav-link.active {
               color: var(--primary);
           }

           .nav-link-wrapper {
               position: relative;
               display: inline-flex;
               align-items: center;
               gap: 6px;
           }

           .dropdown-menu {
               position: absolute;
               top: 100%;
               left: 0;
               background: white;
               min-width: 240px;
               padding: 12px 0;
               border-radius: 8px;
               box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
               opacity: 0;
               visibility: hidden;
               transform: translateY(8px);
               transition: all 0.3s ease;
               z-index: 1001;
               border: 1px solid var(--border);
           }

           .nav-link-wrapper:hover .dropdown-menu {
               opacity: 1;
               visibility: visible;
               transform: translateY(0);
           }

           .dropdown-item {
               display: block;
               padding: 10px 20px;
               color: var(--text);
               text-decoration: none;
               transition: all 0.3s ease;
               font-family: 'Inter', sans-serif;
           }

           .dropdown-item:hover {
               background-color: var(--primary);
               color: white;
           }

           .header-actions {
               display: flex;
               align-items: center;
               gap: 20px;
           }

           .search-container {
               position: relative;
           }

           .search-btn {
               background: none;
               border: none;
               font-size: 18px;
               cursor: pointer;
               color: var(--text);
               transition: color 0.3s ease;
           }

           .search-btn:hover {
               color: var(--primary);
           }

           .search-box {
               position: absolute;
               top: 100%;
               right: 0;
               background: white;
               padding: 15px;
               border-radius: 8px;
               box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
               display: flex;
               gap: 10px;
               opacity: 0;
               visibility: hidden;
               transform: translateY(-10px);
               transition: all 0.3s ease;
               z-index: 1002;
               width: 300px;
               border: 1px solid var(--border);
           }

           .search-box.active {
               opacity: 1;
               visibility: visible;
               transform: translateY(0);
           }

           .search-input {
               border: 1px solid var(--border);
               outline: none;
               width: 100%;
               font-size: 16px;
               font-family: 'Inter', sans-serif;
               padding: 10px 15px;
               background: white;
               color: var(--text);
               border-radius: 4px;
           }

           .search-input:focus {
               border-color: var(--primary);
           }

           .search-submit {
               background: var(--primary);
               border: none;
               color: white;
               cursor: pointer;
               padding: 10px 15px;
               border-radius: 4px;
               transition: background 0.3s ease;
           }

           .search-submit:hover {
               background: #004d33;
           }

           .action-icons {
               display: flex;
               gap: 16px;
               align-items: center;
           }

           .action-icon {
               position: relative;
               font-size: 20px;
               color: var(--text);
               transition: color 0.3s ease;
           }

           .action-icon:hover {
               color: var(--primary);
           }

           .badge {
               position: absolute;
               top: -8px;
               right: -8px;
               background-color: #dc3545;
               color: white;
               font-size: 10px;
               width: 18px;
               height: 18px;
               border-radius: 50%;
               display: flex;
               align-items: center;
               justify-content: center;
               font-weight: 600;
           }

           .mobile-menu-btn {
               display: none;
               background: none;
               border: none;
               font-size: 24px;
               cursor: pointer;
               color: var(--text);
               z-index: 1003;
           }

           .mobile-nav {
               display: none;
               position: fixed;
               top: 0;
               left: 0;
               width: 100%;
               height: 100vh;
               background: rgba(255, 255, 255, 0.98);
               z-index: 999;
               padding: 10px 20px 20px;
               transform: translateX(-100%);
               transition: transform 0.3s ease;
           }

           .mobile-nav.active {
               transform: translateX(0);
           }

           .mobile-nav-list {
               list-style: none;
               padding: 0;
               margin: 0;
           }

           .mobile-nav-item {
               margin-bottom: 15px;
           }

           .mobile-nav-link {
               display: block;
               padding: 12px 15px;
               font-size: 1.1rem;
               font-weight: 600;
               color: var(--text);
               text-decoration: none;
               border-radius: 8px;
               transition: all 0.3s ease;
           }

           .mobile-nav-link:hover,
           .mobile-nav-link.active {
               background: var(--primary);
               color: white;
           }

           .mobile-dropdown-toggle {
               display: flex;
               justify-content: space-between;
               align-items: center;
               width: 100%;
           }

           .mobile-dropdown-content {
               padding-left: 20px;
               margin-top: 10px;
               display: none;
           }

           .mobile-dropdown-content.active {
               display: block;
           }

           .mobile-dropdown-item {
               display: block;
               padding: 10px 15px;
               font-size: 0.95rem;
               color: var(--text);
               text-decoration: none;
               border-radius: 6px;
               margin-bottom: 5px;
               transition: all 0.3s ease;
           }

           .mobile-dropdown-item:hover {
               background: #f0f0f0;
               color: var(--primary);
           }

           .mobile-search-btn {
               display: none !important;
               background: none;
               border: none;
               font-size: 20px;
               color: var(--text);
               cursor: pointer;
               padding: 8px;
               margin-right: 10px;
               transition: color 0.3s ease;
           }

           .mobile-search-btn:hover {
               color: var(--primary);
           }

           .mobile-search-box {
               position: fixed;
               top: 100px;
               left: 0;
               width: 100%;
               background: white;
               padding: 15px;
               box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
               z-index: 1002;
               transform: translateY(-100%);
               opacity: 0;
               visibility: hidden;
               transition: all 0.3s ease;
               border-top: 1px solid var(--border);
               border-bottom: 1px solid var(--border);
           }

           .mobile-search-box.active {
               transform: translateY(0);
               opacity: 1;
               visibility: visible;
           }

           .mobile-search-box .search-input {
               width: 100%;
               padding: 12px 15px;
               border: 1px solid var(--border);
               border-radius: 8px;
               font-size: 16px;
               font-family: 'Inter', sans-serif;
           }

           .mobile-search-box .search-input:focus {
               border-color: var(--primary);
               outline: none;
           }

           .mobile-badge {
               background-color: var(--secondary);
               color: white;
               font-size: 10px;
               padding: 2px 6px;
               border-radius: 10px;
               margin-left: auto;
               font-weight: 600;
               min-width: 18px;
               text-align: center;
           }

           /* ===== Page ===== */
           .account-page {
               padding: 20px 10px;
               margin-top: 120px;
               /* Increased from 100px to 120px */
               min-height: calc(100vh - 120px);
               /* Updated to match */
               display: flex;
               align-items: flex-start;
               justify-content: center;
           }

           .account-wrapper {
               width: 100%;
               max-width: 1000px;
               display: grid;
               grid-template-columns: 280px 1fr;
               gap: 20px;
               align-items: start;
           }


           .account-sidebar {
               background: linear-gradient(160deg, var(--primary), var(--primary-dark));
               color: #fff;
               border-radius: var(--radius);
               padding: 22px;
               display: flex;
               flex-direction: column;
               justify-content: flex-start;
               box-shadow: var(--shadow);
               height: fit-content;
           }

           .account-sidebar h1 {
               font-family: 'Cairo', sans-serif;
               font-size: 1.5rem;
               margin-bottom: 6px;
           }

           .account-sidebar p {
               font-size: .85rem;
               opacity: .9;
               line-height: 1.4;
           }

           /* Card - Compact Design */
           .account-card {
               background: var(--card);
               border-radius: var(--radius);
               box-shadow: var(--shadow);
               padding: 22px;
               display: flex;
               flex-direction: column;
               justify-content: flex-start;
               height: fit-content;
           }

           /* Form - Compact Design - Updated icons */
           .form-title {
               display: flex;
               align-items: center;
               gap: 10px;
               font-size: 1.25rem;
               font-weight: 600;
               margin-bottom: 2px;
           }

           .form-title i {
               color: var(--primary);
               font-size: 1.1rem;
           }

           .form-subtitle {
               font-size: .8rem;
               color: var(--muted);
               margin-bottom: 12px;
           }

           .form-grid {
               display: grid;
               grid-template-columns: 1fr 1fr;
               gap: 10px;
           }

           .form-group {
               display: flex;
               flex-direction: column;
           }

           label {
               font-size: .8rem;
               font-weight: 600;
               margin-bottom: 3px;
           }

           input {
               padding: 8px 12px;
               border: 1px solid #e2e5e8;
               border-radius: 8px;
               font-family: 'Poppins', sans-serif;
               font-size: 0.88rem;
           }

           input:focus {
               outline: none;
               border-color: var(--primary);
           }

           .password-box {
               margin-top: 12px;
               padding: 12px;
               background: #f8faf9;
               border-radius: 10px;
               border-left: 4px solid var(--primary);
           }

           .password-box .fas.fa-info-circle {
               color: var(--primary);
               margin-right: 5px;
           }

           .actions {
               margin-top: 14px;
               display: flex;
               gap: 10px;
           }

           .btn {
               flex: 1;
               padding: 9px;
               border-radius: 8px;
               border: none;
               font-weight: 600;
               cursor: pointer;
               font-family: 'Poppins', sans-serif;
               transition: all 0.3s ease;
               font-size: 0.88rem;
               min-height: 44px;
               display: flex;
               align-items: center;
               justify-content: center;
               gap: 8px;
           }

           .btn-primary {
               background: var(--primary);
               color: #fff;
           }

           .btn-primary:hover {
               background: var(--primary-dark);
               transform: translateY(-2px);
               box-shadow: var(--shadow);
           }

           .btn-logout {
               background: #fff;
               border: 2px solid var(--secondary);
               color: var(--secondary);
           }

           .btn-logout:hover {
               background: var(--secondary);
               color: #fff;
               transform: translateY(-2px);
               box-shadow: var(--shadow);
           }

           /* Notification */
           .notification {
               position: fixed;
               top: 20px;
               right: 20px;
               padding: 14px 18px;
               border-radius: 8px;
               color: #fff;
               display: flex;
               gap: 10px;
               align-items: center;
               transform: translateX(120%);
               transition: .3s ease;
               z-index: 9999;
               box-shadow: var(--shadow);
               font-weight: 500;
           }

           .notification.show {
               transform: translateX(0)
           }

           .notification.success {
               background: #28a745
           }

           .notification.error {
               background: #dc3545
           }

           /* ===== MODAL WINDOWS ===== */
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
               z-index: 10000;
               padding: 20px;
           }

           .modal-container {
               background: white;
               border-radius: 8px;
               width: 90%;
               max-width: 500px;
               max-height: 90vh;
               overflow-y: auto;
           }

           .modal-header {
               padding: 20px;
               border-bottom: 1px solid #e0e0e0;
               display: flex;
               justify-content: space-between;
               align-items: center;
           }

           .modal-header h3 {
               margin: 0;
               font-family: 'Playfair Display', serif;
               color: #2d2d2d;
           }

           .modal-close {
               background: none;
               border: none;
               font-size: 24px;
               cursor: pointer;
               color: #666;
               transition: color 0.3s ease;
               width: 44px;
               height: 44px;
               display: flex;
               align-items: center;
               justify-content: center;
               border-radius: 50%;
           }

           .modal-close:hover {
               background-color: rgba(0, 0, 0, 0.1);
               color: #dc3545;
           }

           .modal-content {
               padding: 20px;
           }

           .cart-empty {
               text-align: center;
               padding: 40px 20px;
           }

           .cart-empty i {
               font-size: 48px;
               color: var(--primary);
               margin-bottom: 20px;
           }

           .cart-empty h4 {
               margin-bottom: 20px;
               color: #666;
               font-family: 'Inter', sans-serif;
               font-size: 18px;
           }

           .cart-items {
               display: none;
           }

           .cart-items-list {
               display: flex;
               flex-direction: column;
               gap: 15px;
               margin-bottom: 20px;
           }

           .cart-item {
               display: flex;
               gap: 15px;
               padding: 15px;
               background: #f8f9fa;
               border-radius: 8px;
               align-items: center;
           }

           .cart-item-img {
               width: 80px;
               height: 80px;
               border-radius: 4px;
               overflow: hidden;
               flex-shrink: 0;
               border: 1px solid #e0e0e0;
           }

           .cart-item-img img {
               width: 100%;
               height: 100%;
               object-fit: cover;
           }

           .cart-item-details {
               flex-grow: 1;
           }

           .cart-item-title {
               font-weight: 600;
               margin-bottom: 5px;
               font-size: 15px;
               font-family: 'Inter', sans-serif;
               color: #2d2d2d;
           }

           .cart-item-price {
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
               min-width: 44px;
               min-height: 44px;
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
               min-height: 44px;
               display: inline-flex;
               align-items: center;
           }

           .remove-item:hover {
               background: #f8d7da;
           }

           .cart-summary {
               padding: 20px;
               background: #f8f9fa;
               border-radius: 8px;
               margin-top: 20px;
           }

           .summary-row {
               display: flex;
               justify-content: space-between;
               padding: 10px 0;
               border-bottom: 1px solid #e0e0e0;
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

           .btn-block {
               width: 100%;
               padding: 14px;
               font-size: 16px;
               margin-top: 15px;
               font-weight: 600;
               font-family: 'Inter', sans-serif;
               min-height: 44px;
           }

           /* Wishlist Modal */
           .wishlist-modal {
               max-width: 600px;
           }

           .wishlist-empty {
               text-align: center;
               padding: 40px 20px;
           }

           .wishlist-empty i {
               font-size: 48px;
               color: var(--primary);
               margin-bottom: 20px;
           }

           .wishlist-empty h4 {
               margin-bottom: 20px;
               color: #666;
               font-family: 'Inter', sans-serif;
               font-size: 18px;
           }

           .wishlist-items {
               display: none;
           }

           .wishlist-items-list {
               display: flex;
               flex-direction: column;
               gap: 15px;
               margin-bottom: 20px;
           }

           .wishlist-item {
               background: #f8f9fa;
               border-radius: 8px;
               padding: 15px;
               display: flex;
               align-items: center;
               gap: 15px;
               position: relative;
           }

           .wishlist-item-img {
               width: 80px;
               height: 80px;
               border-radius: 4px;
               overflow: hidden;
               flex-shrink: 0;
               border: 1px solid #e0e0e0;
           }

           .wishlist-item-img img {
               width: 100%;
               height: 100%;
               object-fit: cover;
           }

           .wishlist-item-details {
               flex-grow: 1;
           }

           .wishlist-item-title {
               font-weight: 600;
               font-size: 15px;
               margin-bottom: 5px;
               line-height: 1.4;
               color: #2d2d2d;
               font-family: 'Inter', sans-serif;
           }

           .wishlist-item-price {
               color: var(--primary);
               font-weight: 700;
               font-size: 16px;
               margin-bottom: 10px;
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
               min-height: 44px;
               display: flex;
               align-items: center;
               justify-content: center;
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
               min-width: 44px;
               min-height: 44px;
           }

           .remove-wishlist-item:hover {
               background: #c82333;
               transform: scale(1.1);
           }

           .wishlist-actions {
               text-align: center;
               margin-top: 20px;
           }

           /* Cart Notification */
           .cart-notification {
               position: fixed;
               top: 100px;
               right: 20px;
               background: #006341;
               color: white;
               padding: 15px 25px;
               border-radius: 8px;
               box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
               z-index: 9999;
               animation: slideIn 0.3s ease;
               font-weight: 600;
               font-family: 'Cairo', sans-serif;
               border-left: 4px solid #006341;
               text-transform: uppercase;
               letter-spacing: 0.5px;
               font-size: 14px;
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

           @keyframes fadeIn {
               from {
                   opacity: 0;
                   transform: translateY(-10px);
               }

               to {
                   opacity: 1;
                   transform: translateY(0);
               }
           }

           /* ===== RESPONSIVE DESIGN - Updated to match contact.html ===== */
           @media(max-width: 1100px) {
               .nav-list {
                   gap: 18px;
               }

               .logo-img {
                   height: 70px;
               }
           }

           @media(max-width: 992px) {
               .nav-list {
                   gap: 15px;
               }

               .container {
                   width: 95%;
               }
           }

           @media(max-width: 768px) {
               .main-nav {
                   display: none;
               }

               .header-actions {
                   gap: 10px;
               }

               .mobile-menu-btn {
                   display: block;
               }

               .logo-img {
                   height: 65px;
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

               .search-input {
                   width: 100%;
               }

               .action-icons {
                   display: none;
               }

               .header-actions {
                   display: flex;
                   align-items: center;
               }

               .search-container {
                   display: none;
               }

               .mobile-search-btn {
                   display: block !important;
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

               .mobile-nav-list {
                   list-style: none;
                   padding: 0;
                   margin: 0;
                   width: 100%;
               }

               .mobile-nav-item {
                   margin-bottom: 10px;
                   width: 100%;
               }

               .mobile-nav-link {
                   display: flex;
                   align-items: center;
                   padding: 15px 20px;
                   font-size: 1.1rem;
                   font-weight: 600;
                   color: var(--text);
                   text-decoration: none;
                   border-radius: 8px;
                   transition: all 0.3s ease;
                   width: 100%;
               }

               .mobile-nav-link:hover,
               .mobile-nav-link.active {
                   background: var(--primary);
                   color: white;
               }

               .mobile-nav-link i {
                   margin-right: 10px;
                   width: 20px;
                   text-align: center;
               }

               .mobile-dropdown-toggle {
                   display: flex;
                   justify-content: space-between;
                   align-items: center;
                   width: 100%;
                   cursor: pointer;
               }

               .mobile-dropdown-content {
                   padding-left: 20px;
                   margin-top: 5px;
                   display: none;
                   width: 100%;
               }

               .mobile-dropdown-content.active {
                   display: block;
               }

               .mobile-dropdown-item {
                   display: block;
                   padding: 12px 20px;
                   font-size: 0.95rem;
                   color: var(--text);
                   text-decoration: none;
                   border-radius: 6px;
                   margin-bottom: 5px;
                   transition: all 0.3s ease;
                   background: rgba(0, 0, 0, 0.03);
               }

               .mobile-dropdown-item:hover {
                   background: rgba(0, 99, 65, 0.1);
                   color: var(--primary);
               }

               .header-actions {
                   display: flex;
                   align-items: center;
                   justify-content: flex-end;
               }

               .mobile-menu-btn {
                   order: 2;
               }

               .account-page {
                   margin-top: 120px;
                   padding: 15px 10px;
               }

               .account-wrapper {
                   grid-template-columns: 1fr;
                   gap: 20px;
               }

               .account-sidebar,
               .account-card {
                   padding: 25px;
               }

               .form-grid {
                   grid-template-columns: 1fr;
                   gap: 15px;
               }

               .cart-item,
               .wishlist-item {
                   flex-direction: column;
                   text-align: center;
                   padding: 15px;
               }

               .cart-item-img,
               .wishlist-item-img {
                   width: 100%;
                   max-width: 150px;
                   height: 150px;
                   margin: 0 auto 15px;
               }

               .cart-item-qty {
                   justify-content: center;
                   flex-wrap: wrap;
                   gap: 8px;
               }

               .wishlist-item-actions {
                   flex-direction: column;
                   gap: 8px;
               }

               .wishlist-item-actions button {
                   width: 100%;
               }
           }

           @media(max-width: 576px) {
               .logo-img {
                   height: 60px;
               }

               .header-main {
                   padding: 12px 0;
               }

               .action-icons {
                   gap: 12px;
               }

               .action-icon {
                   font-size: 18px;
               }

               .mobile-nav {
                   padding: 100px 12px 12px;
               }

               .mobile-nav-link {
                   font-size: 0.95rem;
                   padding: 10px 12px;
               }

               .mobile-dropdown-item {
                   padding: 8px 12px;
                   font-size: 0.85rem;
               }

               .action-icons {
                   display: none;
               }

               .account-page {
                   margin-top: 110px;
                   padding: 10px;
               }

               .account-sidebar,
               .account-card {
                   padding: 20px;
               }

               .account-sidebar h1 {
                   font-size: 1.4rem;
               }

               .form-title {
                   font-size: 1.2rem;
               }

               .actions {
                   flex-direction: column;
                   gap: 10px;
               }

               .btn {
                   padding: 12px;
               }

               .notification {
                   top: 15px;
                   right: 15px;
                   padding: 12px 16px;
                   font-size: 0.9rem;
               }

               .modal-container {
                   width: 95%;
                   margin: 20px auto;
               }
           }

           @media(max-width: 375px) {
               .logo-img {
                   height: 55px;
               }

               .action-icons {
                   display: none;
               }

               .account-page {
                   margin-top: 105px;
               }

               .account-sidebar,
               .account-card {
                   padding: 18px;
               }

               .form-title {
                   font-size: 1.1rem;
               }

               input {
                   padding: 10px 12px;
                   font-size: 0.95rem;
               }

               label {
                   font-size: 0.85rem;
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

           @media(max-height: 700px) {
               .account-page {
                   margin-top: 90px;
                   padding: 10px;
               }

               .account-wrapper {
                   gap: 15px;
               }

               .account-sidebar,
               .account-card {
                   padding: 18px;
               }

               .form-grid {
                   gap: 8px;
               }
           }
       </style>
       <!-- Main -->
       <main class="account-page">
           <div class="account-wrapper">

               <aside class="account-sidebar">
                   <h1>Account Settings</h1>
                   <p>Manage your personal information and security preferences.</p>
               </aside>

               <section class="account-card">
                   <div>
                       <div class="form-title">
                           <i class="fas fa-user-cog"></i> Profile Settings
                       </div>
                       <div class="form-subtitle">Update your personal information</div>

                       <form method="post" action="{{ route('ecommerce.account.update') }}" id="update-form"
                           class="update-form">
                           @csrf
                           <div class="form-grid">

                               <div class="form-group">
                                   <label>Name</label>
                                   <input name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                               </div>

                               <div class="form-group">
                                   <label>Email</label>
                                   <input name="email" type="email"
                                       value="{{ old('email', auth()->user()->email ?? '') }}" required>
                               </div>

                               <div class="form-group">
                                   <label>Phone</label>
                                   <input name="phone" type="tel"
                                       value="{{ old('phone', auth()->user()->phone ?? '') }}">
                               </div>

                               <div class="form-group">
                                   <label>Date of Birth</label>
                                   <input name="date_of_birth" type="date"
                                       value="{{ old('date_of_birth', auth()->user()->date_of_birth ?? '') }}">
                               </div>

                           </div>

                           <div class="password-box">
                               <div class="form-grid">

                                   <div class="form-group">
                                       <label>Current Password</label>
                                       <input type="password" name="current_password">
                                   </div>

                                   <div class="form-group">
                                       <label>New Password</label>
                                       <input type="password" name="password" placeholder="Min. 8 characters">
                                   </div>

                                   <div class="form-group">
                                       <label>Confirm Password</label>
                                       <input type="password" name="password_confirmation"
                                           placeholder="Repeat new password">
                                   </div>

                               </div>
                           </div>

                           <div class="actions">

                               <button class="btn btn-primary" type="submit">
                                   <i class="fas fa-save"></i> Save Changes
                               </button>

                       </form>

                       <form method="POST" action="{{ route('logout') }}" class="logout-form">
                           @csrf
                           <button class="btn btn-logout" type="submit">
                               <i class="fas fa-sign-out-alt"></i> Logout
                           </button>
                       </form>

                   </div>
           </div>
           </section>

           </div>
       </main>

       <!-- Cart Modal -->
       <div class="modal-overlay" id="cartModal">
           <div class="modal-container cart-modal">
               <div class="modal-header">
                   <h3>Your Shopping Cart</h3>
                   <button class="modal-close" id="closeCartModal"><i class="fas fa-times"></i></button>
               </div>
               <div class="modal-content">
                   <div class="cart-empty" id="cartEmpty">
                       <i class="fas fa-shopping-bag"></i>
                       <h4>Your cart is empty</h4>
                       <a href="../html/shop.html" class="btn btn-primary" id="continueShopping">Continue Shopping</a>
                   </div>
                   <div class="cart-items" id="cartItems">
                       <div class="cart-items-list" id="cartItemsList"></div>
                       <div class="cart-summary">
                           <div class="summary-row"><span>Subtotal</span><span class="cart-subtotal">$0.00</span></div>
                           <div class="summary-row total"><span>Total</span><span class="cart-total-amount">$0.00</span>
                           </div>
                           <button class="btn btn-primary btn-block" id="modalCheckoutBtn">Proceed to Checkout</button>
                       </div>
                   </div>
               </div>
           </div>
       </div>

       <!-- Wishlist Modal -->
       <div class="modal-overlay" id="wishlistModal">
           <div class="modal-container wishlist-modal">
               <div class="modal-header">
                   <h3>Your Wishlist</h3>
                   <button class="modal-close" id="closeWishlistModal"><i class="fas fa-times"></i></button>
               </div>
               <div class="modal-content">
                   <div class="wishlist-empty" id="wishlistEmpty">
                       <i class="fas fa-heart"></i>
                       <h4>Your wishlist is empty</h4>
                       <a href="../html/shop.html" class="btn btn-primary" id="continueBrowsing">Continue Browsing</a>
                   </div>
                   <div class="wishlist-items" id="wishlistItems">
                       <div class="wishlist-items-list" id="wishlistItemsList"></div>
                       <div class="wishlist-actions">
                           <button class="btn btn-primary btn-block" id="wishlistToCartBtn">Add All to Cart</button>
                       </div>
                   </div>
               </div>
           </div>
       </div>

       <div class="notification" id="notification">
           <i class="fas fa-check-circle"></i>
           <span id="notificationMessage"></span>
       </div>

       @if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    });
</script>
@endif
   @endsection
