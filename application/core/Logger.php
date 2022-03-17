<?php

namespace core;

use helpers\PhpMailer\Mail;

class Logger {

	private static $_printError = false;

	private static $_clear = false;

	private static $_emailError = false;

	public static $_errorFile =  'error_log.html';

	public static function customErrorMsg() {
		echo '<p>An error occurred, the error has been reported.</p>';
		exit;
	}

	public static function exceptionHandler($e) {
		self::newMessage($e);
		self::customErrorMsg();
	}

	public static function errorHandler($number, $message, $file, $line) {
		$msg = $message . ' in ' . $file . ' on line ' . $line;

		if (($number !== E_NOTICE) && ($number < 2048)) {
			self::errorMessage($msg);
			self::customErrorMsg();
		}

		return 0;
	}

	public static function newMessage($exception) {
		$message 	= $exception->getMessage();
		$code 		= $exception->getCode();
		$file 		= $exception->getFile();
		$line 		= $exception->getLine();
		$trace 		= $exception->getTraceAsString();

		$trace = str_replace(DB_PASS, '********', $trace);

		$date = date('M d, Y G:iA');

		$logMessage = "
			<h3>Exception information:</h3>\n
			<p><strong>Date:</strong> {$date}</p>\n
			<p><strong>Message:</strong> {$message}</p>\n
			<p><strong>Code:</strong> {$code}</p>\n
			<p><strong>File:</strong> {$file}</p>\n
			<p><strong>Line:</strong> {$line}</p>\n
			<h3>Stack trace:</h3>\n
			<pre>{$trace}</pre>\n
			<hr>\n
		";

		if (is_file(self::$_errorFile) === false) {
			file_put_contents(self::$_errorFile, '');
		}

		if (self::$_clear) {
			$file = fopen(self::$_errorFile, "r+");

			if ($file !== false) {
				ftruncate($file, 0);
				fclose($file);
			}
		} else {
			$content = file_get_contents(self::$_errorFile);
		}

		file_put_contents(self::$_errorFile, $logMessage . $content);

		self::sendEmail($logMessage);

		if (self::$_printError === true) {
			echo $logMessage;
			exit;
		}
	}

	public static function errorMessage($error) {
		$date = date('M d, Y G:iA');

		$logMessage = '<p>Error on ' . $date . ' - ' . $error . '</p>';

		if (is_file(self::$_errorFile) === false) {
			file_put_contents(self::$_errorFile, '');
		}

		if (self::$_clear) {
			$file = fopen(self::$_errorFile, "r+");

			if ($file !== false) {
				ftruncate($file, 0);
				fclose($file);
			}
		} else {
			$content = file_get_contents(self::$_errorFile);
		}

		file_put_contents(self::$_errorFile, $logMessage . $content);

		self::sendEmail($logMessage);

		if (self::$_printError === true) {
			echo $logMessage;
			exit;
		}
	}

	public static function sendEmail($message) {
		if (self::$_emailError === true) {
			$mail = new Mail();
			$mail->setFrom(SITE_EMAIL);
			$mail->addAddress(SITE_EMAIL);
			$mail->subject('New error on ' . SITE_TITLE);
			$mail->body($message);
			$mail->send();
		}
	}
}