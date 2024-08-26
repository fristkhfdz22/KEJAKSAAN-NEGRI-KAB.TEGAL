<?php
include('../config.php'); // Adjust path as needed

if (!$pdo) {
    die('Database connection failed.');
}

// Fetch existing settings
try {
    $query = $pdo->query("SELECT * FROM settings LIMIT 1");
    $settings = $query->fetch();
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $address = $_POST['address'];
    $facebook_url = $_POST['facebook_url'];
    $twitter_url = $_POST['twitter_url'];
    $instagram_url = $_POST['instagram_url'];

    try {
        $stmt = $pdo->prepare("UPDATE settings SET address = ?, facebook_url = ?, twitter_url = ?, instagram_url = ? WHERE id = 1");
        $stmt->execute([$address, $facebook_url, $twitter_url, $instagram_url]);
        echo "Settings updated successfully!";
    } catch (PDOException $e) {
        die("Update failed: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Settings</title>
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
        <h2>Manage Settings</h2>
        <form method="post">
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($settings['address']); ?>">
            </div>
            <div class="mb-3">
                <label for="facebook_url" class="form-label">Facebook URL</label>
                <input type="url" class="form-control" id="facebook_url" name="facebook_url" value="<?php echo htmlspecialchars($settings['facebook_url']); ?>">
            </div>
            <div class="mb-3">
                <label for="twitter_url" class="form-label">Twitter URL</label>
                <input type="url" class="form-control" id="twitter_url" name="twitter_url" value="<?php echo htmlspecialchars($settings['twitter_url']); ?>">
            </div>
            <div class="mb-3">
                <label for="instagram_url" class="form-label">Instagram URL</label>
                <input type="url" class="form-control" id="instagram_url" name="instagram_url" value="<?php echo htmlspecialchars($settings['instagram_url']); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
