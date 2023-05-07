<?php

class ReviewController  extends BaseController
{

    protected $reviewModel;
    protected $productModel;


    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel;
        $this->loadModel('ReviewModel');
        $this->reviewModel = new ReviewModel;
    }

    public function index()
    {
        $lists = $this->reviewModel->getReviewList();
        $page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
        // $links      = (isset($_GET['links'])) ? $_GET['links'] : 2;
        // links: so page dc hien thi truoc hoac sau dau ...
        $links = 2;
        return $this->view('admin.review.index', [
            'data' => $lists->getData(5, $page)->data,
            'pagination' => $lists->createLinks($links, 'pagination')
        ]);
    }


    public function reviewDetail()
    {

        $page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $links = 2;
        $id = $_GET['id'] ?? null;
        $product = $this->productModel->findProductById(['name', 'id'], $id);
        $reviews = $this->reviewModel->getAllReviewByProductIdPaginate($id);
        return $this->view('admin.review.detail', [
            'data' => $reviews->getData(5, $page)->data,
            'pagination' => $reviews->createLinks($links, 'pagination'),
            'pro' => $product
        ]);
    }


    public function delete()
    {

        $id = $_GET['id'] ?? null;
        $pro_id = $_GET['proId'] ?? null;
        $this->reviewModel->deleteData($id);

        header("location: ./?module=admin&controller=review&action=reviewDetail&id=" . $pro_id);
    }

    public function searchReviewListFull()
    {
        $searchData = (isset($_REQUEST['reviewSearch'])) ? $_REQUEST['reviewSearch'] : "";
        $reviews = $this->reviewModel->searchReviewListFull($searchData);
        $page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
        // $links      = (isset($_GET['links'])) ? $_GET['links'] : 2;
        // links: so page dc hien thi truoc hoac sau dau ...
        $links = 2;
        return $this->view('admin.review.index', [
            'data' => $reviews->getData(5, $page)->data,
            'pagination' => $reviews->createLinks($links, 'pagination')
        ]);
    }

    public function searchReviewForProductFull()
    {
        $searchData = (isset($_REQUEST['reviewSearch'])) ? $_REQUEST['reviewSearch'] : "";
        $reviews = $this->reviewModel->searchReviewFullForProduct($_GET['id'], $searchData);
        $product = $this->productModel->findProductById(['name', 'id'], $_GET['id']);
        $page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
        // $links      = (isset($_GET['links'])) ? $_GET['links'] : 2;
        // links: so page dc hien thi truoc hoac sau dau ...
        $links = 2;
        return $this->view('admin.review.detail', [
            'data' => $reviews->getData(5, $page)->data,
            'pagination' => $reviews->createLinks($links, 'pagination'),
            'pro' => $product
        ]);
    }
}
