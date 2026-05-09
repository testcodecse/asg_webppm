<?php
session_start();
include '../../inc/config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fields = ['hero_title', 'hero_subtitle', 'about_text', 'phone', 'email', 'address'];
    foreach($fields as $field) {
        $value = $_POST[$field];
        $stmt = $conn->prepare("UPDATE home_content SET content_value = ? WHERE content_key = ?");
        $stmt->execute([$value, $field]);
    }
    $success = 'Cap nhat thanh cong!';
}

$stmt = $conn->query("SELECT content_key, content_value FROM home_content");
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
    <title>Quan ly noi dung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 bg-dark text-white min-vh-100 p-0">
                <div class="text-center py-4 border-bottom border-secondary">
                    <h5>Admin Panel</h5>
                    <small><?php echo $_SESSION['user_name']; ?></small>
                </div>
                <ul class="nav flex-column mt-3">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.php">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="manage_contacts.php">
                            <i class="fas fa-envelope me-2"></i> Quan ly lien he
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white bg-primary" href="manage_home.php">
                            <i class="fas fa-edit me-2"></i> Quan ly noi dung
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../logout.php">
                            <i class="fas fa-sign-out-alt me-2"></i> Dang xuat
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-md-9 col-lg-10 p-4">
                <h2>Quan ly noi dung trang chu</h2>
                
                <?php if($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label>Tieu de Hero</label>
                        <input type="text" name="hero_title" class="form-control" value="<?php echo htmlspecialchars($content['hero_title']); ?>">
                    </div>
                    <div class="mb-3">
                        <label>Phu de Hero</label>
                        <input type="text" name="hero_subtitle" class="form-control" value="<?php echo htmlspecialchars($content['hero_subtitle']); ?>">
                    </div>
                    <div class="mb-3">
                        <label>Noi dung gioi thieu</label>
                        <textarea name="about_text" class="form-control" rows="5"><?php echo htmlspecialchars($content['about_text']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label>So dien thoai</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($content['phone']); ?>">
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($content['email']); ?>">
                    </div>
                    <div class="mb-3">
                        <label>Dia chi</label>
                        <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($content['address']); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Luu thay doi</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>