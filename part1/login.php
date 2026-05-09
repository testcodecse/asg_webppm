<?php
session_start();

if(isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

include '../inc/config.php';

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if(empty($username) || empty($password)) {
        $error = 'Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu';
    } else {
        $sql = "SELECT * FROM users WHERE (username = ? OR email = ?) AND status = 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();
        
        if($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['fullname'];
            $_SESSION['user_role'] = $user['role'];
            
            header('Location: index.php');
            exit;
        } else {
            $error = 'Sai tên đăng nhập hoặc mật khẩu, hoặc tài khoản bị khóa';
        }
    }
}
?>

<?php include '../templates/header.php'; ?>

<main>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0"><i class="fas fa-sign-in-alt me-2"></i>Đăng nhập</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php if($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Tên đăng nhập hoặc Email</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mật khẩu</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                            </button>
                        </form>
                        
                        <p class="mt-3 text-center">
                            Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../templates/footer.php'; ?>