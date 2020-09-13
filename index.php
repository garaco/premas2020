<?php
define('BASEPATH', true);
define('HOMEDIR',__DIR__);
require_once('system/Config.php');
require_once('system/Core/Autoload.php');

/**
 * Inicializa Router y detección de valores de la URI
 */
$router = new Router();

$controller = $router->getController();
$method = $router->getMethod();
$param = $router->getParam();

/**
 * Validaciones e inclusión del controlador y el metodo
 */
if(!CoreHelper::validateController($controller))
  $controller = 'Error404';

require PATH_CONTROLLERS . "{$controller}Controller.php";

$controller .= 'Controller';

if(!CoreHelper::validateMethodController($controller, $method))
  $method = 'index';

/**
 * Ejecución final del controlador, método y parámetro obtenido por URI
 */
$controller = new $controller;

$controller->$method($param);
