<?php

class BannerController extends BaseController
{
    use UploadFile;
    protected $bannerModel;
    protected $message = '';
    public function __construct()
    {
        $this->loadModel('BannerModel');
        $this->bannerModel = new BannerModel;
    }

    public function index()
    {
        $banners = $this->bannerModel->getAllBannerPaginate();
        $page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
        // $links      = (isset($_GET['links'])) ? $_GET['links'] : 2;
        // links: so page dc hien thi truoc hoac sau dau ...
        $links = 2;
        return $this->view('admin.banner.index', [
            'data'  => $banners->getData(6, $page)->data,
            'pagination' => $banners->createLinks($links, 'pagination')
        ]);
    }

    public function create()
    {
        return $this->view('admin.banner.create');
    }

    public function store()
    {

        $data = [
            'name' => $_POST['name'],
            'site' => $_POST['site'],
            'description' => $_POST['description'],
            'status' => $_POST['status'],
            'priority' => $_POST['priority'],
        ];

        if ($this->getImage()) { //kiểm tra lấy ảnh
            $data['image'] = $this->getImage();
        }

        $this->message = 'Banner added successfully';
        $this->bannerModel->createData($data);

        header('location: ./?module=admin&controller=banner');
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        $banner = $this->bannerModel->findBannerById(['*'], $id);

        return $this->view('admin.banner.edit', [
            'banner' => $banner,
        ]);
    }

    public function update()
    {

        $data = [
            'name' => $_POST['name'],
            'site' => $_POST['site'],
            'description' => $_POST['description'],
            'status' => $_POST['status'],
            'priority' => $_POST['priority'],
            'updated_at' => date("Y-m-d", time())
        ];


        $data['image'] = $this->getImage();


        $this->bannerModel->updateData($_GET['id'], $data);
        $this->message = 'Banner updated successfully';
        $banner = $this->bannerModel->findBannerById(['*'], $_GET['id']);
        return $this->view('admin.banner.edit', [
            'message' => $this->message,
            'banner' => $banner
        ]);
    }
    public function delete()
    {
        $id = $_GET['id'] ?? null;
        $this->message = 'Banner deleted successfully';
        if ($id && is_numeric($id)) {
            $this->bannerModel->deleteData($id);
            header('location: ./?module=admin&controller=banner');
        }
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

    public function searchBannerFull()
    {
        $searchData = (isset($_REQUEST['bannerSearch'])) ? $_REQUEST['bannerSearch'] : "";
        $banners = $this->bannerModel->searchBannerFull($searchData);
        $page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
        // $links      = (isset($_GET['links'])) ? $_GET['links'] : 2;
        // links: so page dc hien thi truoc hoac sau dau ...
        $links = 2;
        return $this->view('admin.banner.index', [
            'data' => $banners->getData(5, $page)->data,
            'pagination' => $banners->createLinks($links, 'pagination')
        ]);
    }
}
