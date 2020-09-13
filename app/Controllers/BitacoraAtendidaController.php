<?php
defined('BASEPATH') or exit('ERROR403');

require_once ROOT . FOLDER_PATH .'/app/Models/BitacoraAtendidoModel.php';
require_once LIBS_ROUTE .'Session.php';

class BitacoraAtendidaController extends Controller
{
  private $session;
  private $model;

  public function __construct()
  {
    $this->session = new Session();
    $this->model = new BitacoraAtendidoModel();
    $this->session->init();
    if($this->session->get('Tipo')!='Admin')
      header('location: '.FOLDER_PATH.'/Error403');
  }

  public function index()
  {
    $result = $this->model->Atendidas();
    $params = array('result'=> $result);
    $this->render(__CLASS__,$params);
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

    public function search(){
      $funcion = $_POST['function'];
      if(empty($funcion)){
        header('location: '.FOLDER_PATH.'/BitacoraAtendida');
      }
      $result = $this->model->Atendidas();
      if (!empty($_POST['id'])) {
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
    require_once ROOT . FOLDER_PATH .'/app/Request/BitacoraAtendidaRequest.php';
  }
  private function verify($request)
  {
    return empty($request["id"]);
  }

}
