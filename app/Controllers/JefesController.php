<?php
defined('BASEPATH') or exit('ERROR403');

require_once ROOT . FOLDER_PATH .'/app/Models/JefesModel.php';
require_once LIBS_ROUTE .'Session.php';

/**
* Main controller
*/
class JefesController extends Controller
{
  private $session;
  private $model;

  public function __construct()
  {
    $this->model = new JefesModel();
    $this->session = new Session();
    $this->session->init();
    if($this->session->get('Tipo')!='SuperAdmin')
      header('location: '.FOLDER_PATH.'/Error403');
  }

  public function index()
  {
    $result = $this->model->getAllJefes('IdJefe');
    $c=$this->model->getCount();
    $p = round($c->num_rows/21) + ($c->num_rows%21 < 10 ? 1 : 0);
    $params = array('result'=> $result,'pag'=>$p,'cant'=>$c->num_rows ,'User'=>$this->session->get('User'));
    $this->render(__CLASS__, $params);
  }

 //metodo para guardar, captura los datos que tiene el formulario
//y ejecuta las funciones que se encuentran en el archivo model de partidas
  public function save($request){
    if($this->verify($request)){
       header('location: '.FOLDER_PATH.'/Jefes');
    }else{
      if($request["id"] == 0){
        $this->model->add($request["id"],$request["subfijo"],$request["nombre"],$request["paterno"],$request["materno"],$request["area"],$request["departamento"]);
      }else{
        $this->model->update($request["id"],$request["nombre"],$request["paterno"],$request["materno"],$request["area"],$request["departamento"]);
      }

      header('location: '.FOLDER_PATH.'/Jefes');
    }
  }
  //metodo que enlaza la parte de la vista con el request este metodo se
  //se manda a llamar desde el archivo request.js
  public function requested(){
    $Id = ''; $subfijo = ''; $nombre = ''; $paterno = ''; $materno = ''; $Idarea = ''; $Iddep = '';
    $result = $this->model->getById('IdJefe',$_POST['id']);

    foreach ($result as $r) {
      $Id = $r["IdJefe"];
      $subfijo=$r['Subfijo'];
      $nombre = $r["Nombre"];
      $paterno = $r["A_paterno"];
      $materno = $r["A_materno"];
      $Idarea=$r["IdArea"];
      $Iddep =$r["IdDep"];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/JefesRequest.php';
  }

//metodo para eliminar trae el id para eliminar
//siempre y cuando el usuario alla aceptado
  public function remove($request){
    if(!empty($request['id'])){
       $this->model->del($request["id"]);
    }
    header('location: '.FOLDER_PATH.'/Jefes');
  }

//Metodo para eliminar es llamado desde el archivo request.js
  public function delete(){
   $Id =''; $nombre = ''; $paterno = ''; $materno = ''; $Idarea = ''; $Iddep = '';
    $result = $this->model->getById('IdJefe',$_POST['id']);
    foreach ($result as $r) {
      $Id = $r["IdJefe"];
      $subfijo=$r['Subfijo'];
      $nombre = $r["Nombre"];
      $paterno = $r["A_paterno"];
      $materno = $r["A_materno"];
      $Idarea = $r["IdArea"];
      $Iddep = $r["IdDep"];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/JefesRequest.php';
  }

  public function search(){
    $funcion = $_POST['function'];
    if(empty($funcion)){
      header('location: '.FOLDER_PATH.'/Partidas');
    }
    $result = $this->model->getAllJefes('IdJefe',0,21);
    if (!empty($_POST['date'])) {
      $result = $this->model->getSearchJefes('subfijo','Nombre',$_POST['date']);
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/JefesRequest.php';
  }

  public function pagination(){
    $funcion = $_POST['function'];
    $result = $this->model->getAllJefes('IdJefe',($_POST['page']),($_POST['fin']));
    require_once ROOT . FOLDER_PATH .'/app/Request/JefesRequest.php';
  }

  private function verify($request)
  {
    return empty($request['nombre']);
  }
  public function logout()
  {
    $this->session->close();
    header('location: '.FOLDER_PATH.'/login');
  }

}
