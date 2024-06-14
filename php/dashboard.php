<?php
session_start();

if (!isset($_SESSION["username"]) || ((isset($_SESSION["username"])) && (substr($_SESSION["username"], 0, 5) !== "t3adm"))) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
$conn = mysqli_connect("localhost", "kelompok1sic", "pemwebsic", "data_user");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Update user data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_user') {
    $old_username = $_POST['old_username'];
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $tanggal_lahir = $_POST['tanggal_lahir'];

    // Begin transaction
    mysqli_begin_transaction($conn);

    try {
        // Update user in akun table
        $query = "UPDATE akun SET user='$username', nama='$nama', email='$email', password='$password', tanggal_lahir='$tanggal_lahir' WHERE user='$old_username'";
        mysqli_query($conn, $query);

        // Update posts with new username
        $query = "UPDATE posts SET author='$username' WHERE author='$old_username'";
        mysqli_query($conn, $query);

        // Commit transaction
        mysqli_commit($conn);
    } catch (mysqli_sql_exception $exception) {
        // Rollback transaction
        mysqli_rollback($conn);
        throw $exception;  // Handle exception as needed
    }
}

// Delete user data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_user') {
    $username = $_POST['username'];

    // Posts akan otomatis terhapus karena constraint ON DELETE CASCADE
    $query = "DELETE FROM akun WHERE user='$username'";
    mysqli_query($conn, $query);
}

// Update post data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_post') {
    $post_id = $_POST['postID'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $query = "UPDATE posts SET title='$title', content='$content', updated_at=CURRENT_TIMESTAMP WHERE postID='$post_id'";
    mysqli_query($conn, $query);
}

// Delete post data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_post') {
    $post_id = $_POST['postID'];

    $query = "DELETE FROM posts WHERE postID='$post_id'";
    mysqli_query($conn, $query);
}

// Ambil data user dari tabel akun
$query = "SELECT * FROM akun";
$result = mysqli_query($conn, $query);

$users = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}

// Ambil data posts dari tabel posts
$query = "SELECT * FROM posts";
$result = mysqli_query($conn, $query);

$posts = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Style/Dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Dashboard</title>
</head>
<body>
    <div id="wrapper" class="toggled">
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <h2>Administrator</h2>
                </li>
                <li>
                    <a href="#" id="dashboard-link">Dashboard</a>
                </li>
                <li>
                    <a href="#" id="account-management-link">Account Management</a>
                </li>
                <li>
                    <a href="#" id="posts-management-link">Posts Management</a>
                </li>
                <li>
                    <a href="logout.php">Logout</a>
                </li>
            </ul>
        </div>

        <div id="page-content-wrapper">
            <div class="container-fluid" id="dashboard-content">
                <h1>Halo Admin!</h1>
                <p>Ini adalah dashboard khusus untuk Admin.</p>
                <p>Silakan pilih menu untuk otorisasi lebih lanjut.</p>
            </div>

            <div class="container-fluid" id="account-management-content" style="display:none;">
                <h1>Account Management</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Username</th>
                            <!-- <th>Password</th> -->
                            <th>Tanggal Lahir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr data-username="<?= $user['user']; ?>">
                            <td><?= $user['nama']; ?></td>
                            <td><?= $user['email']; ?></td>
                            <td><?= $user['user']; ?></td>
                            <!-- <td><?= $user['password']; ?></td> -->
                            <td><?= $user['tanggal_lahir']; ?></td>
                            <td>
                                <button class="update-button" data-username="<?= $user['user']; ?>">Update</button>
                                <button class="delete-button" data-username="<?= $user['user']; ?>">Delete</button>
                            </td>
                        <?php endforeach; ?>
                        </tr>
                    </tbody>
                </table>
                <form id="update-form" style="display:none; margin-top: 20px;" method="post">
                    <h2>Update Account</h2>
                    <input type="hidden" name="old_username" id="update-old-username">
                    <input type="hidden" name="action" value="update_user">
                    <div>
                        <label for="update-username">Username:</label>
                        <input type="text" name="username" id="update-username">
                    </div>
                    <div>
                        <label for="update-nama">Nama:</label>
                        <input type="text" name="nama" id="update-nama">
                    </div>
                    <div>
                        <label for="update-email">Email:</label>
                        <input type="email" name="email" id="update-email">
                    </div>
                    <!-- <div>
                        <label for="update-password">Password:</label>
                        <input type="password" name="password" id="update-password">
                    </div> -->
                    <div>
                        <label for="update-tanggal_lahir">Tanggal Lahir:</label>
                        <input type="date" name="tanggal_lahir" id="update-tanggal_lahir">
                    </div>
                    <button type="submit">Update</button>
                </form>
                <form id="delete-form" style="display:none;" method="post">
                    <input type="hidden" name="username" id="delete-username">
                    <input type="hidden" name="action" value="delete_user">
                </form>
            </div>

            <div class="container-fluid" id="posts-management-content" style="display:none;">
                <h1>Posts Management</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Post ID</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Author</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post): ?>
                        <tr data-post-id="<?= $post['postID']; ?>">
                            <td><?= $post['postID']; ?></td>
                            <td><?= $post['title']; ?></td>
                            <td><?= $post['content']; ?></td>
                            <td><?= $post['author']; ?></td>
                            <td><?= $post['created_at']; ?></td>
                            <td><?= $post['updated_at']; ?></td>
                            <td>
                                <button class="update-post-button" data-post-id="<?= $post['postID']; ?>">Update</button>
                                <button class="delete-post-button" data-post-id="<?= $post['postID']; ?>">Delete</button>
                            </td>
                        <?php endforeach; ?>
                        </tr>
                    </tbody>
                </table>
                <form id="update-post-form" style="display:none; margin-top: 20px;" method="post">
                    <h2>Update Post</h2>
                    <input type="hidden" name="postID" id="update-post-id">
                    <input type="hidden" name="action" value="update_post">
                    <div>
                        <label for="update-title">Title:</label>
                        <input type="text" name="title" id="update-title">
                    </div>
                    <div>
                        <label for="update-content">Content:</label>
                        <textarea name="content" id="update-content" rows="4" cols="50"></textarea>
                    </div>
                    <button type="submit">Update</button>
                </form>
                <form id="delete-post-form" style="display:none;" method="post">
                    <input type="hidden" name="postID" id="delete-post-id">
                    <input type="hidden" name="action" value="delete_post">
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../Js/dashboard.js"></script>
</body>
</html>
