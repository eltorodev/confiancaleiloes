<?php

namespace core;

use helpers\Session;

class Config {

  public function __construct() {
    define('DIR', 'http://localhost:8080/confiancaleiloes');

    define('SITE_TITLE', 'Confiança Leilões');

    define('DEFAULT_TEMPLATE', 'default');

    define('SESSION_PREFIX', 'cl_');

    define('DEFAULT_CONTROLLER', 'Home');
    define('DEFAULT_METHOD', 'index');

    define('DB_TYPE', 'mysql');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'confianca');
    define('DB_USER', 'root');
    define('DB_PASS', '');

    set_exception_handler('core\Logger::ExceptionHandler');
    set_error_handler('core\Logger::ErrorHandler');
    
    date_default_timezone_set('America/Sao_Paulo');

    Session::init();
  }
}