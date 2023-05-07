<?php

class CategoryController extends BaseController
{

    protected $categoryModel;
    protected $message;

    public function __construct()
    {
        $this->loadModel('CategoryModel');
        $this->categoryModel = new CategoryModel;
    }

    public function index()
    {
        $categories = $this->categoryModel->getAllWithCountAllStatus();

        return $this->view('admin.category.index', [
            "data" => $categories
        ]);
    }

    public function create()
    {
        return $this->view('admin.category.create');
    }

    public function store()
    {

        $data = [
            'name' => $_POST['name'],
            'status' => $_POST['status'],
            'priority' => $_POST['priority'],
        ];
        if (sizeof($this->categoryModel->findCategoryByName($_POST['name'])) > 0) {
            $this->message['error-name'] = 'This category is already existing';
        } else {
            $this->message['success-add'] = 'Category added successfully';
            $this->categoryModel->createData($data);
        }
        return $this->view('admin.category.create', [
            'message' => $this->message
        ]);
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        $category = $this->categoryModel->findCategoryById(['*'], $id);

        return $this->view('admin.category.edit', [
            'category' => $category,
        ]);
    }

    public function update()
    {
        $data = [
            'name' => $_POST['name'],
            'status' => $_POST['status'],
            'priority' => $_POST['priority'],
            'updated_at' => date("Y-m-d", time())
        ];
        $category = $this->categoryModel->findCategoryById(['*'], $_GET['id']);
        if (sizeof($this->categoryModel->checkNameUnique($_POST['name'], $category['name'])) == 1) {
            $this->message['error-name'] = 'This category is already existing';
        } else {
            $this->message['success-edit'] = 'Category updated successfully';
            $this->categoryModel->updateData($_GET['id'], $data);
        }
        $category = $this->categoryModel->findCategoryById(['*'], $_GET['id']);
        return $this->view('admin.category.edit', [
            'message' => $this->message,
            'category' => $category
        ]);
    }
    public function delete()
    {
        $id = $_GET['id'] ?? null;
        $categories = $this->categoryModel->getAllWithCountAllStatus();
        $count = $this->categoryModel->countProducts($id);

        if ($id && is_numeric($id) && $count[0]['count'] == 0) {

            $this->categoryModel->deleteData($id);
            $this->message['success-delete'] = 'Category deleted successfully';
        } else {
            $this->message['error-delete'] = "Can not delete this category. There are still products belonged to it";
        }
        return $this->view('admin.category.index', [
            "data" => $categories,
            "message" => $this->message
        ]);
    }

    public function searchCategoryFull()
    {
        $searchData = (isset($_REQUEST['categorySearch'])) ? $_REQUEST['categorySearch'] : "";
        $categories = $this->categoryModel->searchCategoryFull($searchData);
        return $this->view('admin.category.index', [
            'data' => $categories
        ]);
    }
}
