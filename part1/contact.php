<?php session_start(); ?>
<?php include '../inc/config.php'; ?>

<?php
$success = '';
$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    
    if(empty($name) || empty($email) || empty($message)) {
        $error = 'Vui lòng nhập đầy đủ thông tin bắt buộc';
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email không hợp lệ';
    } else {
        $sql = "INSERT INTO contacts (name, email, phone, message) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if($stmt->execute([$name, $email, $phone, $message])) {
            $success = 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất.';
        } else {
            $error = 'Có lỗi xảy ra, vui lòng thử lại sau';
        }
    }
}

$stmt = $conn->query("SELECT content_key, content_value FROM home_content WHERE content_key IN ('phone', 'email', 'address')");
$info = [];
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $info[$row['content_key']] = $row['content_value'];
}
?>

<?php include '../templates/header.php'; ?>

<main>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12 text-center mb-5">
                <h1 class="fw-bold">Liên hệ với chúng tôi</h1>
                <p class="text-muted">Chúng tôi luôn sẵn sàng hỗ trợ bạn</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-5 mb-4">
                <div class="bg-light p-4 rounded shadow-sm">
                    <h3 class="mb-4"><i class="fas fa-map-marker-alt me-2 text-primary"></i>Thông tin</h3>
                    <p><strong><i class="fas fa-phone me-2"></i>Điện thoại:</strong> <?php echo $info['phone']; ?></p>
                    <p><strong><i class="fas fa-envelope me-2"></i>Email:</strong> <?php echo $info['email']; ?></p>
                    <p><strong><i class="fas fa-map-marker-alt me-2"></i>Địa chỉ:</strong> <?php echo $info['address']; ?></p>
                    
                    <hr>
                    <h5><i class="fas fa-clock me-2"></i>Giờ làm việc</h5>
                    <p>Thứ 2 - Thứ 6: 8h00 - 17h30<br>Thứ 7: 8h00 - 12h00</p>
                </div>
            </div>
            
            <div class="col-md-7">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="mb-4"><i class="fas fa-paper-plane me-2 text-primary"></i>Gửi tin nhắn</h3>
                        
                        <?php if($success): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php endif; ?>
                        <?php if($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Họ tên <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Điện thoại</label>
                                <input type="tel" name="phone" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nội dung <span class="text-danger">*</span></label>
                                <textarea name="message" class="form-control" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-paper-plane me-2"></i>Gửi liên hệ
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../templates/footer.php'; ?>