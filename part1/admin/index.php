<?php
session_start();
include '../../inc/config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

$contact_count = $conn->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
$unread_count = $conn->query("SELECT COUNT(*) FROM contacts WHERE status = 'chua_doc'")->fetchColumn();
$user_count = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="http://localhost/company_website/srtdash/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="page-container">
    <div class="sidebar-menu">
        <div class="sidebar-header">
            <div class="logo"><h5>Công ty ABC</h5></div>
        </div>
        <div class="main-menu">
            <ul class="metismenu">
                <li class="active"><a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="manage_contacts.php"><i class="fas fa-envelope"></i> Quản lý liên hệ</a></li>
                <li><a href="manage_home.php"><i class="fas fa-edit"></i> Quản lý nội dung</a></li>
                <li><a href="manage_users.php"><i class="fas fa-users"></i> Quản lý thành viên</a></li>
                <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="header-area">
            <div class="nav-btn"><i class="fas fa-bars"></i></div>
            <div class="user-profile">
                <div class="avatar"><?php echo substr($_SESSION['user_name'], 0, 1); ?></div>
                <div class="user-name"><?php echo $_SESSION['user_name']; ?></div>
            </div>
        </div>

        <div class="main-content-inner">
            <div class="row">
                <div class="col-md-4">
                    <div class="single-report">
                        <div class="s-report-inner">
                            <div><div class="s-report-title">Tổng liên hệ</div><h2><?php echo $contact_count; ?></h2></div>
                            <div class="icon icon-blue"><i class="fas fa-envelope"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-report">
                        <div class="s-report-inner">
                            <div><div class="s-report-title">Chưa đọc</div><h2><?php echo $unread_count; ?></h2></div>
                            <div class="icon icon-amber"><i class="fas fa-eye"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-report">
                        <div class="s-report-inner">
                            <div><div class="s-report-title">Thành viên</div><h2><?php echo $user_count; ?></h2></div>
                            <div class="icon icon-emerald"><i class="fas fa-users"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelector('.nav-btn').addEventListener('click', function() {
    document.querySelector('.sidebar-menu').classList.toggle('active');
    document.querySelector('.page-container').classList.toggle('sbar_collapsed');
});

document.querySelector('.user-profile').addEventListener('click', function(e) {
    let dropdown = this.querySelector('.dropdown-menu');
    if(dropdown) {
        dropdown.classList.toggle('show');
        e.stopPropagation();
    }
});
</script>
</body>
</html>