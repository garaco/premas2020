<?php
defined('BASEPATH') or exit('ERROR403');
 require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/LoginModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/RBSModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/BitacoraModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/ProyectoModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/MetasModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/PartidasModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/RequisicionAnualModel.php';
require_once LIBS_ROUTE .'Session.php';

/**
* Main controller
*/
class MaterialReqController extends Controller
{
  private $session;
  private $model;

  public function __construct()
  {
    $this->session = new Session();
    $this->model = new RBSModel();
    $this->model2 = new BitacoraModel();
    $this->session->init();
    if($this->session->get('Tipo')!='SuperAdmin' && $this->session->get('Tipo')!='Normal' && $this->session->get('Tipo')!='SCM'){
      header('location: '.FOLDER_PATH.'/Error403');
  }
  }

  public function index()
  {
    $result = $this->model->getJoinAll(0,20);
    $c=$this->model->getCount();
    $p = round($c->num_rows/21) + ($c->num_rows%21 < 10 ? 1 : 0);
    $params = array('result'=> $result,'pag'=>$p,'cant'=>$c->num_rows);
    $this->render(__CLASS__, $params);
  }


  public function save($request){
    if($this->verify($request)){
       header('location: '.FOLDER_PATH.'/RBS');
    }else{
      if($request["id"] == 0){
           $this->model->add($request["id"], $request["fSolicitud"], $request["departamento"], $request["jefe"],'PENDIENTE');
         header('location: '.FOLDER_PATH.'/RBS');
        }
      }
     header('location: '.FOLDER_PATH.'/RBS');
   }

  public function requested(){
  $ID=" "; $Foliorequisicon=""; $fechaRecepcion=""; $FechaReporte="";  $IdDep=""; $IdSolicitante="";
  $Concepto=""; $costo=""; $FechaAutorizacion=""; $estado=""; $FechaAatencion="";  $Archivo=""; $Status="";

  $proyecto=""; $partidad=""; $descripcion=""; $cantidad="";
  $result = $this->model->getRequisicion($_POST['id']);

    foreach ($result as $r) {
      $ID=$r['IdBitacora'];
      $Foliorequisicon=$r['Foliorequisicion'];
      $fechaRecepcion = $r["FechaRecepcion"];
      $FechaReporte = $r["FechaReporte"];
      $IdDep = $r["IdDep"];
      $IdSolicitante=$r["IdSolicitante"];
      $Concepto =$r["Concepto"];
      $costo =$r["Costo"];
      $proyecto=$r["Proyecto"];
      $partidad=$r["Partida"];
      $descripcion=$r["Descripcion"];
      $cantidad=$r["Cantidad"];

    }
    require_once ROOT . FOLDER_PATH .'/app/Request/RBSRequest.php';
  }

// ============ [ funcion para obtener las metas y enviar a final.js ] ============================
  public function getMetas()
  {
    // $metas = new MetasModel();
    // $metas = $metas->getAll('Num');
    $programaAnual = new RequisicionAnualModel();
    $result = $programaAnual->getIdMeta($_POST['idUser'],date("Y"));

    $array = array();
    $enum = array();
    $i=0;

    foreach ($result as $r) {
      $enum[$i] = $r['EnumMeta'];
      $array[$i]=$r['IdMeta'];
      $i++;
    }
    $json = array(
    'IdMeta'=>$array,
    'Enum'=>$enum
    );
    echo json_encode($json,JSON_FORCE_OBJECT);


  }

  private function verify($request)
  {
    return empty($request['id']);
  }

  public function logout()
  {
    $this->session->close();
    header('location: '.FOLDER_PATH.'/login');
  }

}


class ElementoAutocompletar {
   var $value;
   var $label;

   function __construct($label, $value){
      $this->label = $label;
      $this->value = $value;
   }
}
?>
