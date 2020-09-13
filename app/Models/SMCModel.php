<?php
require_once EXECUTOR;
class SMCModel extends Model
{

  function __construct(){
    self::$tablename = 'depto_manto';
  }
  public function getAllSMC(){
     $sql="SELECT a.Idsmc, a.Folio, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,a.Archivo, a.Concepto, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion,d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno,a.Estatus
    FROM ".self::$tablename." as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
    INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe ORDER BY a.Folio DESC ";
     return Executor::doit($sql);
   }
  public function getCount(){
  $sql="SELECT * FROM ".self::$tablename."  WHERE Folio LIKE 'SMC%'";
  return Executor::doit($sql);
  }
   public function add($Id,$folio,$recepcion,$reporte,$dep,$solicitante,$concepto,$estado,$archivo){
     $sql="INSERT INTO ".self::$tablename." ( Idsmc, Folio, FechaRecepcion, FechaReporte, IdDep, IdSolicitante, Concepto, Costo, FechaAutorizacion, Estado, FechaAatencion, Archivo) VALUES
     ('0','{$folio}', '{$recepcion}', '{$reporte}', '{$dep}', '{$solicitante}', '{$concepto}','0','0000-00-00','{$estado}','0000-00-00','{$archivo}')";
     return Executor::doit($sql);
   }
   // funcion para actualizar los datos, pero solo para el depto de matenimiento
   public function update($Id,$folio,$departamento,$solicitante,$concepto,$FechaRecepcion,$archivo){
     $sql="UPDATE ".self::$tablename." SET Folio='{$folio}', IdDep='{$departamento}', IdSolicitante='{$solicitante}', Concepto='{$concepto}', FechaRecepcion='{$FechaRecepcion}', Archivo='{$archivo}'  WHERE Idsmc='{$Id}'";
     return Executor::doit($sql);
   }
   // funcion para actualizar los datos, solo para el depto de R.M
   public function updateEstado($Id,$estdo){
     $sql="UPDATE ".self::$tablename." SET Estatus='{$estdo}' WHERE Idsmc='{$Id}'";
     return Executor::doit($sql);
   }
   // funcion para actualizar los datos, solo para el depto de direccion general.
   public function updateAdmin($Id,$estdo,$fecha,$Comentario){
     $sql="UPDATE ".self::$tablename." SET Estado='{$estdo}', FechaAutorizacion='{$fecha}', Comentario='{$Comentario}' WHERE Idsmc='{$Id}'";
     return Executor::doit($sql);
   }
    public function UltimoRegitroSMC(){
     $sql="SELECT * FROM ".self::$tablename." ORDER BY Idsmc DESC limit 1";
     return Executor::doit($sql);
   }
  public function getOneSMC($id){
     $sql="SELECT a.Idsmc, a.Folio, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
    a.Concepto, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion,d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno,a.Estatus
    FROM ".self::$tablename." as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
    INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe WHERE a.Idsmc='{$id}' ORDER BY a.Folio DESC ";
     return Executor::doit($sql);
   }
}
