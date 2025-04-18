<?php
session_start();
require 'userdb.php'; // DB connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user inputs to prevent XSS attacks
    $username = htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES, 'UTF-8');

    // Fetch user from database
    $stmt = $conn->prepare("SELECT * FROM user WHERE userName = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['userPass'])) {
            // Store user info in session
            $_SESSION['userID'] = $user['userID'];
            $_SESSION['userName'] = $user['userName'];
            $_SESSION['userEmail'] = $user['userEmail'];
            $_SESSION['userFullName'] = $user['userFullName'];
            $_SESSION['userBio'] = $user['userBio'];
            $_SESSION['ticketLeftColor'] = $user['ticketLeftColor'];
            $_SESSION['userPic'] = $user['userPic'];

            // Redirect to profile page after successful login
            header("Location: profile.php");
            exit;
        } else {
            $_SESSION['loginError'] = "Incorrect password.";
            header("Location: userpro.php"); // Redirect back to login page
            exit;
        }
    } else {
        $_SESSION['loginError'] = "User not found.";
        header("Location: userpro.php"); // Redirect back to login page
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="menustyle.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <style>@import url('https://fonts.cdnfonts.com/css/eagle-gt-ii');</style>
        <style>@import url('https://fonts.cdnfonts.com/css/trashbox');</style>
        <style>@import url('https://fonts.cdnfonts.com/css/sf-automaton');</style>
        <style>@import url('https://fonts.cdnfonts.com/css/lexend');</style>
        <link rel="stylesheet" href="userpro.css">
    </head>
    <body>        
        <div class="topnav" id="myTopnav">
        <a class="menu" href="Menu.php">
            <img class='logo' src="images/logo2.png"></a>
        <a class="sign up" href="userpro.php">SIGN IN</a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>
    </div>
    
         

    <div class="container signin">
            <h1 style="filter: invert(1);">Sign in</h1>
            <form action="userpro.php" method="post">
                <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <?php 
                    if (isset($_SESSION['loginError']) && strpos($_SESSION['loginError'], "User not found") !== false) {
                        echo "<p style='color: red;'>" . $_SESSION['loginError'] . "</p>";
                    }
                ?>
            </div>
                <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <?php 
                    if (isset($_SESSION['loginError']) && strpos($_SESSION['loginError'], "Incorrect password") !== false) {
                        echo "<p style='color: red;'>" . $_SESSION['loginError'] . "</p>";
                    }
                ?>
            </div>
                <button>Sign in</button>
                <a class="signup" href="signup.php">Don't have an account? Sign up</a>
            </form>
        </div>
            <div>
            <video autoplay muted loop id="myVideo">
                <source src="copy_73F06F1F-9320-4648-BAA0-89F3077551F4.mov" type="video/mp4">
    </div>
</body>

</html> 