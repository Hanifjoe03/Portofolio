<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: projects.php");
    exit;
}

// Ambil data project untuk hapus gambar
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id=?");
$stmt->execute([$id]);
$project = $stmt->fetch();

if ($project) {
    // Hapus gambar dari folder
    if ($project['image_url'] && file_exists(__DIR__ . '/../' . $project['image_url'])) {
        unlink(__DIR__ . '/../' . $project['image_url']);
    }

    // Hapus dari database
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id=?");
    $stmt->execute([$id]);
}

header("Location: projects.php");
exit;
