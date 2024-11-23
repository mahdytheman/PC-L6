<?php
require("config/db_connect.php");

$q = "SELECT * FROM pizza";

$results = mysqli_query($conn, $q);

// Check for errors
if (!$results) {
    die("Query failed: " . mysqli_error($conn));
}

$rows = mysqli_fetch_all($results, MYSQLI_ASSOC);

// Close the database connection
mysqli_close($conn);
?>
