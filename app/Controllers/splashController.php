<?php 
/**
  * 
  */
require_once LIBS_ROUTE .'Session.php';
 class splashController extends Controller
 {
 	
  public function __construct()
  { 
  	// $this->ano=date('Y');
    // $this->Material = new MaterialModel(); 
    $this->session = new Session();
    // $this->model = new RequisicionModel();
    $this->session->init();
    if($this->session->get('Tipo') != "Normal"){
      header('location: '.FOLDER_PATH.'/Error403');
    }
  }

  public function index()
  {
  	$pagina='Main';
    // $Foliorequisicion = $this->model->folioReq();
    // $result = $this->model->getJoinAll();
    $params = array('pagina'=> $pagina);
    $this->render(__CLASS__,$params );
  }

 } ?>