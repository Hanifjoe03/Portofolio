<?php
require_once '../config/database.php';

// Ambil semua admin
$stmt = $pdo->query("SELECT * FROM admin ORDER BY id DESC");
$admins = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-body">
                <h2 class="mb-4">📋 Daftar Admin</h2>
                <a href="add_admin.php" class="btn btn-success mb-3">➕ Tambah Admin</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($admins as $admin): ?>
                            <tr>
                                <td><?= htmlspecialchars($admin['id']); ?></td>
                                <td><?= htmlspecialchars($admin['username']); ?></td>
                                <td>
                                    <a href="edit_admin.php?id=<?= $admin['id']; ?>" class="btn btn-warning btn-sm">✏ Edit</a>
                                    <a href="delete_admin.php?id=<?= $admin['id']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus admin ini?');">🗑 Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($admins)): ?>
                            <tr>
                                <td colspan="3" class="text-center">Belum ada admin</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>