<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM experience ORDER BY start_date DESC");
$experiences = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin - Experience</title>
    <link href="css/projects.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Experience</h1>
        <a href="add_experience.php" class="btn btn-success">+ Add Experience</a>

        <div class="table-container">
            <h2>Experience List</h2>
            <?php if (count($experiences) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th>Company</th>
                            <th>Duration</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($experiences as $e): ?>
                            <tr>
                                <td><?= htmlspecialchars($e['role']); ?></td>
                                <td><?= htmlspecialchars($e['company']); ?></td>
                                <td>
                                    <?= htmlspecialchars($e['start_date']); ?> -
                                    <?= $e['end_date'] ? htmlspecialchars($e['end_date']) : 'Present'; ?>
                                </td>
                                <td><?= htmlspecialchars($e['description']); ?></td>
                                <td>
                                    <a href="edit_experience.php?id=<?= $e['id']; ?>" class="btn btn-primary">Edit</a>
                                    <a href="delete_experience.php?id=<?= $e['id']; ?>"
                                        onclick="return confirm('Delete this experience?')"
                                        class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No experience found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>