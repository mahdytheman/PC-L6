<?php
include("includes/details.inc.php");
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

      <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">

      <label>Pizza Name</label>
      <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" disabled>

      <label>Ingredients</label>
      <input type="text" name="ing" value="<?php echo htmlspecialchars($row['ingredients']); ?>" disabled>

      <label>Creator</label>
      <input type="text" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" disabled>

      <label>Comments</label>
      <input type="text" name="comments" value="<?php echo htmlspecialchars($row['comments']); ?>" placeholder="Type your comment on this pizza..">

      <input type="submit" name="update" value="Update">

    </form>

    <form action="details.php" method="post">
      <input type="hidden" name="id_to_be_deleted" value="<?php echo htmlspecialchars($row['id']); ?>"> 
      <input class="del" type="submit" name="delete" value="Delete">
    </form>
  </body>
</html>
