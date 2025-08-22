<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: experience.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM experience WHERE id = ?");
$stmt->execute([$id]);
$exp = $stmt->fetch();

if (!$exp) {
    header("Location: experience.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'];
    $company = $_POST['company'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'] ?: null;
    $description = $_POST['description'];

    $stmt = $pdo->prepare("UPDATE experience SET role=?, company=?, start_date=?, end_date=?, description=? WHERE id=?");
    $stmt->execute([$role, $company, $start_date, $end_date, $description, $id]);

    header("Location: experience.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Experience</title>
    <link href="css/projects.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Edit Experience</h1>
        <form method="post">
            <label>Role</label>
            <input type="text" name="role" value="<?= htmlspecialchars($exp['role']) ?>" required>
            <label>Company</label>
            <input type="text" name="company" value="<?= htmlspecialchars($exp['company']) ?>" required>
            <label>Start Date</label>
            <input type="date" name="start_date" value="<?= htmlspecialchars($exp['start_date']) ?>" required>
            <label>End Date</label>
            <input type="date" name="end_date" value="<?= htmlspecialchars($exp['end_date']) ?>">
            <label>Description</label>
            <textarea name="description"><?= htmlspecialchars($exp['description']) ?></textarea>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="experience.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>