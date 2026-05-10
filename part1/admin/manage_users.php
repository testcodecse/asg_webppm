<?php
session_start();
include '../../inc/config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

if(isset($_GET['delete'])) {
    $conn->prepare("DELETE FROM users WHERE id = ? AND role != 'admin'")->execute([$_GET['delete']]);
    header('Location: manage_users.php');
    exit;
}
if(isset($_GET['block'])) {
    $conn->prepare("UPDATE users SET status = 0 WHERE id = ? AND role != 'admin'")->execute([$_GET['block']]);
    header('Location: manage_users.php');
    exit;
}
if(isset($_GET['unblock'])) {
    $conn->prepare("UPDATE users SET status = 1 WHERE id = ?")->execute([$_GET['unblock']]);
    header('Location: manage_users.php');
    exit;
}
if(isset($_GET['reset_password'])) {
    $conn->prepare("UPDATE users SET password = ? WHERE id = ?")->execute([password_hash('123456', PASSWORD_DEFAULT), $_GET['reset_password']]);
    header('Location: manage_users.php');
    exit;
}

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$total = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_pages = ceil($total / $limit);
$stmt = $conn->prepare("SELECT * FROM users ORDER BY id DESC LIMIT :limit OFFSET :offset");
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Quản lý thành viên</title>
<link rel="stylesheet" href="http://localhost/company_website/srtdash/assets/css/admin.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"></head>
<body>
<div class="page-container">
    <div class="sidebar-menu"><div class="sidebar-header"><div class="logo"><h5>Công ty ABC</h5></div></div>
    <div class="main-menu"><ul class="metismenu">
        <li><a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="manage_contacts.php"><i class="fas fa-envelope"></i> Quản lý liên hệ</a></li>
        <li><a href="manage_home.php"><i class="fas fa-edit"></i> Quản lý nội dung</a></li>
        <li class="active"><a href="manage_users.php"><i class="fas fa-users"></i> Quản lý thành viên</a></li>
        <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
    </ul></div></div>

    <div class="main-content"><div class="header-area"><div class="nav-btn"><i class="fas fa-bars"></i></div><div class="user-profile"><div class="avatar"><?php echo substr($_SESSION['user_name'],0,1); ?></div><div class="user-name"><?php echo $_SESSION['user_name']; ?></div></div></div>
    <div class="main-content-inner"><div class="card"><div class="card-header">Danh sách thành viên</div><div class="card-body"><div class="table-responsive"><table class="table"><thead><tr><th>ID</th><th>Tên đăng nhập</th><th>Họ tên</th><th>Email</th><th>Vai trò</th><th>Trạng thái</th><th>Thao tác</th></tr></thead><tbody>
    <?php foreach($users as $u): ?>
    <tr><td><?php echo $u['id']; ?></td><td><?php echo htmlspecialchars($u['username']); ?></td><td><?php echo htmlspecialchars($u['fullname']); ?></td><td><?php echo htmlspecialchars($u['email']); ?></td>
    <td><?php echo $u['role'] == 'admin' ? '<span class="badge bg-danger">Admin</span>' : '<span class="badge bg-info">Member</span>'; ?></td>
    <td><?php echo $u['status'] == 1 ? '<span class="badge bg-success">Hoạt động</span>' : '<span class="badge bg-secondary">Bị khóa</span>'; ?></td>
    <td><?php if($u['role'] != 'admin'): ?>
        <?php if($u['status'] == 1): ?><a href="?block=<?php echo $u['id']; ?>" class="btn btn-sm btn-warning" onclick="return confirm('Khóa?')">Khóa</a>
        <?php else: ?><a href="?unblock=<?php echo $u['id']; ?>" class="btn btn-sm btn-success" onclick="return confirm('Mở khóa?')">Mở khóa</a><?php endif; ?>
        <a href="?reset_password=<?php echo $u['id']; ?>" class="btn btn-sm btn-info" onclick="return confirm('Reset pass về 123456?')">Reset MK</a>
        <a href="?delete=<?php echo $u['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa?')">Xóa</a>
    <?php else: ?>Không thể thao tác<?php endif; ?></td></tr>
    <?php endforeach; ?>
    </tbody></table></div>
    <?php if($total_pages > 1): ?><ul class="pagination"><?php if($page>1): ?><li class="page-item"><a class="page-link" href="?page=<?php echo $page-1; ?>">«</a></li><?php endif; ?><?php for($i=1;$i<=$total_pages;$i++): ?><li class="page-item <?php echo $i==$page?'active':''; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li><?php endfor; ?><?php if($page<$total_pages): ?><li class="page-item"><a class="page-link" href="?page=<?php echo $page+1; ?>">»</a></li><?php endif; ?></ul><?php endif; ?>
    </div></div></div></div>
</div>
<script>document.querySelector('.nav-btn').addEventListener('click',function(){document.querySelector('.sidebar-menu').classList.toggle('active');});</script>
</body>
</html>