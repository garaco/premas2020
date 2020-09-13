<?php
defined('BASEPATH') or exit('ERROR403');

class CoreHelper
{
  public static function validateController($controller)
  {
    if(!is_file(PATH_CONTROLLERS . "{$controller}Controller.php"))
      return false;
    return true;
  }

  public static function validateMethodController($controller, $method)
  {
    if(!method_exists($controller, $method))
      return false;
    return true;
  }
}
