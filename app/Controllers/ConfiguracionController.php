<?php
require_once ROOT . FOLDER_PATH .'/app/Models/KardexModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/ConfiguracionModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/KardexModel.php';
require_once LIBS_ROUTE .'Session.php';

class ConfiguracionController extends Controller
{
  private $session;

  public function __construct()
  {
    $this->session = new Session();
    $this->session->init();
    if($this->session->get('Tipo')!='SuperAdmin'){
      header('location: '.FOLDER_PATH.'/Error403');
    }
  }
  public function index()
  {
    $k = new KardexModel();
    $k = $k->getSQL();

    $conf = new ConfiguracionModel();
    $result = $conf->getSQL();

    $user = $conf->DatoUser($this->session->get('id'),'IdUsuario');
    $user = $user->fetch_object();

    $params = array('result'=> $result,'Kardex'=>$k,'User'=>$user->Nombre_User);
    $this->render(__CLASS__, $params);
  }

  public function save(){

    $conf = new ConfiguracionModel();
    $conf->IdConfiguracion=$_POST['id'];
    $conf->Descripcion=$_POST['des'];
    $conf->FechaInicio=$_POST['Inicio'];
    $conf->FechaFinal=$_POST['Final'];
    $conf->Usuario=$this->session->get('id');
    $conf->Anio=$_POST['Anio'];

    if($_POST['id']==0){
      $conf->add();
    }else{
      $conf->update();
    }

    $kardex = new KardexModel();
    $kardex->IdUsuario=$this->session->get('id');
    if($_POST['id']==0){
      $kardex->Accion='Agrego';
      $kardex->Descripcion="Se agrego un nuevo rango de dias para realizar las requisicones anuales";
    }else{
      $kardex->Accion='Edito';
      $kardex->Descripcion="Se edito el rango de dias para realizar las requisicones anuales";
    }
    $kardex->Catalogo='Catalogo General';
    $kardex->add();

    header('location: '.FOLDER_PATH.'/Configuracion');
  }
  public function Importar(){
    require_once ROOT . FOLDER_PATH .'/app/Request/ConfiguracionRequest.php';
  }
  public function Subir(){
    require_once ROOT . FOLDER_PATH .'/app/Request/ConfiguracionRequest.php';
  }
  public function Exportar(){
    require_once ROOT . FOLDER_PATH .'/app/Request/ConfiguracionRequest.php';
  }

  public function ImportExc(){
    require_once ROOT . FOLDER_PATH .'/app/Lib/PHPExcel/IOFactory.php';
    $valor = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N');
    $conf = new ConfiguracionModel();
    $conf->table=$_POST['importa'];
    $resul=$conf->getAllData();//trae todo el contenido de las tablas
    $col=$conf->getDatas();//trae la informacion de as tablas para saber el nombre de cada columna
    $header="";
    $c=0;
    $Id="";

    $nombreArchivo = $_FILES["archivo"]["tmp_name"];
    $objPHPExcel = PHPExcel_IOFactory::load($nombreArchivo);
    $objPHPExcel->setActiveSheetIndex(0);
    $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
    $IdVal="";
    //primer ciclo es para extraer lo que hay en el excel
    for ($i = 2; $i <= $numRows; $i++){
      $cont=0;
      $value="";
      $c=0;
      //segundo ciclo es para extraer el nombre de los campos de la tabla
      foreach ($col as $v){
        if($c==0){
          $Id=$v->Field;
          $header=$v->Field;
          //se almacenan los datos del excel en una variable
          $IdVal=$objPHPExcel->getActiveSheet()->getCell($valor[$cont].$i)->getCalculatedValue();
          $value = "'".$objPHPExcel->getActiveSheet()->getCell($valor[$cont].$i)->getCalculatedValue()."'";
          $edit=$v->Field." = '".$objPHPExcel->getActiveSheet()->getCell($valor[$cont].$i)->getCalculatedValue()."'";
        }else{
          $header=$header.",".$v->Field;
          //se almacenan los datos del excel en una variable
          $value = $value.",'".$objPHPExcel->getActiveSheet()->getCell($valor[$cont].$i)->getCalculatedValue()."'";
          $edit=$edit.",".$v->Field." = '".$objPHPExcel->getActiveSheet()->getCell($valor[$cont].$i)->getCalculatedValue()."'";
        }
        $c++;
        $cont=$cont+1;
      }
      //se crean las consultas para insertar o editar
      if($objPHPExcel->getActiveSheet()->getCell("A".$i)->getCalculatedValue()==0){
        $conf->sql="INSERT INTO ".$_POST['importa']." (".$header.") VALUE (".$value.")";
      }else{
        $conf->sql="UPDATE ".$_POST['importa']." SET ".$edit." WHERE ".$Id." = ".$IdVal;
      }
      $conf->addTables();
    }
    $kardex = new KardexModel();
    $kardex->IdUsuario=$this->session->get('id');
    $kardex->Accion='Importo';
    $kardex->Catalogo='Catalogo General';
    $kardex->Descripcion="Se Importo un archivo excel a la tabla ".$_POST['importa'];
    $kardex->add();
   header('location: '.FOLDER_PATH.'/Configuracion');
  }

  public function ExportExc(){
    require_once ROOT . FOLDER_PATH .'/app/Lib/PHPExcel.php';
    $kardex = new KardexModel();
    $kardex->IdUsuario=$this->session->get('id');
    $kardex->Accion='Exporto';
    $kardex->Catalogo='Catalogo General';
    $kardex->Descripcion="Se Exporto un archivo excel con los datos de la tabla ".$_POST['exportar'];
    $kardex->add();

    $valor = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N');
    $conf = new ConfiguracionModel();
    $conf->table=$_POST['exportar'];
    $resul=$conf->getAllData();
    $col=$conf->getDatas();
    $cont=0;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Alejandro Garcia")->setTitle("catalogos");
    $objPHPExcel->setActiveSheetIndex(0);
  	$objPHPExcel->getActiveSheet()->setTitle("catalogos");
    //Se crea el titulo de cada columna
    foreach ($col as $v){
      $objPHPExcel->getActiveSheet()->setCellValue($valor[$cont].'1', $v->Field);
      $cont=$cont+1;;
    }
    $cont=0;
    $fila=2;
    //el cuerpo de la tabla
    foreach ($resul as $r){
      $cont=0;
      foreach ($col as $v){
        $val=$v->Field;
        $objPHPExcel->getActiveSheet()->setCellValue($valor[$cont].$fila, $r->$val);
        $cont=$cont+1;
      }
      $fila=+$fila+1;
    }

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="catalogos.xls"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    header('location: '.FOLDER_PATH.'/Configuracion');
  }


  public function Import(){
    include ROOT . FOLDER_PATH . '/system/Core/backup.php';
    $ruta1 = $_FILES["db"]["tmp_name"];
    $restorePoint=SGBD::limpiarCadena($ruta1);
    $sql=explode(";",file_get_contents($ruta1));
    $totalErrors=0;
    $con=mysqli_connect(SERVER, USER, PASS, BD);
    $con->query("SET FOREIGN_KEY_CHECKS=0");
    for($i = 0; $i < (count($sql)-1); $i++){
        if($con->query($sql[$i].";")){  }else{ $totalErrors++; }
    }
    $con->query("SET FOREIGN_KEY_CHECKS=1");
    $con->close();

    $kardex = new KardexModel();
    $kardex->IdUsuario=$this->session->get('id');
    $kardex->Accion='Importo';
    $kardex->Catalogo='Catalogo General';
    $kardex->Descripcion="Se importo una base de datos ";
    $kardex->add();


    header('location: '.FOLDER_PATH.'/Configuracion');
  }
  public function Export(){
    include ROOT . FOLDER_PATH . '/system/Core/backup.php';
    $kardex = new KardexModel();
    $kardex->IdUsuario=$this->session->get('id');
    $kardex->Accion='Exporto';
    $kardex->Catalogo='Catalogo General';
    $kardex->Descripcion="Se exporto una base de datos itssated_requibd_".DATE.".sql";
    $kardex->add();

    $DataBASE="itssated_requibd_".DATE.".sql";
    $tables=array();
    $result=SGBD::sql('SHOW TABLES');
    if($result){
        while($row=mysqli_fetch_row($result)){
           $tables[] = $row[0];
        }
        $sql='SET FOREIGN_KEY_CHECKS=0;'."\n\n";
        $sql.='CREATE DATABASE IF NOT EXISTS '.BD.";\n\n";
        $sql.='USE '.BD.";\n\n";;
        foreach($tables as $table){
            $result=SGBD::sql('SELECT * FROM '.$table);
            if($result){
                $numFields=mysqli_num_fields($result);
                $sql.='DROP TABLE IF EXISTS '.$table.';';
                $row2=mysqli_fetch_row(SGBD::sql('SHOW CREATE TABLE '.$table));
                $sql.="\n\n".$row2[1].";\n\n";
                for ($i=0; $i < $numFields; $i++){
                    while($row=mysqli_fetch_row($result)){
                        $sql.='INSERT INTO '.$table.' VALUES(';
                        for($j=0; $j<$numFields; $j++){
                            $row[$j]=addslashes($row[$j]);
                            $row[$j]=str_replace("\n","\\n",$row[$j]);
                            if (isset($row[$j])){
                                $sql .= '"'.$row[$j].'"' ;//a qui va a tronar jajaja
                            }
                            else{
                                $sql.= '""';
                            }
                            if ($j < ($numFields-1)){
                                $sql .= ',';
                            }
                        }
                        $sql.= ");\n";
                    }
                }
                $sql.="\n\n\n";
                $error=0;
            }else{
                $error=1;
            }
        }
        if($error==1){
            echo 'Ocurrio un error inesperado al crear la copia de seguridad';
        }else{
            chmod(BACKUP_PATH, 0777);
            $sql.='SET FOREIGN_KEY_CHECKS=1;';
            $handle=fopen(BACKUP_PATH.$DataBASE,'w+');
            if(fwrite($handle, $sql)){
                fclose($handle);

            }else{

            }
        }
    }else{
        echo 'Ocurrio un error inesperado';
    }
    mysqli_free_result($result);

    $fileName = basename($DataBASE);
    $filePath = BACKUP_PATH.$fileName;
    if(!empty($fileName) && file_exists($filePath)){
        // Define headers
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$fileName");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");

        // Read the file
        readfile($filePath);

    }else{

        exit;
    }

    unlink($filePath);

  }
  public function requested(){
    require_once ROOT . FOLDER_PATH .'/app/Request/ConfiguracionRequest.php';
  }

  public function costo()
  {
    require_once ROOT . FOLDER_PATH .'/app/Lib/PHPExcel.php';
    $valor = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N');
    $conf = new ConfiguracionModel();

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Alejandro Garcia")->setTitle("Costos");
    $objPHPExcel->setActiveSheetIndex(0);
  	$objPHPExcel->getActiveSheet()->setTitle("Costos");

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
  $aux=0;
  $flap=false;
  $fila=6;
  $dep=4;
  $header=5;
  $foot=0;
  $total=0;
  $line=0;

    $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($estiloTituloReporte);
    $objPHPExcel->getActiveSheet()->setCellValue('A2', "REPORTE DE COSTO POR DEPARTAMENTOS");
    $objPHPExcel->getActiveSheet()->mergeCells('A2:G2');

    $ctm=0;
    $con = $conf->getCostos();
    foreach ($con as $r){

      if($ctm==0){
        $ctm=1;

        $objPHPExcel->getActiveSheet()->getStyle('A'.$header)->applyFromArray($estiloTituloColumnas);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$header, 'Departamento');


        $objPHPExcel->getActiveSheet()->getStyle('B'.$header)->applyFromArray($estiloTituloColumnas);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$header, 'Proyectos');

        $objPHPExcel->getActiveSheet()->getStyle('C'.$header)->applyFromArray($estiloTituloColumnas);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$header, 'Partida');

        $objPHPExcel->getActiveSheet()->getStyle('D'.$header)->applyFromArray($estiloTituloColumnas);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(35);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$header, 'Metas');

        $objPHPExcel->getActiveSheet()->getStyle('E'.$header)->applyFromArray($estiloTituloColumnas);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(45);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$header, 'Material');

        $objPHPExcel->getActiveSheet()->getStyle('F'.$header)->applyFromArray($estiloTituloColumnas);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$header, 'Cantidad');

        $objPHPExcel->getActiveSheet()->getStyle('G'.$header)->applyFromArray($estiloTituloColumnas);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$header, 'Importe');

        $aux=$r['IdDepartamento'];
        $line++;
        $header++;
        $dep++;
        $flap=true;
      }

      $foot=$fila;
      $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $r['Dep']);
      $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $r['Proyectos']);
      $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $r['Partida']);
      $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $r['Metas']);
      $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $r['Articulo']);
      $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $r['Cantidad']);
      $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, '$'.$r['Total']);
      $fila++;
      $header++;
      $dep++;

      $total=$total+str_replace(",","",$r['Total']);

      $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A".$foot.":G".$fila);
     }

     $tf = number_format($total, 2);
     $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "");
     $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, "");
     $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, "");
     $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, "");
     $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, "");
     $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, "Total");
     $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, '$'.$tf);
     $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A".$fila.":G".$fila);
     $flap=false;
     $total=0;
     $fila=$fila+4;
     $header=$header+4;
     $dep=$dep+4;
     $zl=0;

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Costos.xls"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    header('location: '.FOLDER_PATH.'/Configuracion');

  }

  public function consumido()
  {
    require_once ROOT . FOLDER_PATH .'/app/Lib/PHPExcel.php';
    $valor = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N');
    $conf = new ConfiguracionModel();

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Alejandro Garcia")->setTitle("Costos");
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Costos");

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
  $aux=0;
  $flap=false;
  $fila=6;
  $dep=4;
  $header=5;
  $foot=0;
  $total=0;
  $line=0;

    $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($estiloTituloReporte);
    $objPHPExcel->getActiveSheet()->setCellValue('A2', "REPORTE DE COSTO CONSUMIOD POR DEPARTAMENTOS");
    $objPHPExcel->getActiveSheet()->mergeCells('A2:G2');

    $ctm=0;
    $con = $conf->getConsumido();
    foreach ($con as $r){

      if($ctm==0){
        $ctm=1;

        $objPHPExcel->getActiveSheet()->getStyle('A'.$header)->applyFromArray($estiloTituloColumnas);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$header, 'Departamento');


        $objPHPExcel->getActiveSheet()->getStyle('B'.$header)->applyFromArray($estiloTituloColumnas);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$header, 'Proyectos');

        $objPHPExcel->getActiveSheet()->getStyle('C'.$header)->applyFromArray($estiloTituloColumnas);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$header, 'Partida');

        $objPHPExcel->getActiveSheet()->getStyle('D'.$header)->applyFromArray($estiloTituloColumnas);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(35);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$header, 'Metas');

        $objPHPExcel->getActiveSheet()->getStyle('E'.$header)->applyFromArray($estiloTituloColumnas);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(45);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$header, 'Material');

        $objPHPExcel->getActiveSheet()->getStyle('F'.$header)->applyFromArray($estiloTituloColumnas);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$header, 'Cantidad consumida');

        $objPHPExcel->getActiveSheet()->getStyle('G'.$header)->applyFromArray($estiloTituloColumnas);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$header, 'Importe consumido');

        $aux=$r['IdDepartamento'];
        $line++;
        $header++;
        $dep++;
        $flap=true;
      }

      $foot=$fila;
      $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $r['Dep']);
      $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $r['Proyectos']);
      $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $r['Partida']);
      $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $r['Metas']);
      $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $r['Articulo']);
      $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $r['Cantidad']);
      $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, '$'.$r['Total']);
      $fila++;
      $header++;
      $dep++;

      $total=$total+str_replace(",","",$r['Total']);

      $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A".$foot.":G".$fila);
     }

     $tf = number_format($total, 2);
     $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "");
     $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, "");
     $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, "");
     $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, "");
     $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, "");
     $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, "Total");
     $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, '$'.$tf);
     $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A".$fila.":G".$fila);
     $flap=false;
     $total=0;
     $fila=$fila+4;
     $header=$header+4;
     $dep=$dep+4;
     $zl=0;

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Consumido.xls"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    header('location: '.FOLDER_PATH.'/Configuracion');

  }

public function viewPDF(){
  $filename= $_POST["filename"].".pdf";
  $mi_pdf = $_POST["url"];
  header('Content-type: application/pdf');
  header('Content-Disposition: attachment; filename="'.$filename.'"');
  readfile($mi_pdf);
}
  private function verify($request)
  {
    return empty($request['codigo']);
  }
  public function logout()
  {
    $this->session->close();
    header('location: '.FOLDER_PATH.'/login');
  }

}
