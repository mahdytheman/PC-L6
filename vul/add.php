<?php

// Any page that requires CRUD --> connnect to db 

require "config/db_connect.php" ; 

// ("C" from CRUD) CREATE -> INSERT INTO

// ========================= PHP (Backend) Validation ========================


// ======================= Variable def =====================
$title = $email = $ingredients = ""; 
$err_title = $err_email = $err_ingredients = "" ;
// flags
$title_valid = $email_valid = $ingredients_valid = false; 



if (isset($_POST['submit']) ){ // is submit button clicked?



// title 
// ========================= Layer 1: Emptyness check =======================
if( empty($_POST['title']) ){
  // failure
  $err_title = "This field should not be left empty!" ; 
  
} else {
  // succcess: not empty? 
  // grab the value 
  // preventing XSS 
  $title = $_POST['title'];
  // ============================= (optional) Layer2: No numbers are allowed ====================
  if( strpbrk($title, "0123456789") ){
    // failure 
    $err_title = "Only Alphapets are allowed!" ; 
  }else {
  //success 
  // set the flag to true 
      $title_valid = true; 
}
}


// email 
// ========================= Layer 1: Emptyness check =======================
if (empty($_POST['email'])){
  // fail
    $err_email = "This field should not be left empty!" ;


  } else {
    // succces : not empty
    // grab the value 
    $email = $_POST['email'];
    // ========================= Layer 2: Email validity =======================
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // enum: SUNDAY->1, MONDAY->2, TUESDAY->3
      // fail
      $err_email = "INVALID EMAIL!";
    } else {
      // success: email valid? 
      // ========================= Layer 3:  uniqness check =======================
      // READ -->  
      $q = "SELECT * FROM pizza WHERE email = '$email' ";

      $result = mysqli_query($conn, $q);

      if (mysqli_num_rows($result) > 0) {
        // fail 
        $err_email = "EMAIL ALREADY EXISTS!";

      } else {
        // success: set flag to true 
        $email_valid = true;
      }

    }
  }
      
// ingreds
// ========================= Layer 1: Emptyness check =======================

if(empty($_POST['ingredients'])){
  //fail
  $err_ingredients = "This should not be left empty"; 
  
} else {
  //success: not empty?
  // XSS
  $ingredients = $_POST['ingredients'] ; 
  // ============================== (optional) Layer 2: 3 comma sep values  ============================== 
  if ( !substr_count($ingredients, ",") == 2 ) {
    // fail
    $err_ingredients = "Only 3 values are allowed!"; 
  }else {
    // success: set flag to true 
        $ingredients_valid = true;  


  }
}

    //========================== insert into ==================
    if($title_valid && $email_valid && $ingredients_valid){
        $query = "INSERT INTO pizza (title, email, ingredients) VALUES ( '$title', '$email', '$ingredients' )"; 
        if (mysqli_query($conn, $query)){
          // success 
          // header('location: index.php '); 
        } else {
          // failure 
          echo "ERROR: " . mysqli_error($conn) . "<br>";  
        }
    }


}



 ?>

 
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title></title>
     <link rel="stylesheet" href="assets/styles_nav.css">
     <link rel="stylesheet" href="assets/styles_add.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">

   </head>
   <body>

      <?php include "templates/nav.php"  ?>



   <h1> Add Pizza </h1>

   <form id="form"  action="add.php" method="post">

      <input id="inputT" type="text" name="title" value="" placeholder="Enter pizza title.." >
      <div class="danger" >   <p>  <?php echo $err_title  ?>  </p> </div>
      
      
      <i id="icon" class="fas fa-exclamation-circle hide-icon" title="Email Already exists"> </i>
      <input id="inputE" type="text" name="email" value="" placeholder="Enter your email.." >
      <div class="danger" >   <p id="p_email">  <?php echo $err_email  ?>  </p> </div>
      
      
      <input id="inputI" type="text" name="ingredients" value="" placeholder="Enter ingredients..">
      <div class="danger" >   <p>  <?php echo $err_ingredients  ?>  </p> </div>


      <input type="submit" name="submit" value="Submit">
     </form>


     <?php if ($title_valid && $email_valid && $ingredients_valid) { ?>
      <div class ='working'> Your Pizza has been added <br> Redirecting you to Home page now ... </div>

      <?php } ?>





  <script src="js/add.js" ></script>





   </body>
 </html>
