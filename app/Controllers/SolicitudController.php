<?php
defined('BASEPATH') or exit('ERROR403');

require_once ROOT . FOLDER_PATH .'/app/Models/PagoModel.php';
require_once LIBS_ROUTE .'Session.php';

class SolicitudController extends Controller
{
  private $session;
  private $model;

  public function __construct()
  {
    $this->session = new Session();
    $this->model = new PagoModel();
    $this->session->init();
    if($this->session->getStatus() === 1 || empty($this->session->get('Admin')) || $this->session->getType('type') == "Normal")
    if ($this->session->getStatus() === 1 || empty($this->session->get('PagoSolicitud')) || $this->session->getType('type') == 'Normal')
    if ($this->session->getStatus() === 1 || empty($this->session->get('Pago')) || $this->session->getType('type') == 'Normal')
      header('location: '.FOLDER_PATH.'/Error403');
  }

  public function index()
  {
    $result = $this->model->Pago('Id',0,20);
    $c=$this->model->getCount();
    $p = round($c->num_rows/21) + ($c->num_rows%21 < 10 ? 1 : 0);
    $params = array('result'=> $result,'pag'=>$p,'cant'=>$c->num_rows,'user'=> $this->session->getType('type'));
    $this->render(__CLASS__, $params);
  }

 public function save($request){
  if ($request["proveedor"] == '') {
    header('location: '.FOLDER_PATH.'/Solicitud');
  }else{
     $this->model->add($request["proveedor"],$request["SPconcepto"],$request["SPmonto"],$request["Revisado"],$request["fsolicitud"]);
  header('location: '.FOLDER_PATH.'/Solicitud');
  }


  }
  public function requested(){
  $result = $this->model->getById('Id',$_POST['id']);
      $Id=" "; $Proveedor=''; $Concepto=''; $Monto=''; $FechaSolicitud='';
      $user = $_POST['valorBoton'];

    require_once ROOT . FOLDER_PATH .'/app/Request/PagoRequest.php';
  }


  public function addcomen(){
  $result = $this->model->getById('Id',$_POST['id']);
  $user = $_POST['valorBoton'];
    foreach ($result as $r) {
      $Id=$r['Id'];
      $Proveedor=$r['Proveedor'];
      $Concepto=$r['Concepto'];
      $Monto=$r['Monto'];
      $Revisado=$r['Revisado'];
      $FechaSolicitud=$r['FechaSolicitud'];
      $AutorizadoPago=$r['AutorizadoPago'];
      $FechaAutorizado=$r['FechaAutorizado'];
      $Comentario=$r['Comentario'];
      $ComentarioCapt=$r['ComentarioCapt'];
      $estado=$r['estado'];
      $FechaPago=$r['FechaPago'];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/PagoRequest.php';
  }
    public function saveComen($request){
    if($this->verify($request)){
       header('location: '.FOLDER_PATH.'/Solicitud');
    }else{
      if($request["user"] == 'PagoSolicitud'){
        $this->model->updatePago($request["id"],$request["UpdateProveedor"],$request["Updateconcepto"],$request["Updatemonto"],$request["UpdateRevisado"],$request["Updatefsolicitud"],$request["Updatecomentario"]);
     header('location: '.FOLDER_PATH.'/Solicitud');
      }
      if($request["user"] == 'Admin'){
        $this->model->updateComentary($request["id"],$request["AutorizaPago"], $request["fAutorizado"],$request["Comentario"]);
     header('location: '.FOLDER_PATH.'/Solicitud');
      }
      if ($request["user"] == 'Pago') {
       $this->model->updateSF($request["id"],$request["UpdateStatus"], $request["UpdatefPago"]);
     header('location: '.FOLDER_PATH.'/Solicitud');
      }

    }
  }
  public function search(){
    $funcion = $_POST['function'];
    $user = $_POST['user'];
   $result = $this->model->Pago('Id',0,20);
      if(empty($funcion)){
        header('location: '.FOLDER_PATH.'/Solicitud');
      }
       if (!empty($_POST['opt'])){
        $result = $this->model->AllPago('Id');
      }
      if (!empty($_POST['date'])){
        $result = $this->model->searchIPC('Id','Proveedor','Concepto',$_POST['date']);
      }
      if (!empty($_POST['estatu'])) {
        $result = $this->model->search('estado',$_POST['estatu']);
      }
      if (!empty($_POST['autorizado'])) {
        $result = $this->model->search('AutorizadoPago',$_POST['autorizado']);
      }
      if (!empty($_POST['autorizado']) && !empty($_POST['datoDesde']) && !empty($_POST['datoHasta'])) {
          $result = $this->model->getEstadoFecha($_POST['autorizado'],$_POST['datoDesde'],$_POST['datoHasta']);
        }
    require_once ROOT . FOLDER_PATH .'/app/Request/PagoRequest.php';
  }
  // funcion que permite visualizar el modal para los datos de exportar
  public function export()
  {
    $id=$_POST['id'];
    require_once ROOT . FOLDER_PATH .'/app/Request/PagoRequest.php';
  }
  // funcion para exportar el pdf
  public function ExportarPDF($dato)
  {
    $resultado="";
    $fechaDesde = date('d/m/Y',strtotime($_POST['fechaDesde']));
    $fechaHasta = date('d/m/Y',strtotime($_POST['fechaHasta']));
    $total= "";
    if ($dato["id"] == 1) {
      $resultado = $this->model->getAllDate($_POST['fechaDesde'],$_POST['fechaHasta']);
      $total= $resultado->num_rows;

    }
    if ($dato["id"] == 2) {
      $resultado = $this->model->getEstadoFecha($_POST['selectEstado'],$_POST['fechaDesde'],$_POST['fechaHasta']);
      $total= $resultado->num_rows;
    }
    require_once ROOT . FOLDER_PATH .'/app/Views/PDF.php';
  }
// funciones para cambiar usuario y cotraseña
  public function CambiarUserPass()
  {
    require_once ROOT . FOLDER_PATH .'/app/Request/PagoRequest.php';
  }
  public function UpdateUserPass()
  {
    $tipoUser=$this->session->getType('type');
    $user = $this->model->user($_POST["UserActual"]);
    $UserActual=$_POST["UserActual"];
    if ($user->num_rows > 0) {
        $username = $_POST["username"];
        $password1 = $_POST["password"];
        $password = password_hash($password1, PASSWORD_DEFAULT);
       
        $this->model->UpdateUser($username,$password,$tipoUser);

      header('location: '.FOLDER_PATH.'/Solicitud');
    }else{

      echo '<script>alert("\u2716 ¡ El usuario anterior: '. $UserActual .', no existe ! ");</script>';
      echo '<script>history.back(-1)</script>';

    }
  }

    public function remove($request){
    if(!empty($request['id'])){
      $user = $_POST['user'];
       $this->model->del($request["id"]);
    }
    header('location: '.FOLDER_PATH.'/Solicitud');
  }

//Metodo para eliminar es llamado desde el archivo request.js
  public function delete(){
    $Id = ''; $codigo = ''; $concepto = ''; $estado="";
    $result = $this->model->getById('Id',$_POST['id']);
    foreach ($result as $r) {
      $Id = $r["Id"];
      $concepto = $r["Concepto"];
      $estado = $r["estado"];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/PagoRequest.php';
  }
    public function pagination(){
    $user = $_POST['valorBoton'];
    $funcion = $_POST['function'];
    $result = $this->model->Pago('Id',($_POST['page']),($_POST['fin']));
    require_once ROOT . FOLDER_PATH .'/app/Request/PagoRequest.php';
  }

  private function verify($request)
  {
    return empty($request["id"]);
  }
}
