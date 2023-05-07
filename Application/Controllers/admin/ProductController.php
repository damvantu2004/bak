<?php

class ProductController extends BaseController
{
    use UploadFile;
    protected $categoryModel;
    protected $productModel;
    protected $message;

    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel;
        $this->loadModel('CategoryModel');
        $this->categoryModel = new CategoryModel;
    }

    public function index()
    {
        $products = $this->productModel->getListProductPaginate();
        $page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
        // $links      = (isset($_GET['links'])) ? $_GET['links'] : 2;
        // links: so page dc hien thi truoc hoac sau dau ...
        $links = 2;
        return $this->view('admin.product.index', [
            'data' => $products->getData(5, $page)->data,
            'pagination' => $products->createLinks($links, 'pagination')
        ]);
    }

    public function create()
    {
        $categories = $this->categoryModel->getAll();
        return $this->view('admin.product.create', [
            'cats' => $categories
        ]);
    }

    public function store()
    {
        $data = [
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'sale_price' => $_POST['sale_price'],
            'description' => $_POST['description'],
            'origin' => $_POST['origin'],
            'quantity' => $_POST['quantity'],
            'status' => $_POST['status'],
            'category_id' => $_POST['category_id']
        ];
        if ($this->getImage()) { //kiểm tra lấy ảnh
            $data['image'] = $this->getImage();
        }
        if (sizeof($this->productModel->findProductByName($_POST['name'])) > 0) {
            $this->message['error-name'] = 'This product is already existing';
        } else {
            $this->message['success-add'] = 'Product added successfully';
            $this->productModel->createData($data);
        }
        $categories = $this->categoryModel->getAll();
        return $this->view('admin.product.create', [
            'message' => $this->message,
            'cats' => $categories
        ]);
        // header('location: ./?module=admin&controller=product');
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        $product = $this->productModel->findProductById(['*'], $id);
        $categories = $this->categoryModel->getAll();
        return $this->view('admin.product.edit', [
            'product' => $product,
            'cats' => $categories
        ]);
    }

    public function update()
    {
        $data = [
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'sale_price' => $_POST['sale_price'],
            'description' => $_POST['description'],
            'origin' => $_POST['origin'],
            'quantity' => $_POST['quantity'],
            'status' => $_POST['status'],
            'category_id' => $_POST['category_id'],
            'updated_at' => date("Y-m-d", time())
        ];
        $product = $this->productModel->findProductById(['*'], $_GET['id']);
        if ($this->getImage()) { //kiểm tra lấy ảnh
            $data['image'] = $this->getImage();
        }
        if (sizeof($this->productModel->checkNameUnique($_POST['name'], $product['name'])) == 1) {
            $this->message['error-name'] = 'This product is already existing';
        } else {
            $this->message['success-edit'] = 'Product updated successfully';
            $this->productModel->updateData($_GET['id'], $data);
        }
        $product = $this->productModel->findProductById(['*'], $_GET['id']);
        $categories = $this->categoryModel->getAll();
        return $this->view('admin.product.edit', [
            'message' => $this->message,
            'product' => $product,
            'cats' => $categories
        ]);
    }
    public function delete()
    {
        $id = $_GET['id'] ?? null;
        $products = $this->productModel->getListProductPaginate();
        $page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
        // $links      = (isset($_GET['links'])) ? $_GET['links'] : 2;
        // links: so page dc hien thi truoc hoac sau dau ...
        $links = 2;
        $count = $this->productModel->countOrders($id);

        if ($id && is_numeric($id) && $count[0]['count'] == 0) {

            $this->productModel->deleteData($id);
            $this->message['success-delete'] = 'Product deleted successfully';
        } else {
            $this->message['error-delete'] = "Can not delete this product. There are still products belonged to it";
            // header('location: ./?module=admin&controller=product');
        }
        return $this->view('admin.product.index', [
            'data' => $products->getData(5, $page)->data,
            'pagination' => $products->createLinks($links, 'pagination'),
            'message' => $this->message
        ]);
    }

    private function getImage()
    { //lấy ảnh
        $image = null;

        if (!empty($_FILES['image']['name'])) {
            $this->setFileName($_FILES['image']['name']);
            $this->setFolderUpload('./public/uploads');
            $this->setFileTemp($_FILES['image']['tmp_name']);
            $image = $this->upload();
        } else {
            $image = $_POST['current-image'];
        }
        return $image;
    }

    public function searchProductByname()
    {
        $searchData = (isset($_REQUEST['productSearch'])) ? $_REQUEST['productSearch'] : "";
        $products = $this->productModel->searchProduct($searchData);
        $page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
        // $links      = (isset($_GET['links'])) ? $_GET['links'] : 2;
        // links: so page dc hien thi truoc hoac sau dau ...
        $links = 2;
        return $this->view('admin.product.index', [
            'data' => $products->getData(5, $page)->data,
            'pagination' => $products->createLinks($links, 'pagination')
        ]);
    }

    public function searchProductFull()
    {
        $searchData = (isset($_REQUEST['productSearch'])) ? $_REQUEST['productSearch'] : "";
        $products = $this->productModel->searchProductFull($searchData);
        $page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
        // $links      = (isset($_GET['links'])) ? $_GET['links'] : 2;
        // links: so page dc hien thi truoc hoac sau dau ...
        $links = 2;
        return $this->view('admin.product.index', [
            'data' => $products->getData(5, $page)->data,
            'pagination' => $products->createLinks($links, 'pagination')
        ]);
    }
}