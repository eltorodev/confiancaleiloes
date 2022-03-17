<?php

namespace helpers;

use helpers\Database;

class Url {

	public static function url_base($url = false) {
		return DIR . '/' . $url;
	}

	public static function redirect($url = null, $fullpath = false) {
		if ($fullpath === false) {
			$url = DIR . '/' . $url;
		}

		header('Location: ' . $url);
		exit;
	}

	public static function templatePath($custom = false) {
		if ($custom === true) {
			return DIR . '/application/templates/' . $custom . '/';
		} else {
			return DIR . '/application/templates/' . DEFAULT_TEMPLATE . '/';
		}
	}

	public static function relativeTemplatePath($custom = false) {
		if ($custom) {
			return 'application/templates/' . $custom . '/';
		} else {
			return 'application/templates/' . DEFAULT_TEMPLATE . '/';
		}
	}

	public static function autoLink($text, $custom = null) {
		$regex = '@(http)?(s)?(://)?(([-\w]+\.)+([^\s]+)+[^,.\s])@';

		if ($custom === null) {
			$replace = '<a href="http$2://$4">$1$2$3$4</a>';
		} else {
			$replace = '<a href="http$2://$4">' . $custom . '</a>';
		}
		
		return preg_replace($regex, $replace, $text);
	}

	public static function generateSafeSlug($slug) {
		setlocale(LC_ALL, 'en_US.utf8');

		$slug = preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $slug));

		$slug = htmlentities($slug, ENT_QUOTES, 'UTF-8');

		$pattern = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
    $slug = preg_replace($pattern, '$1', $slug);
    $slug = html_entity_decode($slug, ENT_QUOTES, 'UTF-8');
    $pattern = '~[^0-9a-z]+~i';
    $slug = preg_replace($pattern, '-', $slug);

    return strtolower(trim($slug, '-'));
	}

	public static function previous() {
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit;
	}

	public static function segments() {
		return explode('/', $_SERVER['REQUEST_URI']);
	}

	public static function getSegment($segments, $id) {
		if (array_key_exists($id, $segments)) {
			return $segments[$id];
		}
	}

	public static function lastSegment($segments) {
		return end($segments);
	}

	public static function firstSegment($segments) {
		return $segments[0];
	}
}