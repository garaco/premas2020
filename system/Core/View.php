<?php
defined('BASEPATH') or exit('ERROR403');
class View
{
  protected $template;
  protected $controller_name;
  protected $params;

  public function __construct($controller_name, $params = array())
  {
    $this->controller_name = $controller_name;
    $this->params = $params;
    $this->render();
  }

  protected function render()
  {
    if(class_exists($this->controller_name)){
      $file_name = str_replace('Controller', '', $this->controller_name);
      $this->template = $this->getContentTemplate($file_name);
      echo $this->template;
    }else{
      throw new Exception("Error No existe $controller_name");
    }
  }

  protected function getContentTemplate($file_name)
  {
    $file_path = ROOT . '/' . PATH_VIEWS . "$file_name" . '.php';
    $file_request = REQUEST. "$file_name" . 'Request.php';
    // compara si existe la ruta y archvio, en caso de que exista
    // extrae los parametros y los envia a la vista
    if(is_file($file_path)){
      extract($this->params);
      ob_start();
      require($file_path);
      $template = ob_get_contents();
      ob_end_clean();
      return $template;
    }else{
      throw new Exception("Error No existe $file_path");
    }
  }

}
