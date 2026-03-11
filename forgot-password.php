<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SCC Inventory - Reset Password</title>

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

        /* Emerald Button */
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

        /* Thematic Side Image */
        .bg-forgot-modern {
            background: linear-gradient(rgba(26, 32, 44, 0.85), rgba(26, 32, 44, 0.85)), 
                        url('https://images.unsplash.com/photo-1550751827-4bd374c3f58b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .icon-box {
            font-size: 3rem;
            color: #10b981;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body class="bg-gradient-midnight">

    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-forgot-modern">
                                <div>
                                    <div class="icon-box">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <h2 class="font-weight-bold text-white">Secure Reset</h2>
                                    <p class="small text-gray-400 px-4">Locked out of your inventory account? No worries. Let's get you back to managing SCC assets safely.</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center mb-4">
                                        <h1 class="h4 text-gray-900 font-weight-bold">Forgot Password?</h1>
                                        <p class="text-muted small">Enter your verified email address below and we'll send a secure link to reset your credentials.</p>
                                    </div>
                                    <form class="user">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..." required>
                                        </div>
                                        <button type="submit" class="btn btn-emerald btn-user btn-block">
                                            Send Reset Link
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small font-weight-bold" style="color: #10b981;" href="register.php">Create an Account!</a>
                                    </div>
                                    <div class="text-center mt-2">
                                        <a class="small text-gray-600" href="login.php">Already have an account? Login!</a>
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