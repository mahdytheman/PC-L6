<?php
// Connection
include('config/db_connect.php');

// Essential Variables
$errors = ["username" => "", "password" => ""];
$username = $password = "";

if (isset($_POST['login'])) {
    if (!empty($_POST['username-valid'])) {
        $username = htmlspecialchars($_POST['username']);
    }

    if (!empty($_POST['password-valid'])) {
        $password = htmlspecialchars($_POST['password']);
    }

    if ($username && $password) {
        // Check if user exists using prepared statement
        $sql = "SELECT * FROM accounts WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Retrieve the salt and hash
            $salt = $row['salt'];
            $hashedPassword = $row['password'];

            // Prepend the salt to the entered password
            $saltedPassword = $salt . $password;

            // Verify the salted password
            if (password_verify($saltedPassword, $hashedPassword)) {
                session_start();
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];

                // Regenerate session ID to mitigate session fixation
                session_regenerate_id(true);

                header('Location: index_menu.php');
                exit();
            } else {
                $errors['password'] = "Password is incorrect!";
            }
        } else {
            $errors['username'] = "Username doesn't exist!";
        }
    }
}

// Additional cleanup if needed
mysqli_close($conn);
?>
