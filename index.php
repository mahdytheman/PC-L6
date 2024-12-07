<?php
include("includes/index.inc.php");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Admin Dashboard</title>
      <link rel="stylesheet" href="assets/styles_nav.css">
      <link rel="stylesheet" href="assets/styles_index.css">
   </head>
   <body>
      <?php include "templates/nav.php" ?>

      <?php if ($current_username != "admin") { ?>
      <h1>Access Denied.</h1>
      <?php } else { ?>
         <h1>Admin Dashboard</h1>
         <br><br><br>

         <!-- Reservation Data -->
         <h2>Reservation Data</h2>
         <table>
            <thead>
               <tr>
                  <td>ID</td>
                  <td>Reservation Date</td>
                  <td>Reservation Time</td>
                  <td>Encrypted ID Image</td>
                  <td>Decrypted ID Image</td>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($reservationRows as $reservation) { ?>
                  <tr>
                     <td><?php echo $reservation['id']; ?></td>
                     <td><?php echo $reservation['reservation_date']; ?></td>
                     <td><?php echo $reservation['reservation_time']; ?></td>
                     <td>
                        <!-- Encrypted ID Image -->
                        <a href="data:application/octet-stream;base64,<?php echo base64_encode($reservation['id_image']); ?>" download="encrypted_id_<?php echo $reservation['id']; ?>.dat">
                           Download Encrypted ID
                        </a>
                     </td>
                     <td>
                        <?php if ($reservation['decrypted_id']) { 
                           $mimeType = match (bin2hex(substr($reservation['decrypted_id'], 0, 4))) {
                               'ffd8ffe0', 'ffd8ffe1' => 'image/jpeg',
                               '89504e47' => 'image/png',
                               default => 'application/octet-stream'
                           };
                        ?>
                           <!-- Decrypted ID Image -->
                           <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($reservation['decrypted_id']); ?>" alt="Decrypted ID" width="100" height="100">
                        <?php } else { ?>
                           <p>Decryption Failed</p>
                        <?php } ?>
                     </td>
                  </tr>
               <?php } ?>
            </tbody>
         </table>

         <!-- Pizza Data -->
         <h2>Pizza Data</h2>
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
               <?php foreach ($pizzaRows as $pizza) { ?>
                  <tr>
                     <td><?php echo $pizza['id']; ?></td>
                     <td><?php echo $pizza['title']; ?></td>
                     <td><?php echo $pizza['email']; ?></td>
                     <td><?php echo $pizza['ingredients']; ?></td>
                     <td><?php echo $pizza['created_at']; ?></td>
                     <td><?php echo $pizza['comments']; ?></td>
                     <td><a class="button" href="details.php?id=<?php echo $pizza['id']; ?>">View More Details</a></td>
                  </tr>
               <?php } ?>
            </tbody>
         </table>
      <?php } ?>
   </body>
</html>
