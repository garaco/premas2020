<?php
defined('BASEPATH') or exit('ERROR403');
require_once ROOT . FOLDER_PATH .'/app/Models/RequisicionViewModel.php';
require_once LIBS_ROUTE .'Session.php';

/**
* Main controller
*/
class RequisicionViewController extends Controller
{
  private $session;
  private $model;
  public function __construct()
  {
    $this->session = new Session();
    $this->model = new RequisicionViewModel();
    $this->session->init();
    if($this->session->getStatus() === 1 || $this->session->getType('type') == "Normal" || $this->session->getType('type') == "Admin" || $this->session->getType('type') == "AdminSecretaria" || $this->session->getType('type') == "Pago"){

      header('location: '.FOLDER_PATH.'/Error403');
    }

  }

  public function index()
  {
    $result = $this->model->getJoinAll($this->session->getType('type'),0,20);
    $c=$this->model->getCountType($this->session->getType('type'));
    $p = round($c->num_rows/21) + ($c->num_rows%21 < 10 ? 1 : 0);
    $params = array('result'=> $result,'pag'=>$p,'cant'=>$c->num_rows);
    $this->render(__CLASS__, $params);
  }

  public function pagination(){
    $funcion = $_POST['function'];
    $result = $this->model->getJoinAll($this->session->getType('type'),($_POST['page']),($_POST['fin']));
    require_once ROOT . FOLDER_PATH .'/app/Request/RequisicionViewRequest.php';
  }

  private function verify($request)
  {
    return empty($request['id']);
  }

  public function logout()
  {
    $this->session->close();
    header('location: '.FOLDER_PATH.'/login');
  }

}
?>
