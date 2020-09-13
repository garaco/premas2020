<?php
class RequisicionViewModel extends Model{
public $resul;
  public function __construct(){
    self::$tablename = 'bitacora';

  }
  public function getJoinAll($field,$ini,$fin){
   $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
   a.Concepto, FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion , a.Archivo,d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno,a.Estatus
   FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
   INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe INNER JOIN area as ar ON ar.IdArea = s.IdArea
   WHERE ar.NombreArea = '{$field}' ORDER BY a.IdBitacora DESC  limit {$ini},{$fin}";
   return Executor::doit($sql);
 }
  public function getSearchBit($field1,$date){
    $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
   a.Concepto, FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion , a.Archivo,d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno,a.Estatus
   FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
   INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe WHERE {$field1} LIKE '%{$date}%' ORDER BY a.IdBitacora DESC";
    return Executor::doit($sql);

  }
   public function getJoinAllEstatus($consulta,$tipo){
    $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
    a.Concepto, FORMAT(a.Costo, 2) AS Costo,a.Estatus, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion , a.Archivo,d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno,a.Estatus
    FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
    INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe WHERE a.$consulta = '{$tipo}'";
    return Executor::doit($sql);
  }

 ////////////////////////// busqueda por estado y fecha ////////////////////////////////
  public function getJoinAllDATEStatu($consulta,$tipo,$datoDesde,$datoHasta){
   $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
   a.Concepto, FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion , a.Archivo,d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno,a.Estatus
   FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
   INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe WHERE a.$consulta = '{$tipo}' AND a.FechaReporte BETWEEN '{$datoDesde}' AND '{$datoHasta}' ORDER BY a.IdBitacora DESC";
   return Executor::doit($sql);
 }
  ////////////////////////// busqueda por fecha ////////////////////////////////
   public function getJoinAllDATE($datoDesde,$datoHasta){
   $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
   a.Concepto, FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion , a.Archivo,d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno, a.Estatus
   FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
   INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe WHERE a.FechaReporte BETWEEN '{$datoDesde}' AND '{$datoHasta}' ORDER BY a.IdBitacora DESC";
   return Executor::doit($sql);
 }
   ///////////////// busqueda por estado //////////////////////////
    public function getJoinStatus($consulta,$tipo){
   $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
   a.Concepto, FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion , a.Archivo,d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno,a.Estatus
   FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
   INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe WHERE a.$consulta = '{$tipo}' ORDER BY a.IdBitacora DESC";
   return Executor::doit($sql);
 }

 public function getCountType($field){
   $sql="SELECT a.IdBitacora FROM ".self::$tablename." as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
   INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe INNER JOIN area as ar ON ar.IdArea = s.IdArea
   WHERE ar.NombreArea = '{$field}'";
   return Executor::doit($sql);
  }

}
