<?php
require_once LIBS_ROUTE .'Session.php';
require_once ROOT . FOLDER_PATH .'/app/Models/RequisicionAnualModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';

class RequisicionAnualController extends Controller
{
  private $session;

  public function __construct()
  {
    $this->session = new Session();
    $this->session->init();
    if($this->session->get('Tipo')!='SuperAdmin' && $this->session->get('Tipo')!='Normal' && $this->session->get('Tipo')!='SCM'){
      header('location: '.FOLDER_PATH.'/Error403');
    }
  }
  public function index()
  {
    $req = new RequisicionAnualModel();

    $proyec=$req->getProyectos($this->session->get('id'),date('Y'));

    $proyecNew=$req->getProyectos($this->session->get('id'),(date('Y')+1));

    $Dep = new DepartamentoModel();
    $Depar = $Dep->getById('idDepart',$this->session->get('Dep'));
    foreach ($Depar as $v) { $d = $v['nombreDepto']; }
    $k=$req->getSQL();
    $Anio=$req->getAnio();

    $params = array('area'=> $this->session->get('Tipo'), "IdDep" => $this->session->get('Dep'),
    'kardex'=>$k,'User'=>utf8_encode($this->session->get('User')), 'dep'=>$d, 'Anio'=>$Anio, "proyectos"=>$proyec,
    "ProyecNew"=>$proyecNew);
    $this->render(__CLASS__, $params);
  }

  public function requested(){
    $p = new RequisicionAnualModel();
    $count = $p->getCountMat($this->session->get('Dep'),$_POST['anio']);
    $IdUser=$this->session->get('id');
    $Type=$this->session->get('Tipo');
    foreach ($count as $r){
        $isZero = $r['contador'];
        $Proyecto = $r['IdProyecto'];
        $Meta = $r['IdMeta'];
    }
    $isExist=false;
    require_once ROOT . FOLDER_PATH .'/app/Request/RequisicionAnualRequest.php';
  }
  public function save(){
    $req = new RequisicionAnualModel();
    $aux = $req;
    $explode = explode("|", $_POST['material']);
    $proy = explode("|", $_POST['proyecto']);
    $req->IdPrograma=$_POST['id'];
    $req->IdDepartamento=$_POST['departamento'];
    $req->IdMaterial=$explode[0];
    $req->Articulo=$explode[1];
    $req->IdPartida=$explode[4];
    $req->PU=$explode[3];
    $req->UnidadMedida=$explode[2];
    $req->IdProyecto=$proy[0];
    $req->IdMeta=$proy[1];
    $req->Ene=$_POST['Enero'];
    $req->Feb=$_POST['Febrero'];
    $req->Mar=$_POST['Marzo'];
    $req->Abr=$_POST['Abril'];
    $req->May=$_POST['Mayo'];
    $req->Jun=$_POST['Junio'];
    $req->Jul=$_POST['Julio'];
    $req->Ago=$_POST['Agosto'];
    $req->Sep=$_POST['Septiembre'];
    $req->Oct=$_POST['Octubre'];
    $req->Nov=$_POST['Noviembre'];
    $req->Dic=$_POST['Diciembre'];
    if($this->session->get('Tipo')=='SuperAdmin'){
      $rs= $aux->getIdUserxDep($_POST['departamento']);
      foreach ($rs as $v) { $req->IdUsuario = $v['IdUsuario']; }
    }else{
      $req->IdUsuario=$this->session->get('id');
    }
    $req->Anio=$_POST['anio'];
    $TotalCant=0;
    $req->TotalArticulo=$TotalCant;
    $isExist=false;
    $IdU=$req->IdUsuario;
    $yr=$req->Anio;
    $dp=$req->IdProyecto;
    $Type=$this->session->get('Tipo');

    $existe=$req->getExistence($explode[0],$proy[0],$_POST['departamento'],$_POST['anio']);
    foreach ($existe as $e) { if($e['contador']>0){
        $isExist=true;
       }
     }

      if($req->IdPrograma==0){
        if(!$isExist){
          $req->add();
          $Id=$req->LastId('programa_anual_requisiciones','IdPrograma_anual');
          $req->addDetalle($Id);
        }
      }else{
        $req->update();
        $req->updateDetalle();
      }

    require_once ROOT . FOLDER_PATH .'/app/Request/RequisicionAnualRequest.php';
  }

  public function onload(){
    $Type=$this->session->get('Tipo');
    $req = new RequisicionAnualModel();
    if($this->session->get('Tipo')=='SuperAdmin'){
      $rs= $req->getIdUserxDep($_POST['opt']);
      foreach ($rs as $v) { $IdU = $v['IdUsuario']; }
    }else{
      $IdU=$this->session->get('id');
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/RequisicionAnualRequest.php';
  }

  public function validate(){
    $req = new RequisicionAnualModel();
     $isExist=false;
     $explode = explode("|", $_POST['proy']);
    $existe=$req->getExistence($_POST['material'],$explode[0],$_POST['dep'],$_POST['anio']);
    foreach ($existe as $e) {
      if($e['contador']>0){
        $isExist=true;
       }
     }

     echo json_encode($isExist);
     exit();
  }

  public function search(){
    $Type=$this->session->get('Tipo');
    $funcion = $_POST['function'];
    require_once ROOT . FOLDER_PATH .'/app/Request/RequisicionAnualRequest.php';
  }

  public function cont(){
    $funcion = $_POST['function'];
    require_once ROOT . FOLDER_PATH .'/app/Request/RequisicionAnualRequest.php';
  }
  public function Refrehs(){
    $act = new RequisicionAnualModel();
    $idUser = $_POST['idUserUp'];
    if($idUser == 0){
        $act->IdUsuario = $this->session->get('Dep');
    }else{
       $act->IdUsuario = $idUser;
    }

    $act->Anio = $_POST['anioUp'];
    $act->UpdateDate();
    header('location: '.FOLDER_PATH.'/RequisicionAnual');
  }
  public function delete(){
    $funcion = $_POST['function'];
    require_once ROOT . FOLDER_PATH .'/app/Request/RequisicionAnualRequest.php';
  }

  public function remove(){
    $act = new RequisicionAnualModel();
    $act->IdPrograma=$_POST['id'];
    $act->deleteDetalle();
    $act->delete();
    header('location: '.FOLDER_PATH.'/RequisicionAnual');
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
?>
