<?php

class ContactController  extends BaseController
{

    protected $contactModel;

    public function __construct()
    {
        $this->loadModel('ContactModel');
        $this->contactModel = new ContactModel;
    }

    public function index()
    {
        $contacts = $this->contactModel->getAllPaginate();
        $page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
        // $links      = (isset($_GET['links'])) ? $_GET['links'] : 2;
        // links: so page dc hien thi truoc hoac sau dau ...
        $links = 2;
        return $this->view('admin.contact.index', [
            'data' => $contacts->getData(5, $page)->data,
            'pagination' => $contacts->createLinks($links, 'pagination')
        ]);
    }

    public function searchContactFull()
    {
        $searchData = (isset($_REQUEST['contactSearch'])) ? $_REQUEST['contactSearch'] : "";
        $contacts = $this->contactModel->searchContactFull($searchData);
        $page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
        // $links      = (isset($_GET['links'])) ? $_GET['links'] : 2;
        // links: so page dc hien thi truoc hoac sau dau ...
        $links = 2;
        return $this->view('admin.contact.index', [
            'data' => $contacts->getData(5, $page)->data,
            'pagination' => $contacts->createLinks($links, 'pagination')
        ]);
    }
}
