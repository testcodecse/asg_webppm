# Website Công ty ABC

## Giới thiệu
Đồ án môn Lập trình web - Website giới thiệu công ty với đầy đủ tính năng: trang chủ, liên hệ, giới thiệu, hỏi/đáp, đăng ký/đăng nhập, phân quyền người dùng, quản trị viên.

## Công nghệ sử dụng
- PHP 7.0+ (Pure PHP, không framework)
- MySQL (MariaDB)
- HTML5, CSS3, JavaScript
- Bootstrap 5
- Font Awesome 6

## Cấu trúc thư mục
company_website/
├── inc/ # Cấu hình
├── templates/ # Header, footer
├── part1/ # Module #1 (Trang chủ, Liên hệ, Admin #1)
├── part2/ # Module #2 (Giới thiệu, Hỏi/Đáp, Admin #2)
├── uploads/ # Ảnh upload
├── srtdash/ # CSS admin
└── database/ # File SQL


## Cài đặt

### Yêu cầu
- XAMPP / WAMP / Laragon
- PHP >= 7.0
- MySQL

### Các bước cài đặt

1. **Copy project vào thư mục htdocs**
C:\xampp\htdocs\company_website\

text

2. **Tạo database**
- Mở phpMyAdmin
- Tạo database `companywebsite`
- Import file `database/companywebsite.sql`

3. **Cấu hình kết nối**
- Mở `inc/config.php`
- Kiểm tra thông tin host, database, username, password

4. **Tạo thư mục upload**
mkdir uploads
mkdir uploads/avatars


5. **Chạy ứng dụng**
- Truy cập: http://localhost/company_website/part1/index.php

### Tài khoản mặc định
| Vai trò | Username | Password |
|---------|----------|----------|
| Admin | myadmin | 123456 |
| Member | (tự đăng ký) | - |

## Tính năng chính

### Khách (chưa đăng nhập)
- Xem trang chủ, giới thiệu, liên hệ, hỏi/đáp
- Gửi tin nhắn liên hệ
- Đăng ký thành viên, đăng nhập

### Thành viên
- Quản lý hồ sơ cá nhân (đổi thông tin, avatar, mật khẩu)

### Quản trị viên
- Quản lý liên hệ (xem, đánh dấu đã đọc/phản hồi, xóa, phân trang)
- Quản lý nội dung trang chủ (sửa text, upload ảnh hero, ảnh giới thiệu)
- Quản lý thành viên (khóa, mở khóa, reset mật khẩu, xóa)
- Quản lý nội dung giới thiệu (sửa text, upload ảnh)
- Quản lý FAQ (thêm, sửa, xóa, phân trang)

## Bảo mật
- PDO prepare statement (chống SQL injection)
- password_hash() (mã hóa mật khẩu)
- htmlspecialchars() (chống XSS)
- CSRF token
- Validate cả client (JS) và server (PHP)

## Responsive
Hỗ trợ đầy đủ các thiết bị: Desktop, Tablet, Mobile


## License
MIT