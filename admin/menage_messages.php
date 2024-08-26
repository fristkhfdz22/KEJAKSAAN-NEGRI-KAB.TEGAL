<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_message'])) {
        $id = $_POST['message_id'];
        $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pesan Kontak</title>
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
        <h2>Kelola Pesan Kontak</h2>
        <!-- Daftar pesan kontak -->
        <div class="row">
            <?php
            $messages = $pdo->query("SELECT * FROM contact_messages")->fetchAll();
            foreach ($messages as $item):
            ?>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $item['name']; ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo $item['email']; ?></h6>
                            <p class="card-text"><?php echo $item['message']; ?></p>
                            <form action="menage_messages.php" method="post">
                                <input type="hidden" name="message_id" value="<?php echo $item['id']; ?>">
                                <button type="submit" name="delete_message" class="btn btn-danger">Hapus</button>
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
