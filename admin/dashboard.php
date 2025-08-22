<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Ambil data projects
$stmt = $pdo->query('SELECT * FROM projects ORDER BY id DESC LIMIT 5');
$projects = $stmt->fetchAll();

// Ambil data skills
$stmt = $pdo->query('SELECT * FROM skills ORDER BY id DESC LIMIT 5');
$skills = $stmt->fetchAll();

// Ambil data experience
$stmt = $pdo->query('SELECT * FROM experience ORDER BY id DESC LIMIT 5');
$experiences = $stmt->fetchAll();

// Ambil footer (misalnya disimpan di tabel settings dengan key = footer_text)
$stmt = $pdo->prepare("SELECT value FROM settings WHERE name = 'footer_text' LIMIT 1");
$stmt->execute();
$footer_text = $stmt->fetchColumn() ?: 'Default footer text here';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../output.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed bg-light">
    <!-- Navbar -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark shadow-sm">
        <a class="navbar-brand ps-3 fw-bold" href="dashboard.php">Portfolio Admin</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto me-3">
            <li class="nav-item dropdown ms-2">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li><a class="dropdown-item" href="admins.php">Manage Admins</a></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Layout -->
    <div id="layoutSidenav">
        <!-- Sidebar -->
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark shadow-sm" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link active" href="dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Content</div>
                        <a class="nav-link" href="projects.php"><i class="fas fa-project-diagram me-2"></i>Projects</a>
                        <a class="nav-link" href="skills.php"><i class="fas fa-code me-2"></i>Skills</a>
                        <a class="nav-link" href="experience.php"><i class="fas fa-briefcase me-2"></i>Experience</a>
                        <a class="nav-link" href="footer.php"><i class="fas fa-shoe-prints me-2"></i>Footer</a>
                        <a class="nav-link" href="admins.php"><i class="fas fa-users-cog me-2"></i>Admins</a>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Content -->
        <div id="layoutSidenav_content">
            <main class="p-4">
                <div class="container-fluid px-4">
                    <h1 class="mt-2 fw-bold">Dashboard</h1>
                    <p class="text-muted">Overview of portfolio content</p>

                    <!-- ====== Projects ====== -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white fw-bold"><i class="fas fa-table me-2"></i> Recent Projects</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($projects as $p): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($p['title']); ?></td>
                                                <td><span class="badge bg-info text-dark"><?= htmlspecialchars($p['category']); ?></span></td>
                                                <td><?= date('d M Y', strtotime($p['created_at'])); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <a href="projects.php" class="btn btn-sm btn-primary">Manage Projects</a>
                            </div>
                        </div>
                    </div>

                    <!-- ====== Skills ====== -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white fw-bold"><i class="fas fa-code me-2"></i> Recent Skills</div>
                        <div class="card-body">
                            <ul class="list-group">
                                <?php foreach ($skills as $s): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?= htmlspecialchars($s['name']); ?>
                                        <span class="badge bg-success"><?= htmlspecialchars($s['level']); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <a href="skills.php" class="btn btn-sm btn-success mt-2">Manage Skills</a>
                        </div>
                    </div>

                    <!-- ====== Experience ====== -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white fw-bold"><i class="fas fa-briefcase me-2"></i> Recent Experience</div>
                        <div class="card-body">
                            <ul class="list-group">
                                <?php foreach ($experiences as $e): ?>
                                    <li class="list-group-item">
                                        <strong><?= htmlspecialchars($e['position']); ?></strong> - <?= htmlspecialchars($e['company']); ?>
                                        <br><small class="text-muted"><?= htmlspecialchars($e['duration']); ?></small>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <a href="experience.php" class="btn btn-sm btn-warning mt-2">Manage Experience</a>
                        </div>
                    </div>

                    <!-- ====== Footer ====== -->
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white fw-bold"><i class="fas fa-shoe-prints me-2"></i> Footer</div>
                        <div class="card-body">
                            <p><?= htmlspecialchars($footer_text); ?></p>
                            <a href="footer.php" class="btn btn-sm btn-danger">Edit Footer</a>
                        </div>
                    </div>

                </div>
            </main>

            <footer class="py-3 bg-white mt-auto border-top">
                <div class="container-fluid px-4 text-muted small text-center">
                    &copy; <?= date('Y'); ?> Portfolio Admin Dashboard
                </div>
            </footer>
        </div>
    </div>
</body>

</html>