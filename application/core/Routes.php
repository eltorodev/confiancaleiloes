<?php

use core\Routers;
use helpers\Hooks;

Routers::any('', 'controllers\Home@index');

// AJAX Requests
Routers::any('customer/ajax/create', 'controllers\Ajax\Customer@create');
Routers::any('customer/ajax/update', 'controllers\Ajax\Customer@update');
Routers::any('customer/ajax/delete', 'controllers\Ajax\Customer@delete');

Routers::errors('core\Error@index');

$hooks = Hooks::get();
$hooks->run('routes');

Routers::$_fallback = false;

Routers::dispatch();