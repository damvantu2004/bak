<?php

class VerifyController extends BaseController
{

    const COOKIE_NAME = 'UserToken';

    protected $userModel;
    protected $productModel;
    protected $categoryModel;
    protected $bannerModel;
    protected $banners;
    public function __construct()
    {
        $this->loadModel("UserModel");
        $this->userModel = new UserModel;
        $this->loadModel('ProductModel');
        $this->loadModel('CategoryModel');
        $this->categoryModel = new CategoryModel;
        $this->productModel = new ProductModel;
        $this->loadModel('BannerModel');
        $this->bannerModel = new BannerModel;
        $this->banners = $this->bannerModel->findBannerBySite('Home');
    }


    public function index()
    {
    }

    // verify user info
    public function login()
    {
        $message = [];
        $input = $_REQUEST;

        // validate form input
        if (empty($input['email'])) {
            $message['all-error']    = "Please enter email";
            goto getBackToHome;
        }

        if (empty($input['password'])) {
            $message['all-error'] = "Please enter password";
            goto getBackToHome;
        }

        if ($user = $this->userModel->getUserByEmailAndPwd($input['email'], $input['password'])) {
            // Kiểm tra xem email đã được xác thực chưa
            if (empty($user['email_verified_at'])) { // nếu cột email_verified_at trong bảng account là null
                $message['all-error'] = 'Vui lòng xác thực email trước khi đăng nhập. Kiểm tra hộp thư của bạn.';
                goto getBackToHome;
            }

            if (!empty($input['remember']) && $input['remember'] == 'on') {
                // generate a session key
                $token = openssl_random_pseudo_bytes(16);
                //Convert the binary data into hexadecimal representation.
                $token = bin2hex($token);

                // todo: construct a storage to store junk tokens

                // update to account db
                $data =
                    [
                        'remember_token'           => $token,
                    ];
                $this->userModel->updateData($user['id'], $data);

                // add session key to browser's cookie
                setcookie(self::COOKIE_NAME, $token, time() + 30 * 24 * 60 * 60, "/", "", "", "true");
            }

            $_SESSION['user'] = $user;
            if ($_SESSION['user']["role"] == "admin") {
                header('location: ./?module=admin&controller=dashboard');
            } else {
                $message['success-login'] = 'Login successfully';
            }
        } else {
            $message['all-error'] = 'Invalid email or password';
        }

        getBackToHome:

        $latest_products8 = $this->productModel->getProducts(8);
        $latest_products4 = $this->productModel->getProducts(4);
        $categories = $this->categoryModel->getAll();
        $offer_pro = $this->productModel->getProductHighestSalePercent();
        $this->view('site.home.index', [
            'banners' => $this->banners,
            'message' => $message,
            'latest_products8'  => $latest_products8,
            'latest_products4' => $latest_products4,
            'categories' => $categories,
            'offer_pro' => $offer_pro
        ]);
    }

    public function autoLogin()
    {
        $message = [];

        if (isset($_COOKIE[self::COOKIE_NAME]) && strlen($_COOKIE[self::COOKIE_NAME]) != 0) {
            // increase time for cookie each time user logins
            setcookie(self::COOKIE_NAME, $_COOKIE[self::COOKIE_NAME], time() + 30 * 24 * 60 * 60, "/", "", "", "true");

            // get user from db by token
            $user = $this->userModel->getUserByToken($_COOKIE[self::COOKIE_NAME]);

            // Kiểm tra xem email đã được xác thực chưa
            if (empty($user['email_verified_at'])) {
                $message['all-error'] = 'Vui lòng xác thực email trước khi đăng nhập. Kiểm tra hộp thư của bạn.';
                goto showHomepage;
            }

            // create session for user
            $_SESSION['user'] = $user;
            if (isset($_SESSION['user']["role"]) && $_SESSION['user']["role"] == "admin") {
                header('location: ./?module=admin&controller=dashboard');
            } else {
                $message['success-login'] = 'Login successfully';
            }
        }

        showHomepage: // điều hướng về trang chủ khi có lỗi. Nếu không có lỗi thì không cần điều hướng
        $latest_products8 = $this->productModel->getProducts(8);
        $latest_products4 = $this->productModel->getProducts(4);
        $categories = $this->categoryModel->getAll();
        $offer_pro = $this->productModel->getProductHighestSalePercent();

        $this->view('site.home.index', [
            'banners' => $this->banners,
            'message' => $message,
            'latest_products8'  => $latest_products8,
            'latest_products4' => $latest_products4,
            'categories' => $categories,
            'offer_pro' => $offer_pro
        ]);
    }

    public function signup()
    {
        $message = [];
        $input = $_REQUEST;

        // validate form input
        if (empty($input['fname'])) {
            $message['all-error']    = "Please enter first name";
            goto getBackToHome;
        }

        if (empty($input['lname'])) {
            $message['all-error'] = "Please enter last name";
            goto getBackToHome;
        }

        if (empty($input['email'])) {
            $message['all-error'] = "Please enter email";
            goto getBackToHome;
        }

        if (empty($input['phone'])) {
            $message['all-error'] = "Please enter phone";
            goto getBackToHome;
        }

        if (empty($input['province'])) {
            $message['all-error'] = "Please enter province";
            goto getBackToHome;
        }

        if (empty($input['address'])) {
            $message['all-error'] = "Please enter address";
            goto getBackToHome;
        }

        if (empty($input['password'])) {
            $message['all-error'] = "Please enter password";
            goto getBackToHome;
        }

        if (empty($input['password_confirmation'])) {
            $message['all-error'] = "Please enter password confirmation";
            goto getBackToHome;
        }

        if ($input['password'] != $input['password_confirmation']) {
            $message['all-error'] = "Two passwords don't match";
            goto getBackToHome;
        }

        // check if email existed
        $rs = $this->userModel->isEmailExisted($input['email']);
        if ($rs) {
            $message['all-error'] = "Email existed";
            goto getBackToHome;
        }

        // check if phone existed
        $rs = $this->userModel->isPhoneExisted($input['phone']);
        if ($rs) {
            $message['all-error'] = "Phone existed";
            goto getBackToHome;
        }

        // Tạo token xác thực
        $verificationToken = bin2hex(random_bytes(32));

        // insert new user
        $data =
            [
                'fname'           => $input['fname'],
                'lname'         => $input['lname'],
                'email'         => $input['email'],
                'phone'         => $input['phone'],
                'province'         => $input['province'],
                'address'         => $input['address'],
                'password'         => password_hash($input['password'], PASSWORD_BCRYPT),
                'verification_token' => $verificationToken,
                'email_verified_at' => null
            ];
        $created_user = $this->userModel->createData($data);
        if ($created_user['email'] == $input['email']) {
            // Gửi email xác thực
            require_once './Helper/MailService.php';
            $mailService = new MailService();
            
            // Tạo đường dẫn xác thực
            $baseUrl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
            $baseUrl .= $_SERVER['HTTP_HOST'];
            // Sửa lại cách tạo baseUrl để tránh các ký tự escape
            $scriptPath = str_replace('\\', '/', dirname($_SERVER['PHP_SELF']));
            $baseUrl .= $scriptPath;
            if (substr($baseUrl, -1) !== '/') {
                $baseUrl .= '/';
            }
            $verificationLink = $baseUrl . "?controller=verify&action=verifyEmail&token=$verificationToken";
            $fullName = $input['fname'] . ' ' . $input['lname'];
            
            $mailService->sendVerificationEmail($input['email'], $fullName, $verificationLink);
            
            $message['success-register'] = 'Đăng ký thành công! Vui lòng kiểm tra email để xác thực tài khoản.';
        } else {
            $message['all-error'] = 'Signup failed';
        }

        getBackToHome:

        $latest_products8 = $this->productModel->getProducts(8);
        $latest_products4 = $this->productModel->getProducts(4);
        $categories = $this->categoryModel->getAll();
        $offer_pro = $this->productModel->getProductHighestSalePercent();

        $this->view('site.home.index', [
            'banners' => $this->banners,
            'message' => $message,
            'latest_products8'  => $latest_products8,
            'latest_products4' => $latest_products4,
            'categories' => $categories,
            'offer_pro' => $offer_pro
        ]);
    }

    public function logout()
    {
        if (!empty($_SESSION['user'])) {
            // if user chose "remember me" -> delete session key in browser & db
            $data =
                [
                    'remember_token'           => "",
                ];
            $this->userModel->updateData($_SESSION['user']['id'], $data);

            // remove session
            unset($_SESSION['user']);
        }

        if (isset($_COOKIE[self::COOKIE_NAME])) {
            // remove cookie
            setcookie(self::COOKIE_NAME, "", time() - 3600, "/", "", "", "true");
        }
        $_SESSION['cart'] = [];
        $_SESSION['total_quantity'] = 0;
        header('location:index.php');
    }
    
    // Xác thực email
    public function verifyEmail() 
    {
        $token = $_GET['token'] ?? '';
        $message = [];
        
        if (empty($token)) {
            $message['all-error'] = 'Token không hợp lệ';
            goto showHomepage;
        }
        
        // Lấy thông tin user từ token
        $user = $this->userModel->getUserByVerificationToken($token);
        
        if (!$user) {
            $message['all-error'] = 'Token không hợp lệ hoặc đã được sử dụng';
            goto showHomepage;
        }
        
        // Cập nhật thời gian xác thực
        $this->userModel->verifyEmail($token);
        
        $message['success-verify'] = 'Xác thực email thành công! Bạn có thể đăng nhập ngay bây giờ.';
        
        showHomepage:
        $latest_products8 = $this->productModel->getProducts(8);
        $latest_products4 = $this->productModel->getProducts(4);
        $categories = $this->categoryModel->getAll();
        $offer_pro = $this->productModel->getProductHighestSalePercent();
        
        $this->view('site.home.index', [
            'banners' => $this->banners,
            'message' => $message,
            'latest_products8'  => $latest_products8,
            'latest_products4' => $latest_products4,
            'categories' => $categories,
            'offer_pro' => $offer_pro
        ]);
    }
    
    // Quên mật khẩu
    public function forgotPassword()
    {
        $this->view('site.account.forgot_password');
    }
    
    public function sendResetLink()
    {
        $email = $_POST['email'] ?? '';
        $message = [];
        
        if (empty($email)) {
            $message['error'] = 'Vui lòng nhập email';
            goto showForm;
        }
        
        // Kiểm tra email tồn tại
        $user = $this->userModel->findUserByEmail(['*'], $email);
        
        if (!$user) {
            $message['error'] = 'Email không tồn tại trong hệ thống';
            goto showForm;
        }
        
        // Tạo token reset mật khẩu
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+24 hours'));
        
        // Lưu token vào database
        $this->userModel->saveResetToken($user['id'], $token, $expires);
        
        // Gửi email với link reset
        require_once './Helper/MailService.php';
        $mailService = new MailService();
        
        // Tạo đường dẫn xác thực - FIX URL CREATION
        $baseUrl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
        $baseUrl .= $_SERVER['HTTP_HOST'];
        
        // Sửa lại cách tạo baseUrl để tránh các ký tự escape
        $scriptPath = str_replace('\\', '/', dirname($_SERVER['PHP_SELF']));
        $baseUrl .= $scriptPath;
        if (substr($baseUrl, -1) !== '/') {
            $baseUrl .= '/';
        }
        
        $resetLink = $baseUrl . "?controller=verify&action=resetPassword&token=$token";
        
        if ($mailService->sendPasswordResetEmail($email, $resetLink)) {
            $message['message'] = 'Chúng tôi đã gửi một email với hướng dẫn đặt lại mật khẩu. Vui lòng kiểm tra hộp thư của bạn.';
        } else {
            $message['error'] = 'Có lỗi xảy ra khi gửi email. Vui lòng thử lại sau.';
        }
        
        showForm:
        $this->view('site.account.forgot_password', $message);
    }
    
    public function resetPassword()
    {
        $token = $_GET['token'] ?? '';
        
        if (empty($token)) {
            return $this->view('site.account.forgot_password', [
                'error' => 'Token không hợp lệ'
            ]);
        }
        
        // Kiểm tra token hợp lệ
        if (!$this->userModel->validateResetToken($token)) {
            return $this->view('site.account.forgot_password', [
                'error' => 'Liên kết đã hết hạn hoặc không hợp lệ'
            ]);
        }
        
        // Hiển thị form đặt lại mật khẩu
        return $this->view('site.account.reset_password', [
            'token' => $token
        ]);
    }
    
    public function updatePassword()
    {
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        // Kiểm tra dữ liệu đầu vào
        if (empty($token) || empty($password) || empty($confirmPassword)) {
            return $this->view('site.account.reset_password', [
                'token' => $token,
                'error' => 'Vui lòng điền đầy đủ thông tin'
            ]);
        }
        
        // Kiểm tra mật khẩu trùng khớp
        if ($password !== $confirmPassword) {
            return $this->view('site.account.reset_password', [
                'token' => $token,
                'error' => 'Mật khẩu xác nhận không khớp'
            ]);
        }
        
        // Lấy thông tin user từ token
        $user = $this->userModel->getUserByResetToken($token);
        
        if (!$user) {
            return $this->view('site.account.forgot_password', [
                'error' => 'Token không hợp lệ'
            ]);
        }
        
        // Cập nhật mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->userModel->updatePassword($user['id'], $hashedPassword);
        $this->userModel->clearResetToken($user['id']);
        
        // Gửi email thông báo
        require_once './Helper/MailService.php';
        $mailService = new MailService();
        $mailService->sendPasswordResetEmail($user['email'], 'Mật khẩu của bạn đã được đặt lại thành công!');
        
        $message = [];
        $message['success-login'] = 'Đặt lại mật khẩu thành công! Bạn có thể đăng nhập ngay bây giờ.';
        
        $latest_products8 = $this->productModel->getProducts(8);
        $latest_products4 = $this->productModel->getProducts(4);
        $categories = $this->categoryModel->getAll();
        $offer_pro = $this->productModel->getProductHighestSalePercent();
        
        $this->view('site.home.index', [
            'banners' => $this->banners,
            'message' => $message,
            'latest_products8'  => $latest_products8,
            'latest_products4' => $latest_products4,
            'categories' => $categories,
            'offer_pro' => $offer_pro
        ]);
    }
}
