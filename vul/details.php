<?php


require 'config/db_connect.php';

$error = ""; 
$comments = "" ; 

if (isset($_GET['id'])){
  $id= $_GET['id'] ;
  $q = "SELECT * FROM pizza where id = $id";
  $result =  mysqli_query($conn, $q);
  $row  = mysqli_fetch_assoc($result);

}

if (isset($_POST['update'])){
  if(empty($_POST['comments'])){
    $error = "You cannot leave this field empty!"; 
  } else {
    $comments = $_POST['comments'];
    $id = $_POST['id']; 
    $q = "UPDATE pizza set comments = '$comments' WHERE id = $id";
    if (mysqli_query($conn, $q)){
      header("location: details.php?id=". $id ) ; 
      // header("location: index.php"); 
    } else {
      echo "ERROR: " . mysqli_error($conn) . "<br>"; 
    }


  }
}
  if (isset($_POST['delete'])){
    $id = $_POST['id_to_be_deleted'];
    $q = "DELETE FROM pizza where id = $id";
    if(mysqli_query($conn, $q)){
      header('location: index.php'); 
    } else{
      echo "ERROR: " . mysqli_error($conn) . "<br>"; 
    }

  }






  ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/styles_nav.css">
    <link rel="stylesheet" href="assets/styles_details.css">
    <title></title>
  </head>
  <body>
    <?php include("templates/nav.php") ?>

      <form class="" action="details.php?id=<?php echo $row['id'] ?>" method="post">

        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">

        <label>Pizza Name</label>
        <input type="text" name="title" value="<?php echo $row['title'] ?>" disabled>

        <label>ingredients</label>
        <input type="text" name="ing" value="<?php echo $row['ingredients'] ?>" disabled>

        <label>Creator</label>
        <input type="text" name="email" value="<?php echo $row['email'] ?>" disabled>

        <label>Comments</label>
          <input type="text" name="comments" value="<?php echo $row['comments'] ?>" placeholder="Type your comment on this pizza..">

        <input type="submit" name="update" value="Update">

      </form>


      <form action="details.php" method="post">
      <input type="hidden" name="id_to_be_deleted" value="<?php echo $row['id'] ?>"> 
      <input class="del" type="submit" name="delete" value="delete">
      </form>
   



  </body>
</html>
