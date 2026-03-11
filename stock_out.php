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

// --- HANDLE STOCK OUT SUBMISSION ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['process_stock_out'])) {
    $item_id = intval($_POST['Item_id']);
    $out_qty = intval($_POST['Quantity']);
    $reason  = trim($_POST['Reason']);

    // 1. Check current stock level first
    $check_stmt = $conn->prepare("SELECT Quantity, Item_name FROM Items_tbl WHERE Item_id = ?");
    $check_stmt->bind_param("i", $item_id);
    $check_stmt->execute();
    $res = $check_stmt->get_result();
    $current_item = $res->fetch_assoc();

    if (!$current_item) {
        $_SESSION['error_message'] = "Item not found.";
    } elseif ($out_qty > $current_item['Quantity']) {
        $_SESSION['error_message'] = "Insufficient stock! Current balance for " . $current_item['Item_name'] . " is only " . $current_item['Quantity'] . ".";
    } elseif ($out_qty <= 0) {
        $_SESSION['error_message'] = "Quantity must be greater than zero.";
    } else {
        // 2. Proceed with deduction
        $update_stmt = $conn->prepare("UPDATE Items_tbl SET Quantity = Quantity - ? WHERE Item_id = ?");
        $update_stmt->bind_param("ii", $out_qty, $item_id);

        if ($update_stmt->execute()) {
            $_SESSION['success_message'] = "Stock successfully withdrawn (" . $out_qty . " units).";
            // Optional: You could insert into a transaction_log table here using $reason
        } else {
            $_SESSION['error_message'] = "Failed to update stock.";
        }
        $update_stmt->close();
    }
    $check_stmt->close();
    header("Location: stock_out.php");
    exit();
}

// Fetch items that actually have stock (> 0)
$items_list = [];
$res = $conn->query("SELECT Item_id, Item_name, Quantity, Department FROM Items_tbl WHERE Quantity > 0 ORDER BY Item_name ASC");
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
    <title>Stock Out | SCC Inventory</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fc; }
        .bg-gradient-primary { background: linear-gradient(180deg, #1a202c 10%, #2d3748 100%) !important; }
        .card { border: none; border-radius: 12px; }
        .btn-danger-custom { background-color: #ef4444; color: white; border-radius: 8px; font-weight: 600; }
        .btn-danger-custom:hover { background-color: #dc2626; color: white; }
        .select2-container .select2-selection--single { height: 45px !important; border: 1px solid #d1d3e2 !important; border-radius: 8px !important; }
        .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 42px !important; padding-left: 15px; }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include __DIR__ . '/includes/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include __DIR__ . '/includes/topbar.php'; ?>
                <div class="container-fluid">
                    
                    <h1 class="h3 mb-4 text-gray-800">Stock Out / Issuance</h1>

                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <?php if ($success_message): ?>
                                <div class="alert alert-success border-0 shadow-sm"><?php echo $success_message; ?></div>
                            <?php endif; ?>
                            <?php if ($error_message): ?>
                                <div class="alert alert-danger border-0 shadow-sm text-dark font-weight-bold"><?php echo $error_message; ?></div>
                            <?php endif; ?>

                            <div class="card shadow-sm">
                                <div class="card-header py-3 bg-white">
                                    <h6 class="m-0 font-weight-bold text-danger"><i class="fas fa-minus-circle mr-2"></i>Withdraw Item</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="form-group mb-4">
                                            <label class="small font-weight-bold text-dark">Select Item to Withdraw</label>
                                            <select name="Item_id" id="itemSelect" class="form-control" required style="width: 100%;">
                                                <option value="">-- Search Item Name --</option>
                                                <?php foreach ($items_list as $item): ?>
                                                    <option value="<?php echo $item['Item_id']; ?>">
                                                        <?php echo htmlspecialchars($item['Item_name']); ?> 
                                                        [Stock: <?php echo $item['Quantity']; ?>] - <?php echo $item['Department']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="small font-weight-bold text-dark">Quantity to Release</label>
                                            <input type="number" name="Quantity" class="form-control form-control-lg" placeholder="Enter amount" min="1" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="small font-weight-bold text-dark">Purpose / Issued To</label>
                                            <textarea name="Reason" class="form-control" placeholder="e.g., Released to Admin Office / Damaged" rows="3" required></textarea>
                                        </div>

                                        <div class="mt-4">
                                            <button type="submit" name="process_stock_out" class="btn btn-danger-custom btn-block shadow-sm py-3">
                                                Confirm Issuance
                                            </button>
                                        </div>
                                    </form>
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
    <script src="js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#itemSelect').select2({
                placeholder: "Type item name...",
                allowClear: true
            });
        });
    </script>
</body>
</html>