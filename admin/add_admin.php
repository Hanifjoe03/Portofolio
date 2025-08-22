<?php
require_once '../config/database.php';

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        // Hash password sebelum disimpan
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hashedPassword]);
            $success = "✅ Admin baru berhasil ditambahkan!";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Duplicate entry
                $error = "❌ Username sudah digunakan!";
            } else {
                $error = "❌ Terjadi kesalahan: " . $e->getMessage();
            }
        }
    } else {
        $error = "❌ Semua field wajib diisi!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-body">
                <h2 class="mb-4">➕ Tambah Admin</h2>

                <?php if ($success): ?>
                    <div class="alert alert-success"><?= $success; ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Tambah Admin</button>
                    <a href="list_admin.php" class="btn btn-secondary">⬅ Kembali</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>