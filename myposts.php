<?php
session_start();
require_once 'userdb.php';

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['userID'];

// Fetch user's posts
$sql = "SELECT p.*, u.userName, u.userPic 
        FROM post p 
        JOIN user u ON p.USER_userID = u.userID 
        WHERE p.USER_userID = ? 
        ORDER BY p.postDateTime DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>My Posts</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="communitystyle.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                <img class='profile' src="<?php echo isset($_SESSION['userPic']) ? htmlspecialchars($_SESSION['userPic']) : 'images/default-profile.png'; ?>" alt="Profile Picture" onerror="this.src='images/default-profile.png'"></a>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </a>
        </div>
        <!--navbar end-->
        
        <div class="header">
            <video autoplay muted loop playsinline>
                <source src="exploreheader.mov" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="textoverlay">
                <h1>MY POSTS</h1>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-12 position-sticky">
                    <a class="btn btn-warning w-100" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">+ create post</a>
                    <div class="joined">
                        <ul>
                            <a href="javascript:void(0);" class="text" onclick="myJoinedList()">
                                <li class="title">Joined Communities</li>
                                <div id="myJoinedList">
                                    <li>
                                        <a href="artist9.html" class="community-item">
                                            <img class='artistpic' src="images/artist1.jpg" alt="Beabadoobee">
                                            <span>Beabadoobee</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="artist2.html" class="community-item">
                                            <img class='artistpic' src="images/artist3.jpg" alt="Wave To Earth">
                                            <span>Wave to Earth</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="artist4.html" class="community-item">
                                            <img class='artistpic' src="images/artist2.jpg" alt="Joji">
                                            <span>Joji</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="artist18.html" class="community-item">
                                            <img class='artistpic' src="images/artist4.jpg" alt="Frank Ocean">
                                            <span>Frank Ocean</span>
                                        </a>
                                    </li>
                                </div>
                            </a>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-8 col-12">
                    <div class="explorenav">
                        <ul class="explorenav">
                            <li><a class="" id="communityLink" href="community.php" >COMMUNITY</a></li>
                            <li><a class="" id="myPostsLink" href="myposts.php">MY POSTS</a></li>
                        </ul>
                    </div>
                    
                    <div class="collapse multi-collapse" id="multiCollapseExample1">
                        <div class="explore">
                            <div class="profile-picture">
                                <img src="<?php echo isset($_SESSION['userPic']) ? htmlspecialchars($_SESSION['userPic']) : 'images/default-profile.png'; ?>" alt="Profile Picture" onerror="this.src='images/default-profile.png'">
                            </div>
                            <div class="post-content">
                                <h4 class="username"><a href="#profile">@<?php echo isset($_SESSION['userName']) ? htmlspecialchars($_SESSION['userName']) : 'Guest'; ?></a></h4>
                                <form id="create-post-form">
                                    <input type="text" name="title" placeholder="post title?" required>
                                    <input type="text" name="content" placeholder="share your thoughts ⋆ ★" required>
                                    <input type="submit" value="post">
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div id="posts-container">
                        <?php
                        if ($result->num_rows > 0) {
                            while ($post = $result->fetch_assoc()) {
                                ?>
                                <div class="explore" data-post-id="<?php echo htmlspecialchars($post["postID"]); ?>">
                                    <div class="profile-picture">
                                        <img src="<?php echo empty($post["userPic"]) ? 'images/default-profile.png' : htmlspecialchars($post["userPic"]); ?>" alt="Profile Picture" onerror="this.src='images/default-profile.png'">
                                    </div>
                                    <div class="post-content">
                                        <h4 class="username">
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                                <a href="#profile">@<?php echo htmlspecialchars($post["userName"]); ?></a>
                                                <div class="actions">
                                                    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item edit-post" href="#" data-post-id="<?php echo htmlspecialchars($post["postID"]); ?>">Edit</a></li>
                                                        <li><a class="dropdown-item delete-post" href="#" data-post-id="<?php echo htmlspecialchars($post["postID"]); ?>">Delete</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </h4>
                                        <h5 class="post-title"><?php echo htmlspecialchars($post["postTitle"]); ?></h5>
                                        <p class="post-text"><?php echo nl2br(htmlspecialchars($post["postContent"])); ?></p>
                                        <div class="comment">
                                            <div class="collapse multi-collapse" id="multiCollapseExample<?php echo substr($post["postID"], 1); ?>">
                                                <form class="comment-form">
                                                    <input type="text" name="comment" placeholder="comment nice stuff please ♫">
                                                    <input type="hidden" name="post_id" value="<?php echo $post["postID"]; ?>">
                                                    <input type="hidden" id="profilePicture" value="<?php echo isset($_SESSION["userPic"]) ? $_SESSION["userPic"] : ''; ?>">
                                                    <input type="hidden" id="username" value="<?php echo isset($_SESSION["userName"]) ? $_SESSION["userName"] : ''; ?>">
                                                    <input type="submit" value="post">
                                                </form>
                                                <div id="comments">
                                                    <?php
                                                    // Fetch comments for this post
                                                    $comment_sql = "SELECT c.*, u.userName, u.userPic 
                                                                  FROM comment c 
                                                                  JOIN user u ON c.USER_userID = u.userID 
                                                                  WHERE c.POST_postID = ? 
                                                                  ORDER BY c.commentID ASC";
                                                    $comment_stmt = $conn->prepare($comment_sql);
                                                    $comment_stmt->bind_param("s", $post["postID"]);
                                                    $comment_stmt->execute();
                                                    $comments = $comment_stmt->get_result();

                                                    if ($comments->num_rows > 0) {
                                                        while ($row = $comments->fetch_assoc()) {
                                                            echo '<div class="comment" data-comment-id="' . $row['commentID'] . '">';
                                                            echo '  <div class="comment-row">';
                                                            echo '    <img src="' . (empty($row["userPic"]) ? 'images/default-profile.png' : htmlspecialchars($row["userPic"])) . '" alt="Profile Picture" onerror="this.src=\'images/default-profile.png\'">';
                                                            echo '    <div class="comment-content">';
                                                            echo '      <div class="comment-header">';
                                                            echo '        <h4>@' . htmlspecialchars($row["userName"]) . '</h4>';
                                                            
                                                            if (isset($_SESSION['userID']) && $row["USER_userID"] === $_SESSION['userID']) {
                                                                echo '        <div class="actions">';
                                                                echo '          <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>';
                                                                echo '          <ul class="dropdown-menu">';
                                                                echo '            <li><a class="dropdown-item edit-comment" href="#">Edit</a></li>';
                                                                echo '            <li><a class="dropdown-item delete-comment" href="#">Delete</a></li>';
                                                                echo '          </ul>';
                                                                echo '        </div>';
                                                            }
                                                            
                                                            echo '      </div>';
                                                            echo '      <p class="comment-text">' . htmlspecialchars($row["commContent"]) . '</p>';
                                                            echo '    </div>';
                                                            echo '  </div>';
                                                            echo '</div>';
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <a class="btn btn-warning comment-toggle" data-bs-toggle="collapse" href="#multiCollapseExample<?php echo substr($post["postID"], 1); ?>" role="button" aria-expanded="false" aria-controls="multiCollapseExample<?php echo substr($post["postID"], 1); ?>">comment</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<div class="no-posts">oh no! you don\'t have any posts yet! <a href="community.php">create your first post!★ </a></div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
            <p>&copy; 2025 S-RECCER</p>
            <img src="images/gif4.webp">
        </footer>

        <script>
            function myFunction() {
                var x = document.getElementById("myTopnav");
                if (x.className === "topnav") {
                    x.className += " responsive";
                } else {
                    x.className = "topnav";
                }
            }

            // Handle comment form submission
            $(document).on('submit', '.comment-form', function(e) {
                e.preventDefault();
                var $form = $(this);
                var comment = $form.find('input[name="comment"]').val().trim();
                var post_id = $form.find('input[name="post_id"]').val();

                if (!comment) {
                    alert('Please enter something!');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: 'comment.php',
                    data: { comment: comment, post_id: post_id },
                    success: function(data) {
                        $form.closest('.comment').find('#comments').html(data);
                        $form.find('input[name="comment"]').val('');
                    }
                });
            });

            // Handle post deletion
            $(document).on('click', '.delete-post', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to delete this post?')) {
                    var $post = $(this).closest('.explore');
                    var postId = $post.data('post-id');
                    
                    $.ajax({
                        url: 'delete_post.php',
                        method: 'POST',
                        data: { post_id: postId },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                $post.fadeOut(function() {
                                    $(this).remove();
                                });
                            } else {
                                alert('Error: ' + (response.message || 'Unknown error'));
                            }
                        }
                    });
                }
            });

            // Handle post editing
            $(document).on('click', '.edit-post', function(e) {
                e.preventDefault();
                var $post = $(this).closest('.explore');
                var $title = $post.find('.post-title');
                var $content = $post.find('.post-text');
                var currentTitle = $title.text().trim();
                var currentContent = $content.text().trim();
                
                $title.html('<input type="text" class="edit-post-title" value="' + currentTitle + '">');
                $content.html('<textarea class="edit-post-content">' + currentContent + '</textarea>');
                
                if ($post.find('.save-post-edit').length === 0) {
                    $content.after('<button class="save-post-edit">save</button>');
                }
            });

            // Handle post edit save
            $(document).on('click', '.save-post-edit', function(e) {
                e.preventDefault();
                const $post = $(this).closest('.explore');
                const postId = $post.data('post-id');
                const newTitle = $post.find('.edit-post-title').val().trim();
                const newContent = $post.find('.edit-post-content').val().trim();

                if (!newTitle || !newContent) {
                    alert('Please fill in both title and content.');
                    return;
                }

                $.ajax({
                    url: 'edit_post.php',
                    type: 'POST',
                    data: {
                        postId: postId,
                        title: newTitle,
                        content: newContent
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            const formattedContent = newContent.replace(/\n/g, '<br>');
                            $post.find('.post-title').text(newTitle).show();
                            $post.find('.post-text').html(formattedContent).show();
                            $post.find('.edit-post-title, .edit-post-content').remove();
                            $post.find('.save-post-edit').remove();
                            $post.find('.edit-post').show();
                        } else {
                            alert(response.message || 'Error updating post');
                        }
                    }
                });
            });
        </script>
    </body>
</html>
