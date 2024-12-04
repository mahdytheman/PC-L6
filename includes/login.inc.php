<?php
// Connection
include('config/db_connect.php');

// Essential Variables
$errors = ["username" => "", "password" => ""];
$username = $password = "";

if (isset($_POST['login'])) {
    // Check hidden inputs
    if (!empty($_POST['username-valid'])) {
        // Grab username input, prevent XSS
        $username = htmlspecialchars($_POST['username']);
    }

    if (!empty($_POST['password-valid'])) {
        // Grab password input, prevent XSS
        $password = htmlspecialchars($_POST['password']);
    }

    // Check username and password in DB
    if ($username && $password) {
        // Query to check if user exists
        $sql = "SELECT * FROM accounts WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            // User exists
            $row = mysqli_fetch_assoc($result);

            // Retrieve salt and hashed password from DB
            $storedSalt = $row['salt'];
            $storedHash = $row['password'];

            // Combine the retrieved salt with the input password
            $inputPasswordWithSalt = $storedSalt . $password;

            // Verify the combined password and salt against the stored hash
            if (password_verify($inputPasswordWithSalt, $storedHash)) {
                // Password is correct
                session_start();
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];

                // Regenerate session ID to mitigate session fixation
                session_regenerate_id(true);

                header('Location: index_menu.php');
                exit();
            } else {
                // Password doesn't match
                $errors['password'] = "Password is incorrect!";
            }
        } else {
            // Username doesn't exist
            $errors['username'] = "Username doesn't exist!";
        }
    }
}

// Additional cleanup if needed
mysqli_close($conn);
?>
