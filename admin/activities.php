<?php
include('../config.php');

// Handle delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM activities WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: activities.php");
    exit();
}

// Handle add or update request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $id = isset($_POST['id']) ? $_POST['id'] : null;

    if ($id) {
        // Update existing activity
        $stmt = $pdo->prepare("UPDATE activities SET title = ?, description = ?, activity_date = ? WHERE id = ?");
        $stmt->execute([$title, $description, $date, $id]);
    } else {
        // Add new activity
        $stmt = $pdo->prepare("INSERT INTO activities (title, description, activity_date) VALUES (?, ?, ?)");
        $stmt->execute([$title, $description, $date]);
    }

    header("Location: activities.php");
    exit();
}

// Fetch all activities
$activities = $pdo->query("SELECT * FROM activities ORDER BY activity_date DESC")->fetchAll(PDO::FETCH_ASSOC);

// Fetch single activity for editing if an ID is set
$editActivity = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM activities WHERE id = ?");
    $stmt->execute([$id]);
    $editActivity = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Activities</title>
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
    <h2><?php echo $editActivity ? 'Edit Activity' : 'Add New Activity'; ?></h2>

    <form method="post">
        <?php if ($editActivity): ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($editActivity['id']); ?>">
        <?php endif; ?>
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo $editActivity ? htmlspecialchars($editActivity['title']) : ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $editActivity ? htmlspecialchars($editActivity['description']) : ''; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="<?php echo $editActivity ? htmlspecialchars($editActivity['activity_date']) : ''; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary"><?php echo $editActivity ? 'Save Changes' : 'Add Activity'; ?></button>
    </form>

    <h2 class="mt-4">Activity List</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($activities as $activity): ?>
                <tr>
                    <td><?php echo htmlspecialchars($activity['id']); ?></td>
                    <td><?php echo htmlspecialchars($activity['title']); ?></td>
                    <td><?php echo htmlspecialchars(substr($activity['description'], 0, 50)) . '...'; ?></td>
                    <td><?php echo htmlspecialchars($activity['activity_date']); ?></td>
                    <td>
                        <a href="?edit=<?php echo htmlspecialchars($activity['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="?delete=<?php echo htmlspecialchars($activity['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
