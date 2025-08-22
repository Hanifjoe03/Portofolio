<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $platform = $_POST['platform'];
    $url = $_POST['url'];
    $icon = $_POST['icon'];

    $stmt = $pdo->prepare("INSERT INTO footer_links (platform, url, icon) VALUES (?, ?, ?)");
    $stmt->execute([$platform, $url, $icon]);

    header("Location: footer.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Footer Link</title>
    <link href="css/projects.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Add Footer Link</h1>
        <form method="POST">
            <label>Platform</label>
            <input type="text" name="platform" required>

            <label>URL</label>
            <input type="url" name="url" required>

            <label>Icon (SVG Path or Code)</label>
            <textarea name="icon" rows="4" required></textarea>

            <button type="submit" class="btn btn-success">Save</button>
            <a href="footer.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>