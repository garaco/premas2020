<?php
require_once EXECUTOR;
class JefesModel extends Model
{

  function __construct(){
    self::$tablename = 'jefe_area';
  }
   public function add($Id,$subfijo,$nombre,$paterno,$materno,$idarea,$iddep){
     $sql="INSERT INTO ".self::$tablename." (IdJefe,Subfijo, Nombre, A_paterno, A_materno, IdArea, IdDep) VALUES
     ('0','{$subfijo}', '{$nombre}', '{$paterno}', '{$materno}', '{$idarea}', '{$iddep}')";
     return Executor::doit($sql);
   }
   public function update($Id,$nombre,$paterno,$materno,$idarea,$iddep){
     $sql="UPDATE ".self::$tablename." SET Nombre='{$nombre}', A_paterno='{$paterno}', A_materno='{$materno}', IdArea='{$idarea}', IdDep='{$iddep}' WHERE IdJefe='{$Id}'";
     return Executor::doit($sql);
   }

   public function del($Id){
     $sql="DELETE FROM ".self::$tablename." WHERE IdJefe = '{$Id}'";
     return Executor::doit($sql);
   }
   public function getAllJefes($ord,$ini=0,$fin=0){
     $sql = "SELECT *, (SELECT nombreDepto FROM departamento WHERE idDepart = IdDep) AS Departamento
     FROM " .self::$tablename. " ORDER BY {$ord} DESC";
     return Executor::doit($sql);
   }
   // public function getAllJefes_area($area){
   //   $sql = "SELECT je.* FROM ".self::$tablename." as je INNER JOIN departamento as d ON je.IdDep = d.idDepart INNER JOIN area as ar ON je.IdArea = ar.IdArea WHERE ar.NombreArea = '{$area}'";
   //   return Executor::doit($sql);
   // }
   // obtiene el todos los datos del usuario
   public function getAllJefes_area($IDarea){
     $sql = "SELECT * FROM ".self::$tablename. " WHERE IdDep = '{$IDarea}'";
     return Executor::doit($sql);
   }
   public function getSearchJefes($field1,$field2,$date){
     $sql = "SELECT *,(SELECT nombreDepto FROM departamento WHERE idDepart = IdDep) AS Departamento
     FROM " .self::$tablename. " WHERE {$field1} LIKE '%{$date}%' OR {$field2} LIKE '%{$date}%'";
     return Executor::doit($sql);
   }
   public function getJefe($Id){
    $sql="SELECT * FROM ".self::$tablename." WHERE IdJefe = '{$Id}'";
     return Executor::doit($sql);
   }
}
