<?php
session_start();
include '../../inc/config.php';
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') header('Location: ../../part1/login.php');
if(isset($_GET['delete'])) $conn->prepare("DELETE FROM faq WHERE id=?")->execute([$_GET['delete']]);
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['add'])) $conn->prepare("INSERT INTO faq (question,answer,order_num) VALUES (?,?,?)")->execute([$_POST['question'],$_POST['answer'],$_POST['order_num']]);
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['edit'])) $conn->prepare("UPDATE faq SET question=?, answer=?, order_num=? WHERE id=?")->execute([$_POST['question'],$_POST['answer'],$_POST['order_num'],$_POST['id']]);
$limit=5; $page=isset($_GET['page'])?(int)$_GET['page']:1; $offset=($page-1)*$limit;
$total=$conn->query("SELECT COUNT(*) FROM faq")->fetchColumn(); $total_pages=ceil($total/$limit);
$stmt=$conn->prepare("SELECT * FROM faq ORDER BY order_num ASC LIMIT :limit OFFSET :offset");
$stmt->bindParam(':limit',$limit,PDO::PARAM_INT); $stmt->bindParam(':offset',$offset,PDO::PARAM_INT);
$stmt->execute(); $faqs=$stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="vi">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Quản lý FAQ</title>
<link rel="stylesheet" href="http://localhost/company_website/srtdash/assets/css/admin.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"></head>
<body>
<div class="page-container"><div class="sidebar-menu"><div class="sidebar-header"><div class="logo"><h5>Công ty ABC</h5></div></div>
<div class="main-menu"><ul class="metismenu"><li><a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
<li><a href="manage_about.php"><i class="fas fa-info-circle"></i> Quản lý giới thiệu</a></li>
<li class="active"><a href="manage_faq.php"><i class="fas fa-question-circle"></i> Quản lý FAQ</a></li>
<li><a href="../../part1/logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li></ul></div></div>
<div class="main-content"><div class="header-area"><div class="nav-btn"><i class="fas fa-bars"></i></div><div class="user-profile"><div class="avatar"><?php echo substr($_SESSION['user_name'],0,1); ?></div><div class="user-name"><?php echo $_SESSION['user_name']; ?></div></div></div>
<div class="main-content-inner"><div class="card"><div class="card-header">Thêm câu hỏi mới</div><div class="card-body"><form method="POST"><input type="hidden" name="add" value="1"><div class="mb-3"><label>Câu hỏi</label><input type="text" name="question" class="form-control" required></div>
<div class="mb-3"><label>Câu trả lời</label><textarea name="answer" class="form-control" rows="3" required></textarea></div><div class="mb-3"><label>Thứ tự</label><input type="number" name="order_num" class="form-control" value="0"></div><button class="btn btn-primary">Thêm mới</button></form></div></div>
<div class="card"><div class="card-header">Danh sách câu hỏi</div><div class="card-body"><div class="table-responsive"><table class="table"><thead><tr><th>ID</th><th>Câu hỏi</th><th>Câu trả lời</th><th>Thứ tự</th><th>Thao tác</th></tr></thead>
<tbody><?php foreach($faqs as $f): ?><form method="POST"><input type="hidden" name="edit" value="1"><input type="hidden" name="id" value="<?php echo $f['id']; ?>">
<tr><td><?php echo $f['id']; ?></td><td><input type="text" name="question" class="form-control" value="<?php echo htmlspecialchars($f['question']); ?>"></td>
<td><textarea name="answer" class="form-control" rows="2"><?php echo htmlspecialchars($f['answer']); ?></textarea></td>
<td><input type="number" name="order_num" class="form-control" style="width:80px" value="<?php echo $f['order_num']; ?>"></td>
<td><button class="btn btn-sm btn-info">Sửa</button> <a href="?delete=<?php echo $f['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa?')">Xóa</a></td></tr></form><?php endforeach; ?>
</tbody></table></div><?php if($total_pages>1): ?><ul class="pagination"><?php if($page>1): ?><li><a href="?page=<?php echo $page-1; ?>">«</a></li><?php endif; ?><?php for($i=1;$i<=$total_pages;$i++): ?><li class="<?php echo $i==$page?'active':''; ?>"><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li><?php endfor; ?><?php if($page<$total_pages): ?><li><a href="?page=<?php echo $page+1; ?>">»</a></li><?php endif; ?></ul><?php endif; ?></div></div></div></div></div>
<script>document.querySelector('.nav-btn').addEventListener('click',function(){document.querySelector('.sidebar-menu').classList.toggle('active');});</script>
</body>
</html>