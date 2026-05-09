<?php
session_start();
include '../../inc/config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: ../../part1/login.php');
    exit;
}

if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->prepare("DELETE FROM faq WHERE id = ?")->execute([$id]);
    header('Location: manage_faq.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    $order_num = $_POST['order_num'];
    
    $stmt = $conn->prepare("INSERT INTO faq (question, answer, order_num) VALUES (?, ?, ?)");
    $stmt->execute([$question, $answer, $order_num]);
    header('Location: manage_faq.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    $order_num = $_POST['order_num'];
    
    $stmt = $conn->prepare("UPDATE faq SET question = ?, answer = ?, order_num = ? WHERE id = ?");
    $stmt->execute([$question, $answer, $order_num, $id]);
    header('Location: manage_faq.php');
    exit;
}

$faqs = $conn->query("SELECT * FROM faq ORDER BY order_num ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quan ly FAQ</title>
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
                        <a class="nav-link text-white" href="manage_about.php">
                            <i class="fas fa-info-circle me-2"></i> Quan ly gioi thieu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white bg-primary" href="manage_faq.php">
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
                <h2>Quan ly cau hoi thuong gap</h2>
                
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Them cau hoi moi</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="add" value="1">
                            <div class="mb-3">
                                <label>Cau hoi</label>
                                <input type="text" name="question" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Cau tra loi</label>
                                <textarea name="answer" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Thu tu</label>
                                <input type="number" name="order_num" class="form-control" value="0">
                            </div>
                            <button type="submit" class="btn btn-primary">Them moi</button>
                        </form>
                    </div>
                </div>
                
                <h3>Danh sach cau hoi</h3>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cau hoi</th>
                            <th>Cau tra loi</th>
                            <th>Thu tu</th>
                            <th>Thao tac</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($faqs as $f): ?>
                        <tr>
                            <form method="POST">
                                <input type="hidden" name="edit" value="1">
                                <input type="hidden" name="id" value="<?php echo $f['id']; ?>">
                                <td><?php echo $f['id']; ?></td>
                                <td><input type="text" name="question" class="form-control" value="<?php echo htmlspecialchars($f['question']); ?>"></td>
                                <td><textarea name="answer" class="form-control" rows="2"><?php echo htmlspecialchars($f['answer']); ?></textarea></td>
                                <td><input type="number" name="order_num" class="form-control" style="width:80px" value="<?php echo $f['order_num']; ?>"></td>
                                <td>
                                    <button type="submit" class="btn btn-sm btn-info">Sua</button>
                                    <a href="?delete=<?php echo $f['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xoa?')">Xoa</a>
                                </td>
                            </form>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>