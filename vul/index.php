<?php

// 1. establish a conection to mysql 
// mysqli (PDO)
// require->Logic(PHP)  , include-> HTML 
require("config/db_connect.php");  

// $conn = mysqli_connect("localhost", "root", "", "pizzastoree", 3308) ; 


// 2. write the READ (select) query

$q = "SELECT * from pizza";

// 3. execute the query 
$results =  mysqli_query($conn, $q); // meta deta/ desxcription

// 4. extract the actual valuaes from the meta data 
// 2d array (inner array: assoc array )
$rows = mysqli_fetch_all($results, MYSQLI_ASSOC);

// print_r($rows); 


 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title></title>
     <link rel="stylesheet" href="assets/styles_nav.css">
     <link rel="stylesheet" href="assets/styles_index.css">
   </head>

   <body>


      <?php include "templates/nav.php" ?>

   <h1>Home</h1>
   <br><br><br>

   <table>


    <thead>
      <tr>
        <td>ID</td>
        <td>Title</td>
        <td>Email</td>
        <td>Ingredients</td>
        <td>Created At</td>
        <td>Comments</td>
        <td>More Details</td>
      </tr>
    </thead>

    <tbody>
      <?php foreach($rows as $row){ ?>
        <tr>
          <td> <?php echo $row['id']; ?> </td> 
          <td> <?php echo $row['title']; ?> </td> 
          <td> <?php echo $row['email']; ?> </td> 
          <td> <?php echo $row['ingredients']; ?> </td> 
          <td> <?php echo $row['created_at'] ?> </td> 
          <td> <?php echo $row['comments'] ?>  </td> 
          <td> <a class="button"href="details.php?id=<?php echo $row['id'] ?>">  View More Details </a> </td> 
        </tr>

        <?php  }?>




    </tbody>

   </table>








   </body>
 </html>
