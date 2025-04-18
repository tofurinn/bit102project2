<?php
session_start();
require 'userdb.php';

// Query the DB to get up-to-date user info
$stmt = $conn->prepare("SELECT userName, userFullName, userBio, userPic, ticketLeftColor FROM user WHERE userID = ?");
$stmt->bind_param("s", $userID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check if session variables are set
  $username = $_SESSION['userName'] ?? "Guest"; // Fallback to "Guest" if not set
  $userFullName = $_SESSION['userFullName'] ?? "Guest Full Name"; // Fallback to "Guest User" if not set
  $userBio = $_SESSION['userBio'] ?? "No bio yettt.";
  $userPic = $_SESSION['userPic'] ?? "images/profile5.jpeg"; // Fallback default image if not set
  $ticketLeftColor = $_SESSION['ticketLeftColor'] ?? "#000000"; // Fallback default color if not set
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <style>@import url('https://fonts.cdnfonts.com/css/eagle-gt-ii');</style>
        <style>@import url('https://fonts.cdnfonts.com/css/trashbox');</style>
        <style>@import url('https://fonts.cdnfonts.com/css/sf-automaton');</style>
        <style>@import url('https://fonts.cdnfonts.com/css/lexend');</style>
        <link rel="stylesheet" href="profile.css">
    </head>
    <body>
        <!--navbar start-->
        <div class="topnav" id="myTopnav">
          <a class="menu" href="Menu.html">
            <img class='logo' src="images/logo2.png"></a>
          <a class="community" href="community.html">community</a>
          <a class="category" href="Categories.html">category</a>
          <a class="profile" href="profile.php">
            <img class='profile' src=<?php echo $userPic; ?> alt="profile"></a>
          <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
          </a>
      </div>
      <!--navbar end-->

      <img class='backg' src="images/bg_gif2.gif">

      <!--ticket(userprofile) container start-->
      <div class="container userprofile">
        <div class="ticket">
            <div class="ticket-left">
                <img class='profilepic' src="<?php echo $userPic;?>" alt="Profile Picture">
                <p class="pfname">@<?php echo $username; ?></p>
            </div>
            <div class="ticket-right">
                <h1><?php echo $userFullName;?></h1>
                <div class="biotxt">
                    <p><?php echo $userBio; ?></p>
                </div>
                <div class="bottombtns">
                    <button class="frndbutton" type="button" data-bs-toggle="collapse" href="#frndsection" aria-expanded="false" aria-controls="frndsection">
                        <img src="frnd_icon-removebg-preview.png" alt="Friends button">
                    </button>
                    <button class="commsbutton" type="button" data-bs-toggle="collapse" href="#commssection" aria-expanded="false" aria-controls="commssection">
                        <img src="images/music_icon-removebg-preview.png" alt="Community button">
                    </button>
                </div>
            </div>
        </div>
      </div>
    <!--ticket container end-->

    <!--collapsable start-->
      <div class="collapse" id="frndsection">
        <div class="card card-body">
            <h3>Friends</h3>
            <div class="friendlist">
            <div class="collapsablecontent">
              <a class="facecard" href="profile2.html">
              <img src="images/profile1.jpeg" alt="User 1" class="collapsablepfp">
              </a>
              <span class="collapsablename">@yakultlover123</span>
          </div>
          <div class="collapsablecontent">
              <a class="facecard" href="profile4.html">
              <img src="images/profile2.jpeg" alt="User 2" class="collapsablepfp">
              </a>
              <span class="collapsablename">@sprayhater</span>
          </div>
          <div class="collapsablecontent">
              <a class="facecard" href="profile3.html">
              <img src="images/profile3.jpeg" alt="User 3" class="collapsablepfp">
              </a>
              <span class="collapsablename">@toetickler</span>
          </div>
          <div class="collapsablecontent">
              <a class="facecard" href="profile5.html">
              <img src="images/profile4.jpeg" alt="User 4" class="collapsablepfp">
              </a>
              <span class="collapsablename">@elonmusksucks</span>
            </div>
          </div>
          </div>
        </div>
      </div>
          <div class="collapse" id="commssection">
            <div class="card card-body">
              <h3>Communities</h3>
                <div class="commslist">
                <div class="collapsablecontent">
                    <a class="facecard" href="artist9.html">
                  <img src="images/artist1.jpg" alt="Beabadoobee" class="collapsablepfp">
                    </a>
                  <span class="collapsablename">Beabadoobee</span>
              </div>
              <div class="collapsablecontent">
                <a class="facecard" href="artist4.html">
                  <img src="images/artist2.jpg" alt="Joji" class="collapsablepfp">
                </a>
                  <span class="collapsablename">Joji</span>
              </div>
              <div class="collapsablecontent">
                <a class="facecard" href="artist2.html">
                  <img src="images/artist3.jpg" alt="Wave to earth" class="collapsablepfp">
                </a>
                  <span class="collapsablename">Wave to Earth</span>
              </div>
              <div class="collapsablecontent">
                <a class="facecard" href="artist18.html">
                  <img src="images/artist4.jpg" alt="frank Ocean" class="collapsablepfp">
                </a>
                  <span class="collapsablename">Frank Ocean</span>
              </div>
            </div>
          </div>
        </div>

    <div class="settings-btn">
      <a class="settings-btn" title="Edit Profile" data-bs-toggle="modal" data-bs-target="#profileModal">
        <img src="images/setting_icon.png" alt="Settings">
      </a>
    </div>

  <!--settings button function-->
  <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="profileModalLabel">Edit Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
      <form action="updateprofile.php" method="POST" enctype="multipart/form-data"><!--sends data to updateprofile.php-->

        <div class="mb-3">
            <label for="bgcolor" class="form-label">Ticket Background Color</label>
            <input class="form-control form-control-color" type="color" name="bgcolor" id="bgcolor" value="<?php echo $ticketLeftColor; ?>">
          </div><hr>

        <div class="mb-3">
            <label for="userPic" class="form-label">Profile Picture</label>
            <input class="form-control" type="file" name="userPic" id="userPic" accept="image/*">
          </div><hr>
          
        <div class="mb-3">
            <label for="userFullName" class="form-label">Full Name</label>
            <input type="text" class="form-control" name="userFullName" value="<?php echo $userFullName; ?>" id="userFullName">
          </div><hr>
          
        <div class="mb-3">
            <label for="userBio" class="form-label">Profile Bio</label>
            <textarea class="form-control" name="userBio" id="userBio"><?php echo $userBio; ?></textarea>
          </div><hr>

          <button type="submit" class="btn btn-primary w-100">Save Changes</button>
        </form><hr>

        <form action="logout.php" method="POST">
          <button type="submit" class="btn btn-danger w-100">Log Out</button>
        </form>

        <form action="deleteacc.php" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.');">
          <button type="submit" name="delete" class="btn btn-danger w-100">Delete Account</button>
        </form>
      </div>
    </div>
  </div>
</div>


</body>

    <!--footer here-->
    <footer class="footer">
      <p>&copy; 2025 S-RECCER</p>
      <img src="images/gif4.webp">
    </footer>
    <!--footer end-->
    <script src="" async defer></script>
    <script>
          function myFunction() {
            var x = document.getElementById("myTopnav");
            if (x.className === "topnav") {
              x.className += " responsive";
            } else {
              x.className = "topnav";
            }
          }
          
    </script>


</html>
<style>
  .ticket-left {
    background-color: <?php echo $ticketLeftColor ?? 'hsl(0, 0%, 0%)'; ?>;
  }
</style>


    