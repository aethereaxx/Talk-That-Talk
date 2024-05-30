<?php
  session_start();

  if (!isset($_SESSION["username"])) {
      header("Location: login.php");
      exit();
  }

  // Database connection settings
  $dsn = "mysql:host=localhost;dbname=data_user;charset=utf8mb4";
  $dbUsername = "kelompok1sic";
  $dbPassword = "pemwebsic";

  try {
    // Create a PDO instance (connect to the database)
    $pdo = new PDO($dsn, $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch posts with corresponding likes and comments
    $sql = "
        SELECT 
            p.postID, p.title, p.content, p.created_at, p.author, 
            COUNT(DISTINCT l.likeID) AS like_count,
            COUNT(DISTINCT c.commentID) AS comment_count
        FROM posts p
        LEFT JOIN likes l ON p.postID = l.postID
        LEFT JOIN comments c ON p.postID = c.postID
        GROUP BY p.postID
        ORDER BY p.created_at DESC";

    $stmt = $pdo->query($sql);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

  } catch (PDOException $e) {
      die("Connection failed: " . $e->getMessage());
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../Style/timeline.css">
  <title>Timeline</title>
</head>
<body>
  <header>
    <div class="logo">
      <img src="../img/Logo.png" alt="Logo" width="55">
    </div>
    <h1>Timeline</h1>
  </header>
  <div class="container">
    <aside class="menu">
      <nav>
        <ul>
          <li><a href="timeline.php">Timeline</a></li>
          <li><a href="profile.php">Profile</a></li>
          <li><a href="mute.php">Mute and Blocked</a></li>
          <li><a href="information.php">Information</a></li>
          <li><a href="license.php">License</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav>
    </aside>
    <main class="main-container">
      <div class="main-content">

        <div class="kontennn">
          <div class="post-container">
            <h2>Post Content</h2>
            <form action="upload_post.php" method="POST">
              <input class="title" type="text" placeholder="title" name="title">
              <textarea id="post-content" name="content" placeholder="Write your question here..." rows="8"></textarea>
              <button type="submit" class="post-button">Post</button>
            </form>
          </div>
        </div>
        <?php foreach ($posts as $post): ?>
            <div class="user-post">
                <div class="post-title"><?php echo htmlspecialchars($post['title']); ?></div>
                <div class="post-meta">By <?php echo htmlspecialchars($post['author']); ?> on <?php echo htmlspecialchars($post['created_at']); ?></div>
                <div class="post-content"><?php echo nl2br(htmlspecialchars($post['content'])); ?></div>
                <div class="like-count">Likes: <?php echo $post['like_count']; ?></div>
                <div class="comment-count">Comments: <?php echo $post['comment_count']; ?></div>

                <!-- Like Button -->
                <form action="like_post.php" method="POST" style="display:inline;">
                    <input type="hidden" name="postID" value="<?php echo htmlspecialchars($post['postID']); ?>">
                    <button type="submit">Like</button>
                </form>

                <!-- Comment Form -->
                <div class="comment-form">
                    <form action="add_comment.php" method="POST">
                        <input type="hidden" name="postID" value="<?php echo htmlspecialchars($post['postID']); ?>">
                        <textarea name="content" placeholder="Add a comment..." rows="2"></textarea>
                        <button type="submit">Comment</button>
                    </form>
                </div>

                <?php
                // Fetch comments for the current post
                $commentSql = "SELECT c.content, c.created_at, c.user FROM comments c WHERE c.postID = :postID ORDER BY c.created_at ASC";
                $commentStmt = $pdo->prepare($commentSql);
                $commentStmt->bindParam(':postID', $post['postID'], PDO::PARAM_INT);
                $commentStmt->execute();
                $comments = $commentStmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <div class="comments">
                    <?php foreach ($comments as $comment): ?>
                        <div class="comment">
                            <div class="comment-meta"><?php echo htmlspecialchars($comment['user']); ?> on <?php echo htmlspecialchars($comment['created_at']); ?></div>
                            <div class="comment-content"><?php echo nl2br(htmlspecialchars($comment['content'])); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
      </div>

      <div class="suggestion-container">
        <h2>Suggestion</h2>
        <!-- Dummy suggestions-->
        <div class="user-post">
                <div class="post-title"><?php echo htmlspecialchars($posts[0]['title']); ?></div>
                <div class="post-meta">By <?php echo htmlspecialchars($posts[0]['author']); ?> on <?php echo htmlspecialchars($posts[0]['created_at']); ?></div>
                <div class="post-content"><?php echo nl2br(htmlspecialchars($posts[0]['content'])); ?></div>
                <div class="like-count">Likes: <?php echo $posts[0]['like_count']; ?></div>
                <div class="comment-count">Comments: <?php echo $posts[0]['comment_count']; ?></div>
                </div>
            </div>
      </div>
    </main>
  </div>
  <script src="../Js/Timeline.js"></script>
</body>
</html>
