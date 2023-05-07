<?php

class CartController extends BaseController
{
    protected $categoryModel;
    protected $productModel;
    protected $bannerModel;
    protected $reviewModel;
    protected $couponModel;
    protected $cart;
    protected $success;
    protected $banners;
    public function __construct()
    {
        $this->loadHelper('CartHelper');
        $this->cart = new CartHelper;
        $this->loadModel('CategoryModel');
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel;
        $this->categoryModel = new CategoryModel;
        $this->loadModel('CouponModel');
        $this->couponModel = new CouponModel;
        $this->loadModel('BannerModel');
        $this->bannerModel = new BannerModel;
        $this->loadModel('ReviewModel');
        $this->reviewModel = new ReviewModel;
        $this->success = [];
        $this->banners = $this->bannerModel->findBannerBySite('Cart');
    }

    public function index()
    {
        $coupon = empty($_SESSION['coupon']) ? null : $_SESSION['coupon'];
        $_SESSION['coupon_id'] = empty($_SESSION['coupon_id']) ? null : $_SESSION['coupon_id'];
        return $this->view('site.cart.cart', [
            'banners' => $this->banners,
            'cart' => $this->cart,
            'coupon' => $coupon,
            'coupon_id' => $_SESSION["coupon_id"],
        ]);
    }


    public function add()
    {
        $id = $_GET['id'] ?? null;
        $pro = $this->productModel->findProductById(['*'], $id);
        $this->cart->add($pro);

        $this->success['add_to_cart'] = "Product '" . $pro['name'] . "' added to cart successfully";

        $latest_products8 = $this->productModel->getProducts(8);
        $latest_products4 = $this->productModel->getProducts(4);
        $categories = $this->categoryModel->getAll();
        $offer_pro = $this->productModel->getProductHighestSalePercent();
        $this->view('site.home.index', [
            'banners' => $this->bannerModel->findBannerBySite('Home'),
            'success' => $this->success,
            'latest_products8'  => $latest_products8,
            'latest_products4' => $latest_products4,
            'categories' => $categories,
            'offer_pro' => $offer_pro
        ]);
    }

    public function addAjax()
    {
        $message = "";
        if (!isset($_GET['id'])) {
            // die("invalid id");
            $message = "invalid id";
            goto endPoint;
        }
        $id = $_GET['id'];
        $pro = $this->productModel->findProductById(['*'], $id);
        $this->cart->add($pro);
        $message = "Product '" . $pro['name'] . "' added to cart successfully";
        $ajaxRes = array();
        $ajaxRes["cartQuantity"] = $this->cart->total_quantity;
        $ajaxRes["message"] = $message;

        endPoint:
        echo json_encode($ajaxRes);
    }

    public function addQuantity()
    {
        $id = $_GET['id'] ?? null;
        $pro = $this->productModel->findProductById(['*'], $id);
        $quantity_add_more = $_POST['more'];
        $this->cart->add($pro, $quantity_add_more);
        $this->success['add_to_cart_quantity'] = $quantity_add_more . ($quantity_add_more > 1 ? " products '" : " product '") . $pro['name'] . "' added to cart successfully";

        $cat = $this->categoryModel->findCategoryById(['*'], $pro['category_id']);
        $pro_same_cat = $this->productModel->getByCategoryId($pro['category_id'], $id);
        $reviews = $this->reviewModel->getAllReviewByProductId($id);

        $avg = $this->reviewModel->getAvgRating($id);
        if ($avg['rating'] == NULL) {
            $avg['rating'] = 5;
        }
        return $this->view('site.product.product_detail', [
            'banners' => $this->bannerModel->findBannerBySite('Product'),
            'pro' => $pro,
            'pro_same_cat' => $pro_same_cat,
            'cat' => $cat,
            'success' => $this->success,
            'reviews' => $reviews,
            'avg' => $avg
        ]);
    }

    public function removeOne()
    {
        $id = $_GET['id'] ?? null;
        $pro = $this->productModel->findProductById(['*'], $id);
        if ($_GET['quantity'] > 1) {
            $this->cart->add($pro, -1);
        } else {
            $this->cart->delete($id);
        }

        header('location: ./?controller=cart');
    }

    public function addOne()
    {
        $id = $_GET['id'] ?? null;
        $pro = $this->productModel->findProductById(['*'], $id);

        $this->cart->add($pro, 1);

        header('location: ./?controller=cart');
    }

    public function ajaxModifyQuantity()
    {
        if (!isset($_GET['id'])) {
            // die("invalid id");
            goto endPoint;
        }

        if (!isset($_GET['cartAction']) || !($_GET['cartAction'] == "add" || $_GET['cartAction'] == "remove")) {
            // die("invalid action");
            goto endPoint;
        }

        $id = $_GET['id'];
        $action = $_GET['cartAction'];
        $pro = $this->productModel->findProductById(['*'], $id);

        if ($action == "add") {
            $this->cart->add($pro, 1);
        } else if ($action == "remove") {
            // this quantity field indicates the current quantity of that product in cart (not the new quantity)
            if (!isset($_GET['quantity'])) {
                // die("invalid quantity");
                goto endPoint;
            }
            if ($_GET['quantity'] > 1) {
                $this->cart->add($pro, -1);
            } else {
                $this->cart->delete($id);
            }
        }
        endPoint:
        echo json_encode($this->cart);
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        $this->cart->delete($id);

        if (empty($_SESSION['cart'])) {
            header('location: ./');
        }
        if (!empty($_SESSION['cart'])) {
            header('location: ./?controller=cart');
        }
    }

    public function ajaxDelete()
    {
        if (!isset($_GET['id']) || !isset($_GET['cartAction']) || $_GET['cartAction'] != "delete") {
            // die("invalid id");
            goto endPoint;
        }

        $this->cart->delete($_GET['id']);

        endPoint:
        echo json_encode($this->cart);
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        $quantity = $_POST['quantity'] ? $_POST['quantity'] : 1;
        if ($quantity  >= 1) {
            $this->cart->update($id, $quantity);
        } else {
            $this->cart->delete($id);
        }
        header('location: ./?controller=cart');
    }



    public function clear()
    {
        $this->cart->clear();
        header('location: ./');
    }

    public function applyCoupon()
    {
        $coupon = $this->couponModel->getCouponDetailById($_POST["coupon_id"]);
        $_SESSION["coupon"] = !empty($coupon) ? (($coupon["status"] == 1 && $coupon["used_times"] > 0) ? $coupon["coupon_value"] : 0) : 0;
        $_SESSION["coupon_id"] = $_POST["coupon_id"];

        // header('location: ./?controller=cart');
        return view('site.cart.cart', [
            'coupon' => $_SESSION["coupon"],
            'cart' => $this->cart,
            'coupon_id' => $_POST["coupon_id"],
            'banners' => $this->banners
        ]);
    }
}