<?php
include('config.php');

// Fetch about content
$stmt = $pdo->query("SELECT * FROM about WHERE id = 1");
try {
    $query = $pdo->query("SELECT * FROM settings LIMIT 1");
    $settings = $query->fetch();
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

$about_content = $stmt->fetch();
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
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
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
    <h2 class="text-center mb-4">Tentang Kejaksaan Negeri</h2>
    <p class="lead text-justify"><?php echo htmlspecialchars($about_content['about_text']); ?></p>

    <div class="row mt-5">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h3 class="card-title text-center text-primary">Visi</h3>
                    <p class="card-text text-justify"><?php echo htmlspecialchars($about_content['vision']); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h3 class="card-title text-center text-success">Misi</h3>
                    <ul class="list-unstyled">
                        <?php 
                        $missions = explode("\n", htmlspecialchars($about_content['mission']));
                        foreach ($missions as $mission): ?>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success"></i> <?php echo $mission; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

    <footer class="footer-bg text-center py-2 ">
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
