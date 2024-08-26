<?php
include('config.php');
$stmt = $pdo->query("SELECT * FROM about WHERE id = 1");
$about_content = $stmt->fetch();
// Fetch settings data

try {
    $query = $pdo->query("SELECT * FROM settings LIMIT 1");
    $settings = $query->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

// Fallback for settings
if (!$settings) {
    $settings = [
        'address' => 'Alamat tidak tersedia',
        'facebook_url' => '#',
        'twitter_url' => '#',
        'instagram_url' => '#'
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kejaksaan Negeri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="jk.png" alt="Logo"> <!-- Add your logo image path here -->
            
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="services.php">Layanan</a>
                    </li>
                  
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Kontak Kami</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php
        include('config.php');
        $id = $_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
        $stmt->execute([$id]);
        $news = $stmt->fetch();
        if ($news):
        ?>
            <h2><?php echo $news['title']; ?></h2>
            <p><?php echo $news['content']; ?></p>
            <p><small>Diterbitkan pada: <?php echo $news['date_created']; ?></small></p>
        <?php else: ?>
            <p>Berita tidak ditemukan.</p>
        <?php endif; ?>
    </div>
    <footer class="footer-bg text-center py-2 fixed-bottom">
        <div class="container">
            <!-- Main Footer Content -->
           
            <!-- Social Media Icons -->
            <div class="social-media">
            <p class="mb-1">Alamat: <?php echo htmlspecialchars($settings['address']); ?></p>
                <a href="<?php echo htmlspecialchars($settings['facebook_url']); ?>" target="_blank" class="btn btn-outline-light">
                    <i class="bi bi-facebook"></i> Facebook
                </a>
                <a href="<?php echo htmlspecialchars($settings['twitter_url']); ?>" target="_blank" class="btn btn-outline-light">
                    <i class="bi bi-twitter"></i> Twitter
                </a>
                <a href="<?php echo htmlspecialchars($settings['instagram_url']); ?>" target="_blank" class="btn btn-outline-light">
                    <i class="bi bi-instagram"></i> Instagram
                </a>
            </div>
            <p class="mb-0">&copy; 2024 Kejaksaan Negeri</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
