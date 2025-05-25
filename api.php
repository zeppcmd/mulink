<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $originalUrl = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
    
    if (!$originalUrl) {
        echo json_encode(['success' => false, 'error' => '无效的URL']);
        exit;
    }

    try {
        $shortCode = generateShortCode();
        
        $stmt = $pdo->prepare("INSERT INTO links (original_url, short_code) VALUES (?, ?)");
        $stmt->execute([$originalUrl, $shortCode]);
        
        $shortUrl = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/' . $shortCode;
        
        echo json_encode([
            'success' => true,
            'short_url' => $shortUrl
        ]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => '数据库错误']);
    }
}
?>