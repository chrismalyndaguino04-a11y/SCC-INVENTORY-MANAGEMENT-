<?php
session_start();
require_once __DIR__ . '/config.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

$conn = getDBConnection();
$success_message = $_SESSION['success_message'] ?? '';
$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['success_message'], $_SESSION['error_message']);

// --- HANDLE STOCK IN SUBMISSION ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['process_stock_in'])) {
    $item_id = intval($_POST['Item_id']);
    $add_qty = intval($_POST['Quantity']);

    if ($add_qty <= 0) {
        $_SESSION['error_message'] = "Quantity must be greater than zero.";
    } else {
        // Update the quantity in Items_tbl
        $stmt = $conn->prepare("UPDATE Items_tbl SET Quantity = Quantity + ? WHERE Item_id = ?");
        $stmt->bind_param("ii", $add_qty, $item_id);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Stock successfully added!";
        } else {
            $_SESSION['error_message'] = "Failed to update stock.";
        }
        $stmt->close();
    }
    header("Location: stock_in.php");
    exit();
}

// Fetch all items for the dropdown selector
$items_list = [];
$res = $conn->query("SELECT Item_id, Item_name, Quantity, Department FROM Items_tbl ORDER BY Item_name ASC");
if ($res) {
    while ($row = $res->fetch_assoc()) { $items_list[] = $row; }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Stock In | SCC Inventory</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fc; }
        .bg-gradient-primary { background: linear-gradient(180deg, #1a202c 10%, #2d3748 100%) !important; }
        .card { border: none; border-radius: 12px; }
        .card-header { background: #fff; border-bottom: 1px solid #edf2f7; }
        .btn-emerald { background-color: #10b981; color: white; border-radius: 8px; font-weight: 600; }
        .btn-emerald:hover { background-color: #059669; color: white; }
        .form-control { border-radius: 8px; }
        /* Style Select2 to match Bootstrap */
        .select2-container .select2-selection--single { height: 38px !important; border: 1px solid #d1d3e2 !important; border-radius: 8px !important; }
        .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 36px !important; }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include __DIR__ . '/includes/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include __DIR__ . '/includes/topbar.php'; ?>
                <div class="container-fluid">
                    
                    <h1 class="h3 mb-4 text-gray-800">Stock In Management</h1>

                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <?php if ($success_message): ?>
                                <div class="alert alert-success border-0 shadow-sm"><?php echo $success_message; ?></div>
                            <?php endif; ?>
                            <?php if ($error_message): ?>
                                <div class="alert alert-danger border-0 shadow-sm"><?php echo $error_message; ?></div>
                            <?php endif; ?>

                            <div class="card shadow-sm">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-dark">Add Item Stock</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="form-group">
                                            <label class="small font-weight-bold text-dark">Select Item</label>
                                            <select name="Item_id" id="itemSelect" class="form-control" required style="width: 100%;">
                                                <option value="">-- Search Item --</option>
                                                <?php foreach ($items_list as $item): ?>
                                                    <option value="<?php echo $item['Item_id']; ?>">
                                                        <?php echo htmlspecialchars($item['Item_name']); ?> 
                                                        (Current: <?php echo $item['Quantity']; ?>) - <?php echo $item['Department']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="small font-weight-bold text-dark">Quantity to Add</label>
                                            <input type="number" name="Quantity" class="form-control" placeholder="0" min="1" required>
                                        </div>

                                        <div class="mt-4">
                                            <button type="submit" name="process_stock_in" class="btn btn-emerald btn-block shadow-sm">
                                                <i class="fas fa-arrow-down mr-2"></i> Update Inventory
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="text-center mt-4">
                                <a href="Itemlist.php" class="text-gray-600 small">
                                    <i class="fas fa-chevron-left mr-1"></i> Back to Inventory List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 searchable dropdown
            $('#itemSelect').select2({
                placeholder: "Search for an item...",
                allowClear: true
            });
        });
    </script>
</body>
</html>