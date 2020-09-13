<?php
require_once ROOT . FOLDER_PATH .'/app/Models/InventarioModel.php';
require_once LIBS_ROUTE .'Session.php';


class InventarioController extends Controller
{
  private $session;
  private $model;

  public function __construct()
  {
    $this->model = new InventarioModel();
    $this->session = new Session();
    $this->session->init();
    if($this->session->get('Tipo')!='SuperAdmin')
      header('location: '.FOLDER_PATH.'/Error403');
  }

  public function index()
  {
    $result = $this->model->getAllMaterial('IDmaterial',0,20);
    $params = array('result'=> $result,'User'=>$this->session->get('User'));
    $this->render(__CLASS__, $params);
  }

  //metodo para guardar, captura los datos que tiene el formulario
//y ejecuta las funciones que se encuentran en el archivo model de partidas
  public function save($request){

      if($request["id"] == 0){
        $this->model->add($request["Concepto"], $request["Medida"], $request["Precio"], $request["Partida"]);

      }else{
        $this->model->update($request["id"],$request["Concepto"],$request["Medida"],$request["Precio"],$request["Partida"]);
      }
      header('location: '.FOLDER_PATH.'/Material');
  }
  //metodo que enlaza la parte de la vista con el request este metodo se
  //se manda a llamar desde el archivo request.js
  public function requested(){
    $funcion = $_POST['function'];
    if(empty($funcion)){
      header('location: '.FOLDER_PATH.'/Material');
    }
      $Id =$_POST['id'];
      $Concepto = "";
      $Medida = "";
      $Precio = "";
      $Partida = "";
    $result = $this->model->AllMaterial($_POST['id']);

    foreach ($result as $r) {
      $Id = $r["IDmaterial"];
      $Concepto = $r["Concepto"];
      $Medida = $r["Medida"];
      $Precio = $r["Precio"];
      $Partida = $r['Codigo'];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/MaterialRequest.php';
  }

//metodo para eliminar trae el id para eliminar
//siempre y cuando el usuario alla aceptado
  public function remove($request){
    if(!empty($request['id'])){
       $this->model->del($request["id"]);
    }
    header('location: '.FOLDER_PATH.'/Material');
  }

//Metodo para eliminar es llamado desde el archivo request.js
  public function delete(){
    $Id = ''; $codigo = ''; $concepto = '';
    $result = $this->model->getById('IDmaterial',$_POST['id']);
    foreach ($result as $r) {
      $Id = $r["IDmaterial"];
      $concepto = $r["Concepto"];

    }
    require_once ROOT . FOLDER_PATH .'/app/Request/MaterialRequest.php';
  }

// Metodo para buscar un dato
  public function search(){
    $funcion = $_POST['function'];
    if(empty($funcion)){
      header('location: '.FOLDER_PATH.'/Material');
    }
    $result = $this->model->getAllMaterial('IDmaterial',0,20);
    if (!empty($_POST['date'])) {
      $result = $this->model->getSearch('Codigo','Concepto',$_POST['date']);

    }
    if (!empty($_POST['partida'])) {
        $result = $this->model->getSearchP_OR_M('IdPartidas',$_POST['partida']);
      }
    if (!empty($_POST['material'])) {
        $result = $this->model->getSearchP_OR_M('IDmaterial',$_POST['material']);
      }

    require_once ROOT . FOLDER_PATH .'/app/Request/InventarioRequest.php';
  }
  public function Existencia()
  {
    require_once ROOT . FOLDER_PATH .'/app/Request/MaterialRequest.php';
  }
  public function addExistencia()
  {
    $cantidad='';
    $result = $this->model->getCantidad($_POST['id']);
    if ($_POST['function'] == 'Entrada') {
      foreach ($result as $r) {
        if ($r['Existencia'] != null) {
          $cantidad=$r['Existencia']+$_POST['Existencia'];
        }

    }
    $this->model->addExistencia($_POST['id'],$cantidad);
    } else if ($_POST['function'] == 'Salida') {
       foreach ($result as $r) {
            if ($r['Existencia'] != null) {
              $cantidad=$r['Existencia']-$_POST['Existencia'];
          }
        }
            if ($cantidad < 0) {
               return $this->renderErrorMessage("La cantidad de {$_POST['Existencia']} excede de la cantidad existente del material: {$_POST['material']}, por favor ingrese otra cantidad menor.");
              }
        $this->model->OutExistencia($_POST['id'],$cantidad);
    }

      header('location: '.FOLDER_PATH.'/Material');
  }

  private function verify($request)
  {
    return empty($request['id']);
  }
    public function renderErrorMessage($message)
  {
    $result = $this->model->getAllMaterial('IDmaterial',0,20);
     $c=$this->model->getCount();
    $p = round($c->num_rows/21) + ($c->num_rows%21 < 10 ? 1 : 0);
    $params = array('error_message' => $message,'result'=>$result,'pag'=>$p,'cant'=>$c->num_rows);
    $this->render(__CLASS__, $params);
  }
  public function logout()
  {
    $this->session->close();
    header('location: '.FOLDER_PATH.'/login');
  }

}
