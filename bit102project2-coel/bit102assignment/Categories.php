<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="categoriestyle.css">
        <style>@import url('https://fonts.cdnfonts.com/css/eagle-gt-ii');</style>
        <style>@import url('https://fonts.cdnfonts.com/css/trashbox');</style>
        <style>@import url('https://fonts.cdnfonts.com/css/sf-automaton');</style>
    </head>
    <body>
        <ul>
            <li><a class="menu" href="Menu.php">
                <img class='logo' src="images/logo1.png"></a></li>
            <li><a href="#news">about us</a></li>
            <li><a href="#search">
                <img class='search' src="images/search.png"></a></li>
                <li id= 'searchbar'><input type="text" placeholder="Search Artist...">
            <li style="float:right"><a class="profile" href="profile.php">
                <img class='profile' src="<?php echo isset($_SESSION['userPic']) ? htmlspecialchars($_SESSION['userPic']) : 'images/default-profile.png'; ?>" alt="Profile Picture" onerror="this.src='images/default-profile.png'"></a></li>
          </ul>
// ... rest of the existing HTML code ... 