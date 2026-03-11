<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SCC Inventory - Dashboard</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fc; }
        
        /* Custom Sidebar Color (Midnight Blue) */
        .bg-gradient-primary {
            background-color: #1a202c;
            background-image: linear-gradient(180deg, #1a202c 10%, #2d3748 100%);
            background-size: cover;
        }

        /* Modern Card Styling */
        .card {
            border: none;
            border-radius: 12px;
            transition: transform 0.2s ease;
        }
        .card:hover { transform: translateY(-5px); }
        
        .border-left-primary { border-left: .25rem solid #4e73df !important; }
        .border-left-success { border-left: .25rem solid #10b981 !important; } /* Emerald */
        .border-left-info { border-left: .25rem solid #3b82f6 !important; }
        .border-left-warning { border-left: .25rem solid #f59e0b !important; }

        .btn-primary { background-color: #4f46e5; border: none; border-radius: 8px; }
        .btn-danger { border-radius: 8px; }

        /* Dashboard Heading */
        .text-gray-800 { color: #1e293b !important; font-weight: 700; }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">
        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include __DIR__ . '/includes/topbar.php'; ?>

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <div>
                            <a href="#" class="btn btn-sm btn-white shadow-sm mr-2 text-dark"><i class="fas fa-sync fa-sm mr-1"></i> Refresh</a>
                            <a href="#" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Add New Item</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Stock Items</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">1,240</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Low Stock Alerts</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">12 Items</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2" style="border-left: .25rem solid #ef4444 !important;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Out of Stock</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Items Issued (Monthly)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">452</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        
                        <div class="card-body text-center py-5">
                           
                        </div>
                    </div>

                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; SCC Inventory Management 2026 | Developed by MalynDaguino</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

</body>
</html>