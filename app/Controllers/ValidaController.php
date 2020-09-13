<?php
defined('BASEPATH') or exit('ERROR403');

require_once ROOT . FOLDER_PATH .'/app/Models/ValidaModel.php';
require_once LIBS_ROUTE .'Session.php';

/**
* Main controller
*/
class ValidaController extends Controller
{
  private $session;
  private $model;

  public function __construct()
  {
    $this->session = new Session();
    $this->session->init();
    if($this->session->get('Tipo') != "Asigna")
      header('location: '.FOLDER_PATH.'/Error403');
  }

  public function index()
  {
    $val = new ValidaModel();
    $result = $val->getValida();
    $params = array('result'=> $result,'User'=>$this->session->get('User'));
    $this->render(__CLASS__, $params);
  }

//metodo para guardar, captura los datos que tiene el formulario
//y ejecuta las funciones que se encuentran en el archivo model de partidas
  public function save(){
      $val = new ValidaModel();
      $val->Idvalida=$_POST['id'];
      $val->IdDepartamento=$_POST['departamento'];
      $val->IdProyecto=$_POST['proyecto'];
      $val->IdMeta=$_POST['metas'];
      $val->anio=$_POST['anio'];
      if($_POST['id'] == 0){
        $val->add();
      }else{
        $val->update();
      }
      header('location: '.FOLDER_PATH.'/Valida');
  }
  //metodo que enlaza la parte de la vista con el request este metodo se
  //se manda a llamar desde el archivo request.js
  public function requested(){

    $Id = ''; $codigo = ''; $concepto = '';
    $val = new ValidaModel();
    $val->Idvalida=$_POST['id'];
    $result = $val->getValidaId();
    foreach ($result as $r) {
      $IdDep = $r["IdDepartamento"];
      $IdPro = $r["IdProyecto"];
      $IdMeta = $r["IdMeta"];
      $Departamento = $r["nombreDepto"];
      $Proyecto = $r["proyecto"];
      $Meta = $r["meta"];
      $year = $r["anio"];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/ValidaRequest.php';
  }

//metodo para eliminar trae el id para eliminar
//siempre y cuando el usuario alla aceptado
  public function remove(){
    if(!empty($_POST['id'])){
       $val = new ValidaModel();
       $val->Idvalida=$_POST['id'];
       $val->del();
    }
    header('location: '.FOLDER_PATH.'/Valida');
  }

//Metodo para eliminar es llamado desde el archivo request.js
  public function delete(){
    $val = new ValidaModel();
    $val->Idvalida=$_POST['id'];
    $result = $val->getValidaId();
    foreach ($result as $r) {
      $Departamento = $r["nombreDepto"];
      $Proyecto = $r["proyecto"];
      $Meta = $r["meta"];
      $year = $r["anio"];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/ValidaRequest.php';
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
