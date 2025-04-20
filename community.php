<?php
session_start();
require 'userdb.php';

if (isset($_SESSION['comments'])) {
  echo $_SESSION['comments'];
  unset($_SESSION['comments']);
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
        <link rel="stylesheet" href="communitystyle.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style>@import url('https://fonts.cdnfonts.com/css/eagle-gt-ii');</style>
        <style>@import url('https://fonts.cdnfonts.com/css/trashbox');</style>
        <style>@import url('https://fonts.cdnfonts.com/css/sf-automaton');</style>
        <style>@import url('https://fonts.cdnfonts.com/css/lexend');</style>
        <style>
            .comment-form {
            display: flexbox;
            flex-direction: column;
            align-items: flex-start;
            padding: 0px;
          }

          .comment-form input[type="text"] {
            width: 100%;
            padding: 10px;
            font-family: 'Lexend', sans-serif;
            font-size: 16px;
            border: 2px solid rgba(0, 27, 232, 0.302);
            border-radius: 5px;
            margin-top: 10px;
            margin-bottom: 10px;
          }

          .comment-form input[type="submit"] {
            font-family: 'SF automaton', sans-serif;
            background-color: hsl(334, 100%, 81%);
            border: 2px solid #ff8fb6;
            font-size: 13px;
            letter-spacing: 2px;
            width: 115px;
            color: #fff;
            padding: 3px 10px;
            margin-right: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            cursor: pointer;
          }

          .comment-form input[type="submit"]:hover {
            background-color: rgb(44, 254, 244);
            border: 2px solid hsl(173, 100%, 66%);
          }
          
          /* Comments section container */
          #comments {
            margin-top: 15px;
            padding-top: 15px;
          }
          
          .comment {
            display: flexbox;
            width: 100%;
            align-items: flex-start;
            padding: 8px 0;
            margin: 0;
          }

          .comment-row {
            display: flex;
            align-items: flex-start;
            width: 100%;
          }

          .comment-row img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-right: 10px;
          }
          
          .comment-content {
            flex: 1;
            margin-top: 2px;
          }

          .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin-bottom: 4px;
          }

          .comment h4 {
            color: black;
            font-family: 'lexend', sans-serif;
            font-weight: bold;
            font-size: 14px;
            text-decoration: none;
            margin: 0;
          }

          .comment p {
            font-family: 'Lexend', sans-serif;
            font-size: 14px;
            margin: 0;
            line-height: 1.4;
          }

          .comment .actions {
            display: flex;
            justify-content: flex-end;
            margin: 0;
          }

          .comment button.dropdown-toggle {
            background-color: transparent;
            border: 1px solid #ddd;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            padding: 0;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
          }
          
          .comment button.dropdown-toggle::after {
            display: none;
          }

          .comment .actions button:hover {
            background-color: #f5f5f5;
            border-color: #ccc;
          }
          
          .comment .actions button::before {
            content: "⋯";
            font-size: 16px;
            line-height: 1;
          }

          .edit-comment-input {
            width: 100%;
            padding: 8px;
            font-family: 'Lexend', sans-serif;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin: 4px 0;
            resize: vertical;
          }
      </style>
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
            <h1>EXPLORE COMMUNITY</h1>
          </div>
        </div>
        <!--explore start-->
        <div class="container">
          <div class="row">
            <div class="col-md-4 col-12 position-sticky">
              <a class="btn btn-warning w-100" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">+ create post</a>
                <div class="joined">
                  <ul>
                    <a href="javascript:void(0);" class="text" onclick="myJoinedList()">
                      <li class="title">Joined Communities</li>
                        <div id = "myJoinedList" >
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
                </ul>
                </div>
              </div>
              <div class="col-md-8 col-12">
                <div class="explorenav">
                  <ul class="explorenav">
                    <li><a class="" id="communityLink" href="community.php" style= "color: #ffdd00;">COMMUNITY</a></li>
                    <li><a class="" id="myPostsLink" href="myposts.php">MY POSTS</a></li>
                  </ul>
                </div>
                <div class="search-container">
                  <input type="text" id="postSearch" class="search-input" placeholder="Search posts by title...">
                  <button class="search-button">
                    <i class="fa fa-search"></i>
                  </button>
                </div>
                <div class="collapse multi-collapse" id="multiCollapseExample1">
                  <div class="explore">
                    <div class="profile-picture">
                      <img src="<?php echo isset($_SESSION['userPic']) ? htmlspecialchars($_SESSION['userPic']) : 'images/default-profile.png'; ?>" alt="Profile Picture" onerror="this.src='images/default-profile.png'">
                    </div>
                    <div class="post-content">
                      <h4 class="username"><a href="#profile"><?php echo isset($_SESSION['userName']) ? '@' . htmlspecialchars($_SESSION['userName']) : 'Guest'; ?></a></h4>
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
                    // Fetch all posts
                    $sql = "SELECT p.*, u.userName, u.userPic 
                           FROM post p 
                           JOIN user u ON p.USER_userID = u.userID 
                           ORDER BY p.postDateTime DESC";
                    $result = $conn->query($sql);

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
                                            <?php if (isset($_SESSION['userID']) && $post["USER_userID"] === $_SESSION['userID']) : ?>
                                                <div class="actions">
                                                    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item edit-post" href="#" data-post-id="<?php echo htmlspecialchars($post["postID"]); ?>">Edit</a></li>
                                                        <li><a class="dropdown-item delete-post" href="#" data-post-id="<?php echo htmlspecialchars($post["postID"]); ?>">Delete</a></li>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>
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
                                                $stmt = $conn->prepare($comment_sql);
                                                $stmt->bind_param("s", $post["postID"]);
                                                $stmt->execute();
                                                $comments = $stmt->get_result();

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
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          <!--footer here-->
          <footer class="footer">
            <p>&copy; 2025 S-RECCER</p>
            <img src="images/gif4.webp">
          </footer>
          <!--footer end-->
        <script>
            function myFunction() {
                var x = document.getElementById("myTopnav");
                if (x.className === "topnav") {
                    x.className += " responsive";
                } else {
                    x.className = "topnav";
                }
              }
          
              function myJoinedList() {
                var x = document.getElementById("myJoinedList");
                if (window.matchMedia("(max-width: 767px)").matches) {
                  x.classList.toggle("hidden");
                    if (x.style.display === "block") {
                        x.style.display = "none";
                    } else {
                        x.style.display = "none";
                    }
                } else {
                    if (x.style.display === "block") {
                        x.style.display = "none";
                    } else {
                        x.style.display = "block";
                    }
                }
              }
          
              $(document).ready(function() {
                // Add comment button toggle functionality
                $('.comment-toggle').on('click', function() {
                    var $this = $(this);
                    var $target = $($this.attr('href'));
                    
                    // Check if the collapse is currently shown
                    if ($target.hasClass('show')) {
                        $this.text('comment');
                    } else {
                        $this.text('hide');
                    }
                });

                // Handle comment form submission
                $(document).on('submit', '.comment-form', function(e) {
                e.preventDefault();
                var $form = $(this);
                    var comment = $form.find('input[name="comment"]').val().trim();
                var post_id = $form.find('input[name="post_id"]').val();

                    // Check if comment is empty or only whitespace
                    if (!comment) {
                        alert('please enter something!');
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

                // Handle comment deletion
                $(document).on('click', '.delete-comment', function(e) {
                    e.preventDefault();
                    if (confirm('Are you sure you want to delete this comment?')) {
                        var $comment = $(this).closest('.comment');
                        var comment_id = $comment.data('comment-id');
                        
                        $.ajax({
                            type: 'POST',
                            url: 'update_comment.php',
                            data: { 
                                action: 'delete',
                                comment_id: comment_id
                            },
                            success: function() {
                                $comment.remove();
                            }
                        });
                    }
                });

                // Handle comment editing
                $(document).on('click', '.edit-comment', function(e) {
                    e.preventDefault();
                    var $comment = $(this).closest('.comment');
                    var $text = $comment.find('.comment-text');
                    var currentText = $text.text().trim();
                    
                    // Replace text with input field
                    $text.replaceWith('<textarea class="edit-comment-input">' + currentText + '</textarea>');
                    
                    // Add save button if it doesn't exist
                    if ($comment.find('.save-comment-edit').length === 0) {
                        $comment.find('.edit-comment-input').after('<button class="save-comment-edit">save</button>');
                    }

                    // Focus on the input
                    $comment.find('.edit-comment-input').focus();
                });

                // Handle clicking outside of edit fields to cancel
                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.edit-post-title, .edit-post-content, .save-post-edit, .edit-comment-input, .save-comment-edit, .edit-post, .edit-comment').length) {
                        // Restore post title and content if clicked outside
                        $('.edit-post-title').each(function() {
                            var $input = $(this);
                            var $title = $input.parent();
                            $title.html($input.val());
                        });
                        
                        $('.edit-post-content').each(function() {
                            var $textarea = $(this);
                            var $content = $textarea.parent();
                            $content.html($textarea.val());
                        });
                        
                        // Restore comment text if clicked outside
                        $('.edit-comment-input').each(function() {
                            var $input = $(this);
                            var currentText = $input.val();
                            $input.replaceWith('<p class="comment-text">' + currentText + '</p>');
                        });
                        
                        // Remove save buttons
                        $('.save-post-edit, .save-comment-edit').remove();
                    }
                });

                // Handle comment edit save
                $(document).on('click', '.save-comment-edit', function(e) {
                    e.preventDefault();
                    var $comment = $(this).closest('.comment');
                    var comment_id = $comment.data('comment-id');
                    var newContent = $comment.find('.edit-comment-input').val().trim();

                    if (!newContent) {
                        alert('Comment cannot be empty');
                        return;
                    }

                    $.ajax({
                        url: 'update_comment.php',
                        type: 'POST',
                        data: {
                            action: 'edit',
                            comment_id: comment_id,
                            content: newContent
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // Update the comment text
                                $comment.find('.edit-comment-input').replaceWith('<p class="comment-text">' + newContent + '</p>');
                                // Remove the save button
                                $comment.find('.save-comment-edit').remove();
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function() {
                            alert('Error updating comment. Please try again.');
                        }
                    });
                });

                // Handle post creation
                $('#create-post-form').on('submit', function(e) {
                    e.preventDefault();
                    
                    var title = $(this).find('input[name="title"]').val().trim();
                    var content = $(this).find('input[name="content"]').val().trim();
                    
                    // Check if title or content is empty or only whitespace
                    if (!title) {
                        alert('please enter a title for your post!');
                        return;
                    }
                    if (!content) {
                        alert('please enter content for your post!');
                        return;
                    }
                    
                    $.ajax({
                        url: 'create_post.php',
                        method: 'POST',
                        data: {
                            title: title,
                            content: content
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // Add the new post at the top of the posts list
                                $(response.html).insertAfter('#multiCollapseExample1');
                                
                                // Clear the form
                                $('#create-post-form')[0].reset();
                                
                                // Close the create post collapse
                                $('#multiCollapseExample1').collapse('hide');
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function() {
                            alert('error creating post: please try again!');
                        }
                    });
                });

                // Handle post editing
                $(document).on('click', '.edit-post', function(e) {
                    e.preventDefault();
                    var $post = $(this).closest('.explore');
                    var $title = $post.find('.post-title');
                    var $content = $post.find('.post-text');
                    var currentTitle = $title.text().trim();
                    var currentContent = $content.text().trim();
                    
                    // Replace with editable fields
                    $title.html('<input type="text" class="edit-post-title" value="' + currentTitle + '">');
                    $content.html('<textarea class="edit-post-content">' + currentContent + '</textarea>');
                    
                    // Add save button if it doesn't exist
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
                        alert('please fill in both title and content.');
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
                                // Format the content for display (replace newlines with <br>)
                                const formattedContent = newContent.replace(/\n/g, '<br>');
                                
                                // Update the post content
                                $post.find('.post-title').text(newTitle).show();
                                $post.find('.post-text').html(formattedContent).show();
                                
                                // Hide edit fields and save button
                                $post.find('.edit-post-title, .edit-post-content').remove();
                                $post.find('.save-post-edit').remove();
                                
                                // Show edit button again
                                $post.find('.edit-post').show();
                            } else {
                                alert(response.message || 'Error updating post');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            console.error('Response:', xhr.responseText);
                            try {
                                const response = JSON.parse(xhr.responseText);
                                alert(response.message || 'error updating post: please try again!');
                            } catch (e) {
                                alert('error updating post: please try again!');
                            }
                        }
                    });
                });

                // Handle post deletion
                $(document).on('click', '.delete-post', function(e) {
                    e.preventDefault();
                    if (confirm('are you sure you want to delete this post?')) {
                        var $post = $(this).closest('.explore');
                        var postId = $(this).data('post-id');
                        
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
                            },
                            error: function(xhr, status, error) {
                                console.error('delete request failed:', error);
                                console.error('server response:', xhr.responseText);
                                alert('error deleting post: check console for details.');
                            }
                        });
                    }
                });

                // Add search functionality
                $('#postSearch').on('input', function() {
                    const searchTerm = $(this).val().toLowerCase();
                    $('.explore').each(function() {
                        const postTitle = $(this).find('.post-title').text().toLowerCase();
                        if (postTitle.includes(searchTerm)) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                });
            });
          </script>
          <script src="" async defer></script>
    </body>
</html>