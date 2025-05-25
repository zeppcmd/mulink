<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// 获取短码
$shortCode = trim($_SERVER['REQUEST_URI'], '/');
// 构造缩短后的链接，假设当前域名可以通过 $_SERVER['HTTP_HOST'] 获取
$shortUrl = 'https://' . $_SERVER['HTTP_HOST'] . '/' . $shortCode;

// 防红检测
if (isWeixinOrQQ()) {
    // 查询数据库获取原始链接，用于复制功能
    try {
        $stmt = $pdo->prepare("SELECT original_url FROM links WHERE short_code = ?");
        $stmt->execute([$shortCode]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $originalUrl = $result ? $result['original_url'] : '';
    } catch (PDOException $e) {
        $originalUrl = '';
    }

    // 美化提示页面，添加样式和简单布局，适配电脑和手机，添加复制链接功能
    $html = <<<HTML
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>提示</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f9;
            -webkit-tap-highlight-color: transparent; /* 去除移动端点击高亮 */
        }
        .container {
            text-align: center;
            padding: 2rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 90%; /* 适配手机屏幕 */
            width: 400px;
        }
        h2 {
            color: #e74c3c;
            margin-bottom: 1rem;
        }
        p {
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }
        .copy-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .copy-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>请在浏览器打开</h2>
        <p>为了获得更好的体验，请在浏览器中打开此链接。</p>
        <button class="copy-btn" onclick="copyUrl()">复制链接</button>
    </div>
    <script>
        function copyUrl() {
            const url = '{$shortUrl}';
            const input = document.createElement('input');
            input.value = url;
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);
            alert('链接已复制到剪贴板');
        }
    </script>
</body>
</html>
HTML;
    die($html);
}

try {
    // 查询数据库
    $stmt = $pdo->prepare("SELECT original_url FROM links WHERE short_code = ?");
    $stmt->execute([$shortCode]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // 更新访问次数
        $pdo->prepare("UPDATE links SET visit_count = visit_count + 1 WHERE short_code = ?")->execute([$shortCode]);
        // 跳转原始链接
        header("Location: " . $result['original_url']);
        exit;
    } else {
        http_response_code(404);
        die('短链接不存在');
    }
} catch (PDOException $e) {
    die("数据库错误");
}
?>