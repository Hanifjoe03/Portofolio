<?php
session_start();
require_once '../config/database.php';

// Cek login admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil data projects
$stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC");
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin - Projects</title>
    <link href="css/projects.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Projects</h1>
        <a href="add_project.php" class="btn btn-success">+ Add Project</a>

        <div class="table-container">
            <h2>Project List</h2>
            <?php if (count($projects) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Links</th>
                            <th>Technologies</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['title']); ?></td>
                                <td><?= htmlspecialchars($p['category']); ?></td>
                                <td>
                                    <?php if (!empty($p['image_url'])): ?>
                                        <img src="uploads/<?= htmlspecialchars($p['image_url']); ?>" width="100" alt="Project Image">
                                    <?php else: ?>
                                        <span>No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($p['github_url'])): ?>
                                        <a href="<?= htmlspecialchars($p['github_url']); ?>" target="_blank">GitHub</a>
                                    <?php endif; ?>
                                    <?php if (!empty($p['live_url'])): ?>
                                        | <a href="<?= htmlspecialchars($p['live_url']); ?>" target="_blank">Live</a>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($p['technologies']); ?></td>
                                <td><?= htmlspecialchars($p['created_at']); ?></td>
                                <td>
                                    <a href="edit_project.php?id=<?= $p['id']; ?>" class="btn btn-primary">Edit</a>
                                    <a href="delete_project.php?id=<?= $p['id']; ?>"
                                        onclick="return confirm('Delete this project?')"
                                        class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No projects found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>