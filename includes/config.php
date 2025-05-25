<?php
$host = 'localhost';
$dbname = 'shortener_db';
$username = 'shortener_db';
$password = '7DeW8MKJd6mMpTSW';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("数据库连接失败: " . $e->getMessage());
}
?>
