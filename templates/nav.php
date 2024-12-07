 <?php
session_start() ;

$current_username = $current_email = "" ;

if (isset($_SESSION['username'])) {
  if (!empty($_SESSION['username'])) {
    $current_username = $_SESSION['username'];
    $current_email = $_SESSION['email'];
  } else {
    $current_username = $current_email = "" ;

  }
  
}


?>
 <nav>
    <ul class="nav-ul">
      <!-- only if logged in was admin -->
      <?php if ($current_username == "admin"){ ?>
      <li> <a href="index.php"> Admin </a> </li>
      <?php } else{ ?>
      <li> <a href="index_menu.php"> Menus </a> </li>
      <?php } ?>
      <li> <a href="add.php"> Add Pizza </a> </li>
      <li> <a class="logo"> PizzaStore </a> </li>

      <!-- if normal user / admin -->
      <?php if ($current_username) { ?>
      <li> <a href="search.php"> Search </a> </li>
      <li> <a href="reservations.php"> Reservations </a> </li>
      <li> <a href="includes/logout.inc.php"> Logout </a> </li>
      <?php } else { ?>
        <li> <a href="signup.php"> Sign Up </a> </li>
      <li> <a href="login.php"> Log In </a> </li>
      <?php  } ?>
    </ul>
   </nav>