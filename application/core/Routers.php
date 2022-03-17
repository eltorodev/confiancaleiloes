<?php

namespace core;

use core\View;

class Routers {

	public static $_fallback = true;

	public static $_halts = true;

	public static $_routes = array();

	public static $_methods = array();

	public static $_callback = array();

	public static $_errorCallback;

	public static $_patterns = array(
		':any' => '[^/]+',
		':num' => '-?[0-9]+',
		':all' => '.*'
	);

	public static function __callstatic($method, $params) {
		$uri = dirname($_SERVER['PHP_SELF']) . '/' . $params[0];
		$callback = $params[1];

		array_push(self::$_routes, $uri);
		array_push(self::$_methods, strtoupper($method));
		array_push(self::$_callback, $callback);
	}

	public static function errors($callback) {
		self::$_errorCallback = $callback;
	}

	public static function haltOnMatch($flag = true) {
		self::$_halts = $flag;
	}

	public static function invokeObject($callback, $matched = null, $message = null) {
		$last = explode('/', $callback);
		$last = end($last);

		$segments = explode('@', $last);

		$controller = $segments[0];
		$method = $segments[1];

		$controller = new $controller($message);

		call_user_func_array(array($controller, $method), $matched ? $matched : array());
	}

	public static function autoDispatch() {
		$uri = parse_url($_SERVER['QUERY_STRING'], PHP_URL_PATH);
		$uri = '/' . $uri;

		if (strpos($uri, DIR) === 0) {
			$uri = substr($uri, strlen(DIR));
		}

		$uri = trim($uri, ' /');
		$uri = ($amp = strpos($uri, '&')) !== false ? substr($uri, 0, $amp) : $uri;

		$parts = explode('/', $uri);

		$controller = array_shift($parts);
		$controller = $controller ? $controller : DEFAULT_CONTROLLER;
		$controller = ucwords($controller);

		$method = array_shift($parts);
		$method = $method ? $method : DEFAULT_METHOD;

		$args = !empty($parts) ? $parts : array();

		if (!file_exists('application/controllers/' . $controller . '.php')) {
			return false;
		}

		$controller = "\controllers\\$controller";
		$control = new $controller;

		if (method_exists($control, $method)) {
			call_user_func_array(array($control, $method), $args);

			return true;
		}

		return false;
	}

	public static function dispatch() {
		$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		$method = $_SERVER['REQUEST_METHOD'];

		$searches = array_keys(static::$_patterns);
		$replaces = array_values(static::$_patterns);

		self::$_routes = str_replace('//', '/', self::$_routes);

		$found_route = false;

		$query = '';
		$query_arr = array();

		if (strpos($uri, '&') > 0) {
			$query = substr($uri, strpos($uri, '&') + 1);
			$uri = substr($uri, 0, strpos($uri, '&'));
			$query_arr = explode('&', $query);

			foreach ($query_arr as $key) {
				$queryOBJ = explode('=', $key);
				$query_arr[] = array($queryOBJ[0] => $queryOBJ[1]);

				if (!isset($_GET[$queryOBJ[0]])) {
					$_GET[$queryOBJ[0]] = $queryOBJ[1];
				}
			}
		}

		if (in_array($uri, self::$_routes)) {
			$route_pos = array_keys(self::$_routes, $uri);

			foreach ($route_pos as $route) {
				if (self::$_methods[$route] == $method || self::$_methods[$route] == 'ANY') {
					$found_route = true;

					if (!is_object(self::$_callback[$route])) {
						self::invokeObject(self::$_callback[$route]);

						if (self::$_halts) {
							return;
						}
					} else {
						call_user_func(self::$_callback[$route]);

						if (self::$_halts) {
							return;
						}
					}
				}
			}
		} else {
			$pos = 0;

			foreach (self::$_routes as $route) {
				$route = str_replace('//', '/', $route);

				if (strpos($route, ':') !== false) {
					$route = str_replace($searches, $replaces, $route);
				}

				if (preg_match('#^' . $route . '$#', $uri, $matched)) {
					if (self::$_methods[$pos] == $method || self::$_methods[$pos] == 'ANY') {
						$found_route = true;

						array_shift($matched);

						if (!is_object(self::$_callback[$pos])) {
							self::invokeObject(self::$_callback[$pos], $matched);

							if (self::$_halts) {
								return;
							}
						} else {
							call_user_func_array(self::$_callback[$pos], $matched);

							if (self::$_halts) {
								return;
							}
						}
					}
				}
				$pos++;
			}
		}

		if (self::$_fallback) {
			$found_route = self::autoDispatch();
		}

		if (!$found_route) {
			if (!self::$_errorCallback) {
				self::$_errorCallback = function() {
					header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");

					$data = array(
						'title' => '404',
						'error'	=> 'Oops! Page not found...'
					);

					View::renderTemplate('header', $data);
					View::render('error/404', $data);
					View::renderTemplate('footer', $data);
				};
			}

			if (!is_object(self::$_errorCallback)) {
				self::invokeObject(self::$_errorCallback, null, 'No routes found.');

				if (self::$_halts) {
					return;
				}
			} else {
				call_user_func(self::$_errorCallback);

				if (self::$_halts) {
					return;
				}
			}
		}
	}
}