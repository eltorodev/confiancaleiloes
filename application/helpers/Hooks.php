<?php

namespace helpers;

class Hooks
{

	private static $_plugins = array();

	private static $_hooks = array();

	private static $_instances = array();

	public static function get($id = 0)
	{
		if (isset(self::$_instances[$id])) {
			return self::$_instances[$id];
		}

		self::setHooks(array(
			'meta',
			'css',
			'afterBody',
			'footer',
			'js',
			'routes'
		));


		$instance = new self();

		self::$_instances[$id] = $instance;

		return $instance;
	}

	public static function setHook($where)
	{
		self::$_hooks[$where] = '';
	}

	public static function setHooks($where)
	{
		foreach ($where as $where) {
			self::setHook($where);
		}
	}

	public static function loadPlugins($fromFolder)
	{
		if ($handle = opendir($fromFolder)) {
			while ($file = readdir($handle)) {
				if (is_file($fromFolder . $file)) {
					if (preg_match('@module.php@', $file)) {
						require_once $fromFolder . $file;
					}
					self::$_plugins[$file]['file'] = $file;
				} elseif ((is_dir($fromFolder . $file)) && ($file != '.') && ($file != '..')) {
					self::loadPlugins($fromFolder . $file . '/');
				}
			}
			closedir($handle);
		}
	}

	public static function addHook($where, $function)
	{
		if (!isset(self::$_hooks[$where])) {
			die('There is no such place (' . $where . ') for hooks.');
		} else {
			$theseHooks  = explode('|', self::$_hooks[$where]);
			$theseHooks[] = $function;
			self::$_hooks[$where] = implode('|', $theseHooks);
		}
	}

	public static function run($where, $args = '')
	{
		if (isset(self::$_hooks[$where])) {
			$theseHooks = explode('|', self::$_hooks[$where]);
			$result = $args;

			foreach ($theseHooks as $hook) {
				if (preg_match("/@/i", $hook)) {
					$parts = explode('/', $hook);

					$last = end($parts);

					$segments = explode('@', $last);

					$className = new $segments[0]();

					$result = call_user_func(array($className, $segments[1]), $result);
				} else {
					if (function_exists($hook)) {
						$result = call_user_func($hook, $result);
					}
				}
			}

			return $result;
		} else {
			die('There is no such place (' . $where . ') for hooks.');
		}
	}

	public static function collectHooks($where, $args = null)
	{
		ob_start();
		echo self::run($where, $args);
		return ob_get_clean();
	}
}
