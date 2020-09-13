<?php
defined('BASEPATH') or exit('ERROR403');
require_once ROOT . FOLDER_PATH .'/app/Models/RBSModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/RequisicionAnualModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/CompraModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/MaterialModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/SMCModel.php';
require_once LIBS_ROUTE .'Session.php';

class VisualizaController extends Controller
{
  private $session;
  private $model;
  // private $modelOrdenCompra;

  public function __construct()
  {
    $this->session = new Session();
    $this->model = new RBSModel();

    $this->session->init();
    if(empty($this->session->get('Tipo'))){
      header('location: '.FOLDER_PATH.'/Error403');
    }
  }
    public function index()
  {
    $this->render(__CLASS__);

  }
   public function pdf()
  {
    $ID=" "; $folioRequisicion=""; $FechaRecepcion=""; $departamento=""; $solicitante=""; $Concepto=""; $CostoTotal=""; $FechaEntrega=""; $sufijo=""; $nombre=""; $A_paterno=""; $A_materno="";

    $Proveerdor=''; $num_compra=''; $FechaPedido=''; $FechaEntrega=''; $IVA=''; $ImporteTotal='';
    $nombrearea=""; $nombreResponsable="";

    $opcion=isset($_POST['num'])?$_POST['num']:'';
    $nombrePDF='';
    $director = $this->model->DatoDirector();
    $firmante2 = $this->model->datoResponsableArea($_POST["file"]);
    foreach ($director as $d) {
         $sufijo=$d["Subfijo"];
         $nombre=$d["Nombre"];
         $A_paterno=$d["A_paterno"];
         $A_materno=$d["A_materno"];
       }
    foreach ($firmante2 as $value) {
      $nombrearea=$value["NombreArea"];
      $nombreResponsable=$value["Responsable"];
    }
    // var_dump($nombre.' '.$A_paterno);
    // exit;
    switch ($opcion) {
      case 'PDFrequisicion':
       $result = $this->model->DatoMateriales($_POST["file"]);
       $dato = $this->model->DatoGeneral($_POST["file"]);

       $titulo='Requisición';
       foreach ($dato as $d) {
          $folioRequisicion=$d["Foliorequisicion"];
          $FechaRecepcion=$d["FechaRecepcion"];
          $departamento=$d["nombreDepto"];
          $solicitante=$d["Subfijo"].$d["Nombre"].' '.$d["A_paterno"].' '.$d["A_materno"];
          $Concepto=$d["Concepto"];
          $CostoTotal=$d["Costo"];
          $FechaEntrega=$d["FechaEntrega"];
       }

       $nombrePDF=$folioRequisicion;
        break;

      case 'PDFordenCompra':

        $modelOrdenCompra = new CompraModel();
        $result = $modelOrdenCompra->GetAllCompraPDF($_POST["file"]);
        $CompraDetalle = $modelOrdenCompra->GetCompra_detallePDF($_POST["file"]);

        foreach ($result as $r) {
          $Proveerdor=$r['Nombre'];
          $num_compra=$r['Num_compra'];
          $FechaPedido=$r['FechaPedido'];
          $FechaEntrega=$r['FechaEntrega'];
          $IVA=$r['Iva'];
          $ImporteTotal=$r['ImporteTotal'];
        }
        $titulo='Orden compra';
        $nombrePDF=$num_compra;
        break;
        case 'PDFinventario':
        $tipo=isset($_POST['tipo'])?$_POST['tipo']:'';// se refiere si se exportara por todo o solo los entregados
        $anio_actual=DATE;
        $reporte='Reporte_Inventario_'.$anio_actual;
        $material = new MaterialModel();
        $materiales = ($tipo=='todo')?$material->PDFexistencia():$material->PDFmaterialEntregado();
        $titulo='Invetario';
        $nombrePDF=$reporte;
        break;
        case 'PDFreqAnual':
        $tipo=isset($_POST['tipo'])?$_POST['tipo']:'';// se refiere si se exportara por todo o solo los entregados
        $anio=isset($_POST['anio'])?$_POST['anio']:'';
        $dep=isset($_POST['dep'])?$_POST['dep']:'';
        $anio_actual=DATE;

        if($dep==''){$dep=$this->session->get('Dep');}
        $reporte='Requisición_Anual_'.$anio;
        $req = new RequisicionAnualModel();
        if ($tipo=='proyeccion'){
          $titulo='Requisición Anual Inicial';
          $name=' Programa Anual Inicial de Requiscion '.$anio;
            $result=$req->getUserReqAllInicial($dep,$anio);

        }else if($tipo=='Real'){
          $titulo='Requisición Anual Actual';
          $name=' Programa Anual Actual de Requiscion '.$anio;
          $result=$req->getUserReqAll($dep,$anio);

        }

        $nombrePDF=$reporte;
        break;
        case 'PDFsmc':
        $smc = new SMCModel();
        $result = $smc->getOneSMC($_POST["file"]);
        $folio="";
        $areasolicitante="";
        $nombresolicitante="";
        $fechaElaboracion="";
        $descipcion="";
        foreach ($result as $k) {
          $folio=$k['Folio'];
          $areasolicitante=$k['nombreDepto'];
          $nombresolicitante=$k['Subfijo'].$k['Nombre'].' '.$k['A_paterno'].' '.$k['A_materno'];
          $fechaElaboracion=$k['FechaRecepcion'];
          $descipcion=$k['Concepto'];
        }
         $titulo='SMC';
        $nombrePDF=$folio;
          break;
          case 'PDFrelacionRBS':
            $modeloc=new CompraModel();
            $relacion=$modeloc->relacionRBS();
            $titulo='RELACION DE REQUISICIONES EJERCICIO';
            $nombrePDF='RELACION DE REQUISICIONES EJERCICIO '.date('Y');
          break;
    }
     require_once ROOT . FOLDER_PATH .'/app/Views/visualiza.php';

  }

}
 ?>
