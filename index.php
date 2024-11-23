<?php
include("includes/index.inc.php");
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

      <?php if ($current_username != "admin") { ?>
      <h1> Access Denied.</h1>
      <?php } else {  ?>
         <h1>Admin</h1>
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
                     <td> <a class="button" href="details.php?id=<?php echo $row['id'] ?>">  View More Details </a> </td> 
                  </tr>
               <?php } ?>
            </tbody>
         </table>
      <?php } ?>

   </body>
</html>
