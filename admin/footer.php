<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM footer_links ORDER BY id ASC");
$footerLinks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin - Footer</title>
    <link href="css/projects.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Footer Links</h1>
        <a href="add_footer.php" class="btn btn-success">+ Add Footer Link</a>

        <div class="table-container">
            <h2>Links List</h2>
            <?php if (count($footerLinks) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Platform</th>
                            <th>URL</th>
                            <th>Icon (SVG)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($footerLinks as $f): ?>
                            <tr>
                                <td><?= htmlspecialchars($f['platform']); ?></td>
                                <td><?= htmlspecialchars($f['url']); ?></td>
                                <td><code><?= htmlspecialchars(substr($f['icon'], 0, 30)); ?>...</code></td>
                                <td>
                                    <a href="edit_footer.php?id=<?= $f['id']; ?>" class="btn btn-primary">Edit</a>
                                    <a href="delete_footer.php?id=<?= $f['id']; ?>" onclick="return confirm('Delete this footer link?')" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No footer links found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>