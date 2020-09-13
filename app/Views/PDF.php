<?php
defined('BASEPATH') or exit('ERROR403');
        if ($total == 0) {
          echo '<script>alert("\u2716  En el rango de fechas que ingreso no hay datos");</script>';
           echo '<script>history.back(-1)</script>';

        }else{
// require_once ROOT . FOLDER_PATH .'/app/Models/RequisicionModel.php';
require_once ROOT . FOLDER_PATH .'/app/Lib/tcpdf/tcpdf.php';
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('PDF Solicitud de pago');

// set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(5, 20, 5);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)

// ---------------------------------------------------------

// set font
$pdf->SetFont('Helvetica', '', 7);
// add a page
$pdf->AddPage('L','A4');

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
$html ="";
$html .= '
<table cellpadding="8">
<tr>
    <td colspan="2"><h1 style="text-align:center;">INSTITUTO TECNOLOGICO SUPERIOR DE SAN ANDRÉS TUXTLA</h1></td>
</tr>
<tr>
    <td><h2 style="text-align:left;">Reporte: Solicitudes de pago</h2></td>
    <td><h3 style="text-align:rigth;">Desde: '.$fechaDesde.' hasta: '.$fechaHasta.'</h3></td>
</tr>
<tr>
    <td colspan="2"><h3 style="text-align:rigth;">Total de solicitudes: '.$total.'</h3></td>
</tr>
</table>
        
        
        

      <table cellpadding="5" style="border: 1px solid gray;">
          <tr style="background-color: rgb(218,218,218); font-weight: blond; text-align: center; ">
                <th width="10%">Proveedor</th>
                <th width="20%">Concepto</th>
                <th width="10%">Monto</th>
                <th width="10%">Fecha  solicitud</th>
                <th width="10%">Revisado</th>
                <th width="10%">Autorizado a pagar</th>
                <th width="10%">Fecha de autorizado</th>
                <th width="10%">Estado</th>
                <th width="10%">Fecha del pago</th>

          </tr>';

    foreach ($resultado as $r){     
    $html .= '
        <tr>
            <td width="10%" style="text-align:justify; border-bottom: 1px solid #ddd;">'.$r['Proveedor'].'</td>
            <td width="20%" style="text-align:justify; border-bottom: 1px solid #ddd;">'.$r['Concepto'].'</td>
            <td width="10%" style="text-align:center; border-bottom: 1px solid #ddd;">'.'$ '.$r['Monto'].'</td>
            <td width="10%" style="text-align:center; border-bottom: 1px solid #ddd;">'. $r['FechaSolicitud'].'</td>
            <td width="10%" style="text-align:center; border-bottom: 1px solid #ddd;">'.$r['Revisado'].'</td>
            <td width="10%" style="text-align:center; border-bottom: 1px solid #ddd;">'.$r['AutorizadoPago'].'</td>
            <td width="10%" style="text-align:center; border-bottom: 1px solid #ddd;">'. $r['FechaAutorizado'].'</td>
            <td width="10%" style="text-align:center; border-bottom: 1px solid #ddd;">'.$r['estado'].'</td>
            <td width="10%" style="text-align:center; border-bottom: 1px solid #ddd;">'.$r['FechaPago'].'</td>
        </tr>
    ';
    }

$html .= '</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('SolicitudPago.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
 }
?>
