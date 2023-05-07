<?php

class HomeController extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $bannerModel;
    protected $home_banners;
    protected $about_banners;
    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->loadModel('CategoryModel');
        $this->loadModel('BannerModel');
        $this->bannerModel = new BannerModel;
        $this->categoryModel = new CategoryModel;
        $this->productModel = new ProductModel;
        $this->home_banners = $this->bannerModel->findBannerBySite('Home');
        $this->about_banners = $this->bannerModel->findBannerBySite('About');
    }

    public function index()
    {
        $latest_products8 = $this->productModel->getProducts(8);
        $latest_products4 = $this->productModel->getProducts(4);
        $categories = $this->categoryModel->getAll();
        $offer_pro = $this->productModel->getProductHighestSalePercent();

        // print_r($banners);
        return $this->view('site.home.index', [
            'latest_products8'  => $latest_products8,
            'latest_products4' => $latest_products4,
            'categories' => $categories,
            'banners' => $this->home_banners,
            'offer_pro' => $offer_pro
        ]);
    }

    public function about()
    {

        return $this->view('site.about.index', [
            'banners' => $this->about_banners
        ]);
    }
}
