<?php
include('config.php');

// Fetch activities from the last week
$one_week_ago = date('Y-m-d', strtotime('-1 week'));

try {
    $activities_query = $pdo->prepare("SELECT * FROM activities WHERE activity_date >= ? ORDER BY activity_date DESC");
    $activities_query->execute([$one_week_ago]);
    $activities = $activities_query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle the error appropriately
    die("Query failed: " . $e->getMessage());
}

// Fallback in case of no activities
if (!$activities) {
    $activities = [];
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
    <title>Kegiatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Custom Styles for Activities Section */
        .card {
            border: none;
            border-radius: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card-body {
            padding: 1.25rem;
        }

        .card-body h5 {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
            color: #333;
        }

        .card-body p.card-text {
            font-size: 1rem;
            color: #6c757d;
        }

        .card-body a.btn-primary {
            background-color: #0056b3;
            border-color: #0056b3;
            text-transform: uppercase;
            font-weight: bold;
        }

        .card-body a.btn-primary:hover {
            background-color: #004494;
            border-color: #003d79;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }
    </style>
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
        <h2>Kegiatan Terakhir</h2>
        <div class="row">
            <?php if (!empty($activities)): ?>
                <?php foreach ($activities as $activity): ?>
                    <div class="col-12">
                        <div class="card mb-4 shadow-sm border-light">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($activity['title']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($activity['description']); ?></p>
                                <p class="card-text"><small class="text-muted"><?php echo htmlspecialchars($activity['activity_date']); ?></small></p>
                                <a href="kegiatan_detail.php?id=<?php echo $activity['id']; ?>" class="btn btn-primary">Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No activities available.</p>
            <?php endif; ?>
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
