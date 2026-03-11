<?php
session_start();
require_once __DIR__ . '/config.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

$success_message = $_SESSION['success_message'] ?? '';
$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['success_message'], $_SESSION['error_message']);

$conn = getDBConnection();

// --- 1. HANDLE DELETE ---
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM Department_tbl WHERE Dept_id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Department deleted successfully.";
    } else {
        $_SESSION['error_message'] = "Failed to delete: Department may be in use.";
    }
    header("Location: Department_registration.php");
    exit();
}

// --- 2. HANDLE UPDATE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_department'])) {
    $dept_id     = intval($_POST['Dept_id']);
    $dept_name   = trim($_POST['Dept_Name'] ?? '');
    $description = trim($_POST['Description'] ?? '');

    $stmt = $conn->prepare("UPDATE Department_tbl SET Dept_Name = ?, Description = ? WHERE Dept_id = ?");
    $stmt->bind_param("ssi", $dept_name, $description, $dept_id);
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Department updated successfully.";
    } else {
        $_SESSION['error_message'] = "Failed to update department.";
    }
    header("Location: Department_registration.php");
    exit();
}

// --- 3. HANDLE REGISTRATION ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_department'])) {
    $dept_name   = trim($_POST['Dept_Name'] ?? '');
    $description = trim($_POST['Description'] ?? '');

    if ($dept_name !== '') {
        $check = $conn->prepare("SELECT Dept_id FROM Department_tbl WHERE Dept_Name = ?");
        $check->bind_param('s', $dept_name);
        $check->execute();
        $check->store_result();
        
        if ($check->num_rows > 0) {
            $_SESSION['error_message'] = "Department '$dept_name' already exists.";
        } else {
            $stmt = $conn->prepare("INSERT INTO Department_tbl (Dept_Name, Description) VALUES (?, ?)");
            $stmt->bind_param('ss', $dept_name, $description);
            if ($stmt->execute()) {
                $_SESSION['success_message'] = 'Department registered successfully.';
            }
            $stmt->close();
        }
        $check->close();
    }
    header("Location: Department_registration.php");
    exit();
}

// Fetch existing departments
$departments = [];
$result = $conn->query("SELECT Dept_id, Dept_Name, Description, Date_Register FROM Department_tbl ORDER BY Dept_Name ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) { $departments[] = $row; }
    $result->free();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SCC Inventory - Departments</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fc; }
        .bg-gradient-primary { background-color: #1a202c !important; background-image: linear-gradient(180deg, #1a202c 10%, #2d3748 100%) !important; }
        .card { border: none; border-radius: 12px; }
        .btn-emerald { background-color: #10b981; border: none; color: white; padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 600; }
        .btn-emerald:hover { background-color: #059669; color: white; }
        .badge-dept { background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include __DIR__ . '/includes/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include __DIR__ . '/includes/topbar.php'; ?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Department Management</h1>
                    
                    <div class="row">
                        <div class="col-lg-4">
                            <?php if ($success_message): ?>
                                <div class="alert alert-success border-0 small alert-dismissible fade show"><?php echo $success_message; ?><button class="close" data-dismiss="alert">&times;</button></div>
                            <?php endif; ?>
                            <?php if ($error_message): ?>
                                <div class="alert alert-danger border-0 small alert-dismissible fade show"><?php echo $error_message; ?><button class="close" data-dismiss="alert">&times;</button></div>
                            <?php endif; ?>

                            <div class="card shadow-sm mb-4">
                                <div class="card-header"><h6 class="m-0 font-weight-bold text-dark">New Department</h6></div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="form-group">
                                            <label class="small font-weight-bold">Department Name *</label>
                                            <input type="text" class="form-control" name="Dept_Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="small font-weight-bold">Description</label>
                                            <textarea class="form-control" name="Description" rows="3"></textarea>
                                        </div>
                                        <button type="submit" name="register_department" class="btn btn-emerald btn-block">Register</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="card shadow-sm">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-dark">Department List</h6>
                                    <span class="badge badge-dept px-3 py-2"><?php echo count($departments); ?> Total</span>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Description</th>
                                                    <th class="text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($departments as $dept): ?>
                                                <tr>
                                                    <td class="font-weight-bold"><?php echo htmlspecialchars($dept['Dept_Name']); ?></td>
                                                    <td class="small"><?php echo htmlspecialchars($dept['Description']); ?></td>
                                                    <td class="text-right">
                                                        <button class="btn btn-sm btn-light border edit-btn" 
                                                                data-id="<?php echo $dept['Dept_id']; ?>"
                                                                data-name="<?php echo htmlspecialchars($dept['Dept_Name']); ?>"
                                                                data-desc="<?php echo htmlspecialchars($dept['Description']); ?>">
                                                            <i class="fas fa-edit text-primary"></i>
                                                        </button>
                                                        <a href="?delete_id=<?php echo $dept['Dept_id']; ?>" 
                                                           class="btn btn-sm btn-light border" 
                                                           onclick="return confirm('Delete this department?')">
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
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Department</h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="Dept_id" id="edit_id">
                        <div class="form-group">
                            <label class="small font-weight-bold">Department Name</label>
                            <input type="text" class="form-control" name="Dept_Name" id="edit_name" required>
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold">Description</label>
                            <textarea class="form-control" name="Description" id="edit_desc" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_department" class="btn btn-emerald">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        // Script to fill the Edit Modal with existing data
        $('.edit-btn').on('click', function() {
            $('#edit_id').val($(this).data('id'));
            $('#edit_name').val($(this).data('name'));
            $('#edit_desc').val($(this).data('desc'));
            $('#editModal').modal('show');
        });
    </script>
</body>
</html>