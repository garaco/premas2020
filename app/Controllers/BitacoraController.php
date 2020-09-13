<?php
defined('BASEPATH') or exit('ERROR403');

require_once ROOT . FOLDER_PATH .'/app/Models/BitacoraModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/RequisicionModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/RequisicionAnualModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/RBSModel.php';
require_once LIBS_ROUTE .'Session.php';

class BitacoraController extends Controller
{
  private $session;
  private $model;
  public static $indice;
  public function __construct()
  {
    $this->session = new Session();
    $this->model = new BitacoraModel();
    $this->session->init();
    if($this->session->get('Tipo')!='Admin')
      header('location: '.FOLDER_PATH.'/Error403');
  }

public function index()
  {

    $Foliorequisicion = $this->model->folioReq();
    $result = $this->model->getJoinAll();
    $params = array('result'=> $result,'Foliorequisicion'=>$Foliorequisicion);
    $this->render(__CLASS__, $params);

  }

  public function show($params){
    header('content-type: application/pdf');
    readfile(PATH_FILES.$params['file']);
  }

  public function requested(){
  $result = $this->model->getById('IdBitacora',$_POST['id']);

    foreach ($result as $r) {
      $ID=$r['IdBitacora'];
      $Foliorequisicon=$r['Foliorequisicion'];
      $Fecha=$r['FechaAutorizacion'];
      $Estado=$r['Estado'];
      $comentario=$r['Comentario'];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/BitacoraRequest.php';
  }
  // funcion para cancelar la requisicion
  public function Cancel()
  {


    $RBS = new RBSModel();
    $req = new RequisicionModel();
    $programaAnual = new RequisicionAnualModel();
    $arrayExplode = explode('|', $_POST['ID']);
    $IdBitacora = $arrayExplode[0];
    $idDepart = $arrayExplode[1];
    $mes= $arrayExplode[2];
    $f_recepcion = $arrayExplode[3];
    $arrayCantidad = array();
    $arrayDescripcion = array();
    $arrayProyecto = array();
    $arrayMeta = array();
    $indice = 0;
    $arrayMes= explode('|',ArrayMes);
    $fecha=strtotime($f_recepcion);
      $m=date('m',$fecha); //numero del mes de la fecha que solicito la req.
      $mm=($m == 10) ? $m: str_replace('0','', $m);
      $mesF = $arrayMes[$mm-1]; //nombre del mes de la fecha que solicito la req.
    $user = $RBS->DatoUser($idDepart,'IdDepartamento');
    $IdUsuario;
    foreach ($user as $u) {
      $IdUsuario=$u['IdUsuario'];
    }

    $consulta = $req->getMateriales($IdBitacora);
    foreach ($consulta as $r) {
      $arrayCantidad[$indice] = $r['Cantidad'];
      $arrayDescripcion[$indice]= $r['Descripcion'];
      $arrayProyecto[$indice] = $r['Proyecto'];
      $arrayMeta[$indice] = $r['Meta'];
       $this->model->deleteMateriales('requisicion_detalle','IdRequisicionDetalle',$r['IdRequisicionDetalle']);
       $indice++;
    }
      if ($mesF == $mes) {
        for ($i=0; $i < count($arrayDescripcion); $i++) {//$IdUsuario,$IdMaterial,$IdMeta,$idProyecto,$mes
          $progAnual = $programaAnual->getMesMaterial($IdUsuario,$arrayDescripcion[$i],$arrayMeta[$i],$arrayProyecto[$i],$mes);
            foreach ($progAnual as $c) {
            $TotalArticulo=$c[$mes]+$arrayCantidad[$i]; //$IdMaterial,$IdUsuario,$TotalArticulo,$IdMeta,$idProyecto,$mes
            $programaAnual->updateMesArt($arrayDescripcion[$i],$IdUsuario,$TotalArticulo,$arrayMeta[$i],$arrayProyecto[$i],$mes);

          }
        }
      }else{
      $fecha2=strtotime(DATE); //fecha actual
      $m2=date('m',$fecha2); //numero del mes de la fecha posterior de la fecha actual
      $mm2=($m2 == 10) ? $m2: str_replace('0','', $m2);
      $mesF2 = $arrayMes[$mm2]; //nombre del mes de la fecha posterior de la fecha actual.

        for ($i=0; $i < count($arrayDescripcion); $i++) {
          $totalmes1=0;//total del material del mes de la fecha que solicito la req.
          $totalmes2=0;//total del material para el mes posterior.
          $mesfechaEntrega = $programaAnual->getMesMaterial($IdUsuario,$arrayDescripcion[$i],$arrayMeta[$i],$arrayProyecto[$i],$mesF);

          $mesDespues = $programaAnual->getMesMaterial($IdUsuario,$arrayDescripcion[$i],$arrayMeta[$i],$arrayProyecto[$i],$mesF2);
            foreach ($mesfechaEntrega as $c) {
            $totalmes1=$c[$mesF];
            $TotalArticulo1=$c[$mesF]-$c[$mesF];
            $programaAnual->updateMesArt($arrayDescripcion[$i],$IdUsuario,$TotalArticulo1,$arrayMeta[$i],$arrayProyecto[$i],$mesF);

          }
          foreach ($mesDespues as $md) {
            $totalmes2=$md[$mesF2];
            $TotalArticulo2=$md[$mesF2]+($totalmes1+$arrayCantidad[$i]);
            $programaAnual->updateMesArt($arrayDescripcion[$i],$IdUsuario,$TotalArticulo2,$arrayMeta[$i],$arrayProyecto[$i],$mesF2);
          }

        }

      }
    // for ($i=0; $i < count($arrayDescripcion); $i++) {
    //   // $progAnual = $programaAnual->getTotalArticulo($IdUsuario,$arrayDescripcion[$i]);
    //   //   foreach ($progAnual as $c) {
    //   //   $TotalArticulo=$c['TotalArticulo']+$arrayCantidad[$i];
    //   //   $programaAnual->updateTotalArt($arrayDescripcion[$i],$IdUsuario,$TotalArticulo);

    //   // }
    //   $progAnual = $programaAnual->getMesMaterial($IdUsuario,$arrayDescripcion[$i]);
    //     foreach ($progAnual as $c) {
    //     $TotalArticulo=$c['TotalArticulo']+$arrayCantidad[$i];
    //     $programaAnual->updateTotalArt($arrayDescripcion[$i],$IdUsuario,$TotalArticulo);

    //   }

    // }

      $this->model->deleteRequisicion('bitacora','IdBitacora',$IdBitacora);
      header('location: '.FOLDER_PATH.'/Bitacora');
  }
  public function prints($request){
    require_once ROOT . FOLDER_PATH .'/app/Lib/fpdf181/fpdf.php';

    $im = imagegrabscreen();
    imagepng($im, "screenshot.png");
    imagedestroy($im);

    $pdf=new FPDF();
    $pdf->AddPage('L');
    $pdf->SetFont('Arial','',15);
    $pdf->Cell(40,20);
    $pdf->Image('screenshot.png' , -2 ,-15, 310 ,200 ,'png');

    $pdf->Output();
  }

  public function saveFile($request){
    if($this->verify($request)){
       header('location: '.FOLDER_PATH.'/Bitacora');
    }else{
      $nombre = $_FILES['archivo']['name'];
      $ruta = $_FILES['archivo']['tmp_name'];
      $nombres = $request["requisicion"].'.pdf';
      $destino = PATH_FILES . $nombres;
      copy($ruta, $destino);
      $this->model->update($request["id"],$request["fecha"],$nombres,$request["estado"]);
     header('location: '.FOLDER_PATH.'/Bitacora');
   }
  }

  public function save(){
    if ($_POST['selectEB']=='PENDIENTE' || $_POST['selectEB']=='COTIZACION') {
      $this->model->update($_POST['id'],'0000-00-00',$_POST['file'],$_POST['selectEB']);
     header('location: '.FOLDER_PATH.'/Bitacora');
    }else{
        $this->model->update($_POST['id'],$_POST['fecha'],$_POST['file'],$_POST['selectEB']);
     header('location: '.FOLDER_PATH.'/Bitacora');
    }

  }
  public function addcomen(){
  $result = $this->model->getById('IdBitacora',$_POST['id']);
  $mes = $_POST['mes'];
  $dateRecepcion=$_POST['datef']; // fecha recepcion de la req
    foreach ($result as $r) {
      $ID=$r['IdBitacora'];
      $Foliorequisicon=$r['Foliorequisicion'];
      $Fecha=$r['FechaAutorizacion'];
      $Estado=$r['Estado'];
      $Concepto=$r['Comentario'];
      $IdDep=$r['IdDep'];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/BitacoraRequest.php';
  }
    public function saveComen($request){
    if($this->verify($request)){
       header('location: '.FOLDER_PATH.'/Bitacora');
    }else{
      $RBS = new RBSModel();
      $req = new RequisicionModel();
      $programaAnual = new RequisicionAnualModel();
      $bitacora= new BitacoraModel();
      $arrayExplode = explode('|', $request["id"]);
      $IdBitacora = $arrayExplode[0];
      $idDepart = $arrayExplode[1];
      $mes= $arrayExplode[2];
      $f_recepcion = $arrayExplode[3];
      $arrayCantidad = array();
      $arrayDescripcion = array();
      $arrayProyecto = array();
      $arrayMeta = array();
      $indice = 0;
      $fecha=strtotime($f_recepcion);
      $m=date('m',$fecha); //numero del mes de la fecha que solicito la req.
      $mm=($m == 10) ? $m: str_replace('0','', $m);
      $mesF = ArrayMes[$mm-1]; //nombre del mes de la fecha que solicito la req.
      $user = $RBS->DatoUser($idDepart,'IdDepartamento');
      $IdUsuario;
      foreach ($user as $u) {
        $IdUsuario=$u['IdUsuario'];
      }

      if ($request["selectEB"] == 'NO AUTORIZADO') {
        $consulta = $req->getMateriales($IdBitacora);
        foreach ($consulta as $r) {
          $arrayCantidad[$indice] = $r['Cantidad'];
          $arrayDescripcion[$indice]= $r['Descripcion'];
          $arrayProyecto[$indice] = $r['Proyecto'];
          $arrayMeta[$indice] = $r['Meta'];
           $bitacora->updateCantidad($r['IdRequisicionDetalle']);

           $indice++;
        }
      if ($mesF == $mes) {
        for ($i=0; $i < count($arrayDescripcion); $i++) {
          $progAnual = $programaAnual->getMesMaterial($IdUsuario,$arrayDescripcion[$i],$arrayMeta[$i],$arrayProyecto[$i],$mes);
            foreach ($progAnual as $c) {
            $TotalArticulo=$c[$mes]+$arrayCantidad[$i];
            $programaAnual->updateMesArt($arrayDescripcion[$i],$IdUsuario,$TotalArticulo,$arrayMeta[$i],$arrayProyecto[$i],$mes);

          }
        }
      }else{
      $fecha2=strtotime(DATE); //fecha actual
      $m2=date('m',$fecha2); //numero del mes de la fecha posterior de la fecha actual
      $mm2=($m2 == 10) ? $m2: str_replace('0','', $m2);
      $mesF2 = ArrayMes[$mm2]; //nombre del mes de la fecha posterior de la fecha actual.

        for ($i=0; $i < count($arrayDescripcion); $i++) {
          $totalmes1=0;//total del material del mes de la fecha que solicito la req.
          $totalmes2=0;//total del material para el mes posterior.
          $mesfechaEntrega = $programaAnual->getMesMaterial($IdUsuario,$arrayDescripcion[$i],$arrayMeta[$i],$arrayProyecto[$i],$mesF);

          $mesDespues = $programaAnual->getMesMaterial($IdUsuario,$arrayDescripcion[$i],$arrayMeta[$i],$arrayProyecto[$i],$mesF2);
            foreach ($mesfechaEntrega as $c) {
            $totalmes1=$c[$mesF];
            $TotalArticulo1=$c[$mesF]-$c[$mesF];
            $programaAnual->updateMesArt($arrayDescripcion[$i],$IdUsuario,$TotalArticulo1,$arrayMeta[$i],$arrayProyecto[$i],$mesF);

          }
          foreach ($mesDespues as $md) {
            $totalmes2=$md[$mesF2];
            $TotalArticulo2=$md[$mesF2]+($totalmes1+$arrayCantidad[$i]);
            $programaAnual->updateMesArt($arrayDescripcion[$i],$IdUsuario,$TotalArticulo2,$arrayMeta[$i],$arrayProyecto[$i],$mesF2);
          }

        }

      }
        // for ($i=0; $i < count($arrayDescripcion); $i++) {
        //   $progAnual = $programaAnual->getTotalArticulo($IdUsuario,$arrayDescripcion[$i]);
        //     foreach ($progAnual as $c) {
        //     $TotalArticulo=$c['TotalArticulo']+$arrayCantidad[$i];
        //     $programaAnual->updateTotalArt($arrayDescripcion[$i],$IdUsuario,$TotalArticulo);

        //   }


        $bitacora->add($IdBitacora ,$request["concepto"],$request["selectEB"],$request["frecepcion"]);
      }else{
      $bitacora->add($IdBitacora ,$request["concepto"],$request["selectEB"],$request["frecepcion"]);
      }

     header('location: '.FOLDER_PATH.'/Bitacora');
    }
  }
    public function search(){
    $funcion = $_POST['function'];
    if(empty($funcion)){
      header('location: '.FOLDER_PATH.'/Bitacora');
    }
    $indice = 'no';
    $result = $this->model->getJoinAll();
    if (!empty($_POST['id'])) {
      $indice=1;
      $result = $this->model->getJoinAllDepar($_POST['id']);
    }

    if (!empty($_POST['date'])) {
      $result = $this->model->getSearchBit('Concepto',$_POST['date']);
    }
    if (!empty($_POST['estatu'])) {
      $result = $this->model->getJoinStatus($_POST['id'],$_POST['estatu']);
    }
    if (!empty($_POST['datoDesde']) && !empty($_POST['datoHasta'])) {
      $result = $this->model->getJoinAllDATEStatu($_POST['id'],$_POST['estatu'],$_POST['datoDesde'],$_POST['datoHasta']);
    }
    if (!empty($_POST['datoHasta'])) {
      $result = $this->model->getJoinAllDATE($_POST['datoDesde'],$_POST['datoHasta']);
    }
      if (!empty($_POST['estatu']) && !empty($_POST['datoDesde']) && !empty($_POST['datoHasta'])) {
        $result = $this->model->getJoinAllDATEStatu($_POST['id'],$_POST['estatu'],$_POST['datoDesde'],$_POST['datoHasta']);
      }
    require_once ROOT . FOLDER_PATH .'/app/Request/BitacoraRequest.php';
  }
  public function CambiarUserPass()
  {
    require_once ROOT . FOLDER_PATH .'/app/Request/BitacoraRequest.php';
  }
  public function UpdateUserPass()
  {
    $tipoUser=$this->session->getType('type');
    $user = $this->model->user($_POST["UserActual"]);
    $UserActual=$_POST["UserActual"];
    // var_dump($user->num_rows);
    if ($user->num_rows > 0) {
        $username = $_POST["username"];
        $password1 = $_POST["password"];
        $password = password_hash($password1, PASSWORD_DEFAULT);
        // var_dump($password);
        $this->model->UpdateUser($username,$password,$tipoUser,$password1);

      header('location: '.FOLDER_PATH.'/Bitacora');
    }else{

      echo '<script>alert("\u2716 ¡ El usuario anterior: '. $UserActual .', no existe ! ");</script>';
      echo '<script>history.back(-1)</script>';

    }
  }

  private function verify($request)
  {
    return empty($request["id"]);
  }

}
