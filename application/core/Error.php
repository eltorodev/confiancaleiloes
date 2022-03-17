<?php

namespace core;

use core\Controller;
use core\View;

use helpers\Session;

class Error extends Controller
{

	private $_error = null;

	public function __construct($error)
	{
		parent::__construct();
		$this->_error = $error;
	}

	public function index()
	{
		header('HTTP/1.0 404 Not Found');

		$data = array(
			'title' => SITE_TITLE . ' - Simples Framwork MVC with PHP',
			'brand' => SITE_TITLE,
			'error'	=> $this->_error
		);

		View::renderTemplate('header', $data);
		View::render('error/404', $data);
		View::renderTemplate('footer', $data);
	}

	public static function display($error, $class = 'alert alert-danger')
	{
		if (is_array($error)) {
			foreach ($error as $error) {
				$row .= '<div class="' . $class . '">' . $error . '</div>';
			}

			return $row;
		} else {
			if (isset($error)) {
				return '<div class="' . $class . '">' . $error . '</div>';
			}
		}
	}
}
