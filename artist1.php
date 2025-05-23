<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daniel Caesar - Artist Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="songs.js"></script>
    <script src="update_song.js"></script>
    <style>@import url('https://fonts.cdnfonts.com/css/eagle-gt-ii');</style>
    <style>@import url('https://fonts.cdnfonts.com/css/trashbox');</style>
    <style>@import url('https://fonts.cdnfonts.com/css/sf-automaton');</style>
    <style>@import url('https://fonts.cdnfonts.com/css/lexend');</style>

    <link rel="stylesheet" href="artistprof.css"> 
    
    <style>
        .artist-header {
            position: relative;
            background: url('images/danielpfp.jpeg') no-repeat center/cover;
            height: 250px;  
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: bold;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.7);
        }

    </style>
</head>
<body>
    <!--navbar start-->
    <div class="topnav" id="myTopnav">
        <a class="menu" href="Menu.html">
        <img class='logo' src="images/logo2.png"></a>
        <a class="community" href="community.html">community</a>
        <a class="category" href="Categories.html">category</a>
        <a class="profile" href="profile.html">
        <img class='profile' src="images/profile5.jpeg" alt="profile"></a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
        </a>
    </div>
    <!--navbar end-->
    
    <div class="artist-header">
        <h1>Daniel Caesar</h1>
    </div>

    <div class="container text-center">

        <button class="btn btn-primary m-2">Follow</button>

        <button class="btn btn-outline-danger m-2">
            ❤️ Like <span id="likeCount">0</span>
        </button>

        <div class="container text-center mt-4">
            <h2> << Top Albums >> </h2>
        
            <div class="album-section">
                <div class="album">
                    <img src="images/album/freudian.jpg" alt="Freudian Album">
                    <p>Freudian (2017)</p>
                </div>
        
                <div class="album">
                    <img src="images/album/casestudy01.jpg" alt="Case Study 01 Album">
                    <p>Case Study 01 (2019)</p>
                </div>
        
                <div class="album">
                    <img src="images/daniel_ceasar.jpeg" alt="Never Enough Album">
                    <p>Never Enough (2023)</p>
                </div>
            </div>
        </div>

    <h2 class="mt-5">🎶 Fan's Top Pick Songs 🎶</h2>
    <div class="song-section" id="songSection">
        <?php
        require_once 'fetch_songs.php';
        ?>
    </div>

        <div class="mt-4 text-start">
            <h5>Artist's community</h5>
            <textarea class="form-control" id="commentInput" placeholder="Write a comment..."></textarea>
            <button class="btn btn-success mt-2">comment</button>
        </div>

        <div class="mt-3" id="commentSection">
<!--community section-->
            <div class="comment-box">
                <img src="images/profile3.jpeg" alt="User">
                <div class="comment-text">
                    <strong>@toetickler</strong>
                    <p>I love you!!!</p>
                </div>
            </div>
            <div class="comment-box">
                <img src="images/profile4.jpeg" alt="User">
                <div class="comment-text">
                    <strong>@elonmusksucks</strong>
                    <p>Love those album🔥</p>
                </div>
            </div>
        </div>
    </div>
<!--end of community area-->
    <footer class="footer">
        <p>&copy; 2025 S-RECCER</p>
        <img src="images/gif4.webp">
      </footer>

    <script>
        let likeCount = 0;

        function likeArtist() {
            likeCount++;
            document.getElementById("likeCount").innerText = likeCount;
        }

        function addComment() {
            let commentInput = document.getElementById("commentInput").value;
            if (commentInput.trim() !== "") {
                let commentSection = document.getElementById("commentSection");


                let commentDiv = document.createElement("div");
                commentDiv.classList.add("comment-box");


                let avatar = document.createElement("img");
                let randomNum = Math.floor(Math.random() * 70) + 1;
                avatar.src = `https://i.pravatar.cc/40?img=${randomNum}`;
                avatar.alt = "User";


                let textDiv = document.createElement("div");
                textDiv.classList.add("comment-text");


                let randomNames = ["@fan123", "@musiclover", "@danielFan", "@soulful_vibes"];
                let username = randomNames[Math.floor(Math.random() * randomNames.length)];


                textDiv.innerHTML = `<strong>${username}</strong><p>${commentInput}</p>`;

                commentDiv.appendChild(avatar);
                commentDiv.appendChild(textDiv);
                commentSection.appendChild(commentDiv);


                document.getElementById("commentInput").value = "";
            }
        }
        
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
    </script>

</body>
</html>
