<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "kelompok1sic", "pemwebsic", "data_user");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Update user data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    
    $query = "UPDATE AKUN SET nama='$nama', email='$email', password='$password', tanggal_lahir='$tanggal_lahir' WHERE user='$username'";
    mysqli_query($conn, $query);
}

// Delete user data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $username = $_POST['username'];
    
    $query = "DELETE FROM AKUN WHERE user='$username'";
    mysqli_query($conn, $query);
}

// Ambil data user dari tabel AKUN
$query = "SELECT * FROM AKUN";
$result = mysqli_query($conn, $query);

$users = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
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
                <h1>Simple Sidebar</h1>
                <p>This template has a responsive menu toggling system. The menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will appear/disappear. On small screens, the page content will be pushed off canvas.</p>
                <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>.</p>
            </div>
            
            <div class="container-fluid" id="account-management-content" style="display:none;">
                <h1>Account Management</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Password</th>
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
                            <td><?= $user['password']; ?></td>
                            <td><?= $user['tanggal_lahir']; ?></td>
                            <td>
                                <button class="update-button" data-username="<?= $user['user']; ?>">Update</button>
                                <button class="delete-button" data-username="<?= $user['user']; ?>">Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <form id="update-form" style="display:none; margin-top: 20px;">
                    <h2>Update Account</h2>
                    <input type="hidden" name="username" id="update-username">
                    <input type="hidden" name="action" value="update">
                    <div>
                        <label for="update-nama">Nama:</label>
                        <input type="text" name="nama" id="update-nama">
                    </div>
                    <div>
                        <label for="update-email">Email:</label>
                        <input type="email" name="email" id="update-email">
                    </div>
                    <div>
                        <label for="update-password">Password:</label>
                        <input type="password" name="password" id="update-password">
                    </div>
                    <div>
                        <label for="update-tanggal_lahir">Tanggal Lahir:</label>
                        <input type="date" name="tanggal_lahir" id="update-tanggal_lahir">
                    </div>
                    <button type="submit">Update</button>
                </form>
                <form id="delete-form" style="display:none;">
                    <input type="hidden" name="username" id="delete-username">
                    <input type="hidden" name="action" value="delete">
                </form>
            </div>
            
            <div class="container-fluid" id="posts-management-content" style="display:none;">
                <h1>Posts Management</h1>
                <p>Content for Posts Management</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../Js/dashboard.js"></script>
</body>
</html>
