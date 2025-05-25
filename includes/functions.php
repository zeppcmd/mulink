<?php
session_start();

// 生成随机短码（6位字符）
function generateShortCode($length = 6) {
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = substr(str_shuffle($chars), 0, $length);
    
    // 检查短码是否已存在（避免重复）
    global $pdo; // 从外部获取数据库连接
    do {
        $stmt = $pdo->prepare("SELECT id FROM links WHERE short_code = ?");
        $stmt->execute([$code]);
        $exists = $stmt->fetch();
    } while ($exists);
    
    return $code;
}

// 检测微信或QQ浏览器
function isWeixinOrQQ() {
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    return (strpos($ua, 'MicroMessenger') !== false) || (strpos($ua, 'QQ/') !== false);
}

// 安全过滤输入
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}
?>