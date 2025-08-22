<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM footer_links WHERE id=?");
$stmt->execute([$id]);

header("Location: footer.php");
exit;
