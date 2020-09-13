<?php
require_once EXECUTOR;
class AreaModel extends Model
{

  function __construct(){
    self::$tablename = 'area';
  }
   public function add($Id,$Num,$NombreArea,$Responsable){
     $sql="INSERT INTO ".self::$tablename." (IdArea,Num, NombreArea, Responsable) VALUES ('0', '{$Num}', '{$NombreArea}', {$Responsable})";
     return Executor::doit($sql);
   }
   public function update($Id,$Codigo,$NombreArea,$Responsable){
     $sql="UPDATE ".self::$tablename." SET Num='{$Codigo}', NombreArea='{$NombreArea}', Responsable='{$Responsable}' WHERE IdArea='{$Id}'";
     return Executor::doit($sql);
   }

   public function del($Id){
     $sql="DELETE FROM ".self::$tablename." WHERE IdArea = '{$Id}'";
     return Executor::doit($sql);
   }
   public function area(){
      $sql="SELECT a.*,CONCAT(j.Subfijo,j.Nombre,' ',j.A_paterno,' ',j.A_materno) as jefe_responsable FROM  ".self::$tablename." as a LEFT JOIN jefe_area as j ON a.Responsable=j.IdJefe";
     return Executor::doit($sql);
   }
  public function getSearchs($field1,$field2,$field3,$date){
    $sql = "SELECT a.*,CONCAT(j.Subfijo,j.Nombre,' ',j.A_paterno,' ',j.A_materno) as jefe_responsable FROM ".self::$tablename." as a LEFT JOIN jefe_area as j ON a.Responsable=j.IdJefe
      WHERE a.$field1 LIKE '%$date%' OR j.$field2 LIKE '%$date%' OR j.Nombre LIKE '%$date%'";
    return Executor::doit($sql);

  }   
}
