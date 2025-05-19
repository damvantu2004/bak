<?php

class OrderController extends BaseController
{

    protected $orderModel;

    protected $message;

    public function __construct()
    {
        $this->loadModel('OrderModel');
        $this->orderModel = new OrderModel;
    }

    public function index()
    {
        $orders = $this->orderModel->getAllOrderPaginate();
        $page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
        // $links      = (isset($_GET['links'])) ? $_GET['links'] : 2;
        // links: so page dc hien thi truoc hoac sau dau ...
        $links = 2;
        return $this->view('admin.order.index', [
            'orders' => $orders->getData(7, $page)->data,
            'pagination' => $orders->createLinks($links, 'pagination')
        ]);
    }



    public function detail()
    {
        $id = $_GET['id'] ?? null;
        $order = $this->orderModel->getOrderDetailById($id);
        $products_in_order = $this->orderModel->getAllProductsInOrderById($id);
        // print_r($order);
        return $this->view('admin.order.detail', [
            'order' => $order,
            'products_in_order' => $products_in_order
        ]);
    }

    public function update()
    {
        $id = $_GET['id'] ?? null;
        $oldStatus = $this->orderModel->getOrderDetailById($id)['status'];
        $newStatus = $_POST['status']; // lấy trạng thái mới từ form ở view
        
        $data = [
            'status' => $newStatus,
            'updated_at' => date("Y-m-d", time())
        ];

        $this->orderModel->updateData($id, $data);
        
        // Gửi email thông báo nếu trạng thái đơn hàng thay đổi
        if ($oldStatus != $newStatus) {
            $order = $this->orderModel->getOrderDetailById($id);
            
            // Gửi email thông báo
            require_once './Helper/MailService.php';
            $mailService = new MailService();
            
            $mailService->sendOrderStatusEmail(
                $order['email'],
                $order['fname'] . ' ' . $order['lname'],
                $id,
                $newStatus
            );
        }
        
        header("location: ./?module=admin&controller=order&action=detail&id=$id");
    }

    public function searchOrderFull()
    {
        $searchData = (isset($_REQUEST['orderSearch'])) ? $_REQUEST['orderSearch'] : "";
        $orders     = $this->orderModel->searchOrderFull($searchData);
        $page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
        // $links      = (isset($_GET['links'])) ? $_GET['links'] : 2;
        // links: so page dc hien thi truoc hoac sau dau ...
        $links = 2;
        return $this->view('admin.order.index', [
            'orders' => $orders->getData(5, $page)->data,
            'pagination' => $orders->createLinks($links, 'pagination')
        ]);
    }
}
