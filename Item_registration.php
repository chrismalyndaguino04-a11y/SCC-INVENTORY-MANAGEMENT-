<?php
session_start();
require_once __DIR__ . '/config.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

$success_message = '';
$error_message = '';

$conn = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $item_name        = trim($_POST['Item_name'] ?? '');
    $item_description = trim($_POST['Item_Discription'] ?? '');
    $quantity         = (int)($_POST['Quantity'] ?? 0);
    $item_type        = trim($_POST['Item_Type'] ?? '');
    $department       = trim($_POST['Department'] ?? '');

    if ($item_name === '' || $item_type === '' || $department === '') {
        $error_message = 'Please fill in all required fields (*).';
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO Items_tbl (Item_name, Item_Discription, Quantity, Item_Type, Department) 
             VALUES (?, ?, ?, ?, ?)"
        );

        if ($stmt) {
            $stmt->bind_param('ssiss', $item_name, $item_description, $quantity, $item_type, $department);
            if ($stmt->execute()) {
                $success_message = 'Item registered successfully.';
            } else {
                $error_message = 'Failed to register item. Please try again.';
            }
            $stmt->close();
        } else {
            $error_message = 'Database error. Please contact the administrator.';
        }
    }
}

$departments = [];
$deptResult = $conn->query("SELECT Dept_id, Dept_Name, Description FROM Department_tbl ORDER BY Dept_Name ASC");
if ($deptResult) {
    while ($row = $deptResult->fetch_assoc()) {
        $departments[] = $row;
    }
    $deptResult->free();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SCC Inventory - Item Registration</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fc; }
        
        /* Matching Sidebar Gradient */
        .bg-gradient-primary {
            background-color: #1a202c !important;
            background-image: linear-gradient(180deg, #1a202c 10%, #2d3748 100%) !important;
        }

        /* Modern Card Styling */
        .card { border: none; border-radius: 12px; }
        .card-header { 
            background-color: #fff; 
            border-bottom: 1px solid #edf2f7; 
            padding: 1.25rem;
            border-top-left-radius: 12px !important;
            border-top-right-radius: 12px !important;
        }

        /* Form Styling */
        .form-control {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0.6rem 1rem;
        }
        .form-control:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25);
        }
        label { font-weight: 600; color: #4a5568; font-size: 0.9rem; }

        /* Emerald Register Button */
        .btn-register {
            background-color: #10b981;
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-register:hover {
            background-color: #059669;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .text-gray-800 { color: #1e293b !important; font-weight: 700; }
        .alert { border-radius: 10px; border: none; }
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
                        <h1 class="h3 mb-0 text-gray-800">Item Registration</h1>
                        <a href="Dashboard.php" class="btn btn-sm btn-light shadow-sm text-dark">
                            <i class="fas fa-arrow-left fa-sm mr-1"></i> Back to Dashboard
                        </a>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            
                            <?php if ($success_message): ?>
                                <div class="alert alert-success shadow-sm">
                                    <i class="fas fa-check-circle mr-2"></i> <?php echo htmlspecialchars($success_message); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($error_message): ?>
                                <div class="alert alert-danger shadow-sm">
                                    <i class="fas fa-exclamation-circle mr-2"></i> <?php echo htmlspecialchars($error_message); ?>
                                </div>
                            <?php endif; ?>

                            <div class="card shadow-sm mb-4">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold text-primary">Item Details</h6>
                                </div>
                                <div class="card-body px-4 py-4">
                                    <form method="POST" action="Item_registration.php">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="Item_name">Item Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="Item_name" name="Item_name" placeholder="Item Name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Item_Type">Item Type <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="Item_Type" name="Item_Type" placeholder="Type of Item" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="Item_Discription">Add Description</label>
                                            <textarea class="form-control" id="Item_Discription" name="Item_Discription" rows="3" placeholder=""></textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Quantity">Initial Quantity</label>
                                                    <input type="number" class="form-control" id="Quantity" name="Quantity" min="0" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Department">Assigned Department <span class="text-danger">*</span></label>
                                                    <select class="form-control" id="Department" name="Department" required>
                                                        <option value="">-- Choose Dept --</option>
                                                        <?php foreach ($departments as $dept): ?>
                                                            <option value="<?php echo htmlspecialchars($dept['Dept_Name']); ?>">
                                                                <?php echo htmlspecialchars($dept['Dept_Name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="my-4">

                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="text-muted small">
                                                <i class="fas fa-clock mr-1"></i> Registration Date: <?php echo date('M d, Y'); ?>
                                            </span>
                                            <button type="submit" name="register" class="btn-register">
                                                <i class="fas fa-save mr-2"></i> Register Item
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

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