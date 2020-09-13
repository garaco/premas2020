<?php
defined('BASEPATH') or exit('ERROR403');

require_once ROOT . FOLDER_PATH .'/app/Models/MetasModel.php';
require_once LIBS_ROUTE .'Session.php';

/**
* Main controller
*/
class MetasController extends Controller
{
  private $session;
  private $model;

  public function __construct()
  {
    $this->model = new MetasModel();
    $this->session = new Session();
    $this->session->init();
    if($this->session->get('Tipo')!='SuperAdmin')
      header('location: '.FOLDER_PATH.'/Error403');
  }

  public function index()
  {
    $result = $this->model->getLimit('IdMetas',0,20);
    $c=$this->model->getCount();
    $p = round($c->num_rows/21) + ($c->num_rows%21 < 10 ? 1 : 0);
    $params = array('result'=> $result,'pag'=>$p,'cant'=>$c->num_rows,'User'=>$this->session->get('User'));
    $this->render(__CLASS__, $params);
  }

//metodo para guardar, captura los datos que tiene el formulario
//y ejecuta las funciones que se encuentran en el archivo model de partidas
  public function save($request){
    if($this->verify($request)){
       header('location: '.FOLDER_PATH.'/Metas');
    }else{
      if($request["id"] == 0){
        $this->model->add($request["id"],$request["codigo"],$request["concepto"]);
      }else{
        $this->model->update($request["id"],$request["codigo"],$request["concepto"]);
      }

      header('location: '.FOLDER_PATH.'/Metas');
    }
  }
  //metodo que enlaza la parte de la vista con el request este metodo se
  //se manda a llamar desde el archivo request.js
  public function requested(){

    $Id = ''; $codigo = ''; $concepto = '';
    $result = $this->model->getById('IdMetas',$_POST['id']);

    foreach ($result as $r) {
      $Id = $r["IdMetas"];
      $codigo = $r["Num"];
      $concepto = $r["Concepto"];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/MetasRequest.php';
  }

//metodo para eliminar trae el id para eliminar
//siempre y cuando el usuario alla aceptado
  public function remove($request){
    if(!empty($request['id'])){
       $this->model->del($request["id"]);
    }
    header('location: '.FOLDER_PATH.'/Metas');
  }

//Metodo para eliminar es llamado desde el archivo request.js
  public function delete(){
    $Id = ''; $codigo = ''; $concepto = '';
    $result = $this->model->getById('IdMetas',$_POST['id']);
    foreach ($result as $r) {
      $Id = $r["IdMetas"];
      $codigo = $r["Num"];
      $concepto = $r["Concepto"];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/MetasRequest.php';
  }

  // Metodo para buscar un dato
  public function search(){
    $funcion = $_POST['function'];
    if(empty($funcion)){
      header('location: '.FOLDER_PATH.'/Metas');
    }
    $result = $this->model->getLimit('IdMetas',0,20);
    if (!empty($_POST['date'])) {
      $result = $this->model->getSearch('Num','Concepto',$_POST['date']);
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/MetasRequest.php';
  }


public function pagination(){
    $funcion = $_POST['function'];
    $result = $this->model->getLimit('IdMetas',($_POST['page']),($_POST['fin']));
    require_once ROOT . FOLDER_PATH .'/app/Request/MetasRequest.php';
  }


  private function verify($request)
  {
    return empty($request['Num']);
  }
  public function logout()
  {
    $this->session->close();
    header('location: '.FOLDER_PATH.'/login');
  }
}
