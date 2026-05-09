<?php session_start(); ?>
<?php include '../inc/config.php'; ?>

<?php
$stmt = $conn->query("SELECT content_key, content_value FROM about_content");
$content = [];
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $content[$row['content_key']] = $row['content_value'];
}
?>

<?php include '../templates/header.php'; ?>

<main>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12 text-center mb-5">
                <h1 class="fw-bold">Giới thiệu</h1>
                <p class="lead"><?php echo $content['company_name']; ?></p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100 p-4">
                    <h3><i class="fas fa-history me-2 text-primary"></i>Lịch sử hình thành</h3>
                    <p class="text-muted"><?php echo nl2br($content['company_history']); ?></p>
                    
                    <h3 class="mt-4"><i class="fas fa-bullseye me-2 text-primary"></i>Sứ mệnh</h3>
                    <p class="text-muted"><?php echo nl2br($content['mission']); ?></p>
                    
                    <h3 class="mt-4"><i class="fas fa-eye me-2 text-primary"></i>Tầm nhìn</h3>
                    <p class="text-muted"><?php echo nl2br($content['vision']); ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 p-4 bg-light">
                    <h3><i class="fas fa-gem me-2 text-primary"></i>Giá trị cốt lõi</h3>
                    <p class="text-muted"><?php echo nl2br($content['core_values']); ?></p>
                    
                    <h3 class="mt-4"><i class="fas fa-star me-2 text-primary"></i>Tại sao chọn chúng tôi?</h3>
                    <p class="text-muted"><?php echo nl2br($content['why_choose_us']); ?></p>
                    
                    <div class="mt-4">
                        <a href="../part1/contact.php" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Liên hệ ngay
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../templates/footer.php'; ?>