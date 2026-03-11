<?php
session_start();
require_once __DIR__ . '/config.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

$conn = getDBConnection();

// --- 1. HANDLE DELETE ---
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM Items_tbl WHERE Item_id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Item deleted successfully.";
    } else {
        $_SESSION['error_message'] = "Failed to delete item.";
    }
    header("Location: Item_list.php");
    exit();
}

// --- 2. HANDLE UPDATE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_item'])) {
    $id = intval($_POST['Item_id']);
    $name = trim($_POST['Item_name']);
    $desc = trim($_POST['Item_Discription']);
    $qty  = intval($_POST['Quantity']);
    $type = trim($_POST['Item_Type']);
    $dept = trim($_POST['Department']);

    $stmt = $conn->prepare("UPDATE Items_tbl SET Item_name=?, Item_Discription=?, Quantity=?, Item_Type=?, Department=? WHERE Item_id=?");
    $stmt->bind_param("ssissi", $name, $desc, $qty, $type, $dept, $id);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Item updated successfully.";
    } else {
        $_SESSION['error_message'] = "Update failed.";
    }
    header("Location: Item_list.php");
    exit();
}

// Fetch Items
$items = [];
$result = $conn->query("SELECT Item_id, Item_name, Item_Discription, Quantity, Item_Type, Department, Date_Register FROM Items_tbl ORDER BY Date_Register DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) { $items[] = $row; }
    $result->free();
}

// Clear alerts after displaying
$success = $_SESSION['success_message'] ?? '';
$error = $_SESSION['error_message'] ?? '';
unset($_SESSION['success_message'], $_SESSION['error_message']);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SCC Inventory - Item List</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fc; }
        .bg-gradient-primary { background: linear-gradient(180deg, #1a202c 10%, #2d3748 100%) !important; }
        .card { border: none; border-radius: 12px; }
        .btn-emerald { background-color: #10b981; color: white; border-radius: 8px; }
        .btn-emerald:hover { background-color: #059669; color: white; }
        .badge-qty { background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; padding: 0.5em 1em; }
        .badge-out { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include __DIR__ . '/includes/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include __DIR__ . '/includes/topbar.php'; ?>
                <div class="container-fluid">
                    
                    <?php if($success): ?> <div class="alert alert-success"><?php echo $success; ?></div> <?php endif; ?>
                    <?php if($error): ?> <div class="alert alert-danger"><?php echo $error; ?></div> <?php endif; ?>

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-900 font-weight-bold">Item List</h1>
                        <a href="Item_registration.php" class="btn btn-emerald shadow-sm">
                            <i class="fas fa-plus fa-sm mr-2"></i> New Registration
                        </a>
                    </div>

                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Item ID</th>
                                            <th>General Info</th>
                                            <th>Type</th>
                                            <th>Department</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td>#<?php echo $item['Item_id']; ?></td>
                                            <td>
                                                <div class="font-weight-bold text-dark"><?php echo htmlspecialchars($item['Item_name']); ?></div>
                                                <small class="text-muted"><?php echo htmlspecialchars($item['Item_Discription']); ?></small>
                                            </td>
                                            <td><?php echo htmlspecialchars($item['Item_Type']); ?></td>
                                            <td><?php echo htmlspecialchars($item['Department']); ?></td>
                                            <td class="text-center">
                                                <span class="badge <?php echo ($item['Quantity'] > 0) ? 'badge-qty' : 'badge-out'; ?>">
                                                    <?php echo ($item['Quantity'] > 0) ? $item['Quantity'] : 'Out'; ?>
                                                </span>
                                            </td>
                                            <td class="text-right">
                                                <button class="btn btn-sm btn-light border edit-btn" 
                                                    data-id="<?php echo $item['Item_id']; ?>"
                                                    data-name="<?php echo htmlspecialchars($item['Item_name']); ?>"
                                                    data-desc="<?php echo htmlspecialchars($item['Item_Discription']); ?>"
                                                    data-qty="<?php echo $item['Quantity']; ?>"
                                                    data-type="<?php echo htmlspecialchars($item['Item_Type']); ?>"
                                                    data-dept="<?php echo htmlspecialchars($item['Department']); ?>">
                                                    <i class="fas fa-edit text-primary"></i>
                                                </button>
                                                <a href="?delete_id=<?php echo $item['Item_id']; ?>" class="btn btn-sm btn-light border" onclick="return confirm('Delete item?')">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Edit Item</h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="Item_id" id="m_id">
                        <div class="form-group">
                            <label class="small font-weight-bold">Item Name</label>
                            <input type="text" name="Item_name" id="m_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold">Description</label>
                            <textarea name="Item_Discription" id="m_desc" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="small font-weight-bold">Quantity</label>
                                    <input type="number" name="Quantity" id="m_qty" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="small font-weight-bold">Type</label>
                                    <input type="text" name="Item_Type" id="m_type" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold">Department</label>
                            <input type="text" name="Department" id="m_dept" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="update_item" class="btn btn-emerald px-4">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        $('.edit-btn').on('click', function() {
            $('#m_id').val($(this).data('id'));
            $('#m_name').val($(this).data('name'));
            $('#m_desc').val($(this).data('desc'));
            $('#m_qty').val($(this).data('qty'));
            $('#m_type').val($(this).data('type'));
            $('#m_dept').val($(this).data('dept'));
            $('#editModal').modal('show');
        });
    </script>
</body>
</html>