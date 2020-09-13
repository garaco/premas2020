<?php

require_once ROOT . FOLDER_PATH .'/app/Models/LoginModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/MainModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/RequisicionModel.php';
require_once LIBS_ROUTE .'Session.php';

/**
* Main controller
*/
class MainController extends Controller
{
  private $session;
  private $model;

  public function __construct()
  {
    $this->session = new Session();
    $this->model = new MainModel();
    $this->session->init();
    if($this->session->get('Tipo')!='SuperAdmin')
      header('location: '.FOLDER_PATH.'/Error403');
  }

  public function index()
  {
    $total= $this->model->getAllRequisicion();
    $NoAutorizado= $this->model->getNoAutorizada();
    $Autorizado= $this->model->getAutorizada();
    $Atendida= $this->model->getAtendida();
    $Foliorequisicion = $this->model->folioReq();
    $params = array('totalr' => $total,'NoAutorizado' => $NoAutorizado,'Autorizado' => $Autorizado,
    'Atendida' => $Atendida,'User'=>$this->session->get('User'),'Foliorequisicion'=>$Foliorequisicion);
    $this->render(__CLASS__, $params);
  }
public function requested()
{
  $tipoEstatus=$_POST['valorBoton'];
  $req=new RequisicionModel();
  $result="";
  switch ($tipoEstatus) {
    case 'Realizadas':
     $result=$req->getJoinAll();
      break;

    case 'Autorizadas':
      $result=$req->getJoinBitacora('AUTORIZADO');
      break;
    case 'NoAutorizadas':
      $result=$req->getJoinBitacora('NO AUTORIZADO');
      break;
    case 'Atendidas':
      $result=$req->getJoinBitacora('ATENDIDA');
      break;
  }
    require_once ROOT . FOLDER_PATH .'/app/Request/MainRequest.php';

}

  public function logout()
  {
    $this->session->close();
    header('location: '.FOLDER_PATH.'/Login');
  }

}
