<?php
defined('BASEPATH') or exit('ERROR403');

require_once ROOT . FOLDER_PATH .'/app/Models/AreaModel.php';
require_once LIBS_ROUTE .'Session.php';

/**
* Main controller
*/
class AreaController extends Controller
{
  private $session;
  private $model;

  public function __construct()
  {
    $this->model = new  AreaModel();
    $this->session = new Session();
    $this->session->init();
    if($this->session->get('Tipo')!='SuperAdmin')
      header('location: '.FOLDER_PATH.'/Error403');
  }

  public function index()
  {
    $result = $this->model->area();
    $params = array('result'=> $result,'User'=>$this->session->get('User'));
    $this->render(__CLASS__, $params);
  }
//metodo para guardar, captura los datos que tiene el formulario
//y ejecuta las funciones que se encuentran en el archivo model de partidas
  public function save($request){
    if($this->verify($request)){
       header('location: '.FOLDER_PATH.'/Area');
    }else{
      if($request["id"] == 0){
        $this->model->add($request["id"],$request["codigo"],$request["NombreArea"],$request['responsable']);
      }else{
        $this->model->update($request["id"],$request["codigo"],$request["NombreArea"],$request['responsable']);
      }

      header('location: '.FOLDER_PATH.'/Area');
    }
  }
  //metodo que enlaza la parte de la vista con el request este metodo se
  //se manda a llamar desde el archivo request.js
  public function requested(){

    $Id = ''; $codigo = ''; $NombreArea = ''; $responsable="";
    $result = $this->model->getById('IdArea',$_POST['id']);

    foreach ($result as $r) {
      $Id = $r["IdArea"];
      $codigo = $r["Num"];
      $NombreArea = $r["NombreArea"];
      $responsable = $r["Responsable"];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/AreaRequest.php';
  }

//metodo para eliminar trae el id para eliminar
//siempre y cuando el usuario alla aceptado
  public function remove($request){
    if(!empty($request['Id'])){
       $this->model->del($request["Id"]);
    }
    header('location: '.FOLDER_PATH.'/Area');
  }

//Metodo para eliminar es llamado desde el archivo request.js
  public function delete(){
    $Id = ''; $codigo = ''; $NombreArea = '';
    $result = $this->model->getById('IdArea',$_POST['id']);
    foreach ($result as $r) {
      $Id = $r["IdArea"];
      $codigo = $r["Num"];
      $NombreArea = $r["NombreArea"];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/AreaRequest.php';
  }

  public function search(){
    $funcion = $_POST['function'];
    if(empty($funcion)){
      header('location: '.FOLDER_PATH.'/Area');
    }
    $result = $this->model->area();
    if (!empty($_POST['date'])) {
      $result = $this->model->getSearchs('NombreArea','Subfijo','Nombre',$_POST['date']);
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/AreaRequest.php';
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
