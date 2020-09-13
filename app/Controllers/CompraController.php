<?php
defined('BASEPATH') or exit('ERROR403');
require_once ROOT . FOLDER_PATH .'/app/Models/LoginModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/RequisicionModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/CompraModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/RBSModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/MaterialModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/KardexModel.php';
require_once LIBS_ROUTE .'Session.php';

/**
 *
 */
class CompraController extends Controller
{
  private $session;
  private $model;
	function __construct()
	{
		$this->session = new Session();
	    $this->session->init();
	    $this->model = new CompraModel();
		if($this->session->get('Tipo')!='SuperAdmin')
      header('location: '.FOLDER_PATH.'/Error403');
	}
	 public function index()
	  {
	     $result = $this->model->GetAllCompra();
	     $NumOrdenCompra = $this->model->NumOrdenCompra();
	     $foliosRequisicion = $this->model->FoliosRequisicion();
	     $UltimoRegitro = $this->model->UltimoRegitro();
	     $relacionEjercicio= $this->model->relacionRBS();
       $user =  $this->model->DatoUser($this->session->get('id'),'IdUsuario');
       $user = $user->fetch_object();
	     $IDcompra="";
	     $numCompra="";

	     foreach ($UltimoRegitro as $ult) {
	     	$numCompra=$ult['id']+1;
	     }

    	 $anioActual = date('Y');
	     $folioNumCompra='OC-'.$numCompra.'-'.$anioActual;
	     $params = array('result'=> $result,'foliosRequisicion' => $foliosRequisicion,'NumOrdenCompra' => $NumOrdenCompra,'folioNumCompra'=>$folioNumCompra,'User'=>$user->Nombre_User,'relacionEjercicio'=>$relacionEjercicio);
	    $this->render(__CLASS__, $params);
	  }
	  public function save($Request)
	  {
	  	if (isset($_POST['datos'])) {
	  	$Proveerdor=$_POST['Proveerdor'];
	  	$NumCompra=$_POST['NumCompra'];
	  	$fecha=$_POST['fecha'];
	  	$fechaEntrega=$_POST['fechaEntrega'];
	  	$IVA=$_POST['iva'];
	  	$ImporteTotal=$_POST['ImporteTotal'];
	  	$arrayIdRequisicion = array();
	  	$arrayidDep = array();
	  	$arrayIdMaterial = array();
	  	$arrayCantidad = array();
	  	$arrayP_U = array();
	  	$arrayImporte_P = array();
	  	$datos=$_POST['datos'];
	  	for ($i=0; $i < count($_POST['datos']); $i++) {
	  		$arrayExplode = explode('-', $datos[$i]);
	  		$arrayIdRequisicion[$i] = $arrayExplode[0];
	  		$arrayidDep[$i] = $arrayExplode[1];
	  		$arrayIdMaterial[$i] = $arrayExplode[2];
	  		$arrayCantidad[$i] = $arrayExplode[3];
	  		$arrayP_U[$i] = $arrayExplode[4];
	  		$arrayImporte_P[$i] = $arrayExplode[5];
	  	}

	  	$ultimo = $this->model->UltimoRegitro();
	  	$ID="";
        foreach ($ultimo as $ult) {
          $numCompra=$ult['id']+1;
         }
		  	for ($i=0; $i < count($_POST['datos']); $i++) {
		  		if ($arrayCantidad[$i] == '' && $arrayP_U[$i]  == '') {
		  		return $this->renderErrorMessage("La Orden de Compra {$_POST['NumCompra']} no se guardó debido que un material no contenía CANTIDAD y/o PRECIO UNITARIO.");
		  		}
		  	}


			$this->model->addOrdenCompra($Proveerdor,$NumCompra,$fecha,$fechaEntrega,$IVA,$ImporteTotal);
			// echo 'idCompra '.$ID." Proveerdor".$Proveerdor.' NumCompra '.$NumCompra.' Fecha '.$fecha.' F_Entrega '.$fechaEntrega.' IVA '.$IVA.' ImporteTotal '.$ImporteTotal.'<br>';
			for ($i=0; $i < count($_POST['datos']); $i++) {
				$this->model->addCompra_detalle($ID,$arrayCantidad[$i],$arrayIdMaterial[$i],$arrayIdRequisicion[$i],$arrayidDep[$i],$arrayP_U[$i],$arrayImporte_P[$i]);
				// echo 'IdBitacora '.$arrayIdRequisicion[$i].'idMaterial '.$arrayIdMaterial[$i].' Cantidad '.$arrayCantidad[$i].' P_unitario '.$arrayP_U[$i].' importe '.$arrayImporte_P[$i].'<br>';
			}

	  	      $kardex = new KardexModel();
              $kardex->IdUsuario=$this->session->get('id');
              $kardex->Accion='Crear';
              $kardex->Catalogo='Orden de compra';
              $kardex->Descripcion='Realizo la orden de compra: '.$NumCompra;
              $kardex->add();
	  	}else{
	  		return $this->renderErrorMessage("La Orden de Compra {$_POST['NumCompra']} no se guardó debido que no contenía MATERIAL.");
	  	}
     header('location: '.FOLDER_PATH.'/Compra');
	  }
	  public function AgregarMaterial()
	  {

	  	try {

	  	$datos = $_POST['Id'];
	  	$arrayidOrdComp = array();
	  	$arrayidDetalleDesc = array();
	  	$arrayidDescripcion = array();
	  	$arrayCantidad = array();

	  	for ($i=0; $i < count($datos); $i++) {
	  		$arrayExplode = explode('-', $datos[$i]);
	  		$arrayidOrdComp[$i] = $arrayExplode[0];
			$arrayidDetalleDesc[$i] = $arrayExplode[1];
			$arrayidDescripcion[$i] = $arrayExplode[2];
			$arrayCantidad[$i] = $arrayExplode[3];
	  	}
	  	for ($i=0; $i < count($datos); $i++) {
	  		$material = new MaterialModel();
	  		$existencia = $material->getCantidad($arrayidDescripcion[$i]);
	  		foreach ($existencia as $k) {
	  			$nuevaCantidad = $k['Existencia']+$arrayCantidad[$i];
	 			 $material->addExistencia($arrayidDescripcion[$i],$nuevaCantidad);
	 			$this->model->updateNumEstado('compra_detalle_descripcion','IDdetalleDescripcion',$arrayidDetalleDesc[$i]);
	  		}

	  	}
	  	$getNumEstado = $this->model->getNumEstado($arrayidOrdComp[0]);
	  	if ($getNumEstado) {
	  		$cont=0; $cont1=0;
	  		foreach ($getNumEstado as $n) {
	  			if ($n['Num_estado'] == '1') {
	  				$cont++;
	  			}
	  			$cont1++;
	  		}
	  		if ($cont == $cont1) {
	  		$this->model->updateNumEstado('ordencompra','IDcompra',$arrayidOrdComp[0]);
	  		}
	  		// echo $cont.' '.$cont1;
	  	}
	  	      $kardex = new KardexModel();
              $kardex->IdUsuario=$this->session->get('id');
              $kardex->Accion='Registro';
              $kardex->Catalogo='Orden de compra';
              $kardex->Descripcion='Registro entrada de material de la orden de compra: OC-'.$arrayidOrdComp[0];
              $kardex->add();
	  	// header('location: '.FOLDER_PATH.'/Compra');
	  	 $NumOrdenCompra = $this->model->NumOrdenCompra();
	  	 if($NumOrdenCompra->num_rows > 0){
		  	 $IDcompra = array();
		  	 $Num_compra = array();
		  	 $index=0;
		  	 foreach ($NumOrdenCompra as $v) {
		  	 $IDcompra[$index] = $v['IDcompra'];
		  	 $Num_compra[$index] = $v['Num_compra'];
		  	 $index++;
		  	 }
		  	 $json= array(
		  	 	'status'=>'success',
		  	 	'IDcompra'=>$IDcompra,
		  	 	'Num_compra'=>$Num_compra
		  	 );
		  	 echo json_encode($json, JSON_FORCE_OBJECT);
	  	  }else{
	  	  	$jsonError= array('status'=>" Todas las ordenes de compra fuerón atendidas.");
	  	  	echo json_encode($jsonError, JSON_FORCE_OBJECT);
	  	  }
	  	} catch (Exception $e) {
	  		echo 'ERROR:'.$e->getMessage();
	  	}
	  }

	  public function AgregarRequisicion()
	  {
	  	$arrayExplode = explode('|', $_POST['num_requisicion']);
	  	$ID = $arrayExplode[0];
	  	$idIdDep = $arrayExplode[1];
	  	$Departamento = $arrayExplode[2];
	  	$Foliorequisicion = $arrayExplode[3];
	  	$result=$this->model->MaterialOC($ID); //obtene los material de Orden de compra
	  	// $RBS = new RBSModel();
	  	// $result = $RBS->DatoMateriales($ID); //obtiene los materiales de la requisicion
	  	require_once ROOT . FOLDER_PATH .'/app/Request/CompraRequest.php';
	  }
	  public function AlmacenarTabla()
	  {
	  	$dReqYmat=json_decode($_POST['ObjetidReqYmat'],true);
	  	$cantidad=json_decode($_POST['Objetcantidad'],true);
	  	$unidad=json_decode($_POST['Objetunidad'],true);
	  	$concepto=json_decode($_POST['Objetconcepto'],true);
	  	$precio_unitario=json_decode($_POST['Objetprecio_unitario'],true);
	  	$folioRequisicion=$_POST['folio'];
	  	$Departamento=$_POST['departamento'];
	  	$indice=json_decode($_POST['ObjetIndice'],true);
	  	$iva=json_decode($_POST['ObjetIva'],true);
	  	$c=0; $u=0; $co=0;$pu=0;$in=0; $rm=0; $iv=0;
	  	$arraycantidad = array();
	  	$arrayunidad = array();
	  	$arrayconcepto = array();
	  	$arrayprecio_unitario = array();
	  	$Importe_parcial = array();
	  	$arrayIndice = array();
	  	$arraydReqYmat = array();
	  	$arrayIva = array();
	  	foreach ($dReqYmat as $keyid => $valueid) {
	  		$arraydReqYmat[$rm] = $valueid;
	  		$rm++;
	  	}
	  	foreach ($cantidad as $key => $value) {
	  		$arraycantidad[$c]=$value;
	  		$c++;
	  	}
	  	foreach ($unidad as $key1 => $value1) {
	  		$arrayunidad[$u]=$value1;
	  		$u++;
	  	}
	  	foreach ($concepto as $key2 => $value2) {
	  		$arrayconcepto[$co]=$value2;
	  		$co++;
	  	}
	  	foreach ($precio_unitario as $key3 => $value3) {
	  		$arrayprecio_unitario[$pu]=$value3;
	  		$pu++;
	  	}
	  	for ($i=0; $i < count($precio_unitario); $i++) {
	  		if ($precio_unitario[$i] != '' && $cantidad[$i] != '') {
	  		$Importe_parcial[$i]=$precio_unitario[$i]*$cantidad[$i];
	  		}else{
	  			$Importe_parcial[$i]='<div class="alert alert-danger" style="padding: 0px;">Falto ingresar Cantidad y/o Precio Unitario</div>';
	  		}

	  	}
	  	foreach ($indice as $key4 => $value4) {
	  		$arrayIndice[$in] = $value4;
	  		$in++;
	  	}
	  	foreach ($iva as $key5 => $value5) {
	  		$arrayIva[$iv] = $value5;
	  		$iv++;
	  	}
	  	require_once ROOT . FOLDER_PATH .'/app/Request/CompraRequest.php';
	  }

	  public function EntradaMaterial()
	  {
	  	$idOrdCom = $_POST['idOrdCom'];
	  	$datosTabla = $this->model->GetCompra_detalle($idOrdCom);
	  	$datosGeneral = $this->model->GetAllCompraPDF($idOrdCom);
	  	require_once ROOT . FOLDER_PATH .'/app/Request/CompraRequest.php';
	  }
  public function ExportExcel(){
    require_once ROOT . FOLDER_PATH .'/app/Lib/PHPExcel.php';
    $objPHPExcel = new PHPExcel();

    $objPHPExcel->getProperties()
        ->setCreator("")
        ->setLastModifiedBy("")
        ->setTitle("ORDENES DE COMPRA")
        ->setSubject("Documento")
        ->setDescription("Documento generado con PHPExcel")
        ->setKeywords("excel phpexcel php")
        ->setCategory("Export");
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
      $objPHPExcel->getActiveSheet()->getStyle('A1:H5')->applyFromArray($estiloTituloReporte);
      $objPHPExcel->getActiveSheet()->getStyle('A6:H6')->applyFromArray($estiloTituloColumnas);

    $compramodel = new CompraModel();
	$resultado=$compramodel->GetAllCompraExcel();
	  $fila=7;
	  $objPHPExcel->getActiveSheet()->setCellValue('A2', 'INSTITUTO TECNOLOGICO SUPERIOR DE SAN ANDRÉS TUXTLA');
	  $objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
	  $objPHPExcel->getActiveSheet()->setCellValue('A3', 'DEPARTAMENTO DE RECURSOS MATERIALES');
	  $objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
	  $objPHPExcel->getActiveSheet()->setCellValue('A4', 'ORDENES DE COMPRA');
	  $objPHPExcel->getActiveSheet()->mergeCells('A4:H4');
	  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(70);
	  $objPHPExcel->getActiveSheet()->setCellValue('A6', 'Proveerdor');
	  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
	  $objPHPExcel->getActiveSheet()->setCellValue('B6', 'Servicio');
	  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
	  $objPHPExcel->getActiveSheet()->setCellValue('C6', 'RFC');
	  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(60);
	  $objPHPExcel->getActiveSheet()->setCellValue('D6', 'Domicilio');
	  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
	  $objPHPExcel->getActiveSheet()->setCellValue('E6', 'No. de orden de compra');
	  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
	  $objPHPExcel->getActiveSheet()->setCellValue('F6', 'Fecha pedido');
	  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
	  $objPHPExcel->getActiveSheet()->setCellValue('G6', 'Fecha entrega');
	  $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
	  $objPHPExcel->getActiveSheet()->setCellValue('H6', 'Importe total');

	  while($row = $resultado->fetch_assoc()){
	    $objPHPExcel->setActiveSheetIndex(0);
	    $objPHPExcel->getActiveSheet()->setTitle('Hoja 1');


	    $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['Nombre']);
	    $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['ActComercial']);
	    $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['RFC']);
	    $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['Domicilio']);
	    $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['Num_compra']);
	    $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['FechaPedido']);
	    $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['FechaEntrega']);
	    $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, '$'.$row['ImporteTotal']);

	    $fila++;
	  }
	  $date=date("Y-m-d");
	  $filename="ORDENES_COMPRA-".$date.".xls";
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A7:H".$fila);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
  }
  public function ExportExcelRRE(){
    require_once ROOT . FOLDER_PATH .'/app/Lib/PHPExcel.php';
    $objPHPExcel = new PHPExcel();

    $objPHPExcel->getProperties()
        ->setCreator("")
        ->setLastModifiedBy("")
        ->setTitle("ORDENES DE COMPRA")
        ->setSubject("Documento")
        ->setDescription("Documento generado con PHPExcel")
        ->setKeywords("excel phpexcel php")
        ->setCategory("Export");
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
      $objPHPExcel->getActiveSheet()->getStyle('A1:G5')->applyFromArray($estiloTituloReporte);
      $objPHPExcel->getActiveSheet()->getStyle('A6:G6')->applyFromArray($estiloTituloColumnas);


    $compramodel = new CompraModel();
	$resultado=$compramodel->relacionRBS();
	  $fila=7;
	  $objPHPExcel->getActiveSheet()->setCellValue('A2', 'INSTITUTO TECNOLOGICO SUPERIOR DE SAN ANDRÉS TUXTLA');
	  $objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
	  $objPHPExcel->getActiveSheet()->setCellValue('A3', 'DEPARTAMENTO DE RECURSOS MATERIALES');
	  $objPHPExcel->getActiveSheet()->mergeCells('A3:G3');
	  $objPHPExcel->getActiveSheet()->setCellValue('A4', 'RELACION DE REQUISICIONES EJERCICIO '.date('Y'));
	  $objPHPExcel->getActiveSheet()->mergeCells('A4:G4');
	  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
	  $objPHPExcel->getActiveSheet()->setCellValue('A6', 'N Requisición');
	  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
	  $objPHPExcel->getActiveSheet()->setCellValue('B6', 'No. de orden de compra');
	  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
	  $objPHPExcel->getActiveSheet()->setCellValue('C6', 'Fecha');
	  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
	  $objPHPExcel->getActiveSheet()->setCellValue('D6', 'Area');
	  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
	  $objPHPExcel->getActiveSheet()->setCellValue('E6', 'Solicitante');
	  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
	  $objPHPExcel->getActiveSheet()->setCellValue('F6', 'Concepto');
	  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
	  $objPHPExcel->getActiveSheet()->setCellValue('G6', 'Partida');

	  while($row = $resultado->fetch_assoc()){
	    $objPHPExcel->setActiveSheetIndex(0);
	    $objPHPExcel->getActiveSheet()->setTitle('Hoja 1');


	    $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['Foliorequisicion']);
	    $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['Num_compra']);
	    $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['FechaPedido']);
	    $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['NombreArea']);
	    $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['solicitante']);
	    $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['Concepto']);
	    $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['Codigo']);

	    $fila++;
	  }
  	$date=date("Y-m-d");
  	$filename="RELACION_DE_REQUISICIONES_EJERCICIO-".$date.".xls";
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A7:G".$fila);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
  }
	  public function renderErrorMessage($message)
	  {
	  	 $result = $this->model->GetAllCompra();
	     $NumOrdenCompra = $this->model->NumOrdenCompra();
	     $foliosRequisicion = $this->model->FoliosRequisicion();
	     $params = array('error_message' => $message,'result'=> $result,'foliosRequisicion' => $foliosRequisicion,'NumOrdenCompra' => $NumOrdenCompra);
	    // $params = array();
	    $this->render(__CLASS__, $params);
	  }
}

 ?>
