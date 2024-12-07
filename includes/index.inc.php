<?php
require("config/db_connect.php");

// Fetch reservation data
$reservationQuery = "SELECT id, reservation_date, reservation_time, id_image, iv, encryption_key FROM reservations";
$reservationResults = mysqli_query($conn, $reservationQuery);

// Check for errors
if (!$reservationResults) {
    die("Query failed: " . mysqli_error($conn));
}

$reservationRows = [];
while ($row = mysqli_fetch_assoc($reservationResults)) {
    $row['decrypted_id'] = null; // Initialize decrypted ID as null

    // Decrypt ID image
    if ($row['id_image'] && $row['iv'] && $row['encryption_key']) {
        $row['decrypted_id'] = openssl_decrypt(
            $row['id_image'],
            'des-ede3-cbc',
            $row['encryption_key'],
            OPENSSL_RAW_DATA,
            $row['iv']
        );
    }

    $reservationRows[] = $row;
}

// Fetch pizza data
$pizzaQuery = "SELECT * FROM pizza";
$pizzaResults = mysqli_query($conn, $pizzaQuery);

// Check for errors
if (!$pizzaResults) {
    die("Query failed: " . mysqli_error($conn));
}

$pizzaRows = mysqli_fetch_all($pizzaResults, MYSQLI_ASSOC);

// Close the database connection
mysqli_close($conn);
?>
