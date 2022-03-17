<?php

namespace core;

use helpers\Database;

abstract class Model {

	protected $_db;

	public function __construct() {
		$this->_db = Database::get();
	}
}