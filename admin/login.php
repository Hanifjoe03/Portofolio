<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->execute([$_POST['email']]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($_POST['password'], $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid email or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link href="css/styles.css" rel="stylesheet">
</head>

<body class="bg-light d-flex justify-content-center align-items-center" style="height:100vh;">
    <form method="post" class="p-4 bg-white rounded shadow">
        <h2 class="mb-3">Admin Login</h2>
        <?php if (!empty($error)) echo "<p class='text-danger'>$error</p>"; ?>
        <div class="mb-3">
            <input type="email" name="email" placeholder="Email" class="form-control" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" placeholder="Password" class="form-control" required>
        </div>
        <button class="btn btn-primary w-100">Login</button>
    </form>
</body>

</html>