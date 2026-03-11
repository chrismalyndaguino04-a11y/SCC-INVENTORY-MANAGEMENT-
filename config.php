<?php
// config.php

function getDBConnection() {
    $server_name = "localhost";
    $username = "root";
    $password = "";
    $db_name = "admin_db";

    $conn = mysqli_connect($server_name, $username, $password, $db_name);

    if (!$conn) {
        // die() is better here to stop the script if the DB is down
        die("Database Connection Failed: " . mysqli_connect_error());
    }

    return $conn;
}
?>