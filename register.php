<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SCC Inventory - Create Account</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body { 
            font-family: 'Inter', sans-serif; 
        }
        
        /* Modern Midnight Gradient Background */
        .bg-gradient-midnight {
            background-color: #1a202c;
            background-image: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
            height: 100vh;
        }

        .card { 
            border: none; 
            border-radius: 16px; 
            overflow: hidden;
        }

        /* Form Styling */
        .form-control-user {
            border-radius: 10px !important;
            padding: 1.5rem 1rem !important;
            font-size: 0.9rem !important;
            border: 1px solid #e2e8f0 !important;
        }

        .form-control-user:focus {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.1) !important;
        }

        /* Emerald Register Button */
        .btn-emerald {
            background-color: #10b981;
            border: none;
            color: white;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-emerald:hover {
            background-color: #059669;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        /* Side Image Overlay */
        .bg-register-modern {
            background: linear-gradient(rgba(26, 32, 44, 0.8), rgba(26, 32, 44, 0.8)), 
                        url('https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 2rem;
        }

        .brand-text {
            font-weight: 800;
            letter-spacing: -1px;
            color: #10b981;
        }
    </style>
</head>

<body class="bg-gradient-midnight">

    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-5 d-none d-lg-block bg-register-modern">
                                <div>
                                    <h2 class="brand-text mb-3">SCC INVENTORY</h2>
                                    <p class="small text-gray-400">Secure access to department assets and stock management.</p>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="mb-4">
                                        <h1 class="h4 text-gray-900 font-weight-bold">Create Account</h1>
                                        <p class="text-muted small">Enter your details to register as a system administrator.</p>
                                    </div>
                                    <form class="user" action="register_process.php" method="POST">
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="text" class="form-control form-control-user" name="first_name"
                                                    placeholder="First Name" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control form-control-user" name="last_name"
                                                    placeholder="Last Name" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" name="email"
                                                placeholder="Work Email Address" required>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="password" class="form-control form-control-user"
                                                    name="password" placeholder="Password" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="password" class="form-control form-control-user"
                                                    name="repeat_password" placeholder="Repeat Password" required>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-emerald btn-user btn-block">
                                            Register Account
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small text-gray-600" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small font-weight-bold" style="color: #10b981;" href="login.php">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

</body>
</html>