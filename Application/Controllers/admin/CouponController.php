<?php

class CouponController extends BaseController
{

    protected $couponModel;
    protected $message;

    public function __construct()
    {
        $this->loadModel('CouponModel');
        $this->couponModel = new CouponModel;
    }

    public function index()
    {
        $coupons = $this->couponModel->getAllPaginate();
        $page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
        // $links      = (isset($_GET['links'])) ? $_GET['links'] : 2;
        // links: so page dc hien thi truoc hoac sau dau ...
        $links = 2;
        return $this->view('admin.coupon.index', [
            "data" => $coupons->getData(7, $page)->data,
            'pagination' => $coupons->createLinks($links, 'pagination')
        ]);
    }

    public function create()
    {
        return $this->view('admin.coupon.create');
    }

    public function store()
    {

        $data = [
            'id' => $_POST['id'],
            'status' => $_POST['status'],
            'coupon_value' => round($_POST['coupon_value'] / 100, 1),
            'used_times' => $_POST['used_times']
        ];
        if (sizeof($this->couponModel->getCouponById($_POST['id'])) > 0) {
            $this->message['error-name'] = 'This coupon is already existing';
        } else {
            $this->message['success-add'] = 'Coupon added successfully';
            $this->couponModel->createData($data);
        }
        return $this->view('admin.coupon.create', [
            'message' => $this->message
        ]);
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        $coupon = $this->couponModel->findCouponById($id);

        return $this->view('admin.coupon.edit', [
            'coupon' => $coupon,
        ]);
    }

    public function update()
    {
        $data = [
            'id' => $_POST['id'],
            'status' => $_POST['status'],
            'coupon_value' => round($_POST['coupon_value'] / 100, 1),
            'used_times' => $_POST['used_times'],
            'updated_at' => date("Y-m-d", time())
        ];
        $coupon = $this->couponModel->findCouponById($_GET['id']);
        if (sizeof($this->couponModel->checkIdUnique($_POST['id'], $coupon['id'])) == 1) {
            $this->message['error-name'] = 'This coupon is already existing';
        } else {
            $this->message['success-edit'] = 'Coupon updated successfully';
            $this->couponModel->updateData($_GET['id'], $data);
        }
        return $this->view('admin.coupon.edit', [
            'message' => $this->message,
            'coupon' => $coupon
        ]);
    }
    public function delete()
    {
        $id = $_GET['id'] ?? null;
        $this->couponModel->deleteData($id);
        header("location: ./?module=admin&controller=coupon");
    }

    public function searchCouponFull()
    {
        $searchData = (isset($_REQUEST['couponSearch'])) ? $_REQUEST['couponSearch'] : "";
        $coupons = $this->couponModel->searchCouponFull($searchData);
        $page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
        // $links      = (isset($_GET['links'])) ? $_GET['links'] : 2;
        // links: so page dc hien thi truoc hoac sau dau ...
        $links = 2;
        return $this->view('admin.coupon.index', [
            'data' => $coupons->getData(5, $page)->data,
            'pagination' => $coupons->createLinks($links, 'pagination')
        ]);
    }
}
