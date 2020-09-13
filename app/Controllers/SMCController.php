<?php
defined('BASEPATH') or exit('ERROR403');

require_once ROOT . FOLDER_PATH .'/app/Models/SMCModel.php';
require_once LIBS_ROUTE .'Session.php';

/**
* Main controller
*/
class SMCController extends Controller
{
  private $session;
  private $model;

  public function __construct()
  {
    $this->model = new  SMCModel();
    $this->session = new Session();
    $this->session->init();
    if($this->session->get('Tipo')!='SCM' && $this->session->get('Tipo')!='SuperAdmin' && $this->session->get('Tipo')!='Admin'){
      header('location: '.FOLDER_PATH.'/Error403');
    }
  }

  public function index()
  {
    $result = $this->model->getAllSMC();

    $params = array('result'=> $result,'tipoUser'=>$this->session->get('Tipo'),'User'=>utf8_encode($this->session->get('User')));
    $this->render(__CLASS__, $params);
  }
//metodo para guardar, captura los datos que tiene el formulario
//y ejecuta las funciones que se encuentran en el archivo model de partidas
  public function save($request){
    if (isset($_POST['Estatus'])) {
      $this->model->updateEstado($request["id"],$_POST['Estatus']);
    }else if(isset($_POST['selectEB'])){
      $this->model->updateAdmin($request["id"],$request["selectEB"],$request["fechaAutorizacion"],$request["Comentario"]);
    }else{

       $nombre = $_FILES['archivo']['name'];
       $ruta = $_FILES['archivo']['tmp_name'];
       $nombres = $request["smc"].'.pdf';
       $destino = PATH_FILES . $nombres;
       if($request["id"] == 0){
           copy($ruta, $destino);
            $this->model->add($request["id"],$request["smc"], $request["frecepcion"], $request["freporte"], $request["departamento"], $request["jefe"], $request["concepto"],'PENDIENTE',$nombres);
       }else{
        $this->model->update($request["id"],$request["smc"],$request["departamento"],$request["jefe"],$request["concepto"],$request["frecepcion"],$nombres);
         copy($ruta, $destino);
       }
    }

     header('location: '.FOLDER_PATH.'/SMC');
   }

   public function show($params){
    header('content-type: application/pdf');
    readfile(PATH_FILES.$params['file']);
  }
  //metodo que enlaza la parte de la vista con el request este metodo se
  //se manda a llamar desde el archivo request.js
  public function requested(){
    $tipoUser=$_POST['depto']; //para saber el tipo de usuario, ya sea el de mantenimiento o el admin
    $anio=date('Y');
    $ultmimo=$this->model->UltimoRegitroSMC();
    $id="";
    foreach ($ultmimo as $key) {
      $id=$key['Idsmc']+1;
    }
    if ($id == null) {
        $id=1;
    }
    $ID=$_POST['id'];
    $Foliosmc= 'SMC-'.$id.'-'.$anio;
    $fechaRecepcion="";
    $FechaReporte="";
    $IdDep="";
    $IdSolicitante="";
    $Concepto="";
    $costo="";
    $Estado="";
    $Comentario="";
    $FechaAutorizacion=""; $estado=""; $FechaAatencion="";  $Archivo=""; $Status="";
    $result = $this->model->getById('Idsmc',$_POST['id']);

    foreach ($result as $r) {
      $ID=$r['Idsmc'];
      // $Foliorequisicion= substr($r['Foliorequisicion'], -3) ;
      $Foliosmc= $r['Folio'];
      $fechaRecepcion = $r["FechaRecepcion"];
      $FechaReporte = $r["FechaReporte"];
      $IdDep = $r["IdDep"];
      $IdSolicitante=$r["IdSolicitante"];
      $Concepto =$r["Concepto"];
      $Estado=$r['Estado'];
      $Comentario=$r['Comentario'];
      $FechaAutorizacion =$r["FechaAutorizacion"];
      $FechaAatencion =$r["FechaAatencion"];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/SMCRequest.php';
  }

  public function pagination(){
    $funcion = $_POST['function'];
    $result = $this->model->getAllSMC(($_POST['page']),($_POST['fin']));
    require_once ROOT . FOLDER_PATH .'/app/Request/SMCRequest.php';
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
