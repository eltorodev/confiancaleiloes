<?php

namespace core;

class View {

	private static $_headers = array();

	public static function render($path, $data = false, $error = false) {
		if (!headers_sent()) {
			foreach (self::$_headers as $header) {
				header($header, true);
			}
		}

		require_once SMVC . 'application' . DS . 'views' . DS . $path . '.php';
	}


	public static function renderTemplate($path, $data = false, $custom = false) {
		if (!headers_sent()) {
			foreach (self::$_headers as $header) {
				header($header, true);
			}
		}

		if ($custom === false) {
			require_once SMVC . 'application' . DS . 'templates' . DS . DEFAULT_TEMPLATE . DS . $path . '.php';
		} else {
			require_once SMVC . 'application' . DS . 'templates' . DS . $custom . DS . $path . '.php';
		}
	}

	public function addHeader($header) {
		self::$_headers[] = $header;
	}

	public function addHeaders($headers = array()) {
		foreach ($headers as $header) {
			$this->addHeader($header);
		}
	}
}