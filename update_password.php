<?php
// Script to verify and update password hash
// Run this in your browser: http://localhost/startbootstrap-sb-admin-2-gh-pages/update_password.php

require_once 'config.php';

$email = 'molinamarky99@gmail.com';
$password = '123456';

// Generate hash
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "<h2>Password Hash Generator</h2>";
echo "<p>Email: " . htmlspecialchars($email) . "</p>";
echo "<p>Password: " . htmlspecialchars($password) . "</p>";
echo "<p><strong>Generated Hash:</strong></p>";
echo "<pre>" . $hash . "</pre>";

// Test the hash
if (password_verify($password, $hash)) {
    echo "<p style='color: green;'>✓ Hash verification successful!</p>";
    
    // Update database if connection available
    try {
        $conn = getDBConnection();
        
        // Check if user exists
        $stmt = $conn->prepare("SELECT id FROM admin_users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Update existing user
            $update_stmt = $conn->prepare("UPDATE admin_users SET password = ? WHERE email = ?");
            $update_stmt->bind_param("ss", $hash, $email);
            if ($update_stmt->execute()) {
                echo "<p style='color: green;'>✓ Database updated successfully!</p>";
            } else {
                echo "<p style='color: red;'>✗ Database update failed: " . $conn->error . "</p>";
            }
            $update_stmt->close();
        } else {
            // Insert new user
            $insert_stmt = $conn->prepare("INSERT INTO admin_users (email, password, full_name, is_active) VALUES (?, ?, 'Administrator', 1)");
            $insert_stmt->bind_param("ss", $email, $hash);
            if ($insert_stmt->execute()) {
                echo "<p style='color: green;'>✓ New user created successfully!</p>";
            } else {
                echo "<p style='color: red;'>✗ User creation failed: " . $conn->error . "</p>";
            }
            $insert_stmt->close();
        }
        
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo "<p style='color: orange;'>Note: Could not connect to database. Make sure you've imported database.sql first.</p>";
        echo "<p>Copy the hash above and update it manually in your database.</p>";
    }
} else {
    echo "<p style='color: red;'>✗ Hash verification failed!</p>";
}
?>
