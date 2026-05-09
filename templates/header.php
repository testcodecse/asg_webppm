<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Công ty ABC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .nav-link {
            font-weight: 500;
            transition: 0.3s;
        }
        .nav-link:hover {
            opacity: 0.8;
            transform: translateY(-2px);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            transition: 0.3s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102,126,234,0.4);
        }
        .card {
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        }
        footer {
            background: linear-gradient(135deg, #1e2a3a 0%, #0f1724 100%);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../part1/index.php">
                <i class="fas fa-building me-2"></i>Công ty ABC
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../part1/index.php"><i class="fas fa-home me-1"></i>Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="../part1/contact.php"><i class="fas fa-envelope me-1"></i>Liên hệ</a></li>
                    <li class="nav-item"><a class="nav-link" href="../part2/about.php"><i class="fas fa-info-circle me-1"></i>Giới thiệu</a></li>
                    <li class="nav-item"><a class="nav-link" href="../part2/faq.php"><i class="fas fa-question-circle me-1"></i>Hỏi/Đáp</a></li>
                    
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link" href="../part1/profile.php"><i class="fas fa-user me-1"></i>Xin chào, <?php echo $_SESSION['user_name'] ?? 'User'; ?></a></li>
                        <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
                            <li class="nav-item"><a class="nav-link" href="../part1/admin/index.php"><i class="fas fa-tachometer-alt me-1"></i>Quản trị</a></li>
                        <?php endif; ?>
                        <li class="nav-item"><a class="nav-link" href="../part1/logout.php"><i class="fas fa-sign-out-alt me-1"></i>Đăng xuất</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="../part1/login.php"><i class="fas fa-sign-in-alt me-1"></i>Đăng nhập</a></li>
                        <li class="nav-item"><a class="nav-link" href="../part1/register.php"><i class="fas fa-user-plus me-1"></i>Đăng ký</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>