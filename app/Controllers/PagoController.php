<?php
defined('BASEPATH') or exit('ERROR403');

require_once ROOT . FOLDER_PATH .'/app/Models/PagoModel.php';
require_once LIBS_ROUTE .'Session.php';

class PagoController extends Controller
{
  private $session;
  private $model;

  public function __construct()
  {
    $this->session = new Session();
    $this->model = new PagoModel();
    $this->session->init();
    if($this->session->getStatus() === 1 || empty($this->session->get('Pago')) || $this->session->getType('type') == "Admin")
      header('location: '.FOLDER_PATH.'/Error403');
  }

  public function index()
  {
    $result = $this->model->AllPago('Id');
    $params = array('result'=> $result);
    $this->render(__CLASS__,$params);
  }

  public function save($request){
    if (!empty($request['folio'])) {
          if ($request["id"] == 0) {
            $this->model->add($request['folio'], $request['concepto'], $request['monto']);
           header('location: '.FOLDER_PATH.'/Pago');
          }else{
              $this->model->updatePago($request['id'],$request['folio'],$request['concepto'],$request['monto']);
           header('location: '.FOLDER_PATH.'/Pago');
          }
    }

    header('location: '.FOLDER_PATH.'/Pago');

  }
  public function requested(){
  $result = $this->model->getById('Id',$_POST['id']);
      $Id=" "; $Folio="";
      $Concepto="";
      $Monto="";
    foreach ($result as $r) {
      $Id=$r['Id'];
      $Folio=$r['Folio'];
      $Concepto=$r['Concepto'];
      $Monto=$r['Monto'];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/PagoRequest.php';
  }

    public function saveComen($request){
    if($this->verify($request)){
       header('location: '.FOLDER_PATH.'/Pago');
    }else{
      $this->model->add($request["id"],$request["concepto"]);
     header('location: '.FOLDER_PATH.'/Pago');
    }
  }
    public function search(){
    $funcion = $_POST['function'];
    if(empty($funcion)){
      header('location: '.FOLDER_PATH.'/Pago');
    }
    $result = $this->model->getJoinAll();

    require_once ROOT . FOLDER_PATH .'/app/Request/PagoRequest.php';
  }

  private function verify($request)
  {
    return empty($request["id"]);
  }

}
