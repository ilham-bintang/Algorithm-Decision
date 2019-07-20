<?php
/**
 * LRsoft Corp.
 * http://lrsoft.co.id
 *
 * Author : Zaf
 */

require_once 'config.php';

define('DS', DIRECTORY_SEPARATOR);

define('ABS_PATH', dirname(__FILE__));
define('ABS_VIEW_PATH', ABS_PATH . DS . 'views');
define('ABS_MODEL_PATH', ABS_PATH . DS . 'models');
define('ABS_CONTROLLER_PATH', ABS_PATH . DS . 'controllers');
define('ABS_PLUGIN_PATH', ABS_PATH . DS . 'plugins');

define('URI_ASSET_PATH', URI_PATH . DS . 'assets');
define('URI_CSS_PATH', URI_ASSET_PATH . DS . 'css');
define('URI_JS_PATH', URI_ASSET_PATH . DS . 'js');
define('URI_IMG_PATH', URI_ASSET_PATH . DS . 'img');
define('URI_HTML_PATH', URI_ASSET_PATH . DS . 'html');
define('PAGGING_ROW', 5);


spl_autoload_register(function ($class) {

    $parts = explode('\\', $class);

    $script_file = $parts[0] . '.php';

    $class_model = ABS_MODEL_PATH . DS . $script_file;
    if (is_readable($class_model))
        require_once $class_model;

    $class_controller = ABS_CONTROLLER_PATH . DS . $script_file;
    if (is_readable($class_controller))
        require_once $class_controller;

});


function minify_HTML($buffer)
{
    return Util::_minify_HTML_output($buffer);
}


Routes::_gi()->_init();

session_start();