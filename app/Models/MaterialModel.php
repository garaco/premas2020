<?php
require_once EXECUTOR;
class MaterialModel extends Model
{

  function __construct(){
    self::$tablename = 'materiales';
  }
  public function AllMaterial($id){
    $sql = "SELECT m.IDmaterial,m.Concepto,m.Medida,m.Precio,p.Codigo FROM " .self::$tablename. " as m INNER JOIN partidas as p ON m.IdPartidas=p.IdPartida WHERE IDmaterial='{$id}'";
    return Executor::doit($sql);
  }
  public function getAllMaterial($ord,$Id=0,$Id2=0){
    $sql = "SELECT m.IDmaterial,m.Concepto,m.Medida,m.Precio,p.Codigo,m.Existencia FROM " .self::$tablename. " as m INNER JOIN partidas as p ON m.IdPartidas=p.IdPartida ORDER BY IDmaterial DESC ";
    return Executor::doit($sql);
  }
   public function getSearch($field1,$field2,$date){
    $sql = "SELECT m.IDmaterial,m.Concepto,m.Medida,m.Precio,p.Codigo,m.Existencia FROM " .self::$tablename. " as m INNER JOIN partidas as p ON m.IdPartidas=p.IdPartida  WHERE p.{$field1} LIKE '%{$date}%' OR m.{$field2} LIKE '%{$date}%' ORDER BY m.IDmaterial ASC";
    return Executor::doit($sql);

  }

   public function add($Concepto,$Medida,$Precio,$idpartidas){
     $sql=" INSERT INTO ".self::$tablename." (IDmaterial, Concepto, Medida, Precio, IdPartidas, Existencia) VALUES ('0', '{$Concepto}', '{$Medida}', '{$Precio}', '{$idpartidas}', '0')";
     return Executor::doit($sql);
   }
   public function update($Id,$Concepto,$Medida,$Precio,$idpartidas){
     $sql="UPDATE ".self::$tablename." SET Concepto='{$Concepto}', Medida='{$Medida}',Precio='{$Precio}',idpartidas='{$idpartidas}' WHERE IDmaterial='{$Id}'";
     return Executor::doit($sql);
   }

   public function del($Id){
     $sql="DELETE FROM ".self::$tablename." WHERE IDmaterial = '{$Id}'";
     return Executor::doit($sql);
   }
   //=============== consulta para obtener cantidad de existencia del material ==========================
   public function getCantidad($Id)
   {
     $sql="SELECT Existencia FROM ".self::$tablename." WHERE IDmaterial='{$Id}' ";
     return Executor::doit($sql);
   }
   // ====== consulta para actualizar la existencia de un material =====================================
   public function addExistencia($Id,$cantidad)
   {
     $sql="UPDATE ".self::$tablename." SET Existencia='{$cantidad}' WHERE IDmaterial='{$Id}'";
     return Executor::doit($sql);
   }
   public function OutExistencia($Id,$cantidad)
   {
    $sql="UPDATE ".self::$tablename." SET Existencia='{$cantidad}' WHERE IDmaterial='{$Id}'";
     return Executor::doit($sql);
   }
   // consulta para obtener la cantidad del material solicitado y el numero de existenacia del mismo
   public function CantidadMaterial($IdBitacora)
   {
    $sql="SELECT rd.Cantidad,mt.Existencia,mt.IDmaterial,mt.Concepto FROM requisicion_detalle as rd INNER JOIN bitacora as b ON rd.IDbitacora=b.IdBitacora INNER JOIN materiales as mt ON mt.IDmaterial=rd.Descripcion WHERE rd.IDbitacora='{$IdBitacora}'";
    return Executor::doit($sql);
   }
   //
    public function PDFexistencia()
    {
      $sql="SELECT mt.*,p.Codigo FROM ".self::$tablename." as mt INNER JOIN partidas as p on mt.IdPartidas=p.IdPartida WHERE mt.Existencia > 0";
      return Executor::doit($sql);
    }
    public function PDFmaterialEntregado()
    {
     $sql="SELECT b.Foliorequisicion, DATE_FORMAT(b.FechaEntrega ,'%d/%m/%Y')as FechaEntrega,mt.Concepto,mt.Medida,pt.Codigo,
          DATE_FORMAT(rd.FechaEntrega ,'%d/%m/%Y')as rdFechaEntrega 
          FROM bitacora as b 
            INNER JOIN requisicion_detalle as rd on b.IdBitacora=rd.IDbitacora 
            INNER JOIN materiales as mt on mt.IDmaterial=rd.Descripcion 
            INNER JOIN partidas as pt on pt.IdPartida=mt.IdPartidas 
            WHERE rd.Num_estado=1";
     return Executor::doit($sql);
    }
}
