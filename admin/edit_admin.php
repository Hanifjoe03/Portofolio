<?php
require_once '../config/database.php';

$success = $error = "";
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: list_admin.php");
    exit;
}

// Ambil data admin
$stmt = $pdo->prepare("SELECT * FROM admin WHERE id = ?");
$stmt->execute([$id]);
$admin = $stmt->fetch();

if (!$admin) {
    die("Admin tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username)) {
        try {
            if (!empty($password)) {
                // Update dengan password baru
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE admin SET username = ?, password = ? WHERE id = ?");
                $stmt->execute([$username, $hashedPassword, $id]);
            } else {
                // Update hanya username
                $stmt = $pdo->prepare("UPDATE admin SET username = ? WHERE id = ?");
                $stmt->execute([$username, $id]);
            }
            $success = "✅ Data admin berhasil diperbarui!";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $error = "❌ Username sudah digunakan!";
            } else {
                $error = "❌ Terjadi kesalahan: " . $e->getMessage();
            }
        }
    } else {
        $error = "❌ Username tidak boleh kosong!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-body">
                <h2 class="mb-4">✏ Edit Admin</h2>

                <?php if ($success): ?>
                    <div class="alert alert-success"><?= $success; ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username"
                            class="form-control"
                            value="<?= htmlspecialchars($admin['username']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password (kosongkan jika tidak ingin diubah)</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="list_admin.php" class="btn btn-secondary">⬅ Kembali</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>