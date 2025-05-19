<?php
// Không cần require các file PHPMailer nếu đã cài đặt qua Composer
// Dòng dưới đây sẽ tự động load PHPMailer
// require_once './Core/PHPMailer/src/PHPMailer.php';
// require_once './Core/PHPMailer/src/SMTP.php';
// require_once './Core/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->setupMailer();
    }

    private function setupMailer()
    {
        // Cấu hình SMTP
        $this->mail->isSMTP();
        $this->mail->SMTPDebug = 0; // 0: tắt debug, 1: chỉ hiện client, 2: hiện cả client & server
        $this->mail->Debugoutput = 'html';
        $this->mail->Host = 'smtp.gmail.com'; // Thay đổi theo nhà cung cấp email
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'damvantu2004@gmail.com'; // Thay đổi thành email thật
        $this->mail->Password = 'xecc vfic dpwh hcju'; // Thay đổi thành mật khẩu ứng dụng
        $this->mail->SMTPSecure = 'tls'; // Thử lại với TLS thay vì SSL
        $this->mail->Port = 587; // Port cho TLS
        $this->mail->CharSet = 'UTF-8';
        
        // Thông tin người gửi
        $this->mail->setFrom('damvantu2004@gmail.com', 'Bakya Shop');
    }

    public function sendRegistrationEmail($email, $name)
    {
        try {
            // Clear all recipients before adding new ones
            $this->mail->clearAddresses();
            
            // Người nhận
            $this->mail->addAddress($email, $name);
            
            // Nội dung
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Chào mừng bạn đến với Bakya Shop';
            $this->mail->Body = "
                <h2>Xin chào $name!</h2>
                <p>Cảm ơn bạn đã đăng ký tài khoản tại Bakya Shop.</p>
                <p>Thông tin đăng nhập của bạn:</p>
                <p>Email: $email</p>
                <p>Trân trọng,<br>Bakya Shop</p>
            ";
            
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            // Log chi tiết lỗi
            error_log("Email không thể gửi được. Lỗi: {$this->mail->ErrorInfo}");
            // Có thể hiển thị lỗi trực tiếp nếu đang debug
            echo "Lỗi gửi mail: {$this->mail->ErrorInfo}";
            return false;
        }
    }
    
    public function sendVerificationEmail($email, $name, $verificationLink)
    {
        try {
            // Clear all recipients before adding new ones
            $this->mail->clearAddresses();
            
            // Người nhận
            $this->mail->addAddress($email, $name);
            
            // Nội dung
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Xác thực tài khoản Bakya Shop';
            $this->mail->Body = "
                <h2>Xin chào $name!</h2>
                <p>Cảm ơn bạn đã đăng ký tài khoản tại Bakya Shop.</p>
                <p>Vui lòng nhấp vào liên kết dưới đây để xác thực tài khoản của bạn:</p>
                <p><a href='$verificationLink'>Xác thực tài khoản</a></p>
                <p>Liên kết sẽ hết hạn sau 24 giờ.</p>
                <p>Nếu bạn không thực hiện đăng ký tài khoản, vui lòng bỏ qua email này.</p>
                <p>Trân trọng,<br>Bakya Shop</p>
            ";
            
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            // Log chi tiết lỗi
            error_log("Email không thể gửi được. Lỗi: {$this->mail->ErrorInfo}");
            // Có thể hiển thị lỗi trực tiếp nếu đang debug
            echo "Lỗi gửi mail: {$this->mail->ErrorInfo}";
            return false;
        }
    }

    public function sendPasswordResetEmail($email, $resetLink)
    {
        try {
            // Clear all recipients before adding new ones
            $this->mail->clearAddresses();
            
            $this->mail->addAddress($email);
            
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Khôi phục mật khẩu Bakya Shop';
            $this->mail->Body = "
                <h2>Yêu cầu khôi phục mật khẩu</h2>
                <p>Chúng tôi đã nhận được yêu cầu khôi phục mật khẩu từ bạn.</p>
                <p>Vui lòng nhấp vào liên kết dưới đây để đặt lại mật khẩu:</p>
                <p><a href='$resetLink'>Đặt lại mật khẩu</a></p>
                <p>Liên kết sẽ hết hạn sau 24 giờ.</p>
                <p>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>
                <p>Trân trọng,<br>Bakya Shop</p>
            ";
            
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Email could not be sent. Mailer Error: {$this->mail->ErrorInfo}");
            return false;
        }
    }

    public function sendOrderStatusEmail($email, $name, $orderId, $status)
    {
        try {
            // Clear all recipients before adding new ones
            $this->mail->clearAddresses();
            
            $this->mail->addAddress($email, $name);
            
            $statusText = $this->getStatusText($status);
            
            // Tạo URL đầy đủ
            $baseUrl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
            $baseUrl .= $_SERVER['HTTP_HOST'];
            $scriptPath = str_replace('\\', '/', dirname($_SERVER['PHP_SELF']));
            if ($scriptPath != '/') {
                $baseUrl .= $scriptPath;
            }
            if (substr($baseUrl, -1) !== '/') {
                $baseUrl .= '/';
            }
            
            $orderDetailUrl = $baseUrl . "?controller=customer&action=orderDetail&id=" . $orderId;
            
            $this->mail->isHTML(true);
            $this->mail->Subject = "Cập nhật đơn hàng #$orderId - $statusText";
            $this->mail->Body = "
                <h2>Xin chào $name!</h2>
                <p>Đơn hàng #$orderId của bạn đã được cập nhật sang trạng thái: <strong>$statusText</strong>.</p>
                <p>Xem chi tiết đơn hàng tại <a href='$orderDetailUrl'>đây</a>.</p>
                <p>Trân trọng,<br>Bakya Shop</p>
            ";
            
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            // Log chi tiết lỗi
            error_log("Email không thể gửi được. Lỗi: {$this->mail->ErrorInfo}");
            // Có thể hiển thị lỗi trực tiếp nếu đang debug
            echo "Lỗi gửi mail: {$this->mail->ErrorInfo}";
            return false;
        }
    }
    
    private function getStatusText($status)
    {
        switch ($status) {
            case 0:
                return 'Đã giao hàng';
            case 1:
                return 'Đang xử lý';
            case 2:
                return 'Đang giao hàng';
            case 3:
                return 'Đã hủy';
            default:
                return 'Không xác định';
        }
    }
    
    // Hàm kiểm tra kết nối SMTP
    public function testConnection()
    {
        try {
            // Thử kết nối đến máy chủ SMTP
            $this->mail->SMTPDebug = 2; // Hiển thị chi tiết debug
            
            // Clear all recipients
            $this->mail->clearAddresses();
            $this->mail->addAddress('damvantu2004@gmail.com'); // Gửi cho chính mình để test
            
            // Nội dung test
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Bakya Shop - Test kết nối SMTP';
            $this->mail->Body = "<h2>Đây là email test</h2><p>Nếu bạn nhận được email này, cấu hình SMTP đã hoạt động!</p>";
            
            // Gửi mail
            echo "<div style='background:#f0f0f0; padding:10px; margin:10px; border:1px solid #ccc;'>";
            echo "<h3>Bắt đầu test kết nối SMTP...</h3>";
            $result = $this->mail->send();
            echo "<p><strong>Kết quả: " . ($result ? "Thành công!" : "Thất bại!") . "</strong></p>";
            echo "</div>";
            
            return $result;
        } catch (Exception $e) {
            echo "<div style='background:#fff0f0; padding:10px; margin:10px; border:1px solid #ff0000;'>";
            echo "<h3>Lỗi khi test SMTP:</h3>";
            echo "<p>" . $e->getMessage() . "</p>";
            echo "<p>Lỗi Mailer: " . $this->mail->ErrorInfo . "</p>";
            echo "</div>";
            return false;
        }
    }
} 
