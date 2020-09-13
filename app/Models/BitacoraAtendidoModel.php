<?php
require_once EXECUTOR;
class BitacoraAtendidoModel extends Model
{

  function __construct(){
    self::$tablename = 'bitacora';
  }

   public function Atendidas(){
   $sql = "SELECT IdBitacora, Foliorequisicion, DATE_FORMAT(FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(FechaReporte,'%d/%m/%Y') as FechaReporte, IdDep, IdSolicitante, Comentario,
   Concepto, FORMAT(Costo, 2) AS Costo, DATE_FORMAT(FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, Estado, DATE_FORMAT(FechaAatencion,'%d/%m/%Y') as FechaAatencion , Estatus
   FROM " .self::$tablename. " WHERE Estatus='ATENDIDA' or Estatus = 'atendida' ORDER BY IdBitacora DESC";
   return Executor::doit($sql);
 }

  public function getSearchBit($field1,$date){
    $sql = "SELECT IdBitacora, Foliorequisicion, DATE_FORMAT(FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(FechaReporte,'%d/%m/%Y') as FechaReporte, IdDep, IdSolicitante,Comentario,
   Concepto, FORMAT(Costo, 2) AS Costo, DATE_FORMAT(FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, Estado, DATE_FORMAT(FechaAatencion,'%d/%m/%Y') as FechaAatencion , Estatus
   FROM " .self::$tablename. " WHERE Estatus='ATENDIDA' AND {$field1} LIKE '%{$date}%' ORDER BY IdBitacora DESC";
    return Executor::doit($sql);

  }

  ///////////////// busqueda por departamento //////////////////////////
    public function getJoinAllDepar($id){
   $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion,a.FechaRecepcion as 'dateRecepcion', DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
    a.Concepto, FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion, a.FechaEntrega,d.idDepart,d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno,a.Estatus
   FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
   INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe WHERE a.IdDep = '{$id}' AND a.Estatus='ATENDIDA'  ORDER BY a.IdBitacora DESC";
   return Executor::doit($sql);
 }
 ////////////////////////// busqueda por estado y fecha ////////////////////////////////
  public function getJoinAllDATEStatu($consulta,$tipo,$datoDesde,$datoHasta){
   $sql = "SELECT IdBitacora, Foliorequisicion, DATE_FORMAT(FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(FechaReporte,'%d/%m/%Y') as FechaReporte, IdDep, IdSolicitante,Comentario,
   Concepto, FORMAT(Costo, 2) AS Costo, DATE_FORMAT(FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, Estado, DATE_FORMAT(FechaAatencion,'%d/%m/%Y') as FechaAatencion , Archivo, Estatus
   FROM " .self::$tablename. " WHERE Estatus='ATENDIDA' AND  $consulta = '{$tipo}' AND FechaReporte BETWEEN '{$datoDesde}' AND '{$datoHasta}' ORDER BY IdBitacora DESC";
   return Executor::doit($sql);
 }
  ////////////////////////// busqueda por fecha ////////////////////////////////
   public function getJoinAllDATE($datoDesde,$datoHasta){
  $sql = "SELECT IdBitacora, Foliorequisicion, DATE_FORMAT(FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(FechaReporte,'%d/%m/%Y') as FechaReporte, IdDep, IdSolicitante,Comentario,
   Concepto, FORMAT(Costo, 2) AS Costo, DATE_FORMAT(FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, Estado, DATE_FORMAT(FechaAatencion,'%d/%m/%Y') as FechaAatencion, Estatus
   FROM " .self::$tablename. " WHERE Estatus='ATENDIDA' AND FechaReporte BETWEEN '{$datoDesde}' AND '{$datoHasta}' ORDER BY IdBitacora DESC";
   return Executor::doit($sql);
 }
   ///////////////// busqueda por estado //////////////////////////
    public function getJoinStatus($consulta,$tipo){
   $sql = "SELECT IdBitacora, Foliorequisicion, DATE_FORMAT(FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(FechaReporte,'%d/%m/%Y') as FechaReporte, IdDep, IdSolicitante,Comentario,
   Concepto, FORMAT(Costo, 2) AS Costo, DATE_FORMAT(FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, Estado, DATE_FORMAT(FechaAatencion,'%d/%m/%Y') as FechaAatencion , Archivo, Estatus
   FROM " .self::$tablename. " WHERE Estatus='Atendido' AND $consulta = '{$tipo}' ORDER BY IdBitacora DESC";
   return Executor::doit($sql);
 }
}
