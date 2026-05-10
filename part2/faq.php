<?php
include '../inc/config.php';

$stmt = $conn->prepare("SELECT * FROM faq WHERE status = 1 ORDER BY order_num ASC");
$stmt->execute();
$faqs = $stmt->fetchAll();

include '../templates/header.php';
?>

<main>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12 text-center mb-5">
                <h1 class="fw-bold">Câu hỏi thường gặp</h1>
                <p class="text-muted">Những thắc mắc phổ biến của khách hàng</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <?php foreach($faqs as $index => $faq): ?>
                <div class="card mb-3 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <span class="badge bg-primary rounded-circle me-3"><?php echo $index + 1; ?></span>
                            <?php echo htmlspecialchars($faq['question']); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0 text-muted">
                            <i class="fas fa-reply-all me-2 text-primary"></i>
                            <?php echo nl2br(htmlspecialchars($faq['answer'])); ?>
                        </p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <p>Không tìm thấy câu trả lời?</p>
                <a href="../part1/contact.php" class="btn btn-outline-primary">
                    <i class="fas fa-envelope me-2"></i>Liên hệ hỗ trợ
                </a>
            </div>
        </div>
    </div>
</main>

<?php include '../templates/footer.php'; ?>