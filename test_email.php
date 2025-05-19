<?php
// File test kết nối SMTP

// Hiển thị tất cả các lỗi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Sử dụng autoload của Composer
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Helper/MailService.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

echo "<h1>Kiểm tra kết nối SMTP Gmail</h1>";

// Thử sử dụng MailService
echo "<h2>Test sử dụng MailService</h2>";
try {
    $mailService = new MailService();
    $result = $mailService->testConnection();
} catch (Exception $e) {
    echo "<div style='background:#fff0f0; padding:10px; margin:10px; border:1px solid #ff0000;'>";
    echo "<h3>Lỗi khi dùng MailService:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "</div>";
}

// Thử sử dụng PHPMailer trực tiếp
echo "<h2>Test sử dụng PHPMailer trực tiếp</h2>";
try {
    $mail = new PHPMailer(true);
    
    // Cấu hình SMTP
    $mail->isSMTP();
    $mail->SMTPDebug = 2; // 0: tắt debug, 1: hiện client, 2: hiện cả client & server
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'damvantu2004@gmail.com';
    $mail->Password = 'xecc vfic dpwh hcju';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->CharSet = 'UTF-8';
    
    // Thông tin người gửi và người nhận
    $mail->setFrom('damvantu2004@gmail.com', 'Bakya Shop');
    $mail->addAddress('damvantu2004@gmail.com', 'Test User');
    
    // Nội dung
    $mail->isHTML(true);
    $mail->Subject = 'Bakya Shop - Test kết nối SMTP (Trực tiếp)';
    $mail->Body = "<h2>Đây là email test (Trực tiếp từ PHPMailer)</h2><p>Nếu bạn nhận được email này, cấu hình SMTP đã hoạt động!</p>";
    
    // Gửi mail
    echo "<div style='background:#f0f0f0; padding:10px; margin:10px; border:1px solid #ccc;'>";
    echo "<h3>Bắt đầu test kết nối SMTP trực tiếp...</h3>";
    $result = $mail->send();
    echo "<p><strong>Kết quả: " . ($result ? "Thành công!" : "Thất bại!") . "</strong></p>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div style='background:#fff0f0; padding:10px; margin:10px; border:1px solid #ff0000;'>";
    echo "<h3>Lỗi khi test SMTP trực tiếp:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<p>Lỗi Mailer: " . $mail->ErrorInfo . "</p>";
    echo "</div>";
}

echo "<hr>";
echo "<p>Quay lại <a href='./'>[Trang chủ]</a></p>"; 