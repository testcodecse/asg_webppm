<?php
session_start();
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

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    
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
?>

<?php include '../templates/header.php'; ?>

<main>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
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
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Tên đăng nhập</label>
                                <input type="text" class="form-control bg-light" value="<?php echo $user['username']; ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Họ tên</label>
                                <input type="text" name="fullname" class="form-control" value="<?php echo $user['fullname']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
                            </div>
                            
                            <hr class="my-4">
                            <h5 class="mb-3"><i class="fas fa-key me-2"></i>Đổi mật khẩu</h5>
                            <div class="mb-3">
                                <label class="form-label">Mật khẩu mới</label>
                                <input type="password" name="new_password" class="form-control" placeholder="Để trống nếu không đổi">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Xác nhận mật khẩu mới</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Để trống nếu không đổi">
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="fas fa-save me-2"></i>Cập nhật
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../templates/footer.php'; ?>