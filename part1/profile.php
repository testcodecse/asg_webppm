<?php
include '../inc/config.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$success = '';
$error = '';

if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
    $upload_dir = '../uploads/avatars/';
    if(!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $filename = $_FILES['avatar']['name'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    if(in_array($ext, $allowed)) {
        $new_name = 'user_' . $user_id . '_' . time() . '.' . $ext;
        $destination = $upload_dir . $new_name;
        
        if(move_uploaded_file($_FILES['avatar']['tmp_name'], $destination)) {
            $avatar_path = 'uploads/avatars/' . $new_name;
            $update_avatar = $conn->prepare("UPDATE users SET avatar = ? WHERE id = ?");
            $update_avatar->execute([$avatar_path, $user_id]);
            $success = 'Cập nhật ảnh đại diện thành công!';
            $user['avatar'] = $avatar_path;
        } else {
            $error = 'Upload ảnh thất bại';
        }
    } else {
        $error = 'Chỉ chấp nhận file JPG, PNG, GIF, WEBP';
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    if(!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'Lỗi bảo mật, vui lòng thử lại';
    } else {
        $fullname = trim($_POST['fullname']);
        $email = trim($_POST['email']);
        
        if(empty($email)) {
            $error = 'Email không được để trống';
        } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Email không hợp lệ';
        } else {
            $update = $conn->prepare("UPDATE users SET fullname = ?, email = ? WHERE id = ?");
            if($update->execute([$fullname, $email, $user_id])) {
                $_SESSION['user_name'] = $fullname;
                $success = 'Cập nhật thông tin thành công!';
                $user['fullname'] = $fullname;
                $user['email'] = $email;
            } else {
                $error = 'Cập nhật thất bại, vui lòng thử lại';
            }
        }
        
        if(!empty($_POST['new_password'])) {
            $new_pass = $_POST['new_password'];
            $confirm_pass = $_POST['confirm_password'];
            
            if(strlen($new_pass) < 6) {
                $error = 'Mật khẩu phải có ít nhất 6 ký tự';
            } elseif($new_pass != $confirm_pass) {
                $error = 'Mật khẩu xác nhận không khớp';
            } else {
                $hashed = password_hash($new_pass, PASSWORD_DEFAULT);
                $conn->prepare("UPDATE users SET password = ? WHERE id = ?")->execute([$hashed, $user_id]);
                $success = 'Cập nhật mật khẩu thành công!';
            }
        }
    }
}

include '../templates/header.php';
?>

<main>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0"><i class="fas fa-user-circle me-2"></i>Thông tin tài khoản</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php if($success): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php endif; ?>
                        <?php if($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <div class="row mb-4">
                            <div class="col-md-3 text-center">
                                <?php if(isset($user['avatar']) && file_exists('../' . $user['avatar'])): ?>
                                    <img src="../<?php echo $user['avatar']; ?>" class="rounded-circle img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/120?text=Avatar" class="rounded-circle img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                                <?php endif; ?>
                                
                                <form method="POST" enctype="multipart/form-data" class="mt-2">
                                    <input type="file" name="avatar" class="form-control form-control-sm" accept="image/*">
                                    <button type="submit" class="btn btn-sm btn-outline-primary mt-2">Đổi avatar</button>
                                </form>
                            </div>
                            
                            <div class="col-md-9">
                                <form method="POST" id="profileForm">
                                    <input type="hidden" name="update_profile" value="1">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Tên đăng nhập</label>
                                        <input type="text" class="form-control bg-light" value="<?php echo $user['username']; ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Họ tên</label>
                                        <input type="text" name="fullname" id="fullname" class="form-control" value="<?php echo $user['fullname']; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" value="<?php echo $user['email']; ?>" required>
                                        <div id="emailError" class="text-danger small"></div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                                </form>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        <h5 class="mb-3"><i class="fas fa-key me-2"></i>Đổi mật khẩu</h5>
                        <form method="POST" id="passwordForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Mật khẩu mới</label>
                                        <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Để trống nếu không đổi">
                                        <div id="new_passwordError" class="text-danger small"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Xác nhận mật khẩu mới</label>
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Để trống nếu không đổi">
                                        <div id="confirm_passwordError" class="text-danger small"></div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning">Đổi mật khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../templates/footer.php'; ?>