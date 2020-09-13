<?php
require_once EXECUTOR;
class BitacoraModel extends Model
{

  function __construct(){
    self::$tablename = 'bitacora';
  }

  public function getJoinAll(){
   $sql = "SELECT IdBitacora, Foliorequisicion, DATE_FORMAT(FechaRecepcion,'%d/%m/%Y') as FechaRecepcion,FechaRecepcion as dateRecepcion, DATE_FORMAT(FechaReporte,'%d/%m/%Y') as FechaReporte, IdDep, IdSolicitante, Comentario,
   Concepto, FORMAT(Costo, 2) AS Costo, DATE_FORMAT(FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, Estado, DATE_FORMAT(FechaAatencion,'%d/%m/%Y') as FechaAatencion , Estatus,FechaEntrega
   FROM " .self::$tablename. " WHERE FechaAatencion='0000-00-00' AND Num_estado='1' ORDER BY IdBitacora DESC";
   return Executor::doit($sql);
 }

/////////////////////////////// prueba ////////////////////////////////////////////////////777
  public function getJoinAll2($limit,$nlotes){
   $sql = "SELECT IdBitacora, Foliorequisicion, DATE_FORMAT(FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(FechaReporte,'%d/%m/%Y') as FechaReporte, IdDep, IdSolicitante, Comentario,
   Concepto, FORMAT(Costo, 2) AS Costo, DATE_FORMAT(FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, Estado, DATE_FORMAT(FechaAatencion,'%d/%m/%Y') as FechaAatencion , Estatus
   FROM " .self::$tablename. " WHERE Estatus IS NULL LIMIT".$limit.",".$nlotes." ORDER BY IdBitacora DESC";
   return Executor::doit($sql);
 }
///////////////////////////////////////////////////////////////////////////////////7
   public function Atendidas(){
   $sql = "SELECT IdBitacora, Foliorequisicion, DATE_FORMAT(FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(FechaReporte,'%d/%m/%Y') as FechaReporte, IdDep, IdSolicitante, Comentario,
   Concepto, FORMAT(Costo, 2) AS Costo, DATE_FORMAT(FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, Estado, DATE_FORMAT(FechaAatencion,'%d/%m/%Y') as FechaAatencion , Estatus
   FROM " .self::$tablename. " WHERE Estatus='Atendido' OR Estatus='ATENDIDO' ORDER BY IdBitacora DESC";
   return Executor::doit($sql);
 }

  public function getSearchBit($field1,$date){
    $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
   a.Concepto, FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion ,d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno, a.Estatus, a.FechaEntrega
   FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
   INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe WHERE FechaAatencion='0000-00-00' AND {$field1} LIKE '%{$date}%' AND Num_estado='1' ORDER BY a.IdBitacora DESC";
    return Executor::doit($sql);

  }
  public function update($Id,$fecha,$archivo,$estado){
    $sql="UPDATE ".self::$tablename." SET FechaAutorizacion='{$fecha}', Archivo='{$archivo}', Estado='{$estado}' WHERE IdBitacora='{$Id}'";
    return Executor::doit($sql);
  }
    public function add($Id,$cometario,$estado,$fecha){
    $sql="UPDATE ".self::$tablename." SET Comentario='{$cometario}', Estado= '{$estado}', FechaAutorizacion = '{$fecha}' WHERE IdBitacora='{$Id}'";
    return Executor::doit($sql);
  }
  ///////////////// busqueda por departamento //////////////////////////
    public function getJoinAllDepar($id){
   $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion,a.FechaRecepcion as 'dateRecepcion', DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
    a.Concepto, FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion, a.FechaEntrega,d.idDepart,d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno,a.Estatus
   FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
   INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe WHERE a.IdDep = '{$id}' AND a.Num_estado=1  ORDER BY a.IdBitacora DESC";
   return Executor::doit($sql);
 }
 ////////////////////////// busqueda por estado y fecha ////////////////////////////////
  public function getJoinAllDATEStatu($consulta,$tipo,$datoDesde,$datoHasta){
   $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
   a.Concepto, FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion ,d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno, a.Estatus,a.FechaEntrega
   FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
   INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe WHERE FechaAatencion='0000-00-00' AND a.$consulta = '{$tipo}' AND a.FechaReporte BETWEEN '{$datoDesde}' AND '{$datoHasta}' AND a.Num_estado=1 ORDER BY a.IdBitacora DESC";
   return Executor::doit($sql);
 }
  ////////////////////////// busqueda por fecha ////////////////////////////////
   public function getJoinAllDATE($datoDesde,$datoHasta){
   $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
   a.Concepto, FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion ,d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno, a.Estatus,a.FechaEntrega
   FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
   INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe WHERE FechaAatencion='0000-00-00' AND a.FechaReporte BETWEEN '{$datoDesde}' AND '{$datoHasta}' ORDER BY a.IdBitacora DESC";
   return Executor::doit($sql);
 }
   ///////////////// busqueda por estado //////////////////////////
    public function getJoinStatus($consulta,$tipo){
   $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
   a.Concepto, FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion ,d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno, a.Estatus,a.FechaEntrega
   FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
   INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe WHERE FechaAatencion='0000-00-00' AND a.$consulta = '{$tipo}' AND a.Num_estado=1 ORDER BY a.IdBitacora DESC";
   return Executor::doit($sql);
 }
   public function getCount(){
  $sql="SELECT * FROM ".self::$tablename." WHERE  FechaAatencion='0000-00-00' AND Foliorequisicion != ' '";
  return Executor::doit($sql);
}
  // consulta para obtener el folio de la requisicion
  public function folioReq()
  {
    $sql="SELECT if ((DATEDIFF(FechaEntrega, DATE(now()))+1) > 0,
    concat('La rquisición ', Foliorequisicion,' expira en ',(DATEDIFF(FechaEntrega, DATE(now()))+1),' dias')
    ,'0') as dato FROM ".self::$tablename." WHERE Num_estado = 1";
    return Executor::doit($sql);
  }
  // funcion para actualizar la cantidad de la tabla requisicion_detalle
  public function updateCantidad($IdRequisicionDetalle)
  {
    $sql="UPDATE requisicion_detalle SET Cantidad = '0' WHERE IdRequisicionDetalle = '{$IdRequisicionDetalle}' ";
    return Executor::doit($sql);
  }

}
