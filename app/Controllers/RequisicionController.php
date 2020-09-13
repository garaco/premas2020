<?php
defined('BASEPATH') or exit('ERROR403');
 require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/LoginModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/RequisicionModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/BitacoraModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/MaterialModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/RBSModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/RequisicionAnualModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/KardexModel.php';
require_once LIBS_ROUTE .'Session.php';

/**
* Main controller
*/
class RequisicionController extends Controller
{
  private $session;
  private $model;
  private $Material;
  private $ano;

  public function __construct()
  { $this->ano=date('Y');
    $this->Material = new MaterialModel();
    $this->session = new Session();
    $this->model = new RequisicionModel();
    $this->session->init();
    if($this->session->get('Tipo')!='SuperAdmin'){
      header('location: '.FOLDER_PATH.'/Error403');
    }
  }

  public function index()
  {
    $Foliorequisicion = $this->model->folioReq();
    $result = $this->model->getJoinAll();
    $user = $this->model->DatoUser($this->session->get('id'),'IdUsuario');
    $user = $user->fetch_object();
    $params = array('result'=> $result,'Foliorequisicion'=>$Foliorequisicion,'User'=>$user->Nombre_User);
    $this->render(__CLASS__, $params);
  }


  public function save($request){
     if($this->verify($request)){
        header('location:'.FOLDER_PATH.'/Requisicion');
     }else{
      if ($request['btn_Guardar'] == 0) {
         $Num_estado=0;
         if (isset($request['Enviar'])) {
           if ($request['Enviar'] == 'SI') {
            $Num_estado=1;
            }
             $this->model->update($request['id'],$request["monto"],$request["freporte"],$Num_estado);
              $kardex = new KardexModel();
              $kardex->IdUsuario=$this->session->get('id');
              $kardex->Accion='Enviar';
              $kardex->Catalogo='Bitacora';
              $kardex->Descripcion='Envio la requisición RBS-'.$request['id'].'-'.$this->ano.' a Dirección General';
              $kardex->add();
          }
      }else{
          if (isset($request['idMaterial'])) {
            $IdBitacora=$request['id'];
            $num_fila=count($request['idMaterial']);
            $idMaterial=$request['idMaterial'];
            $IdRequisicionDetalle=$request['IdRequisicionDetalle'];
            $arrayExistencia = array();
            $arrayCantidad = array();
            $arrayIDmaterial = array();
            $resultado;
            $this->resultado = new MaterialModel();
            $materiales = new RBSModel();
            $indice=0;
            $diferencia=0;
            $result = $this->resultado->CantidadMaterial($request['id']);
              foreach ($result as $r) {
                  $arrayCantidad[$indice] = $r['Cantidad'];
                  $arrayExistencia[$indice] = $r['Existencia'];
                  $arrayIDmaterial[$indice] = $r['IDmaterial'];
                  $indice++;
                }
              for ($i=0; $i < $num_fila; $i++) {
                for ($j=0; $j < count($arrayIDmaterial); $j++) {
                  if ($idMaterial[$i] == $arrayIDmaterial[$j]) {
                    if ($arrayExistencia[$j] >= $arrayCantidad[$j]) {
                      $prueba=new MaterialModel();
                      $diferencia = $arrayExistencia[$j]-$arrayCantidad[$j];
                      $prueba->OutExistencia($idMaterial[$i],$diferencia);
                      $materiales->updateNum_estado($IdRequisicionDetalle[$j],DATE);
                      }

                  }
                }
              }
              $EstadoMaterial=$materiales->EstadoMaterial($IdBitacora);
              foreach ($EstadoMaterial as $value) {
               if ($value['estado1'] == $value['countrow']) {
                  $objReqModel = new RequisicionModel();
                  $objReqModel->UpdateStatus($IdBitacora);
               }
              }
          }
      }
  }
  header('location:'.FOLDER_PATH.'/Requisicion');
}
  public function Existencia($IDmaterial,$resultado)
  {
    $modelmaterial=new MaterialModel();
    $modelmaterial->OutExistencia($IDmaterial,$resultado);
  }
  //metodo que enlaza la parte de la vista con el request este metodo se
  //se manda a llamar desde el archivo request.js
  public function requested(){
      $ID=" ";
      $Foliorequisicon="";
      $fechaRecepcion="";
      $FechaReporte="";
      $IdDep="";
      $IdSolicitante="";
      $Concepto="";
      $costo="";
      $FechaAutorizacion="";
      $estado="";
      $FechaAatencion="";
      $Archivo="";
      $Status="";
      $fecha_entrega="";
      $num_estado=""; //si se encuentra en 0 es porque aun se encuentra en cotizacion
      $result = $this->model->getById('IdBitacora',$_POST['id']);
      $materiales = new RBSModel();
      $datoMaterial = $materiales->DatoMateriales($_POST['id']);
        foreach ($result as $r) {
          $ID=$r['IdBitacora'];
          $Foliorequisicon=$r['Foliorequisicion'];
          $fechaRecepcion = $r["FechaRecepcion"];
          $FechaReporte = $r["FechaReporte"];
          $IdDep = $r["IdDep"];
          $IdSolicitante=$r["IdSolicitante"];
          $Concepto =$r["Concepto"];
          $costo =$r["Costo"];
          $FechaAutorizacion =$r["FechaAutorizacion"];
          $estado =$r["Estado"];
          $FechaAatencion =$r["FechaAatencion"];
          $Status=$r["Estatus"];
          $fecha_entrega=$r['FechaEntrega'];
          $num_estado = $r['Num_estado'];
        }



    require_once ROOT . FOLDER_PATH .'/app/Request/RequisicionesRequest.php';
  }
  public function Advertencia()
  {
     // $this->Material = new MaterialModel();
     $result = $this->Material->CantidadMaterial($_POST['id']);
      require_once ROOT . FOLDER_PATH .'/app/Request/RequisicionesRequest.php';
  }

  // funcion para cancelar la requisicion
  public function Cancel()
  {
    $arrayMes= explode('|',ArrayMes);

    $RBS = new RBSModel();
    $programaAnual = new RequisicionAnualModel();
    $arrayExplode = explode('|', $_POST['ID']);
    $IdBitacora = $arrayExplode[0];
    $idDepart = $arrayExplode[1];
    $mes= $arrayExplode[2];
    $f_recepcion = $arrayExplode[3];
    $arrayCantidad = array(); //es = a la cantidad en numero, ejemplo: 1, 2 ,3 , etc
    $arrayDescripcion = array();//es el id del material
    $arrayProyecto = array();
    $arrayMeta = array();
    $indice = 0;
    $fecha=strtotime($f_recepcion);
    $m=date('m',$fecha); //numero del mes de la fecha que solicito la req.
    $mm=($m == 10) ? $m: str_replace('0','', $m);
    $mesF = $arrayMes[$mm-1]; //nombre del mes de la fecha que solicito la req.
    $user = $RBS->DatoUser($idDepart,'IdDepartamento');
    $IdUsuario;
    foreach ($user as $u) {
      $IdUsuario=$u['IdUsuario'];
    }

    $consulta = $this->model->getMateriales($IdBitacora);
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
            $TotalArticulo=$c[$mes]+$arrayCantidad[$i];
                                      //$IdMaterial,$IdUsuario,$TotalArticulo,$IdMeta,$idProyecto,$mes
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


      $this->model->deleteRequisicion('bitacora','IdBitacora',$IdBitacora);

      $kardex = new KardexModel();
      $kardex->IdUsuario=$this->session->get('id');
      $kardex->Accion='Cancelar';
      $kardex->Catalogo='Requisicion';
      $kardex->Descripcion='Cancelo la requisicion RBS-'.$IdBitacora.'-'.$this->ano;
      $kardex->add();
      header('location: '.FOLDER_PATH.'/Requisicion');
  }

  public function search(){
    $funcion = $_POST['function'];
      if(empty($funcion)){
        header('location: '.FOLDER_PATH.'/Requisicion');
      }
      // echo $_POST['dateRequi'];
      $result = $this->model->getJoinAll();
      if (!empty($_POST['id'])) {
        $result = $this->model->getJoinAllDepar($_POST['id']);
      }

      if (!empty($_POST['dateRequi'])) {
        $result = $this->model->getSearchBit('Foliorequisicion',$_POST['dateRequi']);
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
    require_once ROOT . FOLDER_PATH .'/app/Request/RequisicionesRequest.php';
  }

  public function show($params){
    header('content-type: application/pdf');
    readfile(PATH_FILES.$params['file']);
  }

  public function llenar(){
      $funcion = $_POST['function'];
      if(empty($funcion)){
        header('location: '.FOLDER_PATH.'/Requisicion');
      }
      $result = $this->model->obtener();
       if (!empty($_POST['estado'])) {
      $result = $this->model->obtener2('Estado',$_POST['estado']);
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/RequisiconesRequest.php';
  }

    public function saveDATE(){
      $this->model->updateDATE($_POST['id'],$_POST['fecha']);
     header('location: '.FOLDER_PATH.'/Requisicion');
  }
    public function departamento(){
     $this->model = new  DepartamentoModel();
    $result = $this->model->getJoin('idDepart');
    if (!empty($_POST['depa'])) {
      $result = $this->model->getJoin2('idDepart',$_POST['depa']);
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/RequisicionesRequest.php';
  }
  public function filto_ano()
  {
    $ano = $_POST['boton_ano'];
    $result = $this->model->Requisicion_All_ano($ano);
   require_once ROOT . FOLDER_PATH .'/app/Request/RequisicionesRequest.php';
  }
  public function pagination(){
    $funcion = $_POST['function'];
    $result = $this->model->getJoinAll(($_POST['page']),($_POST['fin']));
    require_once ROOT . FOLDER_PATH .'/app/Request/RequisicionesRequest.php';
  }

  public function export()
  {
    $id=$_POST['id'];
    require_once ROOT . FOLDER_PATH .'/app/Request/RequisicionesRequest.php';
  }
  public function Exportar($parame){
    require_once ROOT . FOLDER_PATH .'/app/Lib/PHPExcel.php';
    $objPHPExcel = new PHPExcel();

    $objPHPExcel->getProperties()
        ->setCreator("Códigos de Programación")
        ->setLastModifiedBy("Códigos de Programación")
        ->setTitle("Bitacora de Relaciones")
        ->setSubject("Documento de prueba")
        ->setDescription("Documento generado con PHPExcel")
        ->setKeywords("excel phpexcel php")
        ->setCategory("Ejemplos");
      $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
      $objDrawing->setName('Logotipo');

        $estiloTituloReporte = array(
        'font' => array(
        'name'  => 'Arial',
        'bold' => true,
        'italic' => false,
        'strike' => false,
        'size' =>12
          ),
          'fill' => array(
        'type'  => PHPExcel_Style_Fill::FILL_SOLID
        ),
          'borders' => array(
        'allborders' => array(
        'style' => PHPExcel_Style_Border::BORDER_NONE
        )
          ),
          'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
          )
        );
            $estiloTituloColumnas = array(
      'font' => array(
      'name' => 'Arial',
      'bold' => true,
      'size' =>9,
      'color' => array(
      'rgb' => 'FFFFFF'
      )
      ),
      'fill' => array(
      'type' => PHPExcel_Style_Fill::FILL_SOLID,
      'color' => array('rgb' => '4682B4')
      ),
      'borders' => array(
      'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
      )
      ),
      'alignment' => array(
      'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      )
      );
        $estiloInformacion = new PHPExcel_Style();
        $estiloInformacion->applyFromArray( array(
          'font' => array(
        'name'  => 'Arial',
           'size' =>8,
        'color' => array(
        'rgb' => '000000'
        )
          ),
          'fill' => array(
        'type'  => PHPExcel_Style_Fill::FILL_SOLID
        ),
          'borders' => array(
        'allborders' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
        )
          ),
        'alignment' =>  array(
        'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
          )
        ));
      $objPHPExcel->getActiveSheet()->getStyle('A1:I4')->applyFromArray($estiloTituloReporte);
      $objPHPExcel->getActiveSheet()->getStyle('A5:I5')->applyFromArray($estiloTituloColumnas);



  $resultado="";
  if ($parame["id"] == 2) {
    $resultado = $this->model->exportaDato($_POST['selectEstado'],$_POST['FechaDesde'],$_POST['FechaHasta']);
  }
  else if ($parame["id"] == 3) {
     $resultado = $this->model->getJoinAllDATE($_POST['fechaDesde'],$_POST['fechaHasta']);
  }
  else {
     $resultado = $this->model->obtener();

    }

  $fila=6;

  $objPHPExcel->getActiveSheet()->setCellValue('A2', 'DEPARTAMENTO DE RECURSOS MATERIALES');
  $objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
  $objPHPExcel->getActiveSheet()->setCellValue('A3', 'RELACION DE REQUISICION DEL BIEN O SERVICIO POR AUTORIZAR');
  $objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
  $objPHPExcel->getActiveSheet()->setCellValue('A5', 'No de Requisición');
  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
  $objPHPExcel->getActiveSheet()->setCellValue('B5', 'Costo');
  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
  $objPHPExcel->getActiveSheet()->setCellValue('C5', 'Fecha Recepcion');
  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
  $objPHPExcel->getActiveSheet()->setCellValue('D5', 'Fecha Reporte');
  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
  $objPHPExcel->getActiveSheet()->setCellValue('E5', 'Area');
  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
  $objPHPExcel->getActiveSheet()->setCellValue('F5', 'Solicitante');
  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(35);
  $objPHPExcel->getActiveSheet()->setCellValue('G5', 'Concepto');
  $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
  $objPHPExcel->getActiveSheet()->setCellValue('H5', 'Estado');
  $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
  $objPHPExcel->getActiveSheet()->setCellValue('I5', 'Estatus');

  while($row = $resultado->fetch_assoc()){
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle('Hoja 1');


    $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['Foliorequisicion']);
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, '$'.$row['Costo']);
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['FechaRecepcion']);
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['FechaReporte']);
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['nombreDepto']);
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['Nombre'].' '.$row['A_paterno'].' '.$row['A_materno']);
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['Concepto']);
    $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['Estado']);
    $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $row['Estatus']);

    $fila++;
  }
$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A6:I".$fila);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Excel.xls"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
  }

  private function verify($request)
  {
    return empty($request['id']);
  }
    public function renderErrorMessage($message)
  {
    $Foliorequisicion = $this->model->Foliorequisicion();
    $result = $this->model->getJoinAll(0,20);
    $c=$this->model->getCount();
    $p = round($c->num_rows/21) + ($c->num_rows%21 < 10 ? 1 : 0);
    $params = array('error_message' => $message,'result'=> $result,'pag'=>$p,'cant'=>$c->num_rows,'Foliorequisicion'=>$Foliorequisicion);
    $this->render(__CLASS__, $params);
  }
  public function logout()
  {
    $this->session->close();
    header('location: '.FOLDER_PATH.'/login');
  }

}
?>
