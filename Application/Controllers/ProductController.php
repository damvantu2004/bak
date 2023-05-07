<?php

class ProductController extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $bannerModel;
    protected $reviewModel;
    protected $banners;
    protected $userModel;
    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->loadModel('CategoryModel');
        $this->loadModel('BannerModel');
        $this->loadModel('ReviewModel');
        $this->loadModel('UserModel');
        $this->userModel = new UserModel;
        $this->reviewModel = new ReviewModel;
        $this->bannerModel = new BannerModel;
        $this->productModel = new ProductModel;
        $this->categoryModel = new CategoryModel;
        $this->banners["product"] = $this->bannerModel->findBannerBySite('Product');
        $this->banners["product-detail"] = $this->bannerModel->findBannerBySite('Product Detail');
    }

    public function allProducts()
    {
        // $limit      = (isset($_GET['limit'])) ? $_GET['limit'] : 6;
        $page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
        // $links      = (isset($_GET['links'])) ? $_GET['links'] : 2;
        // links: so page dc hien thi truoc hoac sau dau ...
        $links = 2;
        $categoryId = $_GET['id'] ?? null;

        $categories = $this->categoryModel->getAllWithCount();
        // handle products of a specific category
        if (!empty($_SESSION['categoryId'])) {
            if ($_SESSION['categoryId'] == $categoryId) {
                $categoryId = null;
            } else {
                $_SESSION['categoryId'] = $categoryId;
            }
        } else {
            $_SESSION['categoryId'] = $categoryId;
        }
        $products = ($categoryId != null) ? $this->productModel->getByCategoryIdPaginate($categoryId) : $this->productModel->getAllPaginate();

        $currentCategoryId =  $_SESSION['categoryId'];
        $top_products = $this->productModel->getTopProducts();
        return $this->view('site.product.product', [
            'banners' => $this->banners["product"],
            'products'    => $products->getData(6, $page)->data,
            'categories'  => $categories,
            'currentCategoryId' => $currentCategoryId,
            'pagination' => $products->createLinks($links, 'pagination'),
            'top_products' => $top_products
        ]);
    }

    public function ajaxSearch()
    {
        if (isset($_GET['product'])) {
            $rsTxt = "";

            $product_name = $_GET['product'];
            // get 10 results only
            $product_search_rs = $this->productModel->searchProduct($product_name)->getData(10)->data;
            foreach ($product_search_rs as &$prod) {
                $rsTxt .= "<a href='./?controller=product&action=productDetail&id=" . $prod["id"] . "'>" . "<img class='search-bar-image' src='./public/uploads/" . $prod['image'] . "'" . " alt='" . $prod['name'] . "'> &nbsp;" . $prod["name"] . "</a>";
            }

            echo $rsTxt;

            // echo "<select class='form-control select2' style='width: 400px;'><option data-thumbail='' value=''><span>Product name</span></option></select>";
        } else {
            echo "No result";
        }
    }

    public function search()
    {
        $productName = $_POST['product_name'] ?? null;
        $categoryId = !isset($_GET['id']) ? null : $_GET['id'];
        $categories = $this->categoryModel->getAllWithCount();
        // handle products of a specific category
        if ($_SESSION['categoryId'] == $categoryId) {
            $_SESSION['categoryId'] = null;
            $categoryId = null;
        }
        $products = ($categoryId != null) ? $this->productModel->getByCategoryIdPaginate($categoryId) : $this->productModel->getAllPaginate();
        // print_r($products);
        $_SESSION['categoryId'] = $categoryId;
        $currentCategoryId =  $_SESSION['categoryId'];
        $products = $this->productModel->searchProduct($productName);
        return view('site.product.product', [
            'banners' => $this->banners["product"],
            'products' => $products->getData(6)->data,
            'categories'  => $categories,
            'currentCategoryId' => $currentCategoryId,
            'pagination' => $products->createLinks(2, 'pagination')
        ]);
    }

    public function productDetail()
    {
        $productId = $_GET['id'] ?? null;
        $pro = $this->productModel->getProductById($productId);
        $cat = $this->categoryModel->findCategoryById(['*'], $pro['category_id']);
        $pro_same_cat = $this->productModel->getByCategoryId($pro['category_id'], $productId);
        $reviews = $this->reviewModel->getAllReviewByProductId($productId);
        $user = !empty($_SESSION['user']) ? $this->userModel->findUserById(['*'], $_SESSION['user']['id']) : null;
        $avg = $this->reviewModel->getAvgRating($productId);
        if ($avg['rating'] == NULL) {
            $avg['rating'] = 0;
        }
        return $this->view('site.product.product_detail', [
            'banners' => $this->banners["product-detail"],
            'pro' => $pro,
            'pro_same_cat' => $pro_same_cat,
            'cat' => $cat,
            'reviews' => $reviews,
            'avg' => $avg,
            'user' => $user
        ]);
    }

    public function review()
    {
        if (isset($_POST['rating'], $_POST['content'])) {
            $data = [
                "rating" => $_POST["rating"],
                "content" => $_POST["content"],
                "account_id" => $_SESSION['user']['id'],
                "product_id" =>  $_GET['id']
            ];
            $this->reviewModel->createData($data);
        }
        header('location: .?controller=product&action=productDetail&id=' . $_GET['id'] . '#tabs-2');
    }

    public function removeReview()
    {
        $review_id = $_GET['id'] ?? null;
        $product_id = $_GET['productId'] ?? null;
        $this->reviewModel->deleteData($review_id);
        header('location: .?controller=product&action=productDetail&id=' . $product_id . '#tabs-2');
    }
}
