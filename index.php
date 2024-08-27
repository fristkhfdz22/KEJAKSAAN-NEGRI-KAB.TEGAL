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

// Fetch activities from the last week
$one_week_ago = date('Y-m-d', strtotime('-1 week'));
$activities_query = $pdo->prepare("SELECT * FROM activities WHERE activity_date >= ? ORDER BY activity_date DESC");
$activities_query->execute([$one_week_ago]);
$activities = $activities_query->fetchAll(PDO::FETCH_ASSOC);

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">  
</head>
<body>
<style>
.logo-container {
    display: flex;
    justify-content: space-around; /* Space out the items */
    align-items: center; /* Center items vertically */
    background-color: #d4edda; /* Light green background */
    border-radius: 10px; /* Rounded corners */
    padding: 20px; /* Space around the content */
    margin-top: 20px; /* Space above the container */
}

/* Style for each logo item */
.logo {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #155724; /* Dark green color for text */
}

.logo i {
    font-size: 4rem; /* 2x larger than default Bootstrap size */
    margin-right: 10px; /* Space between icon and text */
}

.logo-title {
    font-size: 1.5rem; /* Adjust font size as needed */
}
    </style>
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
    <div class="hero" style="background-image: url('kejari.jpg');">
        <div class="hero-title">
            <h1><?php echo htmlspecialchars($about_content['about_text']); ?></h1>
            <h1>     <a href="#berita" class="btn btn-light btn-lg">GET STARTED</a></h1>
        </div>
      
    </div>

  
   
<br>
<div id="berita" class="container mt-4">
    <div class="logo-container">
        <a href="news.php" class="logo">
            <i class="bi bi-newspaper"></i> <!-- News Icon -->
            <span class="logo-title">Berita</span>
        </a>

        <a href="kegiatan.php" class="logo">
            <i class="bi bi-calendar-event"></i> <!-- Activities Icon -->
            <span class="logo-title">Kegiatan</span>
        </a>
    </div>
</div>

    <div class="container mt-4">
        <h2>Berita Terbaru</h2>
        <div class="row">
            <?php
            include('config.php');
            $news = $pdo->query("SELECT * FROM news ORDER BY date_created DESC LIMIT 10")->fetchAll();
            foreach ($news as $item):
            ?>
                <div class="col-12">
                    <div class="card mb-4 shadow-sm border-light">
                        <?php if (!empty($item['image']) && file_exists('images/' . $item['image'])): ?>
                            <img src="images/<?php echo htmlspecialchars($item['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($item['title']); ?>">
                        <?php else: ?>
                            <img src="images/default.jpg" class="card-img-top" alt="Gambar Default">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($item['title']); ?></h5>
                            <p class="card-text"><?php echo substr(htmlspecialchars($item['content']), 0, 100) . '...'; ?></p>
                            <a href="news_detail.php?id=<?php echo $item['id']; ?>" class="btn btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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
