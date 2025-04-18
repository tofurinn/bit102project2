<?php
    session_start(); // Start the session
    require 'userdb.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form values
    //removed pic,bio and fullname null
    $userID = uniqid();
    $userName = $_POST['username'] ?? '';
    $userPhone = $_POST['phonenumber'] ?? '';
    $password = $_POST['password'] ?? '';
    $userEmail = $_POST['email'] ?? '';
    $password2 = $_POST['password2'] ?? '';

if ($password !== $password2) {
    echo "Passwords do not match.";
    exit;
}

    // Hash the password into 13 characters
    $userPass = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Prepare & bind
    $stmt = $conn->prepare("INSERT INTO user (userID, userName, userEmail, userPhone, userPass) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss",$userID, $userName, $userEmail, $userPhone, $userPass);

    if ($stmt->execute()) {
        //Store info in session
        $_SESSION['userID'] = $userID;
        $_SESSION['userName'] = $userName;
        $_SESSION['userEmail'] = $userEmail;
        header("Location: Menu.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
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
          
    <div class="container signup">
            <h1 style="filter: invert(1);">Sign up</h1>
            <form action="signup.php" method="post">
                <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
                <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required>
            </div>
                <div class="form-group">
                <label for="phonenumber">Phone Number:</label>
                <input type="text" id="phonenumber" name="phonenumber" required>
            </div>
                <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password2">Re-enter Password:</label>
                <input type="password" id="password2" name="password2" required>
            </div>
                <button type="submit">Sign up</button>
            </form>
        </div>
        <div>
            <video autoplay muted loop id="myVideo">
                <source src="copy_73F06F1F-9320-4648-BAA0-89F3077551F4.mov" type="video/mp4">
    </div>
</body>



</html> 