<?php
require 'config/db_connect.php';

$error = "";
$comments = "";

if (isset($_GET['id'])){
  $id = $_GET['id'];
  $q = "SELECT * FROM pizza where id = ?";
  $stmt = mysqli_prepare($conn, $q);
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])){
  if (empty($_POST['comments'])){
    $error = "You cannot leave this field empty!";
  } else {
    $comments = htmlspecialchars($_POST['comments']);
    $id = $_POST['id'];
    $q = "UPDATE pizza SET comments = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $q);
    mysqli_stmt_bind_param($stmt, "si", $comments, $id);
    if (mysqli_stmt_execute($stmt)){
      header("location: details.php?id=" . $id);
    } else {
      echo "ERROR: " . mysqli_error($conn) . "<br>";
    }
  }
}

if (isset($_POST['delete'])){
  $id = $_POST['id_to_be_deleted'];
  $q = "DELETE FROM pizza WHERE id = ?";
  $stmt = mysqli_prepare($conn, $q);
  mysqli_stmt_bind_param($stmt, "i", $id);
  if (mysqli_stmt_execute($stmt)){
    header('location: index.php');
  } else {
    echo "ERROR: " . mysqli_error($conn) . "<br>";
  }
}
?>
