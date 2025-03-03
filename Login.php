<?php
require "database.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
//Going to find the unknown username on the database
    if (!empty($username) && !empty($password)) {
        $sql = "SELECT id, password FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username); //bind the variable let the database find for you
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();

            // Debugging: Check retrieved password hash
           // echo "Stored Hash: " . $hashed_password . "<br>";
           // echo "login password: ". $password."<br>";

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                echo "Login Successfully";
                header("Location: /BANK/dashboard.php");
                exit();
            } else {
                echo "Invalid password!";
            }
        } else {
            echo "User not found!";
        }

        $stmt->close();
    } else {
        echo "Please enter both username and password.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
</head>
<body>
    <h2>User Login</h2>
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" required><br><br>
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
