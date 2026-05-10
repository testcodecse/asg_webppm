<?php
session_start();
include '../../inc/config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->prepare("DELETE FROM contacts WHERE id = ?")->execute([$id]);
    header('Location: manage_contacts.php');
    exit;
}

if(isset($_GET['read'])) {
    $id = $_GET['read'];
    $conn->prepare("UPDATE contacts SET status = 'da_doc' WHERE id = ?")->execute([$id]);
    header('Location: manage_contacts.php');
    exit;
}

if(isset($_GET['replied'])) {
    $id = $_GET['replied'];
    $conn->prepare("UPDATE contacts SET status = 'da_phan_hoi' WHERE id = ?")->execute([$id]);
    header('Location: manage_contacts.php');
    exit;
}

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total = $conn->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
$total_pages = ceil($total / $limit);

$stmt = $conn->prepare("SELECT * FROM contacts ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$contacts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý liên hệ</title>
    <link rel="stylesheet" href="http://localhost/company_website/srtdash/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="page-container">
    <div class="sidebar-menu">
        <div class="sidebar-header">
            <div class="logo"><h5>Công ty ABC</h5></div>
        </div>
        <div class="main-menu">
            <ul class="metismenu">
                <li><a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li class="active"><a href="manage_contacts.php"><i class="fas fa-envelope"></i> Quản lý liên hệ</a></li>
                <li><a href="manage_home.php"><i class="fas fa-edit"></i> Quản lý nội dung</a></li>
                <li><a href="manage_users.php"><i class="fas fa-users"></i> Quản lý thành viên</a></li>
                <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="header-area">
            <div class="nav-btn"><i class="fas fa-bars"></i></div>
            <div class="user-profile">
                <div class="avatar"><?php echo substr($_SESSION['user_name'], 0, 1); ?></div>
                <div class="user-name"><?php echo $_SESSION['user_name']; ?></div>
            </div>
        </div>

        <div class="main-content-inner">
            <div class="card">
                <div class="card-header">Danh sách liên hệ</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr><th>ID</th><th>Họ tên</th><th>Email</th><th>Điện thoại</th><th>Nội dung</th><th>Trạng thái</th><th>Ngày gửi</th><th>Thao tác</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach($contacts as $c): ?>
                                <tr>
                                    <td><?php echo $c['id']; ?></td>
                                    <td><?php echo htmlspecialchars($c['name']); ?></td>
                                    <td><?php echo htmlspecialchars($c['email']); ?></td>
                                    <td><?php echo htmlspecialchars($c['phone']); ?></td>
                                    <td><?php echo htmlspecialchars(substr($c['message'], 0, 50)); ?>...</td>
                                    <td>
                                        <?php if($c['status'] == 'chua_doc'): ?>
                                            <span class="badge bg-danger">Chưa đọc</span>
                                        <?php elseif($c['status'] == 'da_doc'): ?>
                                            <span class="badge bg-warning">Đã đọc</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Đã phản hồi</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $c['created_at']; ?></td>
                                    <td>
                                        <?php if($c['status'] == 'chua_doc'): ?>
                                            <a href="?read=<?php echo $c['id']; ?>" class="btn btn-sm btn-info">Đã đọc</a>
                                        <?php endif; ?>
                                        <?php if($c['status'] != 'da_phan_hoi'): ?>
                                            <a href="?replied=<?php echo $c['id']; ?>" class="btn btn-sm btn-success">Đã phản hồi</a>
                                        <?php endif; ?>
                                        <a href="?delete=<?php echo $c['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa?')">Xóa</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if(count($contacts) == 0): ?>
                                <tr><td colspan="8" class="text-center">Chưa có liên hệ nào</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if($total_pages > 1): ?>
                    <ul class="pagination">
                        <?php if($page > 1): ?><li class="page-item"><a class="page-link" href="?page=<?php echo $page-1; ?>">«</a></li><?php endif; ?>
                        <?php for($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        <?php endfor; ?>
                        <?php if($page < $total_pages): ?><li class="page-item"><a class="page-link" href="?page=<?php echo $page+1; ?>">»</a></li><?php endif; ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.querySelector('.nav-btn').addEventListener('click', function() {
    document.querySelector('.sidebar-menu').classList.toggle('active');
});
</script>
</body>
</html>