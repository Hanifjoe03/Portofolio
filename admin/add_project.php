<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $imagePath = null;

    // Upload gambar
    if (!empty($_FILES['image']['name'])) {
        $targetDir = __DIR__ . "/uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = "admin/uploads/" . $fileName; // simpan relatif
        }
    }

    $stmt = $pdo->prepare("INSERT INTO projects (title, description, category, image_url, github_url, live_url, technologies, created_at) 
                           VALUES (?,?,?,?,?,?,?,NOW())");
    $stmt->execute([
        $_POST['title'],
        $_POST['description'],
        $_POST['category'],
        $imagePath,
        $_POST['github_url'],
        $_POST['live_url'],
        $_POST['technologies']
    ]);

    header("Location: projects.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Project</title>
    <link href="css/styles.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1>Add Project</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Title" class="form-control mb-2" required>
            <textarea name="description" placeholder="Description" class="form-control mb-2"></textarea>
            <input type="text" name="category" placeholder="Category" class="form-control mb-2">
            <input type="file" name="image" class="form-control mb-2" required>
            <input type="text" name="github_url" placeholder="GitHub URL" class="form-control mb-2">
            <input type="text" name="live_url" placeholder="Live URL" class="form-control mb-2">
            <input type="text" name="technologies" placeholder="Technologies" class="form-control mb-2">
            <button class="btn btn-success">Save</button>
        </form>
    </div>
</body>

</html>