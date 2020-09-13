<?php
defined('BASEPATH') or exit('ERROR403');

require_once ROOT . FOLDER_PATH .'/app/Models/BitacoraModel.php';
require_once LIBS_ROUTE .'Session.php';

class BitacoraViewController extends Controller
{
  private $session;
  private $model;

  public function __construct()
  {
    $this->session = new Session();
    $this->model = new BitacoraModel();
    $this->session->init();
    if($this->session->getStatus() === 1 || empty($this->session->get('AdminSecretaria')) || $this->session->getType('type') == "Admin")
      header('location: '.FOLDER_PATH.'/Error403');
  }

  public function index()
  {
    $result = $this->model->getJoinAll(0,20);
    $c=$this->model->getCount();
    $p = round($c->num_rows/21) + ($c->num_rows%21 < 10 ? 1 : 0);
    $params = array('result'=> $result,'pag'=>$p,'cant'=>$c->num_rows);
    $this->render(__CLASS__, $params);
    
  }

  public function show($params){
    header('content-type: application/pdf');
    readfile(PATH_FILES.$params['file']);
  }

 
    public function search(){
    $funcion = $_POST['function'];
    if(empty($funcion)){
      header('location: '.FOLDER_PATH.'/BitacoraView');
    }
    $result = $this->model->getJoinAll(0,20);
    if (!empty($_POST['opt'])) {
      $result = $this->model->getJoinAllDepar($_POST['id'],$_POST['opt']);
    }

    if (!empty($_POST['date'])) {
      $result = $this->model->getSearchBit('Concepto',$_POST['date']);
    }
    if (!empty($_POST['estatu'])) {
      $result = $this->model->getJoinStatus($_POST['id'],$_POST['estatu']);
    }
    if (!empty($_POST['datoDesde']) && !empty($_POST['datoHasta'])) {
      $result = $this->model->getJoinAllDATEStatu($_POST['id'],$_POST['estatu'],$_POST['datoDesde'],$_POST['datoHasta']);
    }
    if (!empty($_POST['datoHasta'])) {
      $result = $this->model->getJoinAllDATE($_POST['datoDesde'],$_POST['datoHasta']);
    }
      if (!empty($_POST['estatu']) && !empty($_POST['datoDesde']) && !empty($_POST['datoHasta'])) {
        $result = $this->model->getJoinAllDATEStatu($_POST['id'],$_POST['estatu'],$_POST['datoDesde'],$_POST['datoHasta']);
      }

    
    require_once ROOT . FOLDER_PATH .'/app/Request/BitacoraViewRequest.php';
  }
    public function CambiarUserPass()
  {
    require_once ROOT . FOLDER_PATH .'/app/Request/BitacoraViewRequest.php';
  }
  public function UpdateUserPass()
  {
    $tipoUser=$this->session->getType('type');
    $user = $this->model->user($_POST["UserActual"]);
    $UserActual=$_POST["UserActual"];
    // var_dump($user->num_rows);
    if ($user->num_rows > 0) {
        $username = $_POST["username"];
        $password1 = $_POST["password"];
        $password = password_hash($password1, PASSWORD_DEFAULT);
        // var_dump($password);
        $this->model->UpdateUser($username,$password,$tipoUser);

      header('location: '.FOLDER_PATH.'/BitacoraView');
    }else{

      echo '<script>alert("\u2716 ¡ El usuario anterior: '. $UserActual .', no existe ! ");</script>';
      echo '<script>history.back(-1)</script>';

    }
  }

    public function pagination(){
    $funcion = $_POST['function'];
    $result = $this->model->getJoinAll(($_POST['page']),($_POST['fin']));
    require_once ROOT . FOLDER_PATH .'/app/Request/BitacoraViewRequest.php';
  }

  private function verify($request)
  {
    return empty($request["id"]);
  }

}
