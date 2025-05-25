

# 短链接生成器

简洁易用的短链接生成工具，支持长链接转短码、二维码同步生成、后台管理、访问统计及微信/QQ浏览器防红提示等功能。适用于需要快速分享链接的场景，如社交媒体推广、短信营销等。

---

## 功能特性

- **短链接生成**：输入长链接自动生成6位随机短码，支持URL格式验证。
- **二维码同步生成**：生成短链接的同时，自动生成对应的二维码图片（基于第三方API）。
- **后台管理系统**：
  - 管理员登录/退出（基于Session验证）。
  - 链接列表展示（含原始链接、短码、访问次数、创建时间）。
  - 链接编辑（修改原始链接或短码）。
  - 链接删除（需二次确认）。
- **访问统计**：记录每个短链接的访问次数，自动更新。
- **防红提示**：检测到在微信/QQ浏览器中访问短链接时，跳转至提示页并支持复制链接。
- **错误处理**：对无效URL、数据库连接失败等场景提供友好提示。

---

## 运行环境

- **PHP**：7.0及以上（需开启PDO、mbstring扩展）。
- **数据库**：MySQL 5.6及以上（需支持InnoDB引擎）。
- **Web服务器**：Apache/Nginx（需配置URL重写支持，本项目通过`redirect.php`处理短码跳转）。
- **前端依赖**：jQuery、Bootstrap（通过CDN加载，无需本地部署）。

---

## 安装教程

### 步骤1：上传源码
将项目所有文件（含子目录）上传至服务器Web根目录（如`/var/www/html`）。

### 步骤2：创建并初始化数据库
1. 登录MySQL，创建数据库（建议命名为`shortener_db`）。
2. 执行`shortener_db.sql`文件（需提前准备，或通过phpMyAdmin导入），创建`links`（存储短链接）和`admin_users`（存储管理员账号）表。

### 步骤3：配置数据库连接
编辑`includes/config.php`文件，修改以下数据库信息：
```php
$host = 'localhost';      // 数据库地址（本地默认localhost）
$dbname = 'shortener_db'; // 数据库名称
$username = 'root';       // 数据库用户名
$password = '123456';     // 数据库密码
```

### 步骤4：创建管理员账号（可选）
通过MySQL插入初始管理员账号（密码需为`password_hash`加密后的值）：
```sql
INSERT INTO admin_users (username, password) VALUES ('admin', '密码的哈希值');
```
> 示例：使用`password_hash('123456', PASSWORD_DEFAULT)`生成哈希值。

---

## 使用说明

### 普通用户
1. 访问首页（`index.php`），输入合法长链接，点击“生成短链”。
2. 生成成功后，页面会显示短链接和二维码，可直接点击或扫码访问。

### 管理员
1. 访问`admin.php`，输入管理员账号密码登录。
2. 进入后台管理页（`admin_dashboard.php`），可查看所有短链接，支持编辑、删除操作。
3. 退出登录通过`logout.php`跳转回登录页。

---

## 目录结构

```
mulink/
├── README.md                # 项目说明文档（当前文件）
├── admin.php                # 管理员登录页面
├── admin_dashboard.php      # 后台管理主页面
├── api.php                  # 短链接生成接口（接收POST请求）
├── index.php                # 首页（短链接生成页面）
├── redirect.php             # 短链接跳转处理（含防红逻辑）
├── logout.php               # 退出登录逻辑
├── favicon.ico              # 网站图标
├── assets/                  # 静态资源
│   ├── css/                 # CSS样式
│   │   └── style.css
│   └── js/                  # JavaScript脚本
│       └── script.js
└── includes/                # 核心功能库
    ├── config.php           # 数据库配置
    └── functions.php        # 工具函数（短码生成、环境检测等）
```

---

## 技术栈

- **前端**：Bootstrap 5（样式）、jQuery 3.6（交互）、Font Awesome 6（图标）。
- **后端**：PHP（处理业务逻辑，使用PDO操作数据库）。
- **数据库**：MySQL（存储短链接和管理员信息）。
- **第三方服务**：`api.pwmqr.com`（二维码生成API）。

---

## 注意事项

1. **短码唯一性**：系统自动生成6位随机短码，若出现重复会重新生成（概率极低）。
2. **安全建议**：
   - 定期备份`shortener_db`数据库。
   - 管理员密码建议使用强密码（含字母、数字、符号）。
   - 生产环境需关闭PHP错误提示（修改`php.ini`的`display_errors=Off`）。
3. **微信/QQ适配**：防红提示页仅在检测到`MicroMessenger`或`QQ/`用户代理时触发，其他浏览器直接跳转原始链接。
