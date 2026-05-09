<?php
session_start();
include '../../inc/config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: ../../part1/login.php');
    exit;
}

$about_count = $conn->query("SELECT COUNT(*) FROM about_content")->fetchColumn();
$faq_count = $conn->query("SELECT COUNT(*) FROM faq")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Phan 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 bg-dark text-white min-vh-100 p-0">
                <div class="text-center py-4 border-bottom border-secondary">
                    <h5>Admin Phan 2</h5>
                    <small><?php echo $_SESSION['user_name']; ?></small>
                </div>
                <ul class="nav flex-column mt-3">
                    <li class="nav-item">
                        <a class="nav-link text-white bg-primary" href="index.php">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="manage_about.php">
                            <i class="fas fa-info-circle me-2"></i> Quan ly gioi thieu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="manage_faq.php">
                            <i class="fas fa-question-circle me-2"></i> Quan ly FAQ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../../part1/logout.php">
                            <i class="fas fa-sign-out-alt me-2"></i> Dang xuat
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-md-9 col-lg-10 p-4">
                <h2>Dashboard Phan 2</h2>
                <div class="row mt-4">
                    <div class="col-md-4 mb-3">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <h5 class="card-title">Noi dung gioi thieu</h5>
                                <p class="card-text display-6"><?php echo $about_count; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <h5 class="card-title">Cau hoi FAQ</h5>
                                <p class="card-text display-6"><?php echo $faq_count; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>