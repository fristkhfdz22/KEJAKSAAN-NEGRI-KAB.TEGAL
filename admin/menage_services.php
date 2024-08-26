<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_service'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $stmt = $pdo->prepare("INSERT INTO services (name, description) VALUES (?, ?)");
        $stmt->execute([$name, $description]);
    } elseif (isset($_POST['update_service'])) {
        $id = $_POST['service_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $stmt = $pdo->prepare("UPDATE services SET name = ?, description = ? WHERE id = ?");
        $stmt->execute([$name, $description, $id]);
    } elseif (isset($_POST['delete_service'])) {
        $id = $_POST['service_id'];
        $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Layanan</title>
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
        <h2>Kelola Layanan</h2>
        <!-- Form untuk menambah layanan -->
        <form action="menage_services.php" method="post" class="mb-4">
            <h3>Tambah Layanan</h3>
            <div class="mb-3">
                <label for="name" class="form-label">Nama Layanan</label>
                <input type="text" name="name" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" id="description" rows="4" required></textarea>
            </div>
            <button type="submit" name="add_service" class="btn btn-primary">Tambah</button>
        </form>

        <!-- Daftar layanan -->
        <h2>Daftar Layanan</h2>
        <div class="row">
            <?php
            $services = $pdo->query("SELECT * FROM services")->fetchAll();
            foreach ($services as $item):
            ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($item['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars(substr($item['description'], 0, 100)); ?>...</p>
                            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editServiceModal<?php echo $item['id']; ?>">Edit</button>
                            <form action="manage_services.php" method="post" class="mt-2">
                                <input type="hidden" name="service_id" value="<?php echo $item['id']; ?>">
                                <button type="submit" name="delete_service" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Layanan -->
                <div class="modal fade" id="editServiceModal<?php echo $item['id']; ?>" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editServiceModalLabel">Edit Layanan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="menage_services.php" method="post">
                                <div class="modal-body">
                                    <input type="hidden" name="service_id" value="<?php echo $item['id']; ?>">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Layanan</label>
                                        <input type="text" name="name" class="form-control" id="name" value="<?php echo htmlspecialchars($item['name']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Deskripsi</label>
                                        <textarea name="description" class="form-control" id="description" rows="4" required><?php echo htmlspecialchars($item['description']); ?></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" name="update_service" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
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
