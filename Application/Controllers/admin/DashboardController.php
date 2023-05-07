<?php

class DashboardController extends BaseController
{
    protected $userModel;
    protected $orderModel;
    protected $reviewModel;
    protected $productModel;

    public function __construct()
    {
        $this->loadModel('UserModel');
        $this->userModel = new UserModel;
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel;
        $this->loadModel('OrderModel');
        $this->orderModel = new OrderModel;
        $this->loadModel('ReviewModel');
        $this->reviewModel = new ReviewModel;
    }

    public function index()
    {
        $total_orders = $this->orderModel->getTotalOrders()["total_orders"];
        $total_customers = $this->userModel->getTotalCustomers()["total_customers"];
        $avg_rating = $this->reviewModel->getAvgRatingAll()['avg_rating'];
        $total_products = $this->productModel->getTotalProducts()["total_products"];

        $top_products = $this->productModel->getTopProducts();
        $top_customers = $this->userModel->getTopCustomers();
        return $this->view('admin.dashboard.index', [
            'total_orders' => $total_orders,
            'total_customers' => $total_customers,
            'total_products' => $total_products,
            'avg_rating' => $avg_rating,
            'top_products' => $top_products,
            'top_customers' => $top_customers
        ]);
    }
}
