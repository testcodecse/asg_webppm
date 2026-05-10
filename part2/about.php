<?php
include '../inc/config.php';

$stmt = $conn->prepare("SELECT content_key, content_value FROM about_content");
$stmt->execute();
$content = [];
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $content[$row['content_key']] = $row['content_value'];
}

include '../templates/header.php';
?>

<main>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12 text-center mb-5">
                <h1 class="fw-bold">Giới thiệu</h1>
                <p class="lead"><?php echo $content['company_name'] ?? 'Công ty TNHH ABC Việt Nam'; ?></p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100 p-4">
                    <h3><i class="fas fa-history me-2 text-primary"></i>Lịch sử hình thành</h3>
                    <p class="text-muted"><?php echo nl2br($content['company_history'] ?? 'Thành lập năm 2010, trải qua 15 năm phát triển, chúng tôi đã khẳng định vị thế hàng đầu.'); ?></p>
                    
                    <h3 class="mt-4"><i class="fas fa-bullseye me-2 text-primary"></i>Sứ mệnh</h3>
                    <p class="text-muted"><?php echo nl2br($content['mission'] ?? 'Mang đến những sản phẩm chất lượng cao, dịch vụ hoàn hảo cho khách hàng.'); ?></p>
                    
                    <h3 class="mt-4"><i class="fas fa-eye me-2 text-primary"></i>Tầm nhìn</h3>
                    <p class="text-muted"><?php echo nl2br($content['vision'] ?? 'Trở thành công ty công nghệ hàng đầu khu vực.'); ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 p-4 bg-light">
                    <h3><i class="fas fa-gem me-2 text-primary"></i>Giá trị cốt lõi</h3>
                    <p class="text-muted"><?php echo nl2br($content['core_values'] ?? 'Chuyên nghiệp - Sáng tạo - Uy tín - Tận tâm'); ?></p>
                    
                    <h3 class="mt-4"><i class="fas fa-star me-2 text-primary"></i>Tại sao chọn chúng tôi?</h3>
                    <p class="text-muted"><?php echo nl2br($content['why_choose_us'] ?? 'Đội ngũ chuyên nghiệp, giá cả cạnh tranh, hỗ trợ 24/7.'); ?></p>
                    
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