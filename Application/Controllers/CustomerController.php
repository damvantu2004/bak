<?php

class CustomerController extends BaseController
{
    protected $userModel;
    protected $bannerModel;
    protected $orderModel;

    public function __construct()
    {
        $this->loadModel('UserModel');
        $this->userModel = new UserModel;
        $this->loadModel('BannerModel');
        $this->bannerModel = new BannerModel;
        $this->banners = $this->bannerModel->findBannerBySite('Checkout');
        $this->bannersHistory = $this->bannerModel->findBannerBySite('Cart');
        $this->loadModel('OrderModel');
        $this->orderModel = new OrderModel;
    }

    public function viewProfile()
    {
        // todo add mechanism to allow only logged-in user

        $user = $this->userModel->findUserById(['*'], $_SESSION['user']['id']);

        if (!isset($_SESSION['user'])) {
            header('location: ./');
        }

        return view('site.customer.profile', [
            'banners' => $this->banners,
            'user' => $user
        ]);
    }

    public function updateProfile()
    {
        // todo add mechanism to allow only logged-in user
        if (!isset($_SESSION['user'])) {
            header('location: ./');
        }

        $message = [];
        $input = $_REQUEST;
        $user = $this->userModel->findUserById(['*'], $_SESSION['user']['id']);
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
            $message['all-error']    = "Please enter email";
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

        if (empty($input['current_password'])) {
            $message['all-error'] = "Please enter password";
            goto getBackToHome;
        }

        // todo: add hash helper function
        // check if submitted password is same as current user password
        if (md5($input['current_password']) != $_SESSION['user']['password']) {
            $message['all-error'] = "Wrong password";
            goto getBackToHome;
        }

        // round 2: 
        // check if submitted password is same as current user password in db
        if ($user = $this->userModel->getUserByEmailAndPwd($_SESSION['user']['email'], $input['current_password'])) {
            if ($user['email'] != $_SESSION['user']['email']) {
                $message['all-error'] = "Invalid password";
                goto getBackToHome;
            }

            $new_email = $input['email'];
            $new_phone = $input['phone'];

            // check if email has been changed
            if ($input['email'] != $user['email']) {
                // check new email is free to use (check existence in db)
                $rs = $this->userModel->isEmailExisted($input['email']);
                if ($rs) {
                    $message['all-error'] = "Email existed";
                    goto getBackToHome;
                }
            }

            // check if phone has been changed
            if ($input['phone'] != $user['phone']) {
                // check new phone is free to use (check existence in db)
                $rs = $this->userModel->isPhoneExisted($input['phone']);
                if ($rs) {
                    $message['all-error'] = "Phone existed";
                    goto getBackToHome;
                }
            }

            // new user data 
            $data =
                [
                    'fname'           => $input['fname'],
                    'lname'         => $input['lname'],
                    'email'         => $new_email,
                    'phone'         => $new_phone,
                    'province'         => $input['province'],
                    'address'         => $input['address'],
                ];

            // update user data in db
            $this->userModel->updateData($user['id'], $data);

            // get user data again
            if ($user = $this->userModel->getUserByEmailAndPwd($new_email, $input['current_password'])) {
                // update user data in browser's session
                $_SESSION['user'] = $user;
                $message['success-update-profile'] = 'Update profile successfully';
            } else {
                $message['all-error'] = "Cannot get up-to-date user info";
            }
        } else {
            $message['all-error'] = "Submitted email and password does not match any user";
        }

        getBackToHome:

        return view('site.customer.profile', [
            'banners' => $this->banners,
            'message' => $message,
            'user' => $user
        ]);
    }

    public function updatePassword()
    {
        // todo add mechanism to allow only logged-in user
        if (!isset($_SESSION['user'])) {
            header('location: ./');
        }
        $user = $this->userModel->findUserById(['*'], $_SESSION['user']['id']);
        $message = [];
        $input = $_REQUEST;

        // validate form input
        if (empty($input['current_password'])) {
            $message['all-error'] = "Please enter password";
            goto getBackToHome;
        }

        if (empty($input['new_password'])) {
            $message['all-error'] = "Please enter new password";
            goto getBackToHome;
        }

        if (empty($input['new_confirm_password'])) {
            $message['all-error'] = "Please enter confirmed new password";
            goto getBackToHome;
        }

        if ($input['current_password'] == $input['new_password']) {
            $message['all-error'] = "New password and current password are identical";
            goto getBackToHome;
        }

        if ($input['new_password'] != $input['new_confirm_password']) {
            $message['all-error'] = "Confirmed password is different from new password";
            goto getBackToHome;
        }

        // todo: add hash helper function

        // check if submitted current password is same as current user password
        if (md5($input['current_password']) != $_SESSION['user']['password']) {
            $message['all-error'] = "Wrong password";
            goto getBackToHome;
        }

        // round 2: 
        // check if submitted password is same as current user password in db
        if ($user = $this->userModel->getUserByEmailAndPwd($_SESSION['user']['email'], $input['current_password'])) {
            if ($user['email'] != $_SESSION['user']['email']) {
                $message['all-error'] = "Invalid password";
                goto getBackToHome;
            }

            // new user data 
            $data =
                [
                    'password'         => md5($input['new_password']),
                ];

            // update user data in db
            $this->userModel->updateData($user['id'], $data);

            // get user data again
            if ($user = $this->userModel->getUserByEmailAndPwd($_SESSION['user']['email'], $input['new_password'])) {
                // update user data in browser's session
                $_SESSION['user'] = $user;
                $message['success-update-profile'] = 'Update password successfully';
            } else {
                $message['all-error'] = "Cannot get up-to-date user info";
            }
        } else {
            $message['all-error'] = "Submitted email and password does not match any user";
        }

        getBackToHome:

        return view('site.customer.profile', [
            'banners' => $this->banners,
            'message' => $message,
            'user' => $user
        ]);
    }

    public function listOrders()
    {
        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $links = 2;

        $id = $_SESSION["user"]["id"];
        $orders = $this->orderModel->getAllOrdersByAccountId($id);
        return view('site.customer.order_list', ['orders' => $orders->getData(6, $page)->data, 'banners' => $this->bannersHistory, "pagination" => $orders->createLinks($links, "pagination")]);
    }

    public function orderDetail()
    {
        $id = $_GET["id"] ?? null;
        $order = $this->orderModel->getOrderDetailById($id);
        $products_in_order = $this->orderModel->getAllProductsInOrderById($id);
        return view('site.customer.order_detail', ['order' => $order, 'products_in_order' => $products_in_order, 'banners' => $this->bannersHistory]);
    }

    public function cancelOrder()
    {
        $id = $_GET['id'] ?? null;
        $data = [
            'status' => 3,
            'updated_at' => date("Y-m-d", time())
        ];
        $this->orderModel->updateData($id, $data);
        header("location: ./?controller=customer&action=orderDetail&id=$id");
    }
}
