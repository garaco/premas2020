<?php
require_once EXECUTOR;
class DepartamentoModel extends Model
{

  function __construct(){
    self::$tablename = 'departamento';
  }
   public function add($Id,$idArea,$nombreDepto){
     $sql="INSERT INTO ".self::$tablename." (idDepart,idArea, nombreDepto) VALUES ('0', '{$idArea}', '{$nombreDepto}')";
     return Executor::doit($sql);
   }
   public function update($Id,$idArea,$nombreDepto){
     $sql="UPDATE ".self::$tablename." SET idArea='{$idArea}', nombreDepto='{$nombreDepto}' WHERE idDepart='{$Id}'";
     return Executor::doit($sql);
   }

   public function del($Id){
     $sql="DELETE FROM ".self::$tablename." WHERE idDepart = '{$Id}'";
     return Executor::doit($sql);
   }
   public function getJoin($ord,$ini=0,$fin=0){
     $sql = "SELECT d.* FROM " .self::$tablename. " AS d ORDER BY {$ord} DESC";
     return Executor::doit($sql);

   }
    public function getJoin2($ord,$area){
      $sql = "SELECT d.*, a.NombreArea FROM " .self::$tablename. " AS d INNER JOIN area AS a ON (a.IdArea = d.IdArea) WHERE a.IdArea= {$area} ORDER BY '{$ord}' DESC";
      return Executor::doit($sql);

   }
   public function JoinSearch($field1,$date){
     $sql = "SELECT d.*, a.NombreArea FROM " .self::$tablename. " AS d INNER JOIN area AS a ON (a.IdArea = d.IdArea) WHERE {$field1} LIKE '%{$date}%'";
     return Executor::doit($sql);

   }
      public function getDepartamento($Id){
    $sql="SELECT * FROM ".self::$tablename." WHERE  idDepart = '{$Id}'";
     return Executor::doit($sql);
   }
   public function allDepartamento()
   {
     $sql="SELECT * FROM ".self::$tablename;
     return Executor::doit($sql);
   }
   // obtiene el departamento especifico del usuario
   public function Departamento_area($IDdepartamento){
     $sql = "SELECT * FROM ".self::$tablename." WHERE idDepart = '{$IDdepartamento}'";
     return Executor::doit($sql);
   }
}
