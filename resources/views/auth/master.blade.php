<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HAWIYA | Account Login & Signup</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Cairo:wght@400;500;600&display=swap"
        rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }

        .auth-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .logo-container {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px 0;
        }

        .auth-title {
            font-size: 24px;
            font-weight: 600;
            margin: 10px 0 20px;
        }

        .auth-subtitle {
            color: #888;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            transition: border 0.2s;
        }

        .form-control.error {
            border-color: #dc3545 !important;
            background-color: #fff5f5;
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .form-control:focus {
            outline: none;
            border-color: #006341;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 10px 0 20px;
            font-size: 14px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .forgot-link {
            color: #006341;
            text-decoration: none;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background: #006341;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            margin-bottom: 20px;
        }

        .btn-primary:hover {
            background: #004d33;
        }

        .social-btn {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: white;
            color: #333;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .social-btn:hover {
            background: #f9f9f9;
        }

        .social-btn i {
            color: #DB4437;
        }

        .signup-link {
            font-size: 14px;
            color: #888;
        }

        .signup-link a {
            color: #006341;
            text-decoration: none;
            font-weight: 600;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        #registerForm {
            display: none;
        }

        .auth-message {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            display: none;
        }

        .auth-message.success {
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.2);
            color: #28a745;
            display: block;
        }

        .auth-message.error {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.2);
            color: #dc3545;
            display: block;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #888;
            cursor: pointer;
            font-size: 16px;
        }

        .input-with-icon {
            position: relative;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 25px;
                margin: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="auth-card">
        <div class="logo-container">
            <div class="logo">
                <img src="{{ asset('website/img/MainLogo (2).png') }}" alt="HAWIYA" style="height: 80px;" />
            </div>
        </div>

        @yield('content')
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('inactive_account'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Account Not Activated',
                text: 'Your account is not activated. Please contact the administration.',
                confirmButtonText: 'OK'
            });
            
        </script>
    @endif
    
    @if (session('error'))
        <script>
            window.addEventListener('load', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Not Logged In',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#006341'
                });
            });
        </script>
    @endif
</body>

</html>
