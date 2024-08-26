<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_news'])) {
        $id = $_POST['news_id'];
        $stmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
        $stmt->execute([$id]);
    } elseif (isset($_POST['update_news'])) {
        $id = $_POST['news_id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $image = $_FILES['image']['name'];

        if (!empty($image)) {
            $imagePath = '../images/' . $image;
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
            $stmt = $pdo->prepare("UPDATE news SET title = ?, content = ?, image = ? WHERE id = ?");
            $stmt->execute([$title, $content, $image, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE news SET title = ?, content = ? WHERE id = ?");
            $stmt->execute([$title, $content, $id]);
        }
    } elseif (isset($_POST['add_news'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $image = $_FILES['image']['name'];

        if (!empty($image)) {
            $imagePath = '../images/' . $image;
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
            $stmt = $pdo->prepare("INSERT INTO news (title, content, image) VALUES (?, ?, ?)");
            $stmt->execute([$title, $content, $image]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO news (title, content) VALUES (?, ?)");
            $stmt->execute([$title, $content]);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Berita</title>
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
        <h2>Kelola Berita</h2>
        <!-- Form untuk menambah berita -->
        <form action="manage_content.php" method="post" enctype="multipart/form-data" class="mb-4">
            <h3>Tambah Berita</h3>
            <div class="mb-3">
                <label for="title" class="form-label">Judul</label>
                <input type="text" name="title" class="form-control" id="title" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Konten</label>
                <textarea name="content" class="form-control" id="content" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Gambar</label>
                <input type="file" name="image" class="form-control" id="image">
            </div>
            <button type="submit" name="add_news" class="btn btn-primary">Tambah</button>
        </form>

        <!-- Daftar berita -->
        <h2>Daftar Berita</h2>
        <div class="row">
            <?php
            $news = $pdo->query("SELECT * FROM news")->fetchAll();
            foreach ($news as $item):
            ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <?php if (!empty($item['image'])): ?>
                            <img src="../images/<?php echo htmlspecialchars($item['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($item['title']); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($item['title']); ?></h5>
                            <p class="card-text"><?php echo substr(htmlspecialchars($item['content']), 0, 100); ?>...</p>
                            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editNewsModal<?php echo $item['id']; ?>">Edit</button>
                            <form action="manage_content.php" method="post" class="mt-2">
                                <input type="hidden" name="news_id" value="<?php echo $item['id']; ?>">
                                <button type="submit" name="delete_news" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Berita -->
                <div class="modal fade" id="editNewsModal<?php echo $item['id']; ?>" tabindex="-1" aria-labelledby="editNewsModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editNewsModalLabel">Edit Berita</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="manage_content.php" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <input type="hidden" name="news_id" value="<?php echo $item['id']; ?>">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Judul</label>
                                        <input type="text" name="title" class="form-control" id="title" value="<?php echo htmlspecialchars($item['title']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="content" class="form-label">Konten</label>
                                        <textarea name="content" class="form-control" id="content" rows="4" required><?php echo htmlspecialchars($item['content']); ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Gambar</label>
                                        <input type="file" name="image" class="form-control" id="image">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" name="update_news" class="btn btn-primary">Simpan Perubahan</button>
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
