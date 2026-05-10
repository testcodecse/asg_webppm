<?php
include '../inc/config.php';

if(isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'Lỗi bảo mật, vui lòng thử lại';
    } else {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $fullname = trim($_POST['fullname']);
        
        if(empty($username) || empty($email) || empty($password)) {
            $error = 'Vui lòng điền đầy đủ thông tin bắt buộc';
        } elseif($password != $confirm_password) {
            $error = 'Mật khẩu xác nhận không khớp';
        } elseif(strlen($password) < 6) {
            $error = 'Mật khẩu phải có ít nhất 6 ký tự';
        } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Email không hợp lệ';
        } else {
            $check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $check->execute([$username, $email]);
            
            if($check->rowCount() > 0) {
                $error = 'Tên đăng nhập hoặc email đã được sử dụng';
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (username, email, password, fullname, role, status) VALUES (?, ?, ?, ?, 'member', 1)";
                $stmt = $conn->prepare($sql);
                
                if($stmt->execute([$username, $email, $hashed_password, $fullname])) {
                    $success = 'Đăng ký thành công! Bạn có thể đăng nhập ngay.';
                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                } else {
                    $error = 'Có lỗi xảy ra, vui lòng thử lại sau';
                }
            }
        }
    }
}

include '../templates/header.php';
?>

<main>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0"><i class="fas fa-user-plus me-2"></i>Đăng ký tài khoản</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php if($success): ?>
                            <div class="alert alert-success">
                                <?php echo $success; ?>
                                <a href="login.php">Đăng nhập ngay</a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form method="POST" id="registerForm">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <div class="mb-3">
                                <label class="form-label">Tên đăng nhập <span class="text-danger">*</span></label>
                                <input type="text" name="username" id="reg_username" class="form-control" required>
                                <div id="reg_usernameError" class="text-danger small"></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="reg_email" class="form-control" required>
                                <div id="reg_emailError" class="text-danger small"></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Họ tên</label>
                                <input type="text" name="fullname" id="fullname" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mật khẩu <span class="text-danger">*</span> <small class="text-muted">(tối thiểu 6 ký tự)</small></label>
                                <input type="password" name="password" id="reg_password" class="form-control" required>
                                <div id="reg_passwordError" class="text-danger small"></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                                <div id="confirm_passwordError" class="text-danger small"></div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="fas fa-user-plus me-2"></i>Đăng ký
                            </button>
                        </form>
                        
                        <p class="mt-3 text-center">
                            Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../templates/footer.php'; ?>