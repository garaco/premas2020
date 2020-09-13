<?php
defined('BASEPATH') or exit('ERROR403');

require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';
require_once LIBS_ROUTE .'Session.php';

/**
* Main controller
*/
class DepartamentoController extends Controller
{
  private $session;
  private $model;

  public function __construct()
  {
    $this->model = new  DepartamentoModel();
    $this->session = new Session();
    $this->session->init();
    if($this->session->get('Tipo')!='SuperAdmin')
      header('location: '.FOLDER_PATH.'/Error403');
  }

  public function index()
  {
    $result = $this->model->getJoin('idDepart',0,21);
    $c=$this->model->getCount();
    $p = round($c->num_rows/21) + ($c->num_rows%21 < 10 ? 1 : 0);
    $params = array('result'=> $result,'pag'=>$p,'cant'=>$c->num_rows,'User'=>$this->session->get('User'));
    $this->render(__CLASS__, $params);
  }

  public function save($request){

    if($this->verify($request)){
       header('location: '.FOLDER_PATH.'/Departamento');
    }else{
      if($request["id"] == 0){
        $this->model->add($request["id"],$request["area"],$request["nombreDepto"]);
      }else{
        $this->model->update($request["id"],$request["area"],$request["nombreDepto"]);
      }

      header('location: '.FOLDER_PATH.'/Departamento');
    }
  }

  public function requested(){

    $Id = ''; $codigo = ''; $nombreDepto = '';
    $result = $this->model->getById('idDepart',$_POST['id']);

    foreach ($result as $r) {
      $Id = $r["idDepart"];
      $codigo = $r["idArea"];
      $nombreDepto = $r["nombreDepto"];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/DepartamentoRequest.php';
  }


  public function remove($request){
    if(!empty($request["Id"])){
       $this->model->del($request["Id"]);
    }
    header('location: '.FOLDER_PATH.'/Departamento');
  }


  public function delete(){
    $Id = ''; $codigo = ''; $nombreDepto = '';
    $result = $this->model->getById('idDepart',$_POST['id']);
    foreach ($result as $r) {
      $Id = $r["idDepart"];
      $codigo = $r["idArea"];
      $nombreDepto= $r["nombreDepto"];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/DepartamentoRequest.php';
  }

  public function search(){
    $funcion = $_POST['function'];
    if(empty($funcion)){
      header('location: '.FOLDER_PATH.'/Departamento');
    }
    $result = $this->model->getJoin('idDepart',0,21);
    if (!empty($_POST['date'])) {
      $result = $this->model->JoinSearch('nombreDepto',$_POST['date']);
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/DepartamentoRequest.php';
  }
    public function departamento(){

    $result = $this->model->getJoin('idDepart',0,21);
    if (!empty($_POST['area'])) {
      $result = $this->model->getJoin2('idDepart',$_POST['area']);
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/DepartamentoRequest.php';
  }

  public function pagination(){
    $funcion = $_POST['function'];
    $result = $this->model->getJoin('idDepart',($_POST['page']),($_POST['fin']));
    require_once ROOT . FOLDER_PATH .'/app/Request/DepartamentoRequest.php';
  }

  private function verify($request)
  {
    return empty($request['nombreDepto']);
  }
  public function logout()
  {
    $this->session->close();
    header('location: '.FOLDER_PATH.'/login');
  }

}
