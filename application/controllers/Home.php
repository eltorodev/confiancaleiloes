<?php

namespace controllers;

use core\Controller;
use core\View;

use models\Customers;

class Home extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$customers = new Customers();


		$data = [
			'title' => SITE_TITLE,
			'brand' => SITE_TITLE,
			'customers' => $customers,
		];

		View::renderTemplate('header', $data);
		View::render('home/home', $data);
		View::renderTemplate('footer', $data);
	}
}
