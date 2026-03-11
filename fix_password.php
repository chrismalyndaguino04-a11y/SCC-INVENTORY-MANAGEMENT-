<?php
// Script to fix the password in the database
// Run this in your browser: http://localhost/startbootstrap-sb-admin-2-gh-pages/fix_password.php

require_once 'config.php';

$email = 'molinamarky99@gmail.com';
$password = '123456';

echo "<h2>Fixing Password in Database</h2>";

try {
    $conn = getDBConnection();
    echo "<p style='color: green;'>✓ Connected to database</p>";
    
    // Generate fresh password hash
    $hash = password_hash($password, PASSWORD_DEFAULT);
    echo "<p>Generated hash for password: <strong>$password</strong></p>";
    echo "<p>Hash: <code>$hash</code></p>";
    
    // Check if user exists
    $check_stmt = $conn->prepare("SELECT id, email FROM admin_users WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Update existing user
        $user = $result->fetch_assoc();
        $update_stmt = $conn->prepare("UPDATE admin_users SET password = ? WHERE email = ?");
        $update_stmt->bind_param("ss", $hash, $email);
        
        if ($update_stmt->execute()) {
            echo "<p style='color: green; font-size: 18px;'><strong>✓ Password updated successfully!</strong></p>";
            echo "<p>You can now login with:</p>";
            echo "<ul>";
            echo "<li><strong>Email:</strong> $email</li>";
            echo "<li><strong>Password:</strong> $password</li>";
            echo "</ul>";
            echo "<p><a href='index.php' style='background: #4e73df; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to Login Page</a></p>";
        } else {
            echo "<p style='color: red;'>✗ Update failed: " . $conn->error . "</p>";
        }
        $update_stmt->close();
    } else {
        // Insert new user if doesn't exist
        $insert_stmt = $conn->prepare("INSERT INTO admin_users (email, password, full_name, is_active) VALUES (?, ?, 'Administrator', 1)");
        $insert_stmt->bind_param("ss", $email, $hash);
        
        if ($insert_stmt->execute()) {
            echo "<p style='color: green; font-size: 18px;'><strong>✓ User created successfully!</strong></p>";
            echo "<p>You can now login with:</p>";
            echo "<ul>";
            echo "<li><strong>Email:</strong> $email</li>";
            echo "<li><strong>Password:</strong> $password</li>";
            echo "</ul>";
            echo "<p><a href='index.php' style='background: #4e73df; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to Login Page</a></p>";
        } else {
            echo "<p style='color: red;'>✗ Insert failed: " . $conn->error . "</p>";
        }
        $insert_stmt->close();
    }
    
    $check_stmt->close();
    $conn->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
    echo "<p><strong>Make sure:</strong></p>";
    echo "<ul>";
    echo "<li>MySQL is running in XAMPP Control Panel</li>";
    echo "<li>You have imported database.sql into phpMyAdmin</li>";
    echo "<li>Database name is 'admin_db'</li>";
    echo "</ul>";
}
?>
