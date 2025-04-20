<?php
session_start();
$host = "localhost";
$user = "root"; // Default user in AMPPS
$password = "mysql"; // Default password in AMPPS
$database = "sreccer";
// Create connection
$conn = new mysqli($host, $user, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

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
    </head>
    <body>
        <!--navbar start-->
        <div class="topnav" id="myTopnav">
            <a class="menu" href="Menu.php">
                <img class='logo' src="images/logo2.png"></a>
            <a class="community" href="community.php">community</a>
            <a class="category" href="Categories.html">category</a>
            <a class="profile" href="profile.php">
                <img class='profile' src="<?php echo isset($_SESSION['userPic']) ? htmlspecialchars($_SESSION['userPic']) : 'images/default-profile.png'; ?>" alt="profile" onerror="this.src='images/default-profile.png'"></a>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </a>
        </div>    <!--navbar end-->
        <div class="div1" style="background-image:url('images/menu1.gif');">
            <img src="images/logo2.png" alt="logo">
            <p>Welcome to S-RECCER!<br>Share your love through music</p>
        </div>
        </div>
        <h2>COMMUNITY FAVORITE ALBUMS</h2>
        <div>
            <div class="topAlbum">
                <img id="image" src="images/1.jpg" height="300px" width="300px" 
                style="background-color: white;">
                <div class="overlay">
                    <div class="left">
                        <button onclick="left ()" , style="
                            padding: 0;
                            background: none;
                            border: none;">
                            <img src="images/left.png" width="100">
                        </button>
                    </div>
                    <div class="right">
                        <button onclick="right ()" , style="
                        padding: 0;
                        background: none;
                        border: none;">
                            <img src="images/right.png"width="100">
                        </button>
                    </div>
                </div>
            </div>

            <div class="imgnavbar" style="width: 100;">    
                    <div class="fotorama" role="button" onclick="imgChange1()">
                        <img src="images/1.jpg" style="width: 80px;">
                    </div>
                    <div class="fotorama" role="button" onclick="imgChange2()">
                        <img src="images/2.jpg" style="width: 80px;">
                    </div>
                    <div class="fotorama" role="button" onclick="imgChange3()">
                        <img src="images/3.jpg" style="width: 80px;">
                    </div>
                    <div class="fotorama" role="button" onclick="imgChange4()">
                        <img src="images/4.jpg" style="width: 80px;">
                    </div>
            </div>
            <figcaption id="ImgCapt" style="color: white;">Gabriel - Keshi</figcaption>

            <script>
                function myFunction() {
                    var x = document.getElementById("myTopnav");
                    if (x.className === "topnav") {
                        x.className += " responsive";
                    } else {
                        x.className = "topnav";
                    }
                    var x = document.getElementById("mySearchBar");
                    if (x.className === "searchbar") {
                        x.className += " responsive";
                    } else {
                        x.className = "searchbar";
                    }
                }
                    function toggleSearchbar() {
                    var searchbar = document.querySelector('mySearchBar');
                    if (searchbar.style.display === 'none') {
                        searchbar.style.display = 'block';
                    } else {
                        searchbar.style.display = 'none';
                        }
                }
                let image = ["images/1.jpg","images/2.jpg", "images/3.jpg","images/4.jpg"];
                let ImgCapt = ["Gabriel - Keshi", "Nectar - Joji", "Summer Flows 0.02", "Blue - Yung Kai"];
                let index = 0;
                function right() {
                    index = (index + 1) % image.length;
                    document.getElementById("image").src = image[index];
                    document.getElementById("ImgCapt").textContent = ImgCapt[index];
                }
                function left() {
                    index = (index - 1 + image.length) % image.length;
                    document.getElementById("image").src = image[index];
                    document.getElementById("ImgCapt").textContent = ImgCapt[index];}
    
                function imgChange1() {
                    index = 0;
                    document.getElementById("image").src = image[index];
                    document.getElementById("ImgCapt").textContent = ImgCapt[index];
                }
                
                function imgChange2() {
                    index = 1;
                    document.getElementById("image").src = image[index];
                    document.getElementById("ImgCapt").textContent = ImgCapt[index];
                }
                function imgChange3() {
                    index = 2;
                    document.getElementById("image").src = image[index];
                    document.getElementById("ImgCapt").textContent = ImgCapt[index];
                }
                function imgChange4() {
                    index = 3;
                    document.getElementById("image").src = image[index];
                    document.getElementById("ImgCapt").textContent = ImgCapt[index];
                }
            </script>
        </div>
        <div class="div2">
            <h1>ABOUT US</h1>
            <p>Our website is a platform for music lovers to share their favorite albums and songs. We aim to create a community where people can share their love for music and discover new artists. Join us and be part of the S-RECCER community!</p>
        </div>
        <script src="" async defer></script>
        <!--footer here-->
        <footer class="footer">
            <p>&copy; 2025 S-RECCER</p>
            <img src="images/gif4.webp">
          </footer>
        <!--footer end-->
    </body>
</html> 