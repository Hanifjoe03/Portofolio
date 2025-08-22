<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM footer_links WHERE id=?");
$stmt->execute([$id]);
$link = $stmt->fetch();

if (!$link) {
    die("Footer link not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $platform = $_POST['platform'];
    $url = $_POST['url'];
    $icon = $_POST['icon'];

    $stmt = $pdo->prepare("UPDATE footer_links SET platform=?, url=?, icon=? WHERE id=?");
    $stmt->execute([$platform, $url, $icon, $id]);

    header("Location: footer.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Footer Link</title>
    <link href="css/projects.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Edit Footer Link</h1>
        <form method="POST">
            <label>Platform</label>
            <input type="text" name="platform" value="<?= htmlspecialchars($link['platform']); ?>" required>

            <label>URL</label>
            <input type="url" name="url" value="<?= htmlspecialchars($link['url']); ?>" required>

            <label>Icon (SVG Path or Code)</label>
            <textarea name="icon" rows="4" required><?= htmlspecialchars($link['icon']); ?></textarea>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="footer.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>