
<?php
include('config.php'); // Pastikan path-nya benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    try {
        $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $message]);
     
    } catch (PDOException $e) {
        echo 'Gagal mengirim pesan: ' . $e->getMessage();
    }
}
try {
    $query = $pdo->query("SELECT * FROM settings LIMIT 1");
    $settings = $query->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

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
    <title>Kejaksaan Negeri - Kontak Kami</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    
   
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="jk.png" alt="Logo" > <!-- Add your logo image path here -->
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
    <h2>Kontak Kami</h2>
    <form action="contact.php" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Pesan</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">Kirim Pesan</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $email, $message])) {
            echo "<div class='alert alert-success mt-4'>Pesan Anda telah dikirim.</div>";
        } else {
            echo "<div class='alert alert-danger mt-4'>Terjadi kesalahan. Silakan coba lagi.</div>";
        }
    }
    ?>
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
