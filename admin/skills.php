<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM skills ORDER BY category, proficiency DESC");
$skills = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin - Skills</title>
    <link href="css/projects.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Skills</h1>
        <a href="add_skill.php" class="btn btn-success">+ Add Skill</a>

        <div class="table-container">
            <h2>Skill List</h2>
            <?php if (count($skills) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Proficiency</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($skills as $s): ?>
                            <tr>
                                <td><?= htmlspecialchars($s['name']); ?></td>
                                <td><?= htmlspecialchars($s['category']); ?></td>
                                <td><?= htmlspecialchars($s['proficiency']); ?>%</td>
                                <td>
                                    <a href="edit_skill.php?id=<?= $s['id']; ?>" class="btn btn-primary">Edit</a>
                                    <a href="delete_skill.php?id=<?= $s['id']; ?>"
                                        onclick="return confirm('Delete this skill?')"
                                        class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No skills found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>