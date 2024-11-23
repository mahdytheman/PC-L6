<!-- add.inc.php -->
<?php

require "config/db_connect.php";

$title = $email = $ingredients = "";
$err_title = $err_email = $err_ingredients = "";
$title_valid = $email_valid = $ingredients_valid = false;

if (isset($_POST['submit'])) {

  if (empty($_POST['title'])) {
    $err_title = "This field should not be left empty!";
  } else {
    $title = htmlspecialchars($_POST['title']);
    if (preg_match('/[^A-Za-z]/', $title)) {
      $err_title = "Only Alphabets are allowed!";
    } else {
      $title_valid = true;
    }
  }

  if (empty($_POST['email'])) {
    $err_email = "This field should not be left empty!";
  } else {
    $email = htmlspecialchars($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $err_email = "INVALID EMAIL!";
    } else {
      $stmt = mysqli_prepare($conn, "SELECT * FROM pizza WHERE email = ?");
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      if (mysqli_num_rows($result) > 0) {
        $err_email = "EMAIL ALREADY EXISTS!";
      } else {
        $email_valid = true;
      }
    }
  }

  if (empty($_POST['ingredients'])) {
    $err_ingredients = "This should not be left empty";
  } else {
    $ingredients = htmlspecialchars($_POST['ingredients']);
    if (count(explode(",", $ingredients)) !== 3) {
      $err_ingredients = "Only 3 values are allowed!";
    } else {
      $ingredients_valid = true;
    }
  }

  if ($title_valid && $email_valid && $ingredients_valid) {
    $query = "INSERT INTO pizza (title, email, ingredients) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $title, $email, $ingredients);
    if (mysqli_stmt_execute($stmt)) {
      // success
      // header('location: index.php ');
    } else {
      // failure
      echo "ERROR: " . mysqli_error($conn) . "<br>";
    }
  }
}
?>
