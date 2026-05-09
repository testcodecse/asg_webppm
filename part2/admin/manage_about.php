<?php
session_start();
include '../../inc/config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: ../../part1/login.php');
    exit;
}

$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fields = ['company_name', 'company_history', 'mission', 'vision', 'core_values', 'why_choose_us'];
    foreach($fields as $field) {
        $value = $_POST[$field];
        $stmt = $conn->prepare("UPDATE about_content SET content_value = ? WHERE content_key = ?");
        $stmt->execute([$value, $field]);
    }
    $success = 'Cap nhat thanh cong!';
}

$stmt = $conn->query("SELECT content_key, content_value FROM about_content");
$content = [];
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $content[$row['content_key']] = $row['content_value'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quan ly gioi thieu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 bg-dark text-white min-vh-100 p-0">
                <div class="text-center py-4 border-bottom border-secondary">
                    <h5>Admin Phan 2</h5>
                    <small><?php echo $_SESSION['user_name']; ?></small>
                </div>
                <ul class="nav flex-column mt-3">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.php">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white bg-primary" href="manage_about.php">
                            <i class="fas fa-info-circle me-2"></i> Quan ly gioi thieu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="manage_faq.php">
                            <i class="fas fa-question-circle me-2"></i> Quan ly FAQ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../../part1/logout.php">
                            <i class="fas fa-sign-out-alt me-2"></i> Dang xuat
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-md-9 col-lg-10 p-4">
                <h2>Quan ly noi dung trang gioi thieu</h2>
                
                <?php if($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label>Ten cong ty</label>
                        <input type="text" name="company_name" class="form-control" value="<?php echo htmlspecialchars($content['company_name']); ?>">
                    </div>
                    <div class="mb-3">
                        <label>Lich su hinh thanh</label>
                        <textarea name="company_history" class="form-control" rows="5"><?php echo htmlspecialchars($content['company_history']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Su menh</label>
                        <textarea name="mission" class="form-control" rows="4"><?php echo htmlspecialchars($content['mission']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Tam nhin</label>
                        <textarea name="vision" class="form-control" rows="4"><?php echo htmlspecialchars($content['vision']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Gia tri cot loi</label>
                        <textarea name="core_values" class="form-control" rows="3"><?php echo htmlspecialchars($content['core_values']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Tai sao chon chung toi</label>
                        <textarea name="why_choose_us" class="form-control" rows="4"><?php echo htmlspecialchars($content['why_choose_us']); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Luu thay doi</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>