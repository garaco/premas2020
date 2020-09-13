<?php
require_once ROOT . FOLDER_PATH .'/app/Models/RequisicionModel.php';
require_once ROOT . FOLDER_PATH .'/app/Lib/tcpdf/tcpdf.php';

class MYPDF_OC extends TCPDF {

	//Page header
	public function Header() {
		$this->Image(ROOT ."/premas/public/img/logoItssat.png", 20, 11, 17, 17, 'PNG', '', '', false, 150, '', false, false, 1, false, false, false);
		$html='
		<table border="1">
			<tr>
				<td width="20%"></td>
				<td width="60%" style="text-align:center;"><br><h4>Formato para Oden de Compra del Bien o Servicio.</h4><br></td>
				<td width="20%" style="text-align:center;"><br><h3>Hoja: ' .$this->getAliasNumPage().' de '.$this->getAliasNbPages().'</h3></td>
			</tr>

		</table>';

		$this->SetFont('helvetica', 'B', 10);
		// Title
		$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 10, $html, $border = 0, $ln = 0, $fill = 0, $reseth = false, $align = 'C', $autopadding = false);
		$this->Cell(530, 0,'', 0, true, 'C', 0, '', 0, true, 'M', 'M');
	}
		// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);

	}
}
class MYPDF_R extends TCPDF {

	//Page header
	public function Header() {
		 $this->Image(ROOT ."/premas/public/img/logoItssat.png", 20, 11, 11, 11, 'PNG', '', '', false, 150, '', false, false, 1, false, false, false);
		$html='
			<table border="1">
			<tr>
				<td width="20%"></td>
			<td width="60%"><h4><br>Formato para Requisición de Bienes y Servicios<br></h4>
			</td>
			<td width="20%" style="text-align:center;"><br><h5>Página: ' .$this->getAliasNumPage().' de '.$this->getAliasNbPages().'</h5></td>
		</tr>
			</table>
		';

		// $y=$this->SetY(20);
		$this->SetFont('helvetica', 'B', 10);
		// Title
		$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 10, $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
		// $this->Cell(200, 0,'Hoja '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'M', 'M');
		// $this->Cell(0, 100,'', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	}
}
class MYPDF_Inv extends TCPDF {

	//Page header
	public function Header() {
		$this->Image(ROOT ."/premas/public/img/logoItssat.png", 20, 11, 17, 17, 'PNG', '', '', false, 150, '', false, false, 1, false, false, false);
		$html='
		<table border="1">
			<tr>
				<td width="20%"></td>
				<td width="60%" style="text-align:center;"><br><h4>Formato para Inventario</h4><br></td>
				<td width="20%" style="text-align:center;"><br><h3>Hoja: ' .$this->getAliasNumPage().' de '.$this->getAliasNbPages().'</h3></td>
			</tr>

		</table>';

		$this->SetFont('helvetica', 'B', 10);
		// Title
		$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 10, $html, $border = 0, $ln = 0, $fill = 0, $reseth = false, $align = 'C', $autopadding = false);
		$this->Cell(530, 0,'', 0, true, 'C', 0, '', 0, true, 'M', 'M');
	}
		// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);

	}
}

class MYPDF_RA extends TCPDF {

	//Page header
	public function Header() {
		$this->Image(ROOT ."/premas/public/img/logoItssat.png", 20, 11, 17, 17, 'PNG', '', '', false, 150, '', false, false, 1, false, false, false);
		$html='
		<table border="1">
			<tr>
				<td width="20%"></td>
				<td width="60%" style="text-align:center;"><br><h4>Programa Anual de Requisicion.</h4><br></td>
				<td width="20%" style="text-align:center;"><br><h3>Hoja: ' .$this->getAliasNumPage().' de '.$this->getAliasNbPages().'</h3></td>
			</tr>

		</table>';

		$this->SetFont('helvetica', 'B', 10);
		// Title
		$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 10, $html, $border = 0, $ln = 0, $fill = 0, $reseth = false, $align = 'C', $autopadding = false);
		$this->Cell(530, 0,'', 0, true, 'C', 0, '', 0, true, 'M', 'M');
	}
		// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);

	}
}
class MYPDF_SMC extends TCPDF {

	//Page header
	public function Header() {
		$this->Image(ROOT ."/premas/public/img/logoItssat.png", 20, 11, 11, 11, 'PNG', '', '', false, 150, '', false, false, 1, false, false, false);
		$html='
			<table border="1">
			<tr>
				<td width="20%"></td>
			<td width="60%"><h4><br>FORMATO DE SOLICITUD DE MANTENIMIENTO CORRECTIVO<br></h4>
			</td>
			<td width="20%" style="text-align:center;"><br><h5>Página: ' .$this->getAliasNumPage().' de '.$this->getAliasNbPages().'</h5></td>
		</tr>
			</table>
		';

		// $y=$this->SetY(20);
		$this->SetFont('helvetica', 'B', 10);
		// Title
		$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 10, $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
		// $this->Cell(200, 0,'Hoja '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'M', 'M');
		// $this->Cell(0, 100,'', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	}
}
class MYPDF_RRE extends TCPDF {

	//Page header
	public function Header() {
		$this->Image(ROOT ."/premas/public/img/logoItssat.png", 20, 11, 11, 11, 'PNG', '', '', false, 150, '', false, false, 1, false, false, false);
		$html='
			<table border="1">
			<tr>
				<td width="20%"></td>
			<td width="60%"><h4><br>FORMATO DE RELACION DE REQUISICIONES EJERCICIO '.date('Y').'<br></h4>
			</td>
			<td width="20%" style="text-align:center;"><br><h5>Página: ' .$this->getAliasNumPage().' de '.$this->getAliasNbPages().'</h5></td>
		</tr>
			</table>
		';

		// $y=$this->SetY(20);
		$this->SetFont('helvetica', 'B', 10);
		// Title
		$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 10, $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
		// $this->Cell(200, 0,'Hoja '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'M', 'M');
		// $this->Cell(0, 100,'', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	}
}


// create new PDF document
if ($opcion=='PDFrequisicion') {
	$pdf = new MYPDF_R(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
}elseif ($opcion=='PDFordenCompra') {
	$pdf = new MYPDF_OC(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
}elseif ($opcion=='PDFinventario') {
	$pdf = new MYPDF_Inv(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
}elseif ($opcion=='PDFreqAnual'){
	$pdf = new MYPDF_RA(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
}elseif ($opcion=='PDFsmc'){
	$pdf = new MYPDF_SMC(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
}elseif ($opcion=='PDFrelacionRBS'){
	$pdf = new MYPDF_RRE(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
}


// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle($titulo);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(7, 30, 7);
$pdf->setPrintHeader(true);
// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// // set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/spa.php')) {
	require_once(dirname(__FILE__).'/lang/spa.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
// comienza el cuerpo de los reportes
// set font
$pdf->SetFont('Helvetica', '', 8);
if ($opcion=='PDFrequisicion') {
// add a page
$pdf->AddPage();
$posicionY=0;
$html ='';
$html .= '
	<table cellpadding="5" id="tabla">

		<tr>
			<td colspan="2"><h3 style="text-align:center;">
			INSTITUTO TECNOLOGICO SUPERIOR DE SAN ANDRÉS TUXTLA</h3><h4 style="text-align:center;">REQUISICIÓN DE BIENES Y SERVICIOS</h4>
			</td>
		</tr>
		<tr>
			<td><label style="text-align:left;"><strong>FECHA DE SOLICITUD:</strong> '.$FechaRecepcion.'</label></td>
			<td><label style="text-align:rigth;"><strong>FOLIO No</strong>. '.$folioRequisicion.' </label></td>
		</tr>
		<tr>
			<td colspan="2"  style="border: 1px solid gray;"><label><strong>NOMBRE Y FIRMA DEL JEFE(A) DEL AREA SOLICITANTE:</strong> '.$solicitante.'</label></td>
		</tr>
		<tr>
			<td colspan="2" style="border: 1px solid gray;"><label><strong>FECHA ENTREGA Y AREA SOLICITANTE:</strong> '.$FechaEntrega.'  '.$departamento.'</label></td>
		</tr>
		<tr><td colspan="2">¿Los Bienes o Servicios están contemplados en el Programa Operativo Anual?<strong> SI[X] NO[ ]</strong></td></tr>
	</table>


	<br>';

$html .= '<table cellpadding="5" >
          <tr style="background-color: rgb(218,218,218); font-weight: blond; text-align: center; ">
          		<th width="16%" style="font-size: 25px; text-align: center;">PROYECTO,ACTIVIDAD Y ACCION</th>
                <th width="15%" style="font-size: 25px; text-align: center;">PARTIDA PRESUPUESTAL</th>
                <th width="10%" style="font-size: 25px; text-align: center;">CANTIDAD</th>
                <th width="10%" style="font-size: 25px; text-align: center;">UNIDAD</th>
                <th width="39%" style="font-size: 25px; text-align: center;">DESCRIPCIÓN DE LOS BIENES O SERVICIOS</th>
                <th width="10%" style="font-size: 25px; text-align: center;">COSTO ESTIMADO TOTAL + IVA</th>

          </tr>';
// $html .='<table border="1">';
foreach ($result as $r) {

$html .= '
<tr>
      <td width="16%" style="text-align: center;  border-bottom: 1px solid black;">'.$r["NumProyecto"].',  '.$r["NumMeta"].'</td>
      <td width="15%" style="text-align: center;  border-bottom: 1px solid black; font-size: 25px;">'.$r["Codigo"].'</td>
      <td width="10%" style="text-align: center;  border-bottom: 1px solid black; font-size: 25px;">'.$r["Cantidad"].'</td>
      <td width="10%" style="text-align: center;  border-bottom: 1px solid black; font-size: 25px;">'.$r["Medida"].'</td>
      <td width="39%" style="text-align: justify;  border-bottom: 1px solid black; font-size: 25px;">'.$r["Concepto"].'</td>
      <td width="10%" style="text-align: rigth;  border-bottom: 1px solid black;">$ '.$r["Costo"].'</td>

 </tr>
';
$posicionY=$posicionY+15;
}
$html .='
		<tr>
			<td colspan="5" style="text-align: rigth"><strong>TOTAL:</strong></td>
			<td style="text-align: rigth">$ '.$CostoTotal.'</td>
		</tr>
		</table>';

$html_footer ='<br>
		<footer>
		<table cellpadding="4" style="border: 1px solid gray;">
			<tr>
				<td width="20%"><strong>LO ANTERIOR PARA SER UTILIZADO EN:</strong></td>
				<td width="80%" style="text-align: justify;">'.$Concepto.'</td>
			</tr>
		</table>
		<br>
		<table>
			<tr>
				<td style="text-align:center">NOMBRE Y FIRMA
					<br>
					<br>
					<br>
					MTRA. MARLINA XALA BERDÁN
					SUBDIRECTORA DE VINCULACIÓN
				</td>
				<td style="text-align:center">NOMBRE Y FIRMA
					<br>
					<br>
					<br>
					'.$nombreResponsable.'<br>
					'.$nombrearea.'
				</td>
				<td style="text-align:center">
					NOMBRE Y FIRMA
					<br>
					<br>
					<br>
					'.$sufijo.''.$nombre.' '.$A_paterno.' '.$A_materno.'
					DIRECTOR GENERAL DEL ITSSAT
				</td>
			</tr>
		</table>
		</footer>


';
// output the HTML content
// $posicionYfinal=($posicionY > 240)?$posicionY:240;

$y = $pdf->SetY(23);
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y=240 , $html_footer, $border = 0, $ln, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);

}else if ($opcion=='PDFordenCompra') {
	$pdf->AddPage('L','A4');
	// $pdf->Image("public\img\logoItssat.png", 20, 11, 17, 17, 'PNG', '', '', false, 150, '', false, false, 1, false, false, false);
	$html='
		<table align="center">
			<tr>
				<td>INSTITUTO TECNOLOGICO SUPERIOR DE SAN ANDRÉS TUXTLA</td>
			</tr>
			<tr>
				<td>DEPARTAMENTO DE RECURSOS MATERIALES Y SERVICIOS</td>
			</tr>
			<tr>
				<td>OFICINA DE ADQUISICIONES</td>
			</tr>
			<tr>
				<td>ORDEN DE COMPRA DEL BIEN O SERVICIO</td>
			</tr>
		</table>
		<br>
		<table cellpadding="5" align="justify">
		<tr>
			<td><strong>PROVEEDOR:</strong>  '.utf8_encode($Proveerdor).'</td>
			<td style="text-align:rigth;"><strong>No. DE ORDEN DE COMPRA:</strong> '.$num_compra.'</td>

		</tr>
		<tr>
			<td> <strong>FECHA:</strong> '.$FechaPedido.'</td>
			<td style="text-align:rigth;"><strong>FECHA ENTREGA DEL BIEN O SERVICIO:</strong> '.$FechaEntrega.'</td>

		</tr>
		</table>
		<br>
	';
	$html .= '<table cellpadding="5" border="1" style="border-collapse: collapse;">
          <tr style="background-color: rgb(218,218,218); font-weight: blond; text-align: center; ">
          		<th width="10%">CANTIDAD</th>
                <th width="10%">UNIDAD</th>
                <th width="40%">DESCRIPCIÓN</th>
                <th width="10%">AREA SOLICITANTE</th>
                <th width="10%">NO.REQUISICIÓN</th>
                <th width="10%">PRECIO UNITARIO</th>
                <th width="10%">IMPORTE PARCIAL </th>

          </tr>
          ';
         foreach ($CompraDetalle as $CD) {
         	$html.='<tr>
         			<td align="center" >'.$CD["Cantidad"].'</td>
         			<td align="center">'.$CD["Medida"].'</td>
         			<td align="justify" >'.$CD["Descripcion"].'</td>
         			<td >'.$CD["departamento"].'</td>
         			<td align="center" >'.$CD["Folio"].'</td>
         			<td align="rigth" >$ '.$CD["Precio_unitario"].'</td>
         			<td align="rigth" >$ '.$CD["Importe_parcial"].'</td>
         			</tr>';
         }

    $html.='
    		<tr style="text-align: rigth;">
		    	<td colspan="7"><strong>IVA: </strong>$ '.$IVA.'</td>
		    </tr>
		    <tr style="text-align: rigth;">
		    	<td colspan="7"><strong>IMPORTE TOTAL: </strong>$ '.$ImporteTotal.'</td>
		    </tr>
		    </table>';
    $html_footer ='
		<table cellpadding="5" >
			<tr>
				<td style="text-align:center">ELABORÓ
					<br>
					<div style="height:1px; background:#717171;border-bottom:1px solid #313030;"></div>
					ING.GRISEL ESMERALDA CORTES UTRERA<br>
					OFICINA DE ADQUISICIONES
				</td>
				<td style="text-align:center">Vo.Bo
					<br>
					<div style="height:1px; background:#717171;border-bottom:1px solid #313030;"></div>
					MTI.EYROCE IVAN BUSTAMANTE CHAGALA<br>
					DEPTO DE RECURSOS MATERIALES
				</td>
				<td style="text-align:center">
					AUTORIZA
					<br>
					<div style="height:1px; background:#717171;border-bottom:1px solid #313030;"></div>
					'.$sufijo.''.$nombre.' '.$A_paterno.' '.$A_materno.'<br>
					DIRECTOR GENERAL DEL ITSSAT
				</td>
			</tr>
		</table>
		</footer>


';
	$pdf->writeHTML($html, true, false, true, false, '');
	$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 165, $html_footer, $border = 0, $ln = 2, $fill = 0, $reseth = false, $align = 'C', $autopadding = false);
}else if($opcion=='PDFinventario'){
$pdf->AddPage('L','A4');
	$html='
		<table align="center">
			<tr>
				<td>INSTITUTO TECNOLOGICO SUPERIOR DE SAN ANDRÉS TUXTLA</td>
			</tr>
			<tr>
				<td>DEPARTAMENTO DE RECURSOS MATERIALES Y SERVICIOS</td>
			</tr>
			<tr>
				<td>OFICINA DE ADQUISICIONES</td>
			</tr>
			<tr>
				<td></td>
			</tr>
		</table>
		<br>
	';
	if ($tipo == 'todo') {
		$html .= '<table cellpadding="5"  border="1" style="border-collapse: collapse;">
          <tr style="background-color: rgb(218,218,218); font-weight: blond; text-align: center; ">
          		<th width="60%">CONCEPTO</th>
                <th width="20%">UNIDAD DE MEDIDA</th>
                <th width="10%">PARTIDA</th>
                <th width="10%">EXISTENCIA</th>

          </tr>
          ';
          if($materiales->num_rows>0){
             foreach ($materiales as $mt) {

         	$html.='<tr>
         			<td align="justify">'.$mt["Concepto"].'</td>
         			<td align="center">'.$mt["Medida"].'</td>
         			<td align="center">'.$mt["Codigo"].'</td>
         			<td align="center">'.$mt["Existencia"].'</td>
         			</tr>';
         }}else{
         	$html.='<tr>
         			<td colspan="4" align="center">! NO HAY EXISTENCIA DE NINGUN MATERIAL ¡</td>

         			</tr>';
         }
$html.="</table>";
	}else{
		$html .= '<table cellpadding="5" border="1" style="border-collapse: collapse;">
          <tr style="background-color: rgb(218,218,218); font-weight: blond; text-align: center; ">
          		<th width="15%">Folio Requisición</th>
          		<th width="10%">Fecha entrega</th>
                <th width="55%">Concepto</th>
                <th width="10%">Medida</th>
                <th width="10%">Partida</th>

          </tr>
          ';
              foreach ($materiales as $mt) {
         	$html.='<tr>
         			<td align="center">'.$mt["Foliorequisicion"].'</td>
         			<td align="center">'.$mt["rdFechaEntrega"].'</td>
         			<td align="justify">'.$mt["Concepto"].'</td>
         			<td align="center">'.$mt["Medida"].'</td>
         			<td align="center">'.$mt["Codigo"].'</td>
         			</tr>';
         }
         $html.="</table>";
	}

	$pdf->writeHTML($html, true, false, true, false, '');
	$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 165, $html_footer, $border = 0, $ln = 2, $fill = 0, $reseth = false, $align = 'C', $autopadding = false);
}elseif($opcion=='PDFreqAnual'){
	$pdf->AddPage('L','A3');
		$html = '
			<table cellpadding="5" id="tabla">

				<tr>
					<td colspan="2"><h2 style="text-align:center;">'.$name.'</h2>
					</td>
				</tr>
			</table>
			<br>';

		$html.='  <table cellpadding="5" border="1" style="border-collapse: collapse;" >
		              <tr style="background-color: rgb(218,218,218); font-weight: blond; text-align: center; ">
										<th rowspan="2" width="10%">Proyecto</th>
										<th rowspan="2" width="10%">Meta</th>
										<th rowspan="2" width="10%">Partida</th>
		                <th rowspan="2" width="15%">Descipcion del Articulo</th>
		                <th rowspan="2" scope="col" class="text-center">Unidad de Medida</th>
		                <th rowspan="2" scope="col" class="text-center">Precio Unitario</th>
		                <th colspan="12" width="35%">Cantidad Mensual</th>
		                <th colspan="2" class="text-center">Total</th>
		              </tr>
		              <tr style="background-color: rgb(218,218,218); font-weight: blond; text-align: center; ">
		                <th scope="col" class="text-center">Ene</th>
		                <th scope="col" class="text-center">Feb</th>
		                <th scope="col" class="text-center">Mar</th>
		                <th scope="col" class="text-center">Abr</th>
		                <th scope="col" class="text-center">May</th>
		                <th scope="col" class="text-center">Jun</th>
		                <th scope="col" class="text-center">Jul</th>
		                <th scope="col" class="text-center">Ago</th>
		                <th scope="col" class="text-center">Sep</th>
		                <th scope="col" class="text-center">Oct</th>
		                <th scope="col" class="text-center">Nov</th>
		                <th scope="col" class="text-center">Div</th>
		                <th scope="col" class="text-center">Cantidad</th>
		                <th scope="col" class="text-center">Precio</th>
		              </tr>

		           ';

			foreach ($result as $r) {
			$html.='    <tr>
											<td class="small text-justify"> '. utf8_encode($r->Proyectos).' </td>
											<td class="small text-justify"> '. utf8_encode($r->Metas).' </td>
			                <td class="small text-justify"> '. strtoupper(utf8_encode($r->Partida)).' </td>
			                <td class="small text-justify">'. $r->Articulo.' </td>
			                <td class="text-center">'. $r->UnidadMedida.'</td>
			                <td class="text-center">'. $r->PU.'</td>
			                <td class="text-center">'. $r->Ene.'</td>
			                <td class="text-center">'. $r->Feb.' </td>
			                <td class="text-center">'. $r->Mar.' </td>
			                <td class="text-center">'. $r->Abr.' </td>
			                <td class="text-center">'. $r->May.' </td>
			                <td class="text-center">'. $r->Jun.' </td>
			                <td class="text-center">'. $r->Jul.' </td>
			                <td class="text-center">'. $r->Ago.' </td>
			                <td class="text-center">'. $r->Sep.' </td>
			                <td class="text-center">'. $r->Oct.' </td>
			                <td class="text-center">'. $r->Nov.' </td>
			                <td class="text-center">'. $r->Dic.' </td>
			                <td class="text-center">'.$r->Cantidad.' </td>
			                <td class="text-center">'."$". round($r->Total,2).' </td>
								</tr>	'	;
					}
				$html.='</table>';

		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 165, $html_footer, $border = 0, $ln = 2, $fill = 0, $reseth = false, $align = 'C', $autopadding = false);
}elseif ($opcion=='PDFsmc') {
$pdf->AddPage();
$html ='';
$html ='
	<table cellpadding="10">
		<tr>
			<td rowspan="3"><label style="text-align:rigth;"><strong>FOLIO No</strong>. '.$folio.' </label></td>

			<td  style="border: 1px solid gray;"><label><strong>RECURSOS MATERIALES Y SERVICIO</strong></label></td>

		</tr>
		<tr>
			<td  style="border: 1px solid gray;"><label><strong>MANTENIMIENTO DE EQUIPO </strong></label></td>
		</tr>
		<tr>
			<td  style="border: 1px solid gray;"><label><strong>CENTRO DE COMPUTO</strong></label></td>
		</tr>
	</table><br>';
$html .= '
	<table cellpadding="10" id="tabla">
		<tr>
			<td  style="border: 1px solid gray;"><label><strong> AREA SOLICITANTE:</strong> '.$areasolicitante.'</label></td>
		</tr>
		<tr>
			<td  style="border: 1px solid gray;"><label><strong> NOMBRE Y FIRMA DEL SOLICITANTE:</strong> '.$nombresolicitante.'</label></td>
		</tr>
		<tr>
			<td  style="border: 1px solid gray;"><label><strong>FECHA DE ELABORACION:</strong> '.$fechaElaboracion.'</label></td>
		</tr>
		<tr><td style="border: 1px solid gray;">DESCRIPCIÓN DEL SERVICIO SOLICITADO O FALLA A REPARAR</td></tr>
		<tr><td style="border: 1px solid gray;">'.$descipcion.'</td></tr>
	</table>


	<br>';
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 165, $html_footer, $border = 0, $ln = 2, $fill = 0, $reseth = false, $align = 'C', $autopadding = false);
}elseif ($opcion=='PDFrelacionRBS') {
$pdf->AddPage('L','A3');
$posicionY=0;
$html ='';
$html .= '
	<table cellpadding="5" id="tabla">

		<tr>
			<td colspan="2"><h3 style="text-align:center;">
			INSTITUTO TECNOLOGICO SUPERIOR DE SAN ANDRÉS TUXTLA</h3><h4 style="text-align:center;">DEPARTAMENTO DE RECURSOS MATERIALES</h4><h4 style="text-align:center;">RELACION DE REQUISICIONES EJERCICIO '.date('Y').'</h4>
			</td>
		</tr>
	</table>
	<br>';

$html .= '<table cellpadding="5" border="1" style="border-collapse: collapse;">
          <tr style="background-color: rgb(218,218,218); font-weight: blond; text-align: center; ">
          		<th width="10%" style="font-size: 25px; text-align: center;">N Requisición</th>
                <th width="10%" style="font-size: 25px; text-align: center;">No. de orden de compra</th>
                <th width="10%" style="font-size: 25px; text-align: center;">Fecha </th>
                <th width="10%" style="font-size: 25px; text-align: center;">Area</th>
                <th width="20%" style="font-size: 25px; text-align: center;">Solicitante</th>
                <th width="30%" style="font-size: 25px; text-align: center;">Concepto</th>
                <th width="10%" style="font-size: 25px; text-align: center;">Partida</th>

          </tr>';
// $html .='<table border="1">';
foreach ($relacion as $r) {

$html .= '
<tr>
      <td width="10%" style="text-align: center; ">'.$r["Foliorequisicion"].'</td>
      <td width="10%" style="text-align: center;  font-size: 25px;">'.$r["Num_compra"].'</td>
      <td width="10%" style="text-align: center;  font-size: 25px;">'.$r["FechaPedido"].'</td>
      <td width="10%" style="text-align: center;  font-size: 25px;">'.$r["NombreArea"].'</td>
      <td width="20%" style="text-align: center;  font-size: 25px;">'.utf8_encode($r["solicitante"]).'</td>
      <td width="30%" style="text-align: justify; ">'.$r["Concepto"].'</td>
      <td width="10%" style="text-align: center; ">'.$r["Codigo"].'</td>
 </tr>
';
		}		$html.='</table>';
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 165, $html_footer, $border = 0, $ln = 2, $fill = 0, $reseth = false, $align = 'C', $autopadding = false);
}


// ---------------------------------------------------------
ob_end_clean();
//Close and output PDF document
$pdf->Output($nombrePDF.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>
