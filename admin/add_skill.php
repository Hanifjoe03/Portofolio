<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $proficiency = intval($_POST['proficiency']);

    $stmt = $pdo->prepare("INSERT INTO skills (name, category, proficiency) VALUES (?, ?, ?)");
    $stmt->execute([$name, $category, $proficiency]);

    header("Location: skills.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Skill</title>
    <link href="css/projects.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Add Skill</h1>
        <form method="post">
            <label>Name</label>
            <input type="text" name="name" required>
            <label>Category</label>
            <input type="text" name="category" required>
            <label>Proficiency (%)</label>
            <input type="number" name="proficiency" min="0" max="100" required>
            <button type="submit" class="btn btn-success">Save</button>
            <a href="skills.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>