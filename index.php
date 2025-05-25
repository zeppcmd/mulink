<?php include 'includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="短链接生成器，快速将长链接转换为短链接，方便分享和传播。">
    <meta name="keywords" content="短链接生成器, 短链, 长链接转短链接">
    <title>短链接生成器 - 快速生成短链接，方便分享</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .card {
            max-width: 600px;
            margin: 0 auto;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        @media (max-width: 768px) {
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }
            .card {
                max-width: 100%;
            }
            h1 {
                font-size: 1.8rem;
            }
        }
        .input-group .btn-primary {
            border-radius: 0 0.375rem 0.375rem 0;
            background-color: #0d6efd;
            border-color: #0d6efd;
            transition: background-color 0.3s ease;
        }
        .input-group .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }
        #result {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 10px;
        }
        h1 {
            color: #333;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }
        footer {
            margin-top: auto; 
            width: 100%;
        }
        /* 添加 GitHub 图标样式 */
        .github-icon {
            position: fixed;
            top: 20px;
            right: 20px;
            font-size: 2rem;
            color: #333;
            transition: color 0.3s ease;
        }
        .github-icon:hover {
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <a href="https://github.com/zeppcmd/mulink" target="_blank" class="github-icon">
        <i class="fab fa-github"></i>
    </a>
    <div class="container mt-5">
        <h1 class="text-center mb-4"><i class="fas fa-link me-2"></i>短链接生成器</h1>
        <div class="card shadow">
            <div class="card-body">
                <form id="shortenForm">
                    <div class="input-group mb-3">
                        <input type="url" class="form-control" placeholder="输入您的长链接" required id="originalUrl" style="border-radius: 0.375rem 0 0 0.375rem;">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-magic me-2"></i>生成短链</button>
                    </div>
                </form>
                <div id="result" class="text-center d-none">
                    <p>短链接：<a href="#" id="shortLink" target="_blank" class="text-primary text-decoration-none" style="font-weight: 600;"></a></p>
                    <img id="qrcode" src="" alt="短链接对应的二维码" class="img-fluid mt-3" style="max-width: 200px;">
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center mt-5">
        <p>&copy; 2025 短链接生成器. 保留所有权利.</p>
    </footer>
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="\assets\js\script.js"></script>
</body>
</html>
