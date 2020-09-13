<?php
defined('BASEPATH') or exit('ERROR403');

require_once ROOT . FOLDER_PATH .'/app/Models/PartidasModel.php';
require_once LIBS_ROUTE .'Session.php';


class PartidasController extends Controller
{
  private $session;
  private $model;

  public function __construct()
  {
    $this->model = new PartidasModel();
    $this->session = new Session();
    $this->session->init();
    if($this->session->get('Tipo')!='SuperAdmin')
      header('location: '.FOLDER_PATH.'/Error403');
  }

  public function index()
  {
    $result = $this->model->getLimit('Codigo');
    $params = array('result'=> $result,'User'=>$this->session->get('User'));
    $this->render(__CLASS__, $params);
  }

//metodo para guardar, captura los datos que tiene el formulario
//y ejecuta las funciones que se encuentran en el archivo model de partidas
  public function save($request){
    if($this->verify($request)){
       header('location: '.FOLDER_PATH.'/Partidas');
    }else{
      if($request["id"] == 0){
        $this->model->add($request["id"],$request["codigo"],$request["concepto"]);
      }else{
        $this->model->update($request["id"],$request["codigo"],$request["concepto"]);
      }

      header('location: '.FOLDER_PATH.'/Partidas');
    }
  }
  //metodo que enlaza la parte de la vista con el request este metodo se
  //se manda a llamar desde el archivo request.js
  public function requested(){
    $funcion = $_POST['function'];
    if(empty($funcion)){
      header('location: '.FOLDER_PATH.'/Partidas');
    }
    $Id = ''; $codigo = ''; $concepto = '';
    $result = $this->model->getById('IdPartida',$_POST['id']);

    foreach ($result as $r) {
      $Id = $r["IdPartida"];
      $codigo = $r["Codigo"];
      $concepto = $r["Concepto"];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/PartidasRequest.php';
  }

//metodo para eliminar trae el id para eliminar
//siempre y cuando el usuario alla aceptado
  public function remove($request){
    if(!empty($request['id'])){
       $this->model->del($request["id"]);
    }
    header('location: '.FOLDER_PATH.'/Partidas');
  }

//Metodo para eliminar es llamado desde el archivo request.js
  public function delete(){
    $Id = ''; $codigo = ''; $concepto = '';
    $result = $this->model->getById('IdPartida',$_POST['id']);
    foreach ($result as $r) {
      $Id = $r["IdPartida"];
      $codigo = $r["Codigo"];
      $concepto = $r["Concepto"];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/PartidasRequest.php';
  }

// Metodo para buscar un dato
  public function search(){
    $funcion = $_POST['function'];
    if(empty($funcion)){
      header('location: '.FOLDER_PATH.'/Partidas');
    }
    $result = $this->model->getLimit('IdPartida',0,20);
    if (!empty($_POST['date'])) {
      $result = $this->model->getSearch('Codigo','Concepto',$_POST['date']);
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/PartidasRequest.php';
  }

  public function pagination(){
    $funcion = $_POST['function'];
    $result = $this->model->getLimit('IdPartida',($_POST['page']),($_POST['fin']));
    require_once ROOT . FOLDER_PATH .'/app/Request/PartidasRequest.php';
  }

  private function verify($request)
  {
    return empty($request['codigo']);
  }
  public function logout()
  {
    $this->session->close();
    header('location: '.FOLDER_PATH.'/login');
  }

}
