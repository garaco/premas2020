<?php
defined('BASEPATH') or exit('ERROR403');
abstract class Controller
{
  private $view;

  public function render($controller_name = '', $params = array())
  {
    $this->view = new View($controller_name, $params);
  }

  abstract public function index();
}
