<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'];
    $company = $_POST['company'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'] ?: null;
    $description = $_POST['description'];

    $stmt = $pdo->prepare("INSERT INTO experience (role, company, start_date, end_date, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$role, $company, $start_date, $end_date, $description]);

    header("Location: experience.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Experience</title>
    <link href="css/projects.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Add Experience</h1>
        <form method="post">
            <label>Role</label>
            <input type="text" name="role" required>
            <label>Company</label>
            <input type="text" name="company" required>
            <label>Start Date</label>
            <input type="date" name="start_date" required>
            <label>End Date</label>
            <input type="date" name="end_date">
            <label>Description</label>
            <textarea name="description"></textarea>
            <button type="submit" class="btn btn-success">Save</button>
            <a href="experience.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>