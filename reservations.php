<?php
include("includes/reservations.inc.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
    <link rel="stylesheet" href="assets/styles_nav.css">
    <link rel="stylesheet" href="assets/style_reservation.css"> <!-- Link to the CSS file -->
</head>
<body>
<?php include("templates/nav.php"); ?>
    <h1>Make a Reservation</h1>
    <form action="reservations.php" method="POST" enctype="multipart/form-data">
        <label for="date">Reservation Date:</label>
        <input type="date" id="date" name="date" required>
        <br>
        <label for="time">Reservation Time:</label>
        <input type="time" id="time" name="time" required>
        <br>
        <label for="id_image">Upload ID (JPEG, PNG):</label>
        <input type="file" id="id_image" name="id_image" accept="image/jpeg, image/png" required>
        <br>
        <button type="submit">Submit Reservation</button>
    </form>
</body>
</html>
