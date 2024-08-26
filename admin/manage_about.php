<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}
include('../config.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $about_text = $_POST['about_text'];
    $vision = $_POST['vision'];
    $mission = $_POST['mission'];

    $stmt = $pdo->prepare("REPLACE INTO about (id, about_text, vision, mission) VALUES (1, ?, ?, ?)");
    $stmt->execute([$about_text, $vision, $mission]);
}

// Fetch current content
$stmt = $pdo->query("SELECT * FROM about WHERE id = 1");
$about_content = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Tentang Kami</title>
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
    <h2>Kelola Tentang Kami</h2>
    <form action="manage_about.php" method="post">
        <div class="mb-3">
            <label for="about_text" class="form-label">Tentang Kami</label>
            <textarea name="about_text" class="form-control" id="about_text" rows="5" required><?php echo htmlspecialchars($about_content['about_text']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="vision" class="form-label">Visi</label>
            <textarea name="vision" class="form-control" id="vision" rows="2" required><?php echo htmlspecialchars($about_content['vision']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="mission" class="form-label">Misi</label>
            <textarea name="mission" class="form-control" id="mission" rows="2" required><?php echo htmlspecialchars($about_content['mission']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
