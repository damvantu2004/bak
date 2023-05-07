<?php

class ContactController extends BaseController
{
	protected $contactModel;
	protected $bannerModel;
	public $errors = [];
	protected $banners;
	public function __construct()
	{
		$this->loadModel('ContactModel');
		$this->contactModel = new ContactModel;
		$this->loadModel('BannerModel');
		$this->bannerModel = new BannerModel;
		$this->banners = $this->bannerModel->findBannerBySite('Contact');
	}

	public function index()
	{

		return $this->view('site.contact.index', [
			'banners' => $this->banners
		]);
	}

	public function submitForm()
	{
		$data = [
			'message' => $_POST['message'],
			'name' => $_POST['name'],
			'email' => $_POST['email'],
			'phone' => $_POST['phone']
		];

		$this->contactModel->createData($data);
		header('location: ./?controller=contact');
	}
}
