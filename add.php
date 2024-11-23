<!-- add.php -->
<?php
include("includes/add.inc.php");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="assets/styles_nav.css">
    <link rel="stylesheet" href="assets/styles_add.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
    <style media="screen">
      .readonly-class {
        background-color: rgb(224, 224, 224);
      }
    </style>
  </head>
  <body>
    <?php include "templates/nav.php" ?>

    <h1> Order Pizza </h1>

    <form id="form" action="add.php" method="post">

      <input id="inputT" type="text" name="title" value="" placeholder="Enter pizza title..">
      <div class="danger"> <p> <?php echo $err_title ?> </p> </div>

      <i id="icon" class="fas fa-exclamation-circle hide-icon" title="Email Already exists"> </i>
      <input class="readonly-class" id="inputE" type="text" name="email" value="<?php echo htmlspecialchars($current_email) ?>" placeholder="Enter your email.." readonly>
      <div class="danger"> <p id="p_email"> <?php echo $err_email ?> </p> </div>

      <input id="inputI" type="text" name="ingredients" value="" placeholder="Enter ingredients..">
      <div class="danger"> <p> <?php echo $err_ingredients ?> </p> </div>

      <input type="submit" name="submit" value="Submit">
    </form>

    <?php if ($title_valid && $email_valid && $ingredients_valid) { ?>
      <div class ='working'> Your Pizza has been added <br> Redirecting you to the Home page now ... </div>
    <?php } ?>

    <script src="js/add.js"></script>

  </body>
</html>
