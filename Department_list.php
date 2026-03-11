<?php
session_start();
require_once __DIR__ . '/config.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

$conn = getDBConnection();

// Fetch departments
$sql = "SELECT * FROM Department_tbl ORDER BY Dept_Name ASC";
$result = $conn->query($sql);

$departments = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $departments[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Department List | SCC Inventory</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fc; }
        
        /* Matching Registration Page Gradient */
        .bg-gradient-primary {
            background-color: #1a202c !important;
            background-image: linear-gradient(180deg, #1a202c 10%, #2d3748 100%) !important;
        }

        /* Card Styling */
        .card { border: none; border-radius: 12px; }
        .card-header { background-color: #fff; border-bottom: 1px solid #edf2f7; padding: 1.25rem; }
        
        /* Emerald Accents */
        .btn-emerald {
            background-color: #10b981;
            border: none;
            color: white;
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-emerald:hover { background-color: #059669; color: white; transform: translateY(-1px); }
        
        /* Table Styling */
        .table { color: #4a5568; }
        .table thead th { 
            background-color: #f8fafc; 
            text-transform: uppercase; 
            font-size: 0.75rem; 
            letter-spacing: 0.05em;
            border-bottom: 2px solid #edf2f7;
        }
        
        .text-primary { color: #1a202c !important; }
        .badge-dept { background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        
        /* DataTables Customization to match theme */
        .page-item.active .page-link {
            background-color: #10b981;
            border-color: #10b981;
        }
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
                        <h1 class="h3 mb-0 text-gray-800">Department Management</h1>
                        <a href="Department_registration.php" class="btn btn-emerald shadow-sm">
                            <i class="fas fa-plus fa-sm text-white-50 mr-2"></i> Add Department
                        </a>
                    </div>

                    <div class="card shadow-sm mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Department Master List</h6>
                            <span class="badge badge-dept px-3 py-2"><?php echo count($departments); ?> Total</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="deptTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Department Name</th>
                                            <th>Description</th>
                                            <th>Date Registered</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($departments as $dept): ?>
                                        <tr>
                                            <td class="small text-muted">#<?php echo $dept['Dept_id']; ?></td>
                                            <td class="font-weight-bold text-dark"><?php echo htmlspecialchars($dept['Dept_Name']); ?></td>
                                            <td class="small"><?php echo htmlspecialchars($dept['Description']); ?></td>
                                            <td class="small text-muted"><?php echo date('M d, Y', strtotime($dept['Date_Register'])); ?></td>
                                            <td class="text-right">
                                                <div class="btn-group">
                                                    <a href="Department_registration.php" class="btn btn-sm btn-outline-secondary border-0" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="Department_registration.php?delete_id=<?php echo $dept['Dept_id']; ?>" 
                                                       class="btn btn-sm btn-outline-danger border-0" 
                                                       onclick="return confirm('Are you sure you want to delete this department?');" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
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

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto small">
                        <span>Developed by MalynDaguino 2026 | SCC Inventory</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#deptTable').DataTable({
                "pageLength": 10,
                "order": [[ 1, "asc" ]],
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search departments...",
                    "paginate": {
                        "previous": "<i class='fas fa-angle-left'></i>",
                        "next": "<i class='fas fa-angle-right'></i>"
                    }
                }
            });
            // Match search input style to theme
            $('.dataTables_filter input').addClass('form-control form-control-sm').css('border-radius', '8px');
        });
    </script>
</body>
</html>