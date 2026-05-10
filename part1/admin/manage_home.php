<?php
session_start();
include '../../inc/config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

$success = '';
$error = '';

if(isset($_FILES['hero_image']) && $_FILES['hero_image']['error'] == 0) {
    $upload_dir = '../../uploads/';
    if(!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    $ext = strtolower(pathinfo($_FILES['hero_image']['name'], PATHINFO_EXTENSION));
    if(in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
        $new_name = 'hero_' . time() . '.' . $ext;
        if(move_uploaded_file($_FILES['hero_image']['tmp_name'], $upload_dir . $new_name)) {
            $conn->prepare("UPDATE home_content SET content_value = ? WHERE content_key = 'hero_image'")->execute(['uploads/' . $new_name]);
            $success = 'Cập nhật ảnh hero thành công!';
        } else $error = 'Upload thất bại';
    } else $error = 'Sai định dạng ảnh';
}

if(isset($_FILES['about_image']) && $_FILES['about_image']['error'] == 0) {
    $upload_dir = '../../uploads/';
    if(!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    $ext = strtolower(pathinfo($_FILES['about_image']['name'], PATHINFO_EXTENSION));
    if(in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
        $new_name = 'about_' . time() . '.' . $ext;
        if(move_uploaded_file($_FILES['about_image']['tmp_name'], $upload_dir . $new_name)) {
            $conn->prepare("UPDATE home_content SET content_value = ? WHERE content_key = 'about_image'")->execute(['uploads/' . $new_name]);
            $success = 'Cập nhật ảnh giới thiệu thành công!';
        } else $error = 'Upload thất bại';
    } else $error = 'Sai định dạng ảnh';
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_text'])) {
    $fields = ['hero_title', 'hero_subtitle', 'about_text', 'phone', 'email', 'address'];
    foreach($fields as $field) {
        $conn->prepare("UPDATE home_content SET content_value = ? WHERE content_key = ?")->execute([$_POST[$field], $field]);
    }
    $success = 'Cập nhật nội dung thành công!';
}

$content = [];
$stmt = $conn->query("SELECT content_key, content_value FROM home_content");
while($row = $stmt->fetch()) $content[$row['content_key']] = $row['content_value'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nội dung</title>
    <link rel="stylesheet" href="http://localhost/company_website/srtdash/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="page-container">
    <div class="sidebar-menu">
        <div class="sidebar-header"><div class="logo"><h5>Công ty ABC</h5></div></div>
        <div class="main-menu">
            <ul class="metismenu">
                <li><a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="manage_contacts.php"><i class="fas fa-envelope"></i> Quản lý liên hệ</a></li>
                <li class="active"><a href="manage_home.php"><i class="fas fa-edit"></i> Quản lý nội dung</a></li>
                <li><a href="manage_users.php"><i class="fas fa-users"></i> Quản lý thành viên</a></li>
                <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="header-area">
            <div class="nav-btn"><i class="fas fa-bars"></i></div>
            <div class="user-profile"><div class="avatar"><?php echo substr($_SESSION['user_name'], 0, 1); ?></div><div class="user-name"><?php echo $_SESSION['user_name']; ?></div></div>
        </div>

        <div class="main-content-inner">
            <?php if($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
            <?php if($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>

            <div class="card">
                <div class="card-header">Ảnh Hero</div>
                <div class="card-body">
                    <?php if(!empty($content['hero_image']) && file_exists('../../' . $content['hero_image'])): ?>
                        <img src="../../<?php echo $content['hero_image']; ?>" style="max-width:200px" class="img-thumbnail mb-3">
                    <?php endif; ?>
                    <form method="POST" enctype="multipart/form-data"><input type="file" name="hero_image" class="form-control mb-2"><button class="btn btn-primary">Upload ảnh hero</button></form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Ảnh giới thiệu</div>
                <div class="card-body">
                    <?php if(!empty($content['about_image']) && file_exists('../../' . $content['about_image'])): ?>
                        <img src="../../<?php echo $content['about_image']; ?>" style="max-width:200px" class="img-thumbnail mb-3">
                    <?php endif; ?>
                    <form method="POST" enctype="multipart/form-data"><input type="file" name="about_image" class="form-control mb-2"><button class="btn btn-primary">Upload ảnh giới thiệu</button></form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Nội dung văn bản</div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="update_text" value="1">
                        <div class="mb-3"><label>Tiêu đề Hero</label><input type="text" name="hero_title" class="form-control" value="<?php echo htmlspecialchars($content['hero_title'] ?? ''); ?>"></div>
                        <div class="mb-3"><label>Phụ đề Hero</label><input type="text" name="hero_subtitle" class="form-control" value="<?php echo htmlspecialchars($content['hero_subtitle'] ?? ''); ?>"></div>
                        <div class="mb-3"><label>Nội dung giới thiệu</label><textarea name="about_text" class="form-control" rows="4"><?php echo htmlspecialchars($content['about_text'] ?? ''); ?></textarea></div>
                        <div class="mb-3"><label>Số điện thoại</label><input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($content['phone'] ?? ''); ?>"></div>
                        <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($content['email'] ?? ''); ?>"></div>
                        <div class="mb-3"><label>Địa chỉ</label><input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($content['address'] ?? ''); ?>"></div>
                        <button class="btn btn-primary">Lưu thay đổi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>document.querySelector('.nav-btn').addEventListener('click',function(){document.querySelector('.sidebar-menu').classList.toggle('active');});</script>
</body>
</html>