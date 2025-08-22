<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: projects.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM projects WHERE id=?");
$stmt->execute([$id]);
$project = $stmt->fetch();

if (!$project) {
    header("Location: projects.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $imagePath = $project['image_url'];

    if (!empty($_FILES['image']['name'])) {
        $targetDir = __DIR__ . "/uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Hapus gambar lama
            if ($project['image_url'] && file_exists(__DIR__ . '/../' . $project['image_url'])) {
                unlink(__DIR__ . '/../' . $project['image_url']);
            }
            $imagePath = "admin/uploads/" . $fileName;
        }
    }

    $stmt = $pdo->prepare("UPDATE projects SET title=?, description=?, category=?, image_url=?, github_url=?, live_url=?, technologies=? WHERE id=?");
    $stmt->execute([
        $_POST['title'],
        $_POST['description'],
        $_POST['category'],
        $imagePath,
        $_POST['github_url'],
        $_POST['live_url'],
        $_POST['technologies'],
        $id
    ]);

    header("Location: projects.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Project</title>
    <link href="css/styles.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1>Edit Project</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="title" value="<?= htmlspecialchars($project['title']); ?>" class="form-control mb-2" required>
            <textarea name="description" class="form-control mb-2"><?= htmlspecialchars($project['description']); ?></textarea>
            <input type="text" name="category" value="<?= htmlspecialchars($project['category']); ?>" class="form-control mb-2">
            <p>Current Image:</p>
            <?php if ($project['image_url']): ?>
                <img src="../<?= $project['image_url']; ?>" width="150"><br>
            <?php endif; ?>
            <input type="file" name="image" class="form-control mb-2">
            <input type="text" name="github_url" value="<?= htmlspecialchars($project['github_url']); ?>" class="form-control mb-2">
            <input type="text" name="live_url" value="<?= htmlspecialchars($project['live_url']); ?>" class="form-control mb-2">
            <input type="text" name="technologies" value="<?= htmlspecialchars($project['technologies']); ?>" class="form-control mb-2">
            <button class="btn btn-primary">Update</button>
        </form>
    </div>
</body>

</html>