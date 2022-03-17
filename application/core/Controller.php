<?php

namespace core;

use core\View;

abstract class Controller {

	public $_view;

	public function __construct() {
		$this->_view = new View();
	}
}