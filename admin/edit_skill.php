<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: skills.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM skills WHERE id = ?");
$stmt->execute([$id]);
$skill = $stmt->fetch();

if (!$skill) {
    header("Location: skills.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $proficiency = intval($_POST['proficiency']);

    $stmt = $pdo->prepare("UPDATE skills SET name=?, category=?, proficiency=? WHERE id=?");
    $stmt->execute([$name, $category, $proficiency, $id]);

    header("Location: skills.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Skill</title>
    <link href="css/projects.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Edit Skill</h1>
        <form method="post">
            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($skill['name']) ?>" required>
            <label>Category</label>
            <input type="text" name="category" value="<?= htmlspecialchars($skill['category']) ?>" required>
            <label>Proficiency (%)</label>
            <input type="number" name="proficiency" value="<?= htmlspecialchars($skill['proficiency']) ?>" min="0" max="100" required>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="skills.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>