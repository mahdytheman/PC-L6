<?php
include('includes/signup.inc.php');
?>

<!DOCTYPE html>
<html lang="" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
        <link rel="stylesheet" href="assets/styles_nav.css">
        <link rel="stylesheet" href="assets/styles_signup.css">
    <head>
    <body>
        <?php include('templates/nav.php'); ?>
        <h1>Sign Up</h1>
        <form id="validate" class="" action="signup.php" method="POST">

            <input type="text" name="username" value=" <?php echo $username ?> " placeholder="Enter your Username..">
            <div class="danger"> <p><?php echo $errors['username'] ?></p> </div>
            <input type="hidden" name="username-valid" value="">
            
            <input type="email" name="email" value=" <?php echo $email ?> " placeholder="Enter your Email..">
            <div class="danger"> <p><?php echo $errors['email'] ?></p> </div>
            <input type="hidden" name="email-valid" value="">
            

            <input type="password" name="password1" value="" placeholder="Enter your Password..">
            <div class="danger"> <p> </p> </div>
            
            
            <input type="password" name="password2" value="" placeholder="Re-Type your Password..">
            <div class="danger"> <p> </p> </div>
            <input type="hidden" name="password-valid" value="">


            <input type="submit" name="signup" value="Register">

            
        </form>

    <script type="text/javascript" src="js/formValidationSignup.js"> </script>

</body>
</html>