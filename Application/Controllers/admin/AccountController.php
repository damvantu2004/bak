<?php

class AccountController extends BaseController
{

    protected $userModel;
    protected $message;

    public function __construct()
    {
        $this->loadModel('UserModel');
        $this->userModel = new UserModel;
    }

    public function index()
    {
        $accounts = $this->userModel->getAllPaginate();
        $page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
        // $links      = (isset($_GET['links'])) ? $_GET['links'] : 2;
        // links: so page dc hien thi truoc hoac sau dau ...
        $links = 2;
        return $this->view('admin.account.index', [
            'data' => $accounts->getData(7, $page)->data,
            'pagination' => $accounts->createLinks($links, 'pagination')
        ]);
    }

    public function create()
    {
        return $this->view('admin.account.create');
    }

    public function store()
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

        if (empty($input['role'])) {
            $message['all-error'] = "Please enter role";
            goto getBackToHome;
        }

        if ($input['role'] != "admin" && $input['role'] != "customer") {
            $message['all-error'] = "Please enter valid role";
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

        // insert new user
        $data =
            [
                'fname'             => $input['fname'],
                'lname'             => $input['lname'],
                'email'             => $input['email'],
                'phone'             => $input['phone'],
                'province'          => $input['province'],
                'role'              => $input['role'],
                'address'           => $input['address'],
                'password'          => md5($input['password']),
            ];
        $created_user = $this->userModel->createData($data);
        if ($created_user['email'] == $input['email']) {
            $message['success-update-profile'] = 'Create new account successfully';
        } else {
            $message['all-error'] = 'Create new account failed';
        }

        getBackToHome:

        $accounts = $this->userModel->getAllPaginate();
        $page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
        // $links      = (isset($_GET['links'])) ? $_GET['links'] : 2;
        // links: so page dc hien thi truoc hoac sau dau ...
        $links = 2;
        return $this->view('admin.account.create', [
            'message' => $message,
        ]);

        // $data = [
        //     'name' => $_POST['name'],
        //     'status' => $_POST['status'],
        //     'priority' => $_POST['priority'],
        // ];
        // if (sizeof($this->categoryModel->findCategoryByName($_POST['name'])) > 0) {
        //     $this->message['error-name'] = 'This category is already existing';
        // } else {
        //     $this->message['success-add'] = 'Category added successfully';
        //     $this->categoryModel->createData($data);
        // }
        // return $this->view('admin.category.create', [
        //     'message' => $this->message
        // ]);
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        $account = $this->userModel->findUserById(['*'], $id);

        return $this->view('admin.account.edit', [
            'user' => $account,
        ]);
    }

    public function update()
    {
        $id = $_GET['id'] ?? null;
        $data = [
            'status' => $_POST['status'],
            'updated_at' => date("Y-m-d", time())
        ];

        $this->userModel->updateData($id, $data);
        // $this->message['success-edit'] = 'Order updated successfully';

        header("location: ./?module=admin&controller=account&action=edit&id=$id");
    }

    public function searchAccountFull()
    {
        $searchData = (isset($_REQUEST['accountSearch'])) ? $_REQUEST['accountSearch'] : "";
        $accounts   = $this->userModel->searchAccountFull($searchData);
        $page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
        // $links      = (isset($_GET['links'])) ? $_GET['links'] : 2;
        // links: so page dc hien thi truoc hoac sau dau ...
        $links = 2;
        return $this->view('admin.account.index', [
            'data' => $accounts->getData(5, $page)->data,
            'pagination' => $accounts->createLinks($links, 'pagination')
        ]);
    }
}