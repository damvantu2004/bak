<?php

class OrderController extends BaseController
{

    protected $orderModel;
    protected $userModel;

    protected $message;

    public function __construct()
    {
        $this->loadModel('OrderModel');
        $this->orderModel = new OrderModel;
        $this->loadModel('UserModel');
        $this->userModel = new UserModel;
    }

    public function index()
    {
        $orders = $this->orderModel->getAllOrderPaginate();
        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $links = 2;
        return $this->view('admin.order.index', [
            "orders" => $orders->getData(7, $page)->data,
            'pagination' => $orders->createLinks($links, 'pagination')
        ]);
    }

    public function detail()
    {
        $id = $_GET['id'] ?? 0;
        $order = $this->orderModel->getOrderDetailById($id);
        $orderDetail = $this->orderModel->getAllProductsInOrderById($id);
        return $this->view('admin.order.detail', [
            'order' => $order,
            'orderDetail' => $orderDetail,
        ]);
    }

    public function update()
    {
        $id = $_GET['id'] ?? null;
        $data = [
            'status' => $_POST['status'],
            'updated_at' => date("Y-m-d", time())
        ];

        $this->orderModel->updateData($id, $data);
        // $this->message['success-edit'] = 'Order updated successfully';

        header("location: ./?module=admin&controller=order&action=detail&id=$id");
    }

    public function updateStatus()
    {
        $orderId = $_POST['id'] ?? 0;
        $status = $_POST['status'] ?? 1;

        $this->loadModel('OrderModel');
        $result = $this->orderModel->updateStatus($orderId, $status);

        if ($result) {
            // Lấy thông tin đơn hàng và người dùng
            $order = $this->orderModel->getOrderDetailById($orderId);

            // Gửi email thông báo
            require_once './Helper/MailService.php';
            $mailService = new MailService();
            $mailService->sendOrderStatusEmail(
                $order['email'],
                $order['fname'] . ' ' . $order['lname'],
                $orderId,
                $status
            );

            // Chuyển hướng với thông báo thành công
            header('location: ./?module=admin&controller=order&action=detail&id=' . $orderId . '&message=success');
        } else {
            header('location: ./?module=admin&controller=order&action=detail&id=' . $orderId . '&message=error');
        }
    }

    public function searchOrderFull()
    {
        $searchData = (isset($_REQUEST['orderSearch'])) ? $_REQUEST['orderSearch'] : "";
        $orders = $this->orderModel->searchOrderFull($searchData);
        $page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $links = 2;
        return $this->view('admin.order.index', [
            'data' => $orders->getData(5, $page)->data,
            'pagination' => $orders->createLinks($links, 'pagination')
        ]);
    }
}
