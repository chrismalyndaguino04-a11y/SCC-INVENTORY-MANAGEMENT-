<?php
session_start();
require_once 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);
    
    // Validate input
    if (!empty($email) && !empty($password)) {
        // Get database connection
        $conn = getDBConnection();
        
        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, email, password, full_name, is_active FROM admin_users WHERE email = ? AND is_active = 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Debug: Uncomment the line below to see what's happening
            // error_log("Password check: " . $password . " vs hash: " . $user['password']);
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_email'] = $user['email'];
                $_SESSION['admin_name'] = $user['full_name'];
                
                // Update last login
                $update_stmt = $conn->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?");
                $update_stmt->bind_param("i", $user['id']);
                $update_stmt->execute();
                $update_stmt->close();
                
                // Set remember me cookie if checked
                if ($remember) {
                    setcookie('admin_email', $email, time() + (86400 * 30), '/'); // 30 days
                }
                
                // Close connections
                $stmt->close();
                $conn->close();
                
                // Redirect to dashboard
                header("Location: Dashboard.php");
                exit();
            } else {
                // Invalid password
                $stmt->close();
                $conn->close();
                header("Location: index.php?error=1");
                exit();
            }
        } else {
            // User not found
            $stmt->close();
            $conn->close();
            header("Location: index.php?error=1");
            exit();
        }
    } else {
        // Empty fields
        header("Location: index.php?error=1");
        exit();
    }
} else {
    // If not POST, redirect to login page
    header("Location: index.php");
    exit();
}
?>
