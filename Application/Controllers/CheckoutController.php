<?php

class CheckoutController extends BaseController
{
    protected $productModel;
    protected $cart;
    protected $orderModel;
    protected $orderDetail;
    protected $banners;
    protected $bannerModel;
    protected $couponModel;
    protected $userModel;
    protected $coupon;

    public function __construct()
    {
        $this->loadHelper('CartHelper');
        $this->cart = new CartHelper;
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel;
        $this->loadModel('OrderModel');
        $this->orderModel = new OrderModel;
        $this->loadModel('OrderDetail');
        $this->orderDetail = new OrderDetail;
        $this->loadModel('BannerModel');
        $this->bannerModel = new BannerModel;
        $this->banners = $this->bannerModel->findBannerBySite('Checkout');
        $this->loadModel('CouponModel');
        $this->couponModel = new CouponModel;
        $this->loadModel('UserModel');
        $this->userModel = new UserModel;
    }

    public function index()
    {
        $user = !empty($_SESSION['user']) ? $this->userModel->findUserById(['*'], $_SESSION['user']['id']) : null;
        $_SESSION['coupon'] = empty($_SESSION['coupon']) ? null : $_SESSION['coupon'];
        return $this->view('site.checkout.checkout', [
            'cart' => $this->cart,
            'banners' => $this->banners,
            'user' => $user
        ]);
    }

    public function process()
    {
        $data = [
            "fname" => $_POST["fname"],
            "lname" => $_POST["lname"],
            "email" => $_POST["email"],
            "phone" => $_POST["phone"],
            "province" => $_POST["province"],
            "address" => $_POST["address"],
            "note" => $_POST["note"],
            "delivery" => $_POST["delivery"],
            "payment" => $_POST["payment"],
            "account_id" => $_SESSION["user"]["id"],
            "coupon" => $_SESSION["coupon"]
        ];

        // store order
        if (!empty($this->cart)) {
            $order = $this->orderModel->store($data);
            // 2. Luu gio hang vao order detail
            foreach ($this->cart->items as $item) {
                $this->orderDetail->store([
                    'order_id' => $order["id"],
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price_sum']
                ]);
            }
        }

        // update coupon
        $coupon = $this->couponModel->getCouponDetailById($_SESSION["coupon_id"]);
        $status = ($coupon["used_times"] == 1) ? 0 : 1;
        $used_times = $coupon["used_times"] - 1;

        $coupon_data = [
            'status' => $status,
            'used_times' => $used_times,
            'updated_at' => date("Y-m-d", time())
        ];
        $this->couponModel->updateDataAfterCheckout($coupon["id"], $coupon_data);

        // clear cart and session data
        $this->cart->clear();
        $_SESSION["coupon"] = 0;
        $_SESSION["coupon_id"] = "";

        // return view
        // return view('site.checkout.success_order', [
        //     'order'=>$this->orderModel->getOrderDetailById($order['id']),
        //     'order_detail'=>$this->orderModel->getAllProductsInOrderById($order['id'])
        // ]);
        header('location: ./?controller=customer&action=orderDetail&id=' . $order["id"]);
    }

    public function validate($data)
    {
        $isValid = false;
    }
}
