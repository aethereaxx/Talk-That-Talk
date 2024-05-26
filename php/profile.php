<?php
  session_start();

  if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
  }

  $username = $_SESSION['username'];

  $dsn = "mysql:host=localhost;dbname=data_user;charset=utf8mb4";
  $dbUsername = "kelompok1sic";
  $dbPassword = "pemwebsic";

  try {
    $pdo = new PDO($dsn, $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT user, email, nama, password, tanggal_lahir FROM akun WHERE user = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userData) {
        die("No user found with the username: " . htmlspecialchars($username));
    }

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

    $userPostCountSql = "
        SELECT 
            COUNT(*) AS post_count
        FROM posts
        WHERE author = :author";
    $userPostCountStmt = $pdo->prepare($userPostCountSql);
    $userPostCountStmt->bindParam(':author', $username, PDO::PARAM_STR);
    $userPostCountStmt->execute();
    $userPostCount = $userPostCountStmt->fetch(PDO::FETCH_ASSOC)['post_count'];

  } catch (PDOException $e) {
      die("Connection failed: " . $e->getMessage());
  }
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="../Style/profile.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
  </head>
  <body>
    <nav>
      <div class="nav_container">
      <a href="timeline.php"><i class="fa-solid fa-arrow-left"></i></a>
          <div class="nav_profile">
          <h2><?php echo htmlspecialchars($userData['nama']); ?></h2>
          <span> <?php echo $userPostCount; ?> Post</span>
        </div>
        <a href="editProfile.php"><button class="edit-profile-btn">Edit Profile</button></a>
      </div>
    </nav>
    <div class="hero">
      <div class="hero_container">
        <img
          src="../img/profile_pic.png"
          alt="profile"
          class="profile_picture"
        />
      </div>
    </div>
    <main>
      <div class="container">
        <div class="profile_info">
          <h1><?php echo htmlspecialchars($userData['nama']); ?></h1>
          <span>@<?php echo htmlspecialchars($userData['user']); ?></span>
          <div class="join_date">
            <i class="fa-solid fa-calendar-days"></i>
            <p>Joined March 2023</p>
          </div>
          <div class="follows">
            <p><strong>40</strong> Following</p>
            <p><strong>397</strong> Follower</p>
          </div>
          <div class="buttons">
            <button class="active">Post</button>
            <button>Replies</button>
            <button>Likes</button>
          </div>
        </div>
        <?php foreach ($posts as $post): ?>
        <div class="post">
            <div class="post-title"><?php echo htmlspecialchars($post['title']); ?></div>
            <div class="post-meta">By <?php echo htmlspecialchars($post['author']); ?> on <?php echo htmlspecialchars($post['created_at']); ?></div>
            <div class="post-content"><?php echo nl2br(htmlspecialchars($post['content'])); ?></div>
            <div class="like-count">Likes: <?php echo $post['like_count']; ?></div>
            <div class="comment-count">Comments: <?php echo $post['comment_count']; ?></div>

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
    </main>
  </body>
</html>
