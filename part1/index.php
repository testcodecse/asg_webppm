<?php
include '../inc/config.php';

$stmt = $conn->prepare("SELECT content_key, content_value FROM home_content");
$stmt->execute();
$content = [];
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $content[$row['content_key']] = $row['content_value'];
}

include '../templates/header.php';
?>

<main>
    <div class="container my-5">
        <div class="hero-section text-center p-5 rounded" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <h1 class="display-4 fw-bold"><?php echo $content['hero_title'] ?? 'Chào mừng đến với công ty chúng tôi'; ?></h1>
            <p class="lead"><?php echo $content['hero_subtitle'] ?? 'Chúng tôi cung cấp giải pháp tốt nhất'; ?></p>
            <a href="contact.php" class="btn btn-light btn-lg mt-3">Liên hệ ngay</a>
        </div>

        <div class="row my-5 align-items-center">
            <div class="col-md-6">
                <h2 class="fw-bold">Về chúng tôi</h2>
                <p class="text-muted"><?php echo nl2br($content['about_text'] ?? 'Đây là nội dung giới thiệu công ty'); ?></p>
                <a href="../part2/about.php" class="btn btn-outline-primary">Xem thêm <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="col-md-6">
                <?php if(isset($content['about_image']) && file_exists('../' . $content['about_image'])): ?>
                    <img src="../<?php echo $content['about_image']; ?>" class="img-fluid rounded shadow" alt="Giới thiệu">
                <?php else: ?>
                    <img src="https://placehold.co/600x400/667eea/white?text=Cong+Ty+ABC" class="img-fluid rounded shadow" alt="Giới thiệu">
                <?php endif; ?>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12 text-center mb-4">
                <h2 class="fw-bold">Thông tin liên hệ</h2>
                <p class="text-muted">Kết nối với chúng tôi ngay hôm nay</p>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center p-4">
                    <i class="fas fa-phone-alt fa-3x text-primary mb-3"></i>
                    <h5>Điện thoại</h5>
                    <p class="text-muted"><?php echo $content['phone'] ?? '0123456789'; ?></p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center p-4">
                    <i class="fas fa-envelope fa-3x text-primary mb-3"></i>
                    <h5>Email</h5>
                    <p class="text-muted"><?php echo $content['email'] ?? 'contact@company.com'; ?></p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center p-4">
                    <i class="fas fa-map-marker-alt fa-3x text-primary mb-3"></i>
                    <h5>Địa chỉ</h5>
                    <p class="text-muted"><?php echo $content['address'] ?? 'Số 456 Đường XYZ, Quận 2, TP.HCM'; ?></p>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <a href="contact.php" class="btn btn-primary btn-lg px-5">Gửi tin nhắn ngay <i class="fas fa-paper-plane ms-2"></i></a>
            </div>
        </div>
    </div>
</main>

<?php include '../templates/footer.php'; ?>