<?php

namespace helpers;

class Session {

	private static $_sessionStarted = false;

	public static function init() {
		if (self::$_sessionStarted === false) {
			session_start();
			self::$_sessionStarted = true;
		}
	}

	public static function set($key, $value = false) {
		if (is_array($key) && value === false) {
			foreach ($key as $name => $value) {
				$_SESSION[SESSION_PREFIX . $name] = $value;
			}
		} else {
			$_SESSION[SESSION_PREFIX . $key] = $value;
		}
	}

	public static function pull($key) {
		if (isset($_SESSION[SESSION_PREFIX . $key])) {
			$value = $_SESSION[SESSION_PREFIX . $key];
			unset($_SESSION[SESSION_PREFIX . $key]);

			return $value;
		}

		return null;
	}

	public static function get($key, $secondKey = false) {
		if ($secondKey === true) {
			if (isset($_SESSION[SESSION_PREFIX . $key][$secondKey])) {
				return $_SESSION[SESSION_PREFIX . $key][$secondKey];
			}
		} else {
			if (isset($_SESSION[SESSION_PREFIX . $key])) {
				return $_SESSION[SESSION_PREFIX . $key];
			}
		}

		return null;
	}

	public static function id() {
		return session_id();
	}

	public static function regenerate() {
		session_regenerate_id(true);
		return session_id();
	}

	public static function display() {
		return $_SESSION;
	}

	public static function destroy($key = '', $prefix = false) {
		if (self::$_sessionStarted === true) {
			if ($key === '' && $prefix === false) {
				session_unset();
				session_destroy();
			} elseif ($prefix === true) {
				foreach ($_SESSION as $key => $value) {
					if (strpos($key, SESSION_PREFIX) === 0) {
						unset($_SESSION[$key]);
					}
				}
			} else {
				unset($_SESSION[SESSION_PREFIX . $key]);
			}
		}
	}

	public static function message($sessionName = 'success') {
		$message = Session::pull($sessionName);

		if (!empty($message)) {
			return $message;
		}
	}
}