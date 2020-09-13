<?php
class RequisicionModel extends Model{
public $resul;
public $ano;
public $fechaActual;
  public function __construct(){
    self::$tablename = 'bitacora';
    $this->ano = date('Y');
    $this->fechaActual = DATE;
  }
   public function add($Id,$requisicion,$recepcion,$reporte,$dep,$solicitante,$concepto,$costo,$estado,$archivo){
     $sql="INSERT INTO ".self::$tablename." ( IdBitacora, Foliorequisicion, FechaRecepcion, FechaReporte, IdDep, IdSolicitante, Concepto, Costo, FechaAutorizacion, Estado, FechaAatencion, Archivo) VALUES
     ('0','{$requisicion}', '{$recepcion}', '{$reporte}', '{$dep}', '{$solicitante}', '{$concepto}','{$costo}','0000-00-00','{$estado}','0000-00-00','{$archivo}')";
     return Executor::doit($sql);
   }
   public function update($Id,$Costo,$fechaReporte,$Num_estado){
     $sql="UPDATE ".self::$tablename." SET Costo='{$Costo}', FechaReporte='{$fechaReporte}', Num_estado='{$Num_estado}'  WHERE IdBitacora='{$Id}'";
     return Executor::doit($sql);
   }
   // mmodifica el estado de la requisicion a atendida
    public function UpdateStatus($Id){
     $sql="UPDATE ".self::$tablename." SET Estatus='ATENDIDA'  WHERE IdBitacora='{$Id}'";
     return Executor::doit($sql);
   }
   ///////////////  update de fecha de atencion ////////////////////7
    public function updateDATE($Id,$Date){
     $sql="UPDATE ".self::$tablename." SET FechaAatencion='{$Date}' WHERE IdBitacora='{$Id}'";
     return Executor::doit($sql);
   }

   public function getJoinAll(){
    $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion,a.FechaRecepcion as 'dateRecepcion', DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
    a.Concepto, FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion, a.FechaEntrega,d.idDepart,d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno,a.Estatus
    FROM ".self::$tablename." as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
    INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe  WHERE a.FechaRecepcion LIKE '%{$this->ano}%' ORDER BY a.FechaRecepcion DESC";
    return Executor::doit($sql);
  }
  public function getSearchBit($field1,$date){
    $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
   a.Concepto, FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion,a.FechaEntrega, d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno,a.Estatus
   FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
   INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe WHERE {$field1} LIKE '%{$date}%' ORDER BY a.IdBitacora DESC";
    return Executor::doit($sql);

  }
   public function getJoinAllEstatus($consulta,$tipo){
    $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
    a.Concepto, FORMAT(a.Costo, 2) AS Costo,a.Estatus, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion , d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno,a.Estatus
    FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
    INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe WHERE a.$consulta = '{$tipo}'";
    return Executor::doit($sql);
  }
  ///////////////// busqueda por departamento //////////////////////////
    public function getJoinAllDepar($id){
   $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion,a.FechaRecepcion as 'dateRecepcion', DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
    a.Concepto, FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion, a.FechaEntrega,d.idDepart,d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno,a.Estatus
   FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
   INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe WHERE a.IdDep = '{$id}' ORDER BY a.IdBitacora DESC";
   return Executor::doit($sql);
 }
 ////////////////////////// busqueda por estado y fecha ////////////////////////////////
  public function getJoinAllDATEStatu($consulta,$tipo,$datoDesde,$datoHasta){
   $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
   a.Concepto, FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion , d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno,a.Estatus,a.FechaEntrega
   FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
   INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe WHERE a.$consulta = '{$tipo}' AND a.FechaReporte BETWEEN '{$datoDesde}' AND '{$datoHasta}' ORDER BY a.IdBitacora DESC";
   return Executor::doit($sql);
 }
  ////////////////////////// busqueda por fecha ////////////////////////////////
   public function getJoinAllDATE($datoDesde,$datoHasta){
   $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
   a.Concepto, FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion , d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno, a.Estatus,a.FechaEntrega
   FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
   INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe WHERE a.FechaReporte BETWEEN '{$datoDesde}' AND '{$datoHasta}' ORDER BY a.IdBitacora DESC";
   return Executor::doit($sql);
 }
   ///////////////// busqueda por estado //////////////////////////
    public function getJoinStatus($consulta,$tipo){
   $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
   a.Concepto, FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion , d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno,a.Estatus,a.FechaEntrega
   FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
   INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe WHERE a.$consulta = '{$tipo}' ORDER BY a.IdBitacora DESC";
   return Executor::doit($sql);
 }

  public static function exist($id){
     $sql = "SELECT Foliorequisicon FROM ".self::$tablename." WHERE  Foliorequisicon = '{$id}'";
     return Executor::doit($sql);
    }
  public function exportaDato($estado,$desde,$hasta)
  {
    $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
   a.Concepto, FORMAT(a.Costo, 2) AS Costo,a.Estatus, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion , d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno
   FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
   INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe WHERE Estado = '{$estado}' AND a.FechaReporte BETWEEN '{$desde}' AND '{$hasta}' ORDER BY a.IdBitacora DESC" ;
    return Executor::doit($sql);
  }
  // consul para obtener el folio y el id de la requisicion (pendiente en modificar)
  public function Foliorequisicion()
  {
    $sql = "SELECT DISTINCT b.IdBitacora,  b.Foliorequisicion ,rd.Cantidad,mt.Existencia FROM requisicion_detalle as rd INNER JOIN bitacora as b ON rd.IDbitacora=b.IdBitacora INNER JOIN materiales as mt ON mt.IDmaterial=rd.Descripcion  WHERE b.Foliorequisicion!='' AND b.Estatus!='ATENDIDA' AND b.Estado='AUTORIZADO' and rd.Cantidad>mt.Existencia GROUP BY b.Foliorequisicion";
    return Executor::doit($sql);

  }
  // consulta para obtener el folio de la requisicion
  public function folioReq()
  {
    $sql="SELECT if (((DATEDIFF(FechaEntrega, DATE(now()))+1) > 0) and ((DATEDIFF(FechaEntrega, DATE(now()))+1) < 4),
    concat('La rquisición ', Foliorequisicion,' expira en ',(DATEDIFF(FechaEntrega, DATE(now()))+1),' dias')
    ,if((Cancelar = 'Si'),concat('Se solicita eliminar la requisición ',Foliorequisicion),'0')) as dato
    FROM ".self::$tablename." WHERE Num_estado = 0 or Cancelar = 'Si'";
    return Executor::doit($sql);
  }
  // para obtener los datos de los materiales de la requisicion enviada
  public function getMateriales($ID)
  {
    $sql="SELECT * FROM requisicion_detalle WHERE IDbitacora = '{$ID}'";
    return Executor::doit($sql);
  }

      /////////////////////////// filtro por año ///////////////////////////////////////////////////
    public function Requisicion_All_ano($ano)
    {
     $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte,DATE_FORMAT(a.FechaEntrega,'%d/%m/%Y') as FechaEntrega, a.IdDep, a.IdSolicitante,a.Comentario,
    a.Concepto, FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion , d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno,a.Estatus
    FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
    INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe  WHERE a.FechaRecepcion LIKE '%{$ano}%' ORDER BY a.IdBitacora DESC";
    return Executor::doit($sql);
    }

  public function getCount(){
  $sql="SELECT * FROM ".self::$tablename." WHERE FechaRecepcion LIKE '%{$this->ano}%'";
  return Executor::doit($sql);
}

  public function DatoUser($ID,$tupla)
  {
    $sql = "SELECT s.IdUsuario,s.Nombre_User,s.IdDepartamento,d.nombreDepto FROM usuarios s INNER JOIN departamento as d ON s.IdDepartamento=d.idDepart WHERE $tupla = '{$ID}'";
    return Executor::doit($sql);
  }
  // funcion para traer las requisiciones dependiendo del estado, pendien,autorizadas y no autorizadas
   public function getJoinBitacora($estado){
    $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion,a.FechaRecepcion as 'dateRecepcion', DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
    a.Concepto, FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion, a.FechaEntrega,d.idDepart,d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno,a.Estatus
    FROM ".self::$tablename." as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
    INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe  WHERE a.FechaRecepcion LIKE '%{$this->ano}%' and Estado='{$estado}' ORDER BY a.FechaRecepcion DESC";
    return Executor::doit($sql);
  }
}
