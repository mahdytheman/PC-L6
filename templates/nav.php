<?php
// Start session if not already started
session_start();

// Initialize session variables
$current_username = $_SESSION['username'] ?? null;
$current_email = $_SESSION['email'] ?? null;
?>
<nav>
    <ul class="nav-ul">
        <!-- Show admin options if logged in as admin -->
        <?php if ($current_username === "admin") { ?>
            <li><a href="index.php">Admin</a></li>
        <?php } else { ?>
            <li><a href="index_menu.php">Menus</a></li>
        <?php } ?>
        <li><a href="add.php">Add Pizza</a></li>
        <li><a class="logo">PizzaStore</a></li>

        <!-- Options for logged-in users -->
        <?php if ($current_username) { ?>
            <li><a href="search.php">Search</a></li>
            <li><a href="includes/logout.inc.php">Logout</a></li>
        <?php } else { ?>
            <!-- Options for guests -->
            <li><a href="signup.php">Sign Up</a></li>
            <li><a href="login.php">Log In</a></li>
        <?php } ?>
    </ul>
</nav>
