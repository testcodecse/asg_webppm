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

$contacts = $conn->query("SELECT * FROM contacts ORDER BY created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quan ly lien he</title>
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
                        <a class="nav-link text-white bg-primary" href="manage_contacts.php">
                            <i class="fas fa-envelope me-2"></i> Quan ly lien he
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="manage_home.php">
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
                <h2>Quan ly lien he</h2>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ho ten</th>
                            <th>Email</th>
                            <th>Dien thoai</th>
                            <th>Noi dung</th>
                            <th>Trang thai</th>
                            <th>Ngay gui</th>
                            <th>Thao tac</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($contacts as $c): ?>
                        <tr>
                            <td><?php echo $c['id']; ?></td>
                            <td><?php echo htmlspecialchars($c['name']); ?></td>
                            <td><?php echo htmlspecialchars($c['email']); ?></td>
                            <td><?php echo htmlspecialchars($c['phone']); ?></td>
                            <td><?php echo htmlspecialchars($c['message']); ?></td>
                            <td>
                                <?php if($c['status'] == 'chua_doc'): ?>
                                    <span class="badge bg-danger">Chua doc</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Da doc</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $c['created_at']; ?></td>
                            <td>
                                <?php if($c['status'] == 'chua_doc'): ?>
                                    <a href="?read=<?php echo $c['id']; ?>" class="btn btn-sm btn-info">Da doc</a>
                                <?php endif; ?>
                                <a href="?delete=<?php echo $c['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xoa?')">Xoa</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>