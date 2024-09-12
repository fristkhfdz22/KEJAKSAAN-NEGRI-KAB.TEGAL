<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_user'])) {
        $id = $_POST['user_id'];
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    } elseif (isset($_POST['update_user'])) {
        $id = $_POST['user_id'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $stmt = $pdo->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
        $stmt->execute([$username, $password, $id]);
    } elseif (isset($_POST['add_user'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);
    }
}
//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//if (isset($_POST['delete_user'])) {
    //$id = $_POST['user_id'];
       // $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        //$stmt->execute([$id]);
    //} elseif (isset($_POST['update_user'])) {
       // $id = $_POST['user_id'];
        //$username = $_POST['username'];
        //$password = $_POST['password'];
        //$stmt = $pdo->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
        //$stmt->execute([$username, $password, $id]);
    //} elseif (isset($_POST['add_user'])) {
      //  $username = $_POST['username'];
      //  $password = $_POST['password'];
     // $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
      //  $stmt->execute([$username, $password]);
   // }//
//}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php"><i class="bi bi-house-door"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_content.php"><i class="bi bi-newspaper"></i> Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="menage_services.php"><i class="bi bi-gear"></i>Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="menage_messages.php"><i class="bi bi-envelope"></i>Pesan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"href="manage_users.php"><i class="bi bi-person"></i> Pengguna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_about.php"><i class="bi bi-info-circle"></i>About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_settings.php"><i class="bi bi-cogs"></i>Setting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="activities.php"><i class="bi bi-calendar-event"></i>Kegiatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Kelola Pengguna</h2>
        <!-- Form untuk menambah pengguna -->
        <form action="manage_users.php" method="post" class="mb-4">
            <h3>Tambah Pengguna</h3>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <button type="submit" name="add_user" class="btn btn-primary">Tambah</button>
        </form>

        <!-- Daftar pengguna -->
        <h2>Daftar Pengguna</h2>
        <div class="row">
            <?php
            $users = $pdo->query("SELECT * FROM users")->fetchAll();
            foreach ($users as $item):
            ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $item['username']; ?></h5>
                            <form action="manage_users.php" method="post" class="mt-2">
                                <input type="hidden" name="user_id" value="<?php echo $item['id']; ?>">
                                <button type="submit" name="delete_user" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
