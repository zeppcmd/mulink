<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/config.php';

// 登录验证（修正语法错误）
if (!isset($_SESSION['admin_logged_in'])) {  // ← 添加缺失的右括号
    header('Location: admin.php');
    exit;
}

// 处理删除操作
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $pdo->prepare("DELETE FROM links WHERE id = ?")->execute([$id]);
    header("Location: admin_dashboard.php");
    exit;
}
// 处理编辑操作
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $originalUrl = filter_input(INPUT_POST, 'original_url', FILTER_VALIDATE_URL);
    $shortCode = $_POST['short_code'];
    
    $stmt = $pdo->prepare("UPDATE links SET original_url = ?, short_code = ? WHERE id = ?");
    $stmt->execute([$originalUrl, $shortCode, $id]);
    header("Location: admin_dashboard.php");
    exit;
}

// 获取所有链接记录
$links = $pdo->query("SELECT * FROM links ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>后台管理</title>
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>链接管理</h3>
            <a href="logout.php" class="btn btn-danger">退出登录</a>
        </div>
        
        <div class="card shadow">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>原始链接</th>
                            <th>短码</th>
                            <th>访问次数</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($links as $link): ?>
                        <tr>
                            <td><?= $link['id'] ?></td>
                            <td><a href="<?= $link['original_url'] ?>" target="_blank"><?= substr($link['original_url'], 0, 30) ?>...</a></td>
                            <td><?= $link['short_code'] ?></td>
                            <td><?= $link['visit_count'] ?></td>
                            <td><?= $link['created_at'] ?></td>
                            <td>
                                <a href="#editModal<?= $link['id'] ?>" data-bs-toggle="modal" class="btn btn-sm btn-warning">编辑</a>
                                <a href="admin_dashboard.php?delete=<?= $link['id'] ?>" onclick="return confirm('确定删除？')" class="btn btn-sm btn-danger">删除</a>
                            </td>
                        </tr>
                        
                        <!-- 编辑模态框 -->
                        <div class="modal fade" id="editModal<?= $link['id'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST">
                                        <input type="hidden" name="id" value="<?= $link['id'] ?>">
                                        <div class="modal-header">
                                            <h5 class="modal-title">编辑链接</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">原始链接</label>
                                                <input type="url" name="original_url" class="form-control" value="<?= $link['original_url'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">短码</label>
                                                <input type="text" name="short_code" class="form-control" value="<?= $link['short_code'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                            <button type="submit" name="edit" class="btn btn-primary">保存</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>