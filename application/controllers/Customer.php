<?php

namespace controllers;

use core\Controller;
use core\View;

use models\Customers;

class Customer extends Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  public function view($id)
  {
    var_dump($id);

    exit;
    $customers = new Customers();


    $data = [
      'title' => SITE_TITLE,
      'brand' => SITE_TITLE,
      'customers' => $customers,
    ];

    View::renderTemplate('header', $data);
    View::render('customer/view', $data);
    View::renderTemplate('footer', $data);
  }
}
