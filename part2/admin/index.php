<?php
session_start();
include '../../inc/config.php';
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') header('Location: ../../part1/login.php');
$about_count = $conn->query("SELECT COUNT(*) FROM about_content")->fetchColumn();
$faq_count = $conn->query("SELECT COUNT(*) FROM faq")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="vi">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Admin Phần 2</title>
<link rel="stylesheet" href="http://localhost/company_website/srtdash/assets/css/admin.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"></head>
<body>
<div class="page-container">
    <div class="sidebar-menu"><div class="sidebar-header"><div class="logo"><h5>Công ty ABC</h5></div></div>
    <div class="main-menu"><ul class="metismenu">
        <li class="active"><a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="manage_about.php"><i class="fas fa-info-circle"></i> Quản lý giới thiệu</a></li>
        <li><a href="manage_faq.php"><i class="fas fa-question-circle"></i> Quản lý FAQ</a></li>
        <li><a href="../../part1/logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
    </ul></div></div>
    <div class="main-content"><div class="header-area"><div class="nav-btn"><i class="fas fa-bars"></i></div><div class="user-profile"><div class="avatar"><?php echo substr($_SESSION['user_name'],0,1); ?></div><div class="user-name"><?php echo $_SESSION['user_name']; ?></div></div></div>
    <div class="main-content-inner"><div class="row"><div class="col-md-6"><div class="single-report"><div class="s-report-inner"><div><div class="s-report-title">Nội dung giới thiệu</div><h2><?php echo $about_count; ?></h2></div><div class="icon icon-indigo"><i class="fas fa-info-circle"></i></div></div></div></div>
    <div class="col-md-6"><div class="single-report"><div class="s-report-inner"><div><div class="s-report-title">Câu hỏi FAQ</div><h2><?php echo $faq_count; ?></h2></div><div class="icon icon-purple"><i class="fas fa-question-circle"></i></div></div></div></div></div></div></div>
</div>
<script>document.querySelector('.nav-btn').addEventListener('click',function(){document.querySelector('.sidebar-menu').classList.toggle('active');});</script>
</body>
</html>