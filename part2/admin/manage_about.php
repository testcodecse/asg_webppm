<?php
session_start();
include '../../inc/config.php';
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') header('Location: ../../part1/login.php');
$success='';
if(isset($_FILES['about_image']) && $_FILES['about_image']['error']==0){
    $upload_dir='../../uploads/'; if(!is_dir($upload_dir)) mkdir($upload_dir,0777,true);
    $ext=strtolower(pathinfo($_FILES['about_image']['name'],PATHINFO_EXTENSION));
    if(in_array($ext,['jpg','jpeg','png','gif','webp'])){
        $new_name='about_page_'.time().'.'.$ext;
        if(move_uploaded_file($_FILES['about_image']['tmp_name'],$upload_dir.$new_name)){
            $conn->prepare("UPDATE about_content SET content_value=? WHERE content_key='about_image'")->execute(['uploads/'.$new_name]);
            $success='Cập nhật ảnh thành công!';
        }
    }
}
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['update_text'])){
    $fields=['company_name','company_history','mission','vision','core_values','why_choose_us'];
    foreach($fields as $f) $conn->prepare("UPDATE about_content SET content_value=? WHERE content_key=?")->execute([$_POST[$f],$f]);
    $success='Cập nhật thành công!';
}
$content=[]; $stmt=$conn->query("SELECT content_key,content_value FROM about_content");
while($row=$stmt->fetch()) $content[$row['content_key']]=$row['content_value'];
?>
<!DOCTYPE html>
<html lang="vi">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Quản lý giới thiệu</title>
<link rel="stylesheet" href="http://localhost/company_website/srtdash/assets/css/admin.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"></head>
<body>
<div class="page-container"><div class="sidebar-menu"><div class="sidebar-header"><div class="logo"><h5>Công ty ABC</h5></div></div>
<div class="main-menu"><ul class="metismenu"><li><a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
<li class="active"><a href="manage_about.php"><i class="fas fa-info-circle"></i> Quản lý giới thiệu</a></li>
<li><a href="manage_faq.php"><i class="fas fa-question-circle"></i> Quản lý FAQ</a></li>
<li><a href="../../part1/logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li></ul></div></div>
<div class="main-content"><div class="header-area"><div class="nav-btn"><i class="fas fa-bars"></i></div><div class="user-profile"><div class="avatar"><?php echo substr($_SESSION['user_name'],0,1); ?></div><div class="user-name"><?php echo $_SESSION['user_name']; ?></div></div></div>
<div class="main-content-inner"><?php if($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
<div class="card"><div class="card-header">Ảnh giới thiệu</div><div class="card-body"><?php if(!empty($content['about_image']) && file_exists('../../'.$content['about_image'])): ?><img src="../../<?php echo $content['about_image']; ?>" style="max-width:200px" class="img-thumbnail mb-3"><?php endif; ?>
<form method="POST" enctype="multipart/form-data"><input type="file" name="about_image" class="form-control mb-2"><button class="btn btn-primary">Upload ảnh</button></form></div></div>
<div class="card"><div class="card-header">Nội dung văn bản</div><div class="card-body"><form method="POST"><input type="hidden" name="update_text" value="1">
<div class="mb-3"><label>Tên công ty</label><input type="text" name="company_name" class="form-control" value="<?php echo htmlspecialchars($content['company_name']??''); ?>"></div>
<div class="mb-3"><label>Lịch sử hình thành</label><textarea name="company_history" class="form-control" rows="4"><?php echo htmlspecialchars($content['company_history']??''); ?></textarea></div>
<div class="mb-3"><label>Sứ mệnh</label><textarea name="mission" class="form-control" rows="3"><?php echo htmlspecialchars($content['mission']??''); ?></textarea></div>
<div class="mb-3"><label>Tầm nhìn</label><textarea name="vision" class="form-control" rows="3"><?php echo htmlspecialchars($content['vision']??''); ?></textarea></div>
<div class="mb-3"><label>Giá trị cốt lõi</label><textarea name="core_values" class="form-control" rows="2"><?php echo htmlspecialchars($content['core_values']??''); ?></textarea></div>
<div class="mb-3"><label>Tại sao chọn chúng tôi</label><textarea name="why_choose_us" class="form-control" rows="3"><?php echo htmlspecialchars($content['why_choose_us']??''); ?></textarea></div>
<button class="btn btn-primary">Lưu thay đổi</button></form></div></div></div></div></div>
<script>document.querySelector('.nav-btn').addEventListener('click',function(){document.querySelector('.sidebar-menu').classList.toggle('active');});</script>
</body>
</html>