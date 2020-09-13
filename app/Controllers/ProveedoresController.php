<?php
defined('BASEPATH') or exit('ERROR403');

require_once ROOT . FOLDER_PATH .'/app/Models/ProveedoresModel.php';
require_once LIBS_ROUTE .'Session.php';


class ProveedoresController extends Controller
{
  private $session;
  private $model;

  public function __construct()
  {
    $this->model = new ProveedoresModel();
    $this->session = new Session();
    $this->session->init();
    if($this->session->get('Tipo')!='SuperAdmin')
      header('location: '.FOLDER_PATH.'/Error403');
  }

  public function index()
  {
    $result = $this->model->getLimit('IdProveedor',0,20);
    $c=$this->model->getCount();
    $p = round($c->num_rows/21) + ($c->num_rows%21 < 10 ? 1 : 0);
    $params = array('result'=> $result,'pag'=>$p,'cant'=>$c->num_rows,'User'=>$this->session->get('User'));
    $this->render(__CLASS__, $params);
  }

//metodo para guardar, captura los datos que tiene el formulario
//y ejecuta las funciones que se encuentran en el archivo model de partidas
  public function save($request){
    if($this->verify($request)){
       header('location: '.FOLDER_PATH.'/Proveedores');
    }else{
      if($request["id"] == 0){
        $this->model->add($request["Nombre"],$request["RFC"],$request["Domicilio"],$request["Email"],$request["Telefono"],$request["Servicio"]);
      }else{
        $this->model->update($request["id"],$request["Nombre"],$request["RFC"],$request["Domicilio"],$request["Email"],$request["Telefono"],$request["Servicio"]);
      }

      header('location: '.FOLDER_PATH.'/Proveedores');
    }
  }
  //metodo que enlaza la parte de la vista con el request este metodo se
  //se manda a llamar desde el archivo request.js
  public function requested(){
    $funcion = $_POST['function'];
    if(empty($funcion)){
      header('location: '.FOLDER_PATH.'/Proveedores');
    }
    $Id = ''; $Nombre = ''; $RFC = ''; $Domicilio = '';$Email = '';$Telefono = '';$Servicio = '';
    $result = $this->model->getById('IdProveedor',$_POST['id']);

    foreach ($result as $r) {
      $Id = $r["IdProveedor"];
      $Nombre = $r["Nombre"];
      $RFC = $r["RFC"];
      $Domicilio = $r["Domicilio"];
      $Email = $r["Email"];
      $Telefono = $r["Telefono"];
      $Servicio = $r["ActComercial"];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/ProveedoresRequest.php';
  }

//metodo para eliminar trae el id para eliminar
//siempre y cuando el usuario alla aceptado
  public function remove($request){
    if(!empty($request['id'])){
       $this->model->del($request["id"]);
    }
    header('location: '.FOLDER_PATH.'/Proveedores');
  }

//Metodo para eliminar es llamado desde el archivo request.js
  public function delete(){
    $Id = ''; $codigo = ''; $concepto = '';
    $result = $this->model->getById('IdProveedor',$_POST['id']);
    foreach ($result as $r) {
      $Id = $r["IdProveedor"];
      $Nombre = $r["Nombre"];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/ProveedoresRequest.php';
  }

// Metodo para buscar un dato
  public function search(){
    $funcion = $_POST['function'];
    if(empty($funcion)){
      header('location: '.FOLDER_PATH.'/Proveedores');
    }
    $result = $this->model->getLimit('IdProveedor',0,20);
    if (!empty($_POST['date'])) {
      $result = $this->model->getSearch('Nombre','ActComercial',$_POST['date']);
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/ProveedoresRequest.php';
  }

  public function pagination(){
    $funcion = $_POST['function'];
    $result = $this->model->getLimit('IdProveedor',($_POST['page']),($_POST['fin']));
    require_once ROOT . FOLDER_PATH .'/app/Request/ProveedoresRequest.php';
  }

  private function verify($request)
  {
    return empty($request['Nombre']);
  }
  public function logout()
  {
    $this->session->close();
    header('location: '.FOLDER_PATH.'/login');
  }

}
