<?php
defined('BASEPATH') or exit('ERROR403');
/**
*
*/
class Error403Controller extends Controller
{
  public $path_inicio;

  public function __construct()
  {
    $this->path_inicio = FOLDER_PATH;
  }

  public function index()
  {
    $this->render(__class__, array('path_inicio' => $this->path_inicio));
  }
}
