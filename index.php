<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SCC Inventory - Admin Login</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Midnight Blue Gradient to match Sidebar */
        .bg-gradient-primary {
            background-color: #1a202c !important;
            background-image: linear-gradient(180deg, #1a202c 10%, #2d3748 100%) !important;
            background-size: cover;
        }

        /* Modern Card Styling */
        .card {
            border: none;
            border-radius: 15px;
        }

        /* Emerald Green Login Button */
        .btn-emerald {
            background-color: #10b981;
            border: none;
            color: white;
            padding: 0.75rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-emerald:hover {
            background-color: #059669;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .form-control-user {
            border-radius: 10px !important;
            padding: 1.5rem 1rem !important;
        }

        .login-illustration {
            max-height: 250px;
            object-fit: contain;
        }
    </style>
</head>

<body class="bg-gradient-primary">

    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center bg-light">
                                <div class="text-center p-4">
                                    <img src="images.png" alt="Login Illustration" class="img-fluid login-illustration mb-4">
                                    <h4 class="text-gray-900 font-weight-bold">SCC Inventory</h4>
                                    <p class="text-gray-600 small"></p>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2 font-weight-bold">Welcome Back</h1>
                                        <p class="mb-4 text-muted small"></p>
                                    </div>

                                    <?php
                                    if (isset($_GET['error'])) {
                                        echo '<div class="alert alert-danger small text-center border-0 shadow-sm" role="alert" style="border-radius:10px;">
                                                <i class="fas fa-exclamation-circle mr-1"></i> Invalid email or password!
                                              </div>';
                                    }
                                    ?>

                                    <form class="user" method="POST" action="login.php">
                                        <div class="form-group">
                                            <label class="small font-weight-bold text-dark ml-1">Email Address</label>
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" name="email" 
                                                placeholder="Enter Email" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="small font-weight-bold text-dark ml-1">Password</label>
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" name="password" 
                                                placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck" name="remember">
                                                <label class="custom-control-label" for="customCheck">Keep me logged in</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-emerald btn-user btn-block shadow-sm">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small text-muted" href="#">Forgot Password?</a>
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